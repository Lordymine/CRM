<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "name"
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
          "provider": "auth"
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
              "name": "type_user"
            },
            "joins": [],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "type_user.name",
                  "field": "type_user.name",
                  "type": "string",
                  "operator": "contains",
                  "value": "{{$_GET.name}}",
                  "data": {
                    "table": "type_user",
                    "column": "name",
                    "type": "text"
                  },
                  "operation": "LIKE"
                }
              ],
              "conditional": null,
              "valid": true
            },
            "orders": [
              {
                "table": "type_user",
                "column": "id",
                "direction": "DESC"
              }
            ],
            "query": "SELECT *\nFROM type_user\nWHERE name LIKE :P1 /* {{$_GET.name}} */\nORDER BY id DESC",
            "params": [
              {
                "operator": "contains",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.name}}"
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
                "name": "name",
                "type": "text"
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