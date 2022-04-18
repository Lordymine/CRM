<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "token"
      }
    ]
  },
  "exec": {
    "steps": [
      {
        "name": "query",
        "module": "dbconnector",
        "action": "single",
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
                  "id": "users.token",
                  "field": "users.token",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_GET.token}}",
                  "data": {
                    "table": "users",
                    "column": "token",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM users\nWHERE token = :P1 /* {{$_GET.token}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.token}}"
              }
            ]
          }
        },
        "output": true,
        "meta": [
          {
            "name": "id",
            "type": "text"
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
            "type": "text"
          },
          {
            "name": "permission_level",
            "type": "text"
          },
          {
            "name": "created_at",
            "type": "datetime"
          },
          {
            "name": "updated_at",
            "type": "datetime"
          },
          {
            "name": "department_id",
            "type": "number"
          }
        ],
        "outputType": "object"
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{query.avatar}}",
          "then": {
            "steps": {
              "name": "user_avatar",
              "module": "core",
              "action": "setvalue",
              "options": {
                "value": "{{query.avatar}}"
              },
              "output": true
            }
          },
          "else": {
            "steps": {
              "name": "user_avatar",
              "module": "core",
              "action": "setvalue",
              "options": {
                "value": "/assets/uploads/usuario_semfoto.png"
              },
              "output": true
            }
          }
        },
        "outputType": "boolean"
      }
    ]
  }
}
JSON
);
?>