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
        "name": "",
        "module": "auth",
        "action": "restrict",
        "options": {
          "provider": "auth"
        }
      },
      {
        "name": "query",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "tickets",
                "column": "*"
              },
              {
                "table": "Departamento",
                "column": "name",
                "alias": "departamento_nome"
              },
              {
                "table": "Cliente",
                "column": "fullname",
                "alias": "cliente_nome"
              },
              {
                "table": "Produto",
                "column": "name",
                "alias": "produto_nome"
              },
              {
                "table": "Responsavel",
                "column": "fullname",
                "alias": "responsavel_nome"
              },
              {
                "table": "Status",
                "column": "name",
                "alias": "status_nome"
              }
            ],
            "table": {
              "name": "tickets"
            },
            "joins": [
              {
                "table": "department_tickets",
                "column": "*",
                "alias": "Departamento",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "Departamento",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "department_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              },
              {
                "table": "users",
                "column": "*",
                "alias": "Cliente",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "Cliente",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "client_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              },
              {
                "table": "products",
                "column": "*",
                "alias": "Produto",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "Produto",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "product_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              },
              {
                "table": "users",
                "column": "*",
                "alias": "Responsavel",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "Responsavel",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "responsible_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              },
              {
                "table": "status_tickets",
                "column": "*",
                "alias": "Status",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "Status",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "status"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "query": "SELECT tickets.*, Departamento.name AS departamento_nome, Cliente.fullname AS cliente_nome, Produto.name AS produto_nome, Responsavel.fullname AS responsavel_nome, Status.name AS status_nome\nFROM tickets\nLEFT JOIN department_tickets AS Departamento ON (Departamento.id = tickets.department_id) LEFT JOIN users AS Cliente ON (Cliente.id = tickets.client_id) LEFT JOIN products AS Produto ON (Produto.id = tickets.product_id) LEFT JOIN users AS Responsavel ON (Responsavel.id = tickets.responsible_id) LEFT JOIN status_tickets AS Status ON (Status.id = tickets.status)\nWHERE tickets.token = :P1 /* {{$_GET.token}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.token}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "tickets.token",
                  "field": "tickets.token",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_GET.token}}",
                  "data": {
                    "table": "tickets",
                    "column": "token",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "orders": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "id",
            "type": "text"
          },
          {
            "name": "created_at",
            "type": "text"
          },
          {
            "name": "updated_at",
            "type": "text"
          },
          {
            "name": "title",
            "type": "text"
          },
          {
            "name": "description",
            "type": "text"
          },
          {
            "name": "status",
            "type": "text"
          },
          {
            "name": "send_email",
            "type": "text"
          },
          {
            "name": "product_id",
            "type": "text"
          },
          {
            "name": "department_id",
            "type": "text"
          },
          {
            "name": "client_id",
            "type": "text"
          },
          {
            "name": "responsible_id",
            "type": "text"
          },
          {
            "name": "token",
            "type": "text"
          },
          {
            "name": "departamento_nome",
            "type": "text"
          },
          {
            "name": "cliente_nome",
            "type": "text"
          },
          {
            "name": "produto_nome",
            "type": "text"
          },
          {
            "name": "responsavel_nome",
            "type": "text"
          },
          {
            "name": "status_nome",
            "type": "text"
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