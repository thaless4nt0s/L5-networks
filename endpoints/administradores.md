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

