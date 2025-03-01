### Rotas de produtos

**POST** `/produtos`

- **Descrição**: Endpoint responsável por criar um produto.
- **Autenticação**: Necessário

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                 |
| ------------ | ------ | ------------- | ----------------------- |
| nome         | string | Sim           | Água crystal 250 ML     |
| valor        | float  | Sim           | 2.99                    |

```
{
    "parametros": {
        "nome": "Água crystal 250 ML",
        "valor": 2.99
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Produto criado com sucesso!",
        "status": 200
    },
    "retorno": {
        "id": "8",
        "nome": "Água crystal 250 ML",
        "valor": "2.99"
    }
}
```

---

**PUT** `/produtos/:idProduto`

- **Descrição**: Endpoint responsável por atualizar um produto.
- **Autenticação**: Necessário

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                  |
| ------------ | ------ | ------------- | ------------------------ |
| nome         | string | Sim           | Frigideira anti aderente |
| valor        | float  | Sim           | 124                      |

```
{
    "parametros": {
        "nome": "Frigideira anti aderente",
        "valor": 124
    }
}
```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Produto atualizado com sucesso!",
        "status": 200
    },
    "retorno": {
        "id": "3",
        "nome": "Frigideira anti aderente",
        "valor": "124.00"
    }
}
```

---

**DELETE** `/produtos/:idProduto`

- **Descrição**: Endpoint responsável por remover um produto.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Produto removido com sucesso!",
        "status": 200
    },
    "retorno": null
}
```

---

**GET** `/produtos?nome={}&page={}`

- **Descrição**: Endpoint responsável por mostrar todos os produtos.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de produtos",
        "status": 200
    },
    "retorno": {
        "produtos": [
            {
                "id": "2",
                "nome": "café santa clara",
                "valor": "24.00"
            },
            {
                "id": "7",
                "nome": "café",
                "valor": "10.00"
            }
        ],
        "paginacao": "\n<nav aria-label=\"Page navigation\">\n\t<ul class=\"pagination\">\n\t\t\n\t\t\t\t\t<li class=\"active\">\n\t\t\t\t<a href=\"http://localhost:8080/index.php/produtos?nome=caf%C3%A9&page=1\">\n\t\t\t\t\t1\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/produtos?nome=caf%C3%A9&page=2\">\n\t\t\t\t\t2\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/produtos?nome=caf%C3%A9&page=3\">\n\t\t\t\t\t3\t\t\t\t</a>\n\t\t\t</li>\n\t\t\n\t\t\t</ul>\n</nav>\n"
    }
}

```

---

**GET** `/produtos/:idProduto`

- **Descrição**: Endpoint responsável por mostrar um produto em específico.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de produtos",
        "status": 200
    },
    "retorno": {
        "id": "3",
        "nome": "Frigideira anti aderente",
        "valor": "124.00"
    }
}

```

---
