<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "password"
      },
      {
        "type": "text",
        "name": "token"
      }
    ]
  },
  "exec": {
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
              "table": "users",
              "column": "password",
              "type": "text",
              "value": "{{$_POST.password.sha1()}}"
            }
          ],
          "table": "users",
          "wheres": {
            "condition": "AND",
            "rules": [
              {
                "id": "token",
                "field": "token",
                "type": "string",
                "operator": "equal",
                "value": "{{$_POST.token}}",
                "data": {
                  "column": "token"
                },
                "operation": "="
              }
            ],
            "conditional": null,
            "valid": true
          },
          "query": "UPDATE users\nSET password = :P1 /* {{$_POST.password.sha1()}} */\nWHERE token = :P2 /* {{$_POST.token}} */",
          "params": [
            {
              "name": ":P1",
              "type": "expression",
              "value": "{{$_POST.password.sha1()}}"
            },
            {
              "operator": "equal",
              "type": "expression",
              "name": ":P2",
              "value": "{{$_POST.token}}"
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
  }
}
JSON
);
?>