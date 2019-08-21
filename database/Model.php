<?php

namespace Api\Database;

use Api\Contracts\iDefaultOperations;
use Api\Contracts\iSupportOperations;

/**
 * Classe: Model
 * =============================================================================
 * Objetivo: Classe Model
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
abstract class Model implements iDefaultOperations, iSupportOperations
{
    public static $conn;
    public $attributes;
    public $table;
    protected $query;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public static function all(int $offset = 0, int $rows = 0): array
    {
        $obj = new static();
        return $obj->_all($offset, $rows);
    }

    public static function create(array $array = array()): iDefaultOperations
    {
        $obj = new static();
        $obj->fromArray($array);
        return $obj->save();
    }

    public static function destroy(int $id): bool
    {
        $obj = self::find($id);
        if ($obj) {
            return $obj->delete();
        }
    }

    public static function find(int $id): ?iDefaultOperations
    {
        $obj = new static();
        return $obj->_find($id);
    }

    public static function where($query)
    {
        $obj        = new static();
        $obj->query = $obj->_where(func_get_args());
        return $obj;
    }

    public static function setConnection(\PDO $conn)
    {
        self::$conn = $conn;
    }

    public function first()
    {
        $result = $this->get(0, 1);
        $data   = array_pop($result);
        return $data;
    }

    public function get($offset = 0, $rows = 0)
    {
        if (!is_null($this->query)) {
            $query = "SELECT * FROM {$this->table} WHERE {$this->query}";

            if ($offset > 0 && $rows > 0) {
                $query .= " LIMIT {$offset}, {$rows}";
            }
            $stmt        = Model::$conn->prepare($query);
            $this->query = null;
            if ($stmt->execute()) {
                //return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
            }

            return null;
        }
    }

    public function _where(array $query)
    {
        $num_args = func_num_args();
        $args     = func_get_args();
        $count    = count($query);
        $result   = '';
        $return   = false;
        if ($count >= 2 && $count <= 3) {
            $loop = 0;
            foreach ($query as $k => $v) {
                if ($loop > 0 && strlen($result) > 0) {
                    if (is_string($v)) {
                        $result .= " {$v} ";
                    } else if (is_array($v) && $count < 3) {
                        $result .= " AND ";
                    }
                }

                if (is_array($v)) {
                    $result .= "({$this->_where($v)})";
                    $return = true;
                }
                $loop++;
            }
            $loop = 0;
            if ($return) return $result;

            if (strlen($result) > 0) {
                $result .= " AND ";
            }
            if ($count == 3) {
                $result .= "`{$query[0]}` $query[1] '{$query[2]}'";
            } else {
                $result .= "`{$query[0]}` = '{$query[1]}'";
            }
        }
        return $result;
    }

    public function _all(int $offset = 0, int $rows = 0): ?array
    {
        $query = "SELECT * FROM {$this->table}";

        if ($offset > 0 && $rows > 0) {
            $query .= " LIMIT {$offset}, {$rows}";
        }
        $stmt = Model::$conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            //return $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        return null;
    }

    public function _delete(): bool
    {
        $query = "DELETE FROM {$this->table} WHERE `id` = ?";
        $stmt  = Model::$conn->prepare($query);
        $stmt->bindValue(1, $this->id);

        return $stmt->execute();
    }

    public function _find(int $id): ?iSupportOperations
    {
        $query = "SELECT * FROM {$this->table}";
        $query .= " WHERE `id` = ? ;";

        $stmt = Model::$conn->prepare($query);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            return $stmt->fetchObject(get_called_class());
        }
    }

    public function update(array $array = array()): ?iDefaultOperations
    {
        $this->fromArray($array);
        return $this->save();
    }

    public function save(): ?iSupportOperations
    {
        if (isset($this->id)) {
            $query = "UPDATE {$this->table} SET ".implode(', ',
                    array_filter(array_map(function($element) {
                            if ($element == 'id') return;
                            return "{$element} = :{$element}";
                        }, array_keys($this->attributes))))." WHERE id = :id";
        } else {
            $query = "INSERT INTO {$this->table} (".implode(', ',
                    array_keys($this->attributes)).
                ") VALUES (:".implode(', :', array_keys($this->attributes)).');';
        }
        $stmt = Model::$conn->prepare($query);
        $stmt->execute($this->attributes);

        if ($stmt->rowCount() > 0) {
            return Model::_find(isset($this->id) ? $this->id : Model::$conn->lastInsertId());
        }
        return null;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function fromArray(array $array)
    {
        foreach ($array as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function delete(): bool
    {
        return $this->_delete();
    }
}