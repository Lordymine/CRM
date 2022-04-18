<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "ticket_id"
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
          "provider": "auth"
        }
      },
      {
        "name": "query",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "followups",
                "column": "*"
              },
              {
                "table": "users",
                "column": "fullname",
                "alias": "autor"
              }
            ],
            "table": {
              "name": "followups"
            },
            "joins": [
              {
                "table": "users",
                "column": "*",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "users",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "followups",
                        "column": "author_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "followups.ticket_id",
                  "field": "followups.ticket_id",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_GET.ticket_id}}",
                  "data": {
                    "table": "followups",
                    "column": "ticket_id",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "orders": [
              {
                "table": "followups",
                "column": "id",
                "direction": "DESC",
                "recid": 1
              }
            ],
            "query": "SELECT followups.*, users.fullname AS autor\nFROM followups\nLEFT JOIN users ON (users.id = followups.author_id)\nWHERE followups.ticket_id = :P1 /* {{$_GET.ticket_id}} */\nORDER BY followups.id DESC",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.ticket_id}}"
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
            "name": "created_at",
            "type": "text"
          },
          {
            "name": "description",
            "type": "text"
          },
          {
            "name": "author_id",
            "type": "text"
          },
          {
            "name": "ticket_id",
            "type": "text"
          },
          {
            "name": "autor",
            "type": "text"
          }
        ],
        "outputType": "array"
      }
    ]
  }
}
JSON
);
?>