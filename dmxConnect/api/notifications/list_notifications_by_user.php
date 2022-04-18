<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
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
        "name": "identity",
        "module": "auth",
        "action": "identify",
        "options": {
          "provider": "auth"
        },
        "output": false,
        "meta": []
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
                "table": "notifications",
                "column": "*"
              },
              {
                "table": "tickets",
                "column": "token"
              }
            ],
            "table": {
              "name": "notifications"
            },
            "joins": [
              {
                "table": "tickets",
                "column": "*",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "tickets",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "notifications",
                        "column": "ticket_id"
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
                  "id": "notifications.status",
                  "field": "notifications.status",
                  "type": "string",
                  "operator": "equal",
                  "value": "2",
                  "data": {
                    "table": "notifications",
                    "column": "status",
                    "type": "text"
                  },
                  "operation": "="
                },
                {
                  "id": "notifications.user_id",
                  "field": "notifications.user_id",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{identity}}",
                  "data": {
                    "table": "notifications",
                    "column": "user_id",
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
                "table": "notifications",
                "column": "id",
                "direction": "DESC"
              }
            ],
            "query": "SELECT notifications.*, tickets.token\nFROM notifications\nLEFT JOIN tickets ON (tickets.id = notifications.ticket_id)\nWHERE notifications.status = '2' AND notifications.user_id = :P1 /* {{identity}} */\nORDER BY notifications.id DESC",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{identity}}"
              }
            ]
          }
        },
        "output": false,
        "meta": [
          {
            "name": "id",
            "type": "text"
          },
          {
            "name": "created_at",
            "type": "datetime"
          },
          {
            "name": "title",
            "type": "text"
          },
          {
            "name": "icon",
            "type": "text"
          },
          {
            "name": "url",
            "type": "text"
          },
          {
            "name": "status",
            "type": "text"
          },
          {
            "name": "user_id",
            "type": "text"
          },
          {
            "name": "ticket_id",
            "type": "text"
          },
          {
            "name": "token",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "total",
        "module": "core",
        "action": "setvalue",
        "options": {
          "value": "{{query.count()}}"
        },
        "output": true
      },
      {
        "name": "notifications",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{query}}",
          "outputFields": [
            "id",
            "title",
            "icon",
            "url",
            "status",
            "token"
          ],
          "exec": {
            "steps": {
              "name": "created_at",
              "module": "core",
              "action": "setvalue",
              "options": {
                "value": "{{created_at.formatDate('dd/MM/yyyy - hh:mm')}}"
              },
              "output": true
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "$index",
            "type": "number"
          },
          {
            "name": "$number",
            "type": "number"
          },
          {
            "name": "$name",
            "type": "text"
          },
          {
            "name": "$value",
            "type": "object"
          },
          {
            "name": "id",
            "type": "text"
          },
          {
            "name": "created_at",
            "type": "datetime"
          },
          {
            "name": "title",
            "type": "text"
          },
          {
            "name": "icon",
            "type": "text"
          },
          {
            "name": "url",
            "type": "text"
          },
          {
            "name": "status",
            "type": "text"
          },
          {
            "name": "user_id",
            "type": "text"
          },
          {
            "name": "ticket_id",
            "type": "text"
          },
          {
            "name": "token",
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