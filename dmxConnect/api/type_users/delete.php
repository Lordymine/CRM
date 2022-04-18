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
        "name": "delete",
        "module": "dbupdater",
        "action": "delete",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "delete",
            "table": "type_user",
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
            "query": "DELETE\nFROM type_user\nWHERE id = :P1 /* {{$_GET.id}} */",
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