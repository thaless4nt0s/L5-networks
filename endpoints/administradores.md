### Rotas de Administradores

**POST** `/admin`

- **Descrição**: Endpoint responsável por criar um administrador.

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                  | VALORES ACEITOS         |
| ------------ | ------ | ------------- | ------------------------ | ----------------------- |
| nome         | string | Sim           | Rogério almeida          |                         |
| email        | string | Sim           | rogerioalmeida@email.com |                         |
| senha        | string | Sim           | 12345678                 | A partir de 8 digitos   |

```
{
    "parametros":{
        "nome": "rogerio almeida",
        "email": "rogerioAlmeidar@email.com",
        "senha": "12345678"
    }
}

```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Administrador adicionado com sucesso",
        "status": 200
    },
    "retorno": {
        "nome": "rogerio almeida",
        "email": "rogerioAlmeidar@email.com"
    }
}
```

---

**POST** `/admin/login`

- **Descrição**: Endpoint responsável por realizar login.

**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                  | VALORES ACEITOS         |
| ------------ | ------ | ------------- | ------------------------ | ----------------------- |
| email        | string | Sim           | rogerioalmeida@email.com |                         |
| senha        | string | Sim           | 12345678                 | A partir de 8 digitos   |

```
{
    "parametros":{
        "email": "yurialberto@email.com",
        "senha": "12345678"
    }
}
```

**Response**

```
{
    "cabecalho": {
        "message": "Login realizado com sucesso",
        "status": 200
    },
    "retorno": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJc3N1ZXIgb2YgdGhlIEpXVCIsImF1ZCI6IkF1ZGllbmNlIHRoYXQgdGhlIEpXVCIsInN1YiI6IlN1YmplY3Qgb2YgdGhlIEpXVCIsImlhdCI6MTc0MDc2OTA4MywiZXhwIjoxNzQwNzcyNjgzLCJlbWFpbCI6Inl1cmlhbGJlcnRvQGVtYWlsLmNvbSJ9.AiUqQadeN8RGPvY0Fm0Yc9pf-GPIn6TOpLpq0umBlU4"
    }
}
```

---

**PUT** `/admin/{id}`

- **Descrição**: Endpoint responsável por alterar dados um administrador.
- **Autenticação**: Necessário
**Query**:

| CAMPO        | TIPO   | OBRIGATÓRIO   | EXEMPLO                  | VALORES ACEITOS         |
| ------------ | ------ | ------------- | ------------------------ | ----------------------- |
| nome         | string | Sim           | Rogério silva            |                         |
| email        | string | Sim           | rsilva@email.com         |                         |
| senha        | string | Sim           | 12345678                 | A partir de 8 digitos   |

```
{
    "parametros":{
        "nome": "rogerio silva",
        "email": "rsilva@email.com",
        "senha": "12345678"
    }
}

```

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Administrador atualizado com sucesso",
        "status": 200
    },
    "retorno": {
        "nome": "rogerio silva",
        "email": "rsilva@email.com"
    }
}
```

---

**DELETE** `/admin/{id}`

- **Descrição**: Endpoint responsável por remover um administrador.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Administrador excluido com sucesso",
        "status": 200
    },
    "retorno": null
}
```

---

**GET** `/admin?nome={}&email={}&page={}`

- **Descrição**: Endpoint responsável por mostrar todos os administradores.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Listagem de admins",
        "status": 200
    },
    "retorno": {
        "admins": [
            {
                "nome": "rogerio",
                "email": "rogerio@email.com"
            },
            {
                "nome": "rogerio junior",
                "email": "rogeriojr@email.com"
            }
        ],
        "paginacao": "\n<nav aria-label=\"Page navigation\">\n\t<ul class=\"pagination\">\n\t\t\n\t\t\t\t\t<li class=\"active\">\n\t\t\t\t<a href=\"http://localhost:8080/index.php/admin?page=1\">\n\t\t\t\t\t1\t\t\t\t</a>\n\t\t\t</li>\n\t\t\t\t\t<li >\n\t\t\t\t<a href=\"http://localhost:8080/index.php/admin?page=2\">\n\t\t\t\t\t2\t\t\t\t</a>\n\t\t\t</li>\n\t\t\n\t\t\t</ul>\n</nav>\n"
    }
}
```

---

**GET** `/admin/{id}`

- **Descrição**: Endpoint responsável por mostrar um administrador.
- **Autenticação**: Necessário

**Response**:

```
{
    "cabecalho": {
        "mensagem": "Administrador",
        "status": 200
    },
    "retorno": {
        "nome": "rogerio",
        "email": "rogerio@email.com"
    }
}
```

---