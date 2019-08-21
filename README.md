# api_estoque_sem_fw

## Desenvolvimento PHP sem frameworks.

## Development without framework
This is an API project using only PHP. All classes were developed based on POO and MVC.
You can find here some interesting features like these: authentication (JWT) and IoC. And some pattern like ActiveRecord, Singleton, strategy, etc.
There are all steps from request to response. When you call for an endpoint, all submitted data will be "wrapped" into a Request object first.
An Application object suchs as a container, will intercept a request that contains a route. If it finds a valid route, dispacher will instantiate a "controller" that was informed with the search result in the route collection.Each route must have a pointed controller and a defined method. But, there are some cases where you would prefer to use a Resource routes.
In this project you can see some controllers with all methods to form a resource (containing all CRUD operations). For each response, a Response object will be instantiated to handle the response to the user. To set up the Dependecy Injector, you can "teach" the Container object by defining classes associated with name references in the "\core\services.php" file.

------------------------------------------------------------------------------------------------------------------------------------------

Desenvolvimento de API em PHP completamente POO e MVC e MySQL.
Autenticação utilizando JWT.
Auto Injeção de Dependência em Container.
Sistema simplificado de rotas para acesso aos endpoints

O sistema ainda está em desenvolvimento, mas já permite cadastros e acessos aos resources.

Clientes, Fornecedores, Produtos, Categorias de Produtos, Usuarios, etc.

Os processos de pedido de compra, entrada e saida de estoque ainda estão em desenvolvimento.

Os testes precisam ser realizados utilizando Postman.

