<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "tipo_usuario"
      },
      {
        "type": "text",
        "name": "buscar"
      },
      {
        "type": "text",
        "name": "offset"
      },
      {
        "type": "text",
        "name": "limit"
      },
      {
        "type": "text",
        "name": "sort"
      },
      {
        "type": "text",
        "name": "dir"
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "auth",
          "permissions": [
            "admin"
          ],
          "loginUrl": "/painel/login",
          "forbiddenUrl": "/painel/login/restrito"
        }
      },
      {
        "name": "query",
        "module": "dbconnector",
        "action": "paged",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [],
            "table": {
              "name": "users"
            },
            "joins": [],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "users.fullname",
                  "field": "users.fullname",
                  "type": "string",
                  "operator": "contains",
                  "value": "{{$_GET.buscar}}",
                  "data": {
                    "table": "users",
                    "column": "fullname",
                    "type": "text"
                  },
                  "operation": "LIKE"
                },
                {
                  "condition": "AND",
                  "rules": [
                    {
                      "id": "users.type_user_id",
                      "field": "users.type_user_id",
                      "type": "double",
                      "operator": "equal",
                      "value": "{{$_GET.tipo_usuario}}",
                      "data": {
                        "table": "users",
                        "column": "type_user_id",
                        "type": "number"
                      },
                      "operation": "="
                    }
                  ],
                  "conditional": "{{$_GET.tipo_usuario}}"
                }
              ],
              "conditional": null,
              "valid": true
            },
            "orders": [
              {
                "table": "users",
                "column": "fullname",
                "direction": "ASC"
              }
            ],
            "query": "SELECT *\nFROM users\nWHERE fullname LIKE :P1 /* {{$_GET.buscar}} */ AND (type_user_id = :P2 /* {{$_GET.tipo_usuario}} */)\nORDER BY fullname ASC",
            "params": [
              {
                "operator": "contains",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.buscar}}"
              },
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P2",
                "value": "{{$_GET.tipo_usuario}}"
              }
            ]
          }
        },
        "output": true,
        "meta": [
          {
            "name": "offset",
            "type": "number"
          },
          {
            "name": "limit",
            "type": "number"
          },
          {
            "name": "total",
            "type": "number"
          },
          {
            "name": "page",
            "type": "object",
            "sub": [
              {
                "name": "offset",
                "type": "object",
                "sub": [
                  {
                    "name": "first",
                    "type": "number"
                  },
                  {
                    "name": "prev",
                    "type": "number"
                  },
                  {
                    "name": "next",
                    "type": "number"
                  },
                  {
                    "name": "last",
                    "type": "number"
                  }
                ]
              },
              {
                "name": "current",
                "type": "number"
              },
              {
                "name": "total",
                "type": "number"
              }
            ]
          },
          {
            "name": "data",
            "type": "array",
            "sub": [
              {
                "name": "id",
                "type": "number"
              },
              {
                "name": "fullname",
                "type": "text"
              },
              {
                "name": "email",
                "type": "text"
              },
              {
                "name": "password",
                "type": "text"
              },
              {
                "name": "cellphone",
                "type": "text"
              },
              {
                "name": "cpf",
                "type": "text"
              },
              {
                "name": "cnpj",
                "type": "text"
              },
              {
                "name": "zipcode",
                "type": "text"
              },
              {
                "name": "address",
                "type": "text"
              },
              {
                "name": "neightborhood",
                "type": "text"
              },
              {
                "name": "city",
                "type": "text"
              },
              {
                "name": "uf",
                "type": "text"
              },
              {
                "name": "company",
                "type": "text"
              },
              {
                "name": "phone",
                "type": "text"
              },
              {
                "name": "avatar",
                "type": "text"
              },
              {
                "name": "token",
                "type": "text"
              },
              {
                "name": "status",
                "type": "number"
              },
              {
                "name": "type_user_id",
                "type": "number"
              },
              {
                "name": "permission_level",
                "type": "number"
              },
              {
                "name": "created_at",
                "type": "datetime"
              },
              {
                "name": "updated_at",
                "type": "datetime"
              }
            ]
          }
        ],
        "outputType": "object"
      }
    ]
  }
}
JSON
);
?>