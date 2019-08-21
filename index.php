<?php
include_once './bootstrap.php';
try {
    response()->setContent(app()->handler())->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}