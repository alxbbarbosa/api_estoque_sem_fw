# API em PHP para controle de estoque

É uma API construída em PHP sem frameworks. A API foi construída com base na arquitetura MVC e utiliza JWT para autenticação.

## Getting Started

This is an API project using only PHP. The whole project was developed based on MVC. You can find here some interesting features like these: authentication (JWT) and IoC. And some pattern like ActiveRecord, Singleton, strategy, etc. There are all steps from request to response. When you call for an endpoint, all submitted data will be "wrapped" into a Request object first. An Application object suchs as a container, will intercept a request that contains a route. If it finds a valid route, dispacher will instantiate a "controller" that was informed with the search result in the route collection.Each route must have a pointed controller and a defined method. But, there are some cases where you would prefer to use a Resource routes. In this project you can see some controllers with all methods to form a resource (containing all CRUD operations). For each response, a Response object will be instantiated to handle the response to the user. To set up the Dependecy Injector, you can "teach" the Container object by defining classes associated with name references in the "\core\services.php" file.

Este é um projeto de API usando apenas PHP. O projeto foi basedo na arquetura MVC. Você encontrará aqui alguns recursos interessantes como: autenticação (JWT) e IoC. E alguns padrões como ActiveRecord, Singleton, strategy, etc. O fluxo todo desde a solicitação até a resposta é reproduzido. Quando você chama um endpoint, todos os dados enviados serão "agrupados" em um objeto request. Um objeto Application, como um contêiner, interceptará uma request que contém uma rota. Se encontrar uma rota válida, o dispacher instancia um "controller" que informado com o resultado da busca na coleção de rotas. Cada rota deve ter mapeado um controlador e um método. Mas, existem alguns casos em que você vai preferir usar as rotas de um resource. Neste projeto, você pode ver alguns controladores com todos os métodos para formar um recurso (contendo todas as operações CRUD). Para cada resposta, um objeto Response será instanciado para manipular a resposta ao usuário. Para configurar o Dependecy Injector, você pode "ensinar" o objeto Container, definindo as classes associadas às referências de nome no arquivo "\core\services.php".

O sistema ainda está em desenvolvimento, mas já permite cadastros e acessos aos resources.
Clientes, Fornecedores, Produtos, Categorias de Produtos, Usuarios, etc.

Os processos de pedido de compra, entrada e saida de estoque ainda estão em desenvolvimento.
Os testes precisam ser realizados utilizando Postman.

### Prerequisites

Você precisa ter instalado PHP e MySQL Server, além disso você deve ativar o módulo de Rewrite do seu servidor web. Se estiver utilizando Linux, muitas vezes o LAMP lhe apresentará todo ambiente perfeito. No Windows, muitos costumam utilizar o XAMP que também contém um servidor web apache.
Não faz parte desde documento, apresentar as etapas de instalação de cada elemento do ambiente de execução.

### Installing

Após baixar o código, se estiver compactado, extrai-os e coloque-os no diretório que pode ser lido por um servidor web ou em um diretório de sua preferencia para rodar com o servidor web embutido no php.

Logo em seguida, você deve executar o composer para instalação das dependências e montagem do autoloader:

```

composer install

composer dump-autoload

```
 
Além disso, você precisa configurar as definições do seu servidor na classe COnnection no diretório database. Portanto, edite as linhas 20 a 24:

```php

    private static $conn     = null;
    private static $host     = 'localhost';
    private static $dbname   = 'api_estoque_1';
    private static $username = 'root';
    private static $password = 'P@ssw0rd';

```
Antes de criar as tabelas vocÊ deve criar um banco de dados no seu servidor de banco de dados. Note nos atributos anteriores que há uma propriedade inicializada com o valor 'api_estoque_1'. Este valor representa o nome do banco de dados. Sendo assim, você precisa criar um banco de dados com o nome definido alí ou alterar para refletir seu ambiente.

Criado o banco de dados, você precisa executar os scripts sql no servidor de banco de dados, para criar as tabelas e gerar alguns registros para testes.


Após isso, você deve estar certo de que o script esteja em um diretório que possa ser lido pelo servidor web local ou, que tenha permissões suficiente de acesso ao diretório para utilizar o servidor embutido do php. 
Em geral para se utilizar o servidor embutido, utiliza-se o seguinte comando no diretório do projeto:

```
php -S localhost:8080

```

Após iniciar o servidor embutido, será possível invocar o programa no browser através de um endereço URL como:

```
http://localhost:8080

```

### Usage

Feito as configurações acima, você precisa utilizar um client para invocar os endpoints. O arquivo api.php dentro do diretório routes, mostra as definições de rotas no momento:


```php

/**
 * Login
 */
$router->post('login', "\Api\Controllers\LoginController@login");
/**
 * Cadastros Gerais
 */
// Rotas Usuarios
$router->resource("usuarios", "\Api\Controllers\UsuarioController");
// Rotas Clientes
$router->resource("clientes", "\Api\Controllers\ClienteController");
// Rotas Fornecedores
$router->resource("fornecedores", "\Api\Controllers\FornecedorController");
// Rotas Transportadoras
$router->resource("transportadoras", "\Api\Controllers\TransportadoraController");
// Rotas Produtos
$router->resource("produtos", "\Api\Controllers\ProdutoController");

```
Note que todas são resources, ou seja, contém os métodos: **index, show, update, store, delete**. Caso você queira adicionar novas rotas, poderá seguir o mesmo padrão ou definir para um verbo específico:

```php

$router->get("produtos", "\Api\Controllers\ProdutoController@index");

$router->get("produtos/{id}", "\Api\Controllers\ProdutoController@show");

$router->put("produtos/{id}", "\Api\Controllers\ProdutoController@update");

$router->post("produtos", "\Api\Controllers\ProdutoController@store");

$router->delete("produtos/{id}", "\Api\Controllers\ProdutoController@delete");

```

Para cada Controller novo criado, ele deverá implementar a interface **iControllerDefault**. Além disso, neste projeto, os controllers estão sendo armazenados no diretório controllers, com o namespace **Api\Controllers**.

Para cada model criado, a classe deverá extender \Api\Database\Model, que é um ORM desenvolvido para este projeto. Além disso, precisa invocar o construtor da classe pai passando como argumento o nome da tabela. Note o exemplo:

```php

namespace Api\Models;
use \Api\Database\Model;

class Produto extends Model
{
    public function __construct()
    {
        parent::__construct('produtos');
    }
}


```

Um sistema de rotas simplificado foi desenvolvido e ele é invocado pelo objeto app, que trata a requisição e manipula utilizado o roteador. Todo percurso de volta retorna para um objeto response que envia os cabeçalhos e os conteúdos. Por isso, no arquivo index.php temos apenas estas declarações:


```php

include_once './bootstrap.php';
try {
    response()->setContent(app()->handler())->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}

```

Se você deseja ensinar o sistema de injeção de dependências, pode editar o arquivo core/services.php. Este arquivo está assim:

```php

/**
 * Serviços do Injetor de dependência
 */
$service->register('Api\Http\Request', function() {
    return new \Api\Http\Request;
});
$service->register('Api\Http\Response', function() {
    return new \Api\Http\Response;
});

```
Então, note que o objeto service tem um método register que recebe dois argumentos: uma string declarando FQCN (Fully-Qualified Class Name) e uma callback que deve retornar uma instância da classe, utilizando também FCQN. Fazendo isso, será possivel ensinar o container a injetar os objetos corretos conforme especificados nos seus métodos:

```php

public function create(Request $request)
{
	// request foi instanciado automaticamente
	
	$data = $request->all();
}

```

## Authors

* **Alexandre Bezerra Barbosa**
