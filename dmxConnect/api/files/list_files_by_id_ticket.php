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
            "columns": [],
            "table": {
              "name": "files"
            },
            "joins": [],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "files.ticket_id",
                  "field": "files.ticket_id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.ticket_id}}",
                  "data": {
                    "table": "files",
                    "column": "ticket_id",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "orders": [
              {
                "table": "files",
                "column": "id",
                "direction": "DESC"
              }
            ],
            "query": "SELECT *\nFROM files\nWHERE ticket_id = :P1 /* {{$_GET.ticket_id}} */\nORDER BY id DESC",
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
            "type": "number"
          },
          {
            "name": "file_name",
            "type": "text"
          },
          {
            "name": "file_url",
            "type": "text"
          },
          {
            "name": "file_type",
            "type": "text"
          },
          {
            "name": "created_at",
            "type": "datetime"
          },
          {
            "name": "ticket_id",
            "type": "number"
          },
          {
            "name": "author_id",
            "type": "number"
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