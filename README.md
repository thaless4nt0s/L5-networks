# Processo seletivo L5 - Networks

## O que é esse projeto ?

```
Consiste em implementar uma API REST utilizando o framework PHP
Codeigniter 4, e um banco de dados relacional MySQL.
Além disso, criar uma API de cadastro de pedidos de compra.
```

## Instalação

1. Baixando o projeto:

```
git clone https://github.com/thaless4nt0s/L5-networks.git

```

2. Acessar o diretório do projeto

```
cd L5-networks
```

3. Executar o docker para o banco de dados, após isso, ele executará normalmente:

```
docker-compose up-d
```

4. Instalando as dependências:

```
composer install
```

5. Ajustar as configurações do banco de dados no seu ENV

```
database.default.hostname = db
database.default.database = NOME DO BANCO
database.default.username = USUARIO
database.default.password = SENHA
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
---------
JWT_SECRET=
```

6. Executar o projeto:

```
php spark serve
```

7. Para acessar o banco de dados, usuário e senha são estabelecidos no item 5:

```
http://localhost:8081/
```

---

# Documentações

| Rotas                                           |
| ----------------------------------------------- |
| [Clientes](endpoints/clientes.md)               |
| [Produtos](endpoints/produtos.md)               |
| [Pedidos](endpoints/pedidosDeCompra.md)         |
| [Administradores](endpoints/administradores.md) |

---
