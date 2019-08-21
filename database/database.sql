-- DEFINIÇÃO DAS TABELAS DO BANCO DE DADOS PARA UM CONTROLE DE ESTOQUE SIMPLES

-- TABELA QUE DEFINE OS USUÁRIOS DO SISTEMA
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `email` VARCHAR(128) DEFAULT NULL,
    `nome` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`),
);

-- TABELA QUE DEFINE OS ESTADOS
CREATE TABLE IF NOT EXISTS `estados` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `sigla` char(2) NOT NULL,
    `nome` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE
);

-- TABELA QUE DEFINE AS CIDADES
CREATE TABLE IF NOT EXISTS `cidades` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `estado_id` int(11) NOT NULL,
    `nome` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`estado_id`) REFERENCES `estados`(id) ON DELETE CASCADE
);

-- TABELA QUE DEFINE O CADASTRO DE FORNECEDORES
CREATE TABLE IF NOT EXISTS `fornecedores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `cidade_id` int(11) NOT NULL,
    `cnpj` VARCHAR(128) NOT NULL,
    `nome` VARCHAR(128) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `email` VARCHAR(128) DEFAULT NULL,
    `telefone` VARCHAR(14) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`cidade_id`) REFERENCES `cidades`(id) ON DELETE CASCADE
);

-- TABELA QUE DEFINE OS CADASTROS DAS TRANSPORTADORAS
CREATE TABLE IF NOT EXISTS `transportadoras` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `cidade_id` int(11) NOT NULL,
    `cnpj` VARCHAR(128) NOT NULL,
    `nome` VARCHAR(128) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `email` VARCHAR(128) DEFAULT NULL,
    `telefone` VARCHAR(14) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`cidade_id`) REFERENCES `cidades`(id) ON DELETE CASCADE
);

-- TABELA QUE DEFINE OS CADASTROS DE CLIENTES
CREATE TABLE IF NOT EXISTS `clientes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `cidade_id` int(11) NOT NULL,
    `cnpj_cpf` VARCHAR(128) NOT NULL,
    `nome` VARCHAR(128) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `email` VARCHAR(128) DEFAULT NULL,
    `telefone` VARCHAR(14) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`cidade_id`) REFERENCES `cidades`(id) ON DELETE CASCADE
);

-- TABELA QUE DEFINE AS CATEGORIAS DE PRODUTOS
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `categoria` VARCHAR(128) NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE 
);

-- TABELA QUE CONTROLA O PRODUTO
CREATE TABLE IF NOT EXISTS `produtos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `categoria_id` int(11) NOT NULL,
    `fornecedor_id` int(11) NOT NULL,
    `SKU` VARCHAR(128) DEFAULT NULL,
    `descricao` VARCHAR(128) NOT NULL,
    `peso` DOUBLE(10,2) DEFAULT NULL,
    `controlado` BOOLEAN DEFAULT TRUE,
    `quantidade_minima` int(11) NOT NULL, -- DEFINE NÍVEL MÍNIMO
    `quantidade_estoque` int(11) NOT NULL, -- CONTROLA NÍVEL DE ESTOQUE
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(id) ON DELETE CASCADE
);

-- TABELA QUE CONTROLA OS PDEIDOS DE COMPRAS PARA ESTOQUE
CREATE TABLE IF NOT EXISTS `pedidos_compras` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `fornecedor_id` int(11) NOT NULL,
    `data_pedido` datetime NOT NULL,
    `data_aprovacao` datetime NOT NULL, -- CONFIRMAÇÃO DE PAGAMENTO
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores`(id) ON DELETE CASCADE
);

-- TABELA COM DETALHAMENTO DOS PEDIDOS DE COMPRA PARA ESTOQUE
CREATE TABLE IF NOT EXISTS `itens_pedido_compras` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `pedido_compra_id` int(11) NOT NULL,
    `produto_id` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 1,
    `valor` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`pedido_compra_id`) REFERENCES `pedidos_compras`(id) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(id) ON DELETE CASCADE
);

-- TABELA QUE CONTROLA AS ENTRADAS NO ESTOQUE
CREATE TABLE IF NOT EXISTS `entradas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `fornecedor_id` int(11) NOT NULL,
    `transportadora_id` int(11) NOT NULL,
    `data_pedido` datetime NOT NULL,
    `data_entrada` datetime NOT NULL,
    `num_nota` int(11) DEFAULT NULL,
    `frete` DOUBLE(10,2) DEFAULT NULL,
    `imposto` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores`(id) ON DELETE CASCADE,
    FOREIGN KEY (`transportadora_id`) REFERENCES `transportadoras`(id) ON DELETE CASCADE
);

-- TABELA COM DETALHAMENTO DAS ENTRADAS NO ESTOQUE
CREATE TABLE IF NOT EXISTS `itens_entradas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `entrada_id` int(11) NOT NULL,
    `produto_id` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 1,
    `lote` VARCHAR(50) DEFAULT NULL,
    `valor` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`entrada_id`) REFERENCES `entradas`(id) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(id) ON DELETE CASCADE
);

-- TABELA QUE CONTROLA OS PDEIDOS DE VENDAS PARA CLIENTE
CREATE TABLE IF NOT EXISTS `pedidos_vendas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `cliente_id` int(11) NOT NULL,
    `num_nota` VARCHAR(128) NOT NULL,
    `faturado` BOOLEAN DEFAULT FALSE,
    `data_pedido` datetime NOT NULL,
    `data_aprovacao` datetime NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(id) ON DELETE CASCADE
);

-- TABELA COM DETALHAMENTO DOS PEDIDOS DE VENDAS PARA CLIENTE
CREATE TABLE IF NOT EXISTS `itens_pedidos_vendas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `pedido_compra_id` int(11) NOT NULL,
    `produto_id` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 1,
    `valor` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`pedido_compra_id`) REFERENCES `pedidos_compras`(id) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(id) ON DELETE CASCADE
);

-- TABELA QUE CONTROLA A RESERVA DE PRODUTOS PARA SAIDA DO ESTOQUE
CREATE TABLE IF NOT EXISTS `reservas_para_saidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `pedido_vendas_id` int(11) NOT NULL,
    `data_pedido` datetime NOT NULL,
    `data_reserva` datetime NOT NULL,
    `produto_id` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`pedido_vendas_id`) REFERENCES `pedidos_vendas`(id) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(id) ON DELETE CASCADE
);

-- TABELA QUE CONTROLA A SAIDA DO ESTOQUE
CREATE TABLE IF NOT EXISTS `saidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `cliente_id` int(11) NOT NULL,
    `transportadora_id` int(11) NOT NULL,
    `data_pedido` datetime NOT NULL,
    `data_saida` datetime NOT NULL,
    `frete` DOUBLE(10,2) DEFAULT NULL,
    `imposto` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(id) ON DELETE CASCADE,
    FOREIGN KEY (`transportadora_id`) REFERENCES `transportadoras`(id) ON DELETE CASCADE
);

-- TABELA QUE DETALHA AS SAIDAS DO ESTOQUE
CREATE TABLE IF NOT EXISTS `itens_saida` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `saida_id` int(11) NOT NULL,
    `produto_id` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 1,
    `lote` VARCHAR(50) DEFAULT NULL,
    `valor` DOUBLE(10,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `usuarios`(id) ON DELETE CASCADE,
    FOREIGN KEY (`saida_id`) REFERENCES `saidas`(id) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(id) ON DELETE CASCADE
);
