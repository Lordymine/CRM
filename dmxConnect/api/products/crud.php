<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "name"
      },
      {
        "type": "number",
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
          "provider": "auth"
        }
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{$_POST.id}}",
          "then": {
            "steps": {
              "name": "update",
              "module": "dbupdater",
              "action": "update",
              "options": {
                "connection": "dados",
                "sql": {
                  "type": "update",
                  "values": [
                    {
                      "table": "products",
                      "column": "name",
                      "type": "text",
                      "value": "{{$_POST.name}}"
                    }
                  ],
                  "table": "products",
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "id",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{$_POST.id}}",
                        "data": {
                          "column": "id"
                        },
                        "operation": "="
                      }
                    ]
                  },
                  "query": "UPDATE products\nSET name = :P1 /* {{$_POST.name}} */\nWHERE id = :P2 /* {{$_POST.id}} */",
                  "params": [
                    {
                      "name": ":P1",
                      "type": "expression",
                      "value": "{{$_POST.name}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P2",
                      "value": "{{$_POST.id}}"
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
          },
          "else": {
            "steps": {
              "name": "insert",
              "module": "dbupdater",
              "action": "insert",
              "options": {
                "connection": "dados",
                "sql": {
                  "type": "insert",
                  "values": [
                    {
                      "table": "products",
                      "column": "name",
                      "type": "text",
                      "value": "{{$_POST.name}}"
                    }
                  ],
                  "table": "products",
                  "returning": "id",
                  "query": "INSERT INTO products\n(name) VALUES (:P1 /* {{$_POST.name}} */)",
                  "params": [
                    {
                      "name": ":P1",
                      "type": "expression",
                      "value": "{{$_POST.name}}"
                    }
                  ]
                }
              },
              "meta": [
                {
                  "name": "identity",
                  "type": "text"
                },
                {
                  "name": "affected",
                  "type": "number"
                }
              ]
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