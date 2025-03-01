### Rotas de clientes

**POST** `/clientes`

- **Descrição**: Endpoint responsável por criar um cliente.
- **Autenticação**: Necessário

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                 | VALORES ACEITOS   |
| ------------ | ------ | ------------- | ----------------------- | ----------------- |
| cpf          | string | Sim           | 12376589066             | 11 dígitos        |
| nome         | string | Sim           | José Roberto dos Santos |                   |

```
{
    "parametros":{
        "cpf": "11111111111",
        "nome": "José Roberto dos Santos"
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Cliente adicionado com sucesso",
        "status": 200
    },
    "retorno": {
        "id": "16",
        "nome": "José Roberto dos Santos",
        "cpf": "12376589066",
        "pedidos": []
    }
}
```

---

**PUT** `/clientes/:idCliente`

- **Descrição**: Endpoint responsável por atualizar um cliente.
- **Autenticação**: Necessário

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                        | VALORES ACEITOS   |
| ------------ | ------ | ------------- | ------------------------------ | ----------------- |
| cpf          | string | Sim           | 12376589066                    | 11 dígitos        |
| nome         | string | Sim           | José Roberto Soares dos Santos |                   |

```
{
    "parametros":{
        "cpf": "32154365677",
        "nome": "josé roberto soares dos santos"
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Cliente atualizado com sucesso",
        "status": 200
    },
    "retorno": {
        "id": "16",
        "nome": "josé roberto soares dos santos",
        "cpf": "32154365677",
        "pedidos": []
    }
}
```

---

**DELETE** `/clientes/:idCliente`

- **Descrição**: Endpoint responsável por remover um cliente.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Cliente removido com sucesso",
        "status": 200
    },
    "retorno": null
}
```

---

**GET** `/clientes?nome={}&page={}`

- **Descrição**: Endpoint responsável por mostrar todos os clientes.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de clientes",
        "status": 200
    },
    "retorno": [
        {
            "nome": "João marcelo souza",
            "cpf": "11111111111",
            "id": "1",
            "pedidos": [
                {
                    "id": "9",
                    "dia": "2025-12-01",
                    "quantidade": "10",
                    "valor_compra": "240.00",
                    "idProduto": "2",
                    "status": "Em aberto"
                },
                {
                    "id": "8",
                    "dia": "2025-02-27",
                    "quantidade": "30",
                    "valor_compra": "720.00",
                    "idProduto": "2",
                    "status": "Em aberto"
                }
            ]
        },
        {
            "nome": "Alberto Rodrigues",
            "cpf": "12312312311",
            "id": "3",
            "pedidos": [
                {
                    "id": "10",
                    "dia": "2025-02-27",
                    "quantidade": "4",
                    "valor_compra": "96.00",
                    "idProduto": "2",
                    "status": "Em aberto"
                }
            ]
        },
        {
            "nome": "João marcelo souza",
            "cpf": "12312312333",
            "id": "12",
            "pedidos": [
                {
                    "id": null,
                    "dia": null,
                    "quantidade": null,
                    "valor_compra": null,
                    "idProduto": null,
                    "status": null
                }
            ]
        },
        "paginacao": "\n<nav aria-label=\"Page navigation\">\n\t<ul class=\"pagination\">\n\t\t\n\t\t\t\t\t<li class=\"active\">\n\t\t\t\t<a href=\"http://localhost:8080/index.php/clientes?nome=Alberto&page=1\">\n\t\t\t\t\t1\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/clientes?nome=Alberto&page=2\">\n\t\t\t\t\t2\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/clientes?nome=Alberto&page=3\">\n\t\t\t\t\t3\t\t\t\t</a>\n\t\t\t</li>\n\t\t\n\t\t\t\t\t<li>\n\t\t\t\t<a href=\"http://localhost:8080/index.php/clientes?nome=Alberto&page=4\" aria-label=\"Next\">\n\t\t\t\t\t<span aria-hidden=\"true\">Next</span>\n\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t<li>\n\t\t\t\t<a href=\"http://localhost:8080/index.php/clientes?nome=Alberto&page=4\" aria-label=\"Last\">\n\t\t\t\t\t<span aria-hidden=\"true\">Last</span>\n\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t</ul>\n</nav>\n"
    ]
    
}
```

---

**GET** `/clientes/:idCliente`

- **Descrição**: Endpoint responsável por mostrar um cliente em específico.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "dados do cliente",
        "status": 500
    },
    "retorno": {
        "id": "1",
        "nome": "João marcelo souza",
        "cpf": "11111111111",
        "pedidos": [
            {
                "id": "4",
                "dia": "2025-02-27",
                "quantidade": "30",
                "valor_compra": "720.00",
                "idProduto": "2",
                "status": "Em aberto"
            },
            {
                "id": "5",
                "dia": "2025-02-27",
                "quantidade": "30",
                "valor_compra": "720.00",
                "idProduto": "2",
                "status": "Em aberto"
            }
        ]
    }
}

```

---
