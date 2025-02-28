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