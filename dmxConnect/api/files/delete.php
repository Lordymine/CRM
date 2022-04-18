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
            "columns": [],
            "table": {
              "name": "files"
            },
            "joins": [],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "files.id",
                  "field": "files.id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.id}}",
                  "data": {
                    "table": "files",
                    "column": "id",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM files\nWHERE id = :P1 /* {{$_GET.id}} */",
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
        "outputType": "object"
      },
      {
        "name": "fileExists",
        "module": "fs",
        "action": "exists",
        "options": {
          "path": "{{query.file_url}}",
          "then": {
            "steps": {
              "name": "fileRemove",
              "module": "fs",
              "action": "remove",
              "options": {
                "path": "{{query.file_url}}"
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
            "table": "files",
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
            "query": "DELETE\nFROM files\nWHERE id = :P1 /* {{$_GET.id}} */",
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