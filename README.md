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

3. Executar o docker para o banco de dados, após isso, após isso ele iniciará normalmente:

```
docker-compose up-d
```

3.1. Caso não execute ou queira executar em outra ocasião

```
Para listar os containers
->docker ps -a 

Para iniciar um container em especifico
->docker start NOME_DO_CONTAINER
ou 
->docker start CONTAINER_ID

obs: Será necessário inicializar os containers para o mysql e para o phpmyadmin.

Caso esteja usando o Docker Desktop, basta dar START nos containers que foram adicionados

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

## Passo a passo no uso do sistema
##### OBS os passos 3 e 4 podem ser realizados na ordem inversa

1. Criar uma conta - [Administradores](endpoints/administradores.md)
2. Realizar Login - [Administradores](endpoints/administradores.md)
3. Criar um Produto - [Produtos](endpoints/produtos.md) 
4. Criar um Cliente - [Clientes](endpoints/clientes.md) 
5. Criar um Pedido - [Pedidos](endpoints/pedidosDeCompra.md) 
6. Dar baixa em um pedido (alterar dados) - [Pedidos](endpoints/pedidosDeCompra.md) 