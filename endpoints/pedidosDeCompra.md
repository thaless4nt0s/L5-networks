### Rotas de Pedidos de Compra

**POST** `/pedidosDeCompra`

- **Descrição**: Endpoint responsável por criar um pedido de compra.

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                 |
| ------------ | ------ | ------------- | ----------------------- |
| quantidade   | int    | Sim           | 1                       |
| idCliente    | int    | Sim           | 16                      |
| idProduto    | int    | Sim           | 2                       |


```
{
    "parametros": {
        "quantidade": 4,
        "idCliente": 16,
        "idProduto": 2
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Pedido criado com sucesso",
        "status": 200
    },
    "retorno": {
        "id": "11",
        "dia": "2025-02-27",
        "quantidade": "4",
        "valor_compra": "96.00",
        "idCliente": "16",
        "idProduto": "2",
        "status": "Em aberto",
        "nomeCliente": "José Roberto dos Santos",
        "nomeProduto": "café santa clara",
        "valorProdutoIndividual": "24.00"
    }
}
```

---

**PUT** `/pedidosDeCompra/:idPedidosDeCompra`

- **Descrição**: Endpoint responsável por atualizar um pedido de compra.

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                 | VALORES ACEITOS            |
| ------------ | ------ | ------------- | ----------------------- | -------------------------- |
| dia          | data   | Sim           | 2025-12-21              |                            |
| quantidade   | int    | Sim           | 10                      |                            |
| idCliente    | int    | Sim           | 1                       |                            |
| idProduto    | int    | Sim           | 2                       |                            |
| status       | string | Sim           | Em aberto               | Em aberto, Pago, Cancelado | 

```
{
    "parametros": {
        "dia": "2025-12-21",
        "quantidade": 10,
        "idCliente": 1,
        "idProduto": 2,
        "status": "Em aberto"
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Pedido atualizado com sucesso",
        "status": 200
    },
    "retorno": {
        "id": "9",
        "dia": "2025-12-21",
        "quantidade": "10",
        "valor_compra": "240.00",
        "idCliente": "1",
        "idProduto": "2",
        "status": "Em aberto",
        "nomeCliente": "João marcelo souza",
        "nomeProduto": "café santa clara",
        "valorProdutoIndividual": "24.00"
    }
}
```
---

**DELETE** `/pedidosDeCompra/:idPedidosDeCompra`

- **Descrição**: Endpoint responsável por remover um pedido de compra.

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Pedido excluido com sucesso ",
        "status": 200
    },
    "retorno": null
}
```

---

**GET** `/pedidosDeCompra?nomeCliente={}&status={}&nomeProduto&?page={}`

- **Descrição**: Endpoint responsável por mostrar todos os pedidos.

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de todos os pedidos",
        "status": 200
    },
   "retorno": {
        "pedidos": [
            {
                "id": "4",
                "dia": "2025-02-27",
                "quantidade": "30",
                "valor_compra": "720.00",
                "idCliente": "1",
                "idProduto": "2",
                "status": "Em aberto",
                "nomeCliente": "João marcelo souza",
                "nomeProduto": "café santa clara",
                "valorProdutoIndividual": "24.00"
            },
            {
                "id": "6",
                "dia": "2025-02-27",
                "quantidade": "30",
                "valor_compra": "7799.70",
                "idCliente": "1",
                "idProduto": "3",
                "status": "Em aberto",
                "nomeCliente": "João marcelo souza",
                "nomeProduto": "Frigideira anti aderente",
                "valorProdutoIndividual": "124.00"
            }
        ],
        "paginacao": "\n<nav aria-label=\"Page navigation\">\n\t<ul class=\"pagination\">\n\t\t\n\t\t\t\t\t<li class=\"active\">\n\t\t\t\t<a href=\"http://localhost:8080/index.php/pedidosDeCompra?nomeCliente=Jo%C3%A3o&page=1\">\n\t\t\t\t\t1\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/pedidosDeCompra?nomeCliente=Jo%C3%A3o&page=2\">\n\t\t\t\t\t2\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/pedidosDeCompra?nomeCliente=Jo%C3%A3o&page=3\">\n\t\t\t\t\t3\t\t\t\t</a>\n\t\t\t</li>\n\t\t\n\t\t\t\t\t<li>\n\t\t\t\t<a href=\"http://localhost:8080/index.php/pedidosDeCompra?nomeCliente=Jo%C3%A3o&page=4\" aria-label=\"Next\">\n\t\t\t\t\t<span aria-hidden=\"true\">Next</span>\n\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t<li>\n\t\t\t\t<a href=\"http://localhost:8080/index.php/pedidosDeCompra?nomeCliente=Jo%C3%A3o&page=4\" aria-label=\"Last\">\n\t\t\t\t\t<span aria-hidden=\"true\">Last</span>\n\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t</ul>\n</nav>\n"
    }
}

```

---

**GET** `/pedidosDeCompra/:idPedidosDeCompra`

- **Descrição**: Endpoint responsável por mostrar um pedido em específico.

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem De um Pedido",
        "status": 200
    },
    "retorno": {
        "id": "4",
        "dia": "2025-02-27",
        "quantidade": "30",
        "valor_compra": "720.00",
        "idCliente": "1",
        "idProduto": "2",
        "status": "Em aberto",
        "nomeCliente": "João marcelo souza",
        "nomeProduto": "café santa clara",
        "valorProdutoIndividual": "24.00"
    }
}

```

---
