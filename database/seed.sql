INSERT INTO `usuarios` (`username`, `password`, `email`, `nome`) VALUES ('admin', '123456', 'admin@test.com', 'Admin');
-- ESTADOS
INSERT INTO `estados` (`user_id`, `sigla`, `nome`) VALUES 
(1, 'SP', 'SÃO PAULO'),
(1, 'PA', 'PARANÁ'),
(1, 'MG', 'MINAS GERAIS');
-- CIDADES
INSERT INTO `cidades` (`user_id`, `estado_id`, `nome`) VALUES 
(1, 1, 'SÃO PAULO'),
(1, 1, 'CAMPINAS'),
(1, 1, 'SOROCABA')
(1, 2, 'CURITIBA'),
(1, 2, 'LONDRINA'),
(1, 3, 'BELO HORIZONTE');
-- CLIENTES
INSERT INTO `clientes` (`user_id`,`cidade_id`,`cnpj_cpf`,`nome`,`endereco`,`email`,`telefone`) VALUES
(1,1,'88000000000125', 'PAULO SANTOS ME', 'AV WHASINGTON LUIZ, 1000', 'pcs@gmail.com', '113345325'),
(1,1,'33000000000125', 'SUPER CENTRO', 'ROD. CASTELO EMBRAQUECIDO KM 22', 'vendas@super.com', '114444234'),
(1,2,'33322423000142', 'MMCD MD', 'ROD. DO CHICO KM 310', 'administracao@mmcsd.com', '413344344444'),
(1,2,'18122423000140', 'SANDRA MAIS ME LTDA', 'AV 123 200', 'administracao@sandramais.com', '4133888444'),
(1,3,'45324323000185', 'BIRO ELETRONICOS LTDA', 'RUA ALVARENGA PEIXERO, 345', 'vendas@etabom.com', '31322224444'),
(1,3,'45324323000185', 'ELB SOM VIDEO E SOM ME LTDA', 'AV ALVARES CABRA, 145', 'vendas@elbsom.com', '31888994444');  
-- FORNECEDORES
INSERT INTO `fornecedores` (`user_id`,`cidade_id`,`cnpj`,`nome`,`endereco`,`email`,`telefone`) VALUES
(1,1,'31000000000125', 'MMXI TECH DISTRIBUIDORA', 'ROD. CASTELO EMBRAQUECIDO KM 22', 'vendas@mmxi.com', '1133211234'),
(1,1,'33000000000125', 'HMAX VIDEO E SOM', 'ROD. CASTELO EMBRAQUECIDO KM 35', 'vendas@hmax.com', '1133211234'),
(1,2,'22122423000140', 'GURIA DIST PROD ELETRONICOS LTDA', 'ROD. DO CHICO KM 210', 'administracao@piadaestrada.com', '4133334444'),
(1,2,'18122423000140', 'ARFA ELETONICAS LTDA', 'ROD. DO CHICO KM 200', 'administracao@arda.com', '4133666444'),
(1,3,'45324323000185', 'ETASOMBOM DIST ELETRONICOS LTDA', 'ROD. DO ANÚARIO CARNEIRO, 12345', 'vendas@etabom.com', '31322224444'),
(1,3,'45324323000185', 'TREMDESOM VIDEO E SOM LTDA', 'ROD. DO ANÚARIO CARNEIRO, 12345', 'vendas@tremdesom.com', '3134454444');  
-- TRANSPORTADORAS
INSERT INTO `transportadoras` (`user_id`,`cidade_id`,`cnpj`,`nome`,`endereco`,`email`,`telefone`) VALUES
(1,1,'35123123000125', 'CARREGA TUDO ALÉM DE FEIJUCA TRANSPORTES', 'ROD. CASTELO EMBRAQUECIDO KM 35', 'vendas@carregaalemfejuca.com', '1143211234'),
(1,2,'18123123000120', 'MUNDEADO NA ESTRADA TRANSPORTES', 'ROD. DO CHICO KM 200', 'administracao@mundeadoestrada.com', '4133334444'),
(1,3,'25123123000115', 'ARREDA ESSE TREM LOGO TRANSPORTES', 'ROD. DO ANÚARIO CARNEIRO, 12345', 'vendas@carregatudolasp.com', '3135554444');  
-- CATEGORIAS DE PRODUTOS
INSERT INTO `categorias` (`user_id`,`categoria`) VALUES
(1, 'TELEVISORES'),
(1, 'CELULARES'),
(1, 'ELETRONICOS');
-- PRODUTOS
INSERT INTO `produtos` (`user_id`,`categoria_id`,`fornecedor_id`,`SKU`,`descricao`,`peso`,`controlado`,`quantidade_minima`,`quantidade_estoque`) VALUES
(1, 1, 1, '305580-1', 'Smart TV 65" 4K HDR NanoCell ThinQ LG', 33.3, true, 4, 2),
(1, 1, 2, '272987-1', 'Smart TV LED 32" HD Philco ', 5.37, true, 10, 4),
(1, 1, 3, '269591-1', 'Smart TV LED 32" HD LG 32LK615BP', 5.15, true, 10, 3),
(1, 2, 4, '300363-1', 'Celular GO!1c Dual Chip SEMP - Preto', 0.7, true, 10, 5),
(1, 2, 5, '301482-2', 'Celular Smartphone Pocophone F1 CX262 Xiaomi - Preto', 0.8, true, 10, 7) ,
(1, 2, 6, '301491-2', 'Celular Smartphone Mi 8 Lite 6,26" 64GB Xiaomi - Preto', 0.9, true, 10, 5),
(1, 3, 1, '300628', 'Refrigerador 474 Litros TF56 Branco Electrolux', 73.0, true, 15, 10),
(1, 3, 3, '277747', 'Forno Elétrico Sapore Inox G3 Mueller', 13.0, true, 15, 8),
(1, 3, 5, '220085', 'Sanduicheira Easy Meal II San253 Preta Cadence', 1.1, true, 8, 4);
-- PEDIDOS DE COMPRAS PARA O ESTOQUE
INSERT INTO `pedidos_compras` (`user_id`,`fornecedor_id`,`data_pedido`,`data_aprovacao`) VALUES 
(1, 1, '2019-07-19 15:22:14', '2019-08-01 11:45:42'),
(1, 2, '2019-07-20 14:22:42', '2019-08-01 13:21:15'),
(1, 3, '2019-07-25 12:59:12', '2019-08-01 11:27:12'),
(1, 4, '2019-07-28 11:20:16', '2019-08-01 12:33:17'),
(1, 5, '2019-07-28 08:30:19', '2019-08-01 14:52:32'),
(1, 6, '2019-07-28 07:22:42', '2019-08-01 15:34:56');
-- ITENS NOS PEDIDOS DE COMPRA PARA O ESTOQUE
INSERT INTO `itens_pedido_compras` (`user_id`, `pedido_compra_id`, `produto_id`, `quantidade`, `valor`) VALUES
(1, 1, 1, 5, 7200.00),
(1, 2, 2, 5, 1230.00),
(1, 3, 3, 5, 1580.00),
(1, 4, 3, 5, 65.00),
(1, 5, 3, 5, 809.00),
(1, 6, 3, 5, 1150.00);

