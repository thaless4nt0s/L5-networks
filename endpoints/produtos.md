### Rotas de produtos

**POST** `/produtos`

- **Descrição**: Endpoint responsável por criar um produto.

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

**GET** `/produtos`

- **Descrição**: Endpoint responsável por mostrar todos os produtos.

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de produtos",
        "status": 200
    },
    "retorno": [
        {
            "id": "2",
            "nome": "café santa clara",
            "valor": "24.00"
        },
        {
            "id": "3",
            "nome": "Frigideira anti aderente",
            "valor": "124.00"
        },
        {
            "id": "8",
            "nome": "Água crystal 250 ML",
            "valor": "2.00"
        }
    ]
}

```

---

**GET** `/produtos/:idProduto`

- **Descrição**: Endpoint responsável por mostrar um produto em específico.

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
