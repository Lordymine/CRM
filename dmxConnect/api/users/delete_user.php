<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "id"
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
        "name": "user",
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
                  "id": "users.id",
                  "field": "users.id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.id}}",
                  "data": {
                    "table": "users",
                    "column": "id",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM users\nWHERE id = :P1 /* {{$_GET.id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.id}}"
              }
            ]
          }
        },
        "meta": [
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
        ],
        "outputType": "object"
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{user}}",
          "then": {
            "steps": {
              "name": "fileExists",
              "module": "fs",
              "action": "direxists",
              "options": {
                "path": "{{'/assets/uploads/users/'+user.id}}",
                "then": {
                  "steps": {
                    "name": "removeFolder",
                    "module": "fs",
                    "action": "removedir",
                    "options": {
                      "path": "{{'/assets/uploads/users/'+user.id}}"
                    },
                    "outputType": "boolean"
                  }
                }
              },
              "outputType": "boolean"
            }
          }
        },
        "outputType": "boolean"
      },
      {
        "name": "delete",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "delete",
            "table": "users",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "id",
                  "field": "id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.id}}",
                  "data": {
                    "column": "id"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "DELETE\nFROM users\nWHERE id = :P1 /* {{$_GET.id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.id}}"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "affected",
            "type": "number"
          }
        ]
      }
    ]
  }
}
JSON
);
?>