<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "notification_id"
      },
      {
        "type": "text",
        "name": "ticket_token"
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
            "table": "notifications",
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "id",
                  "field": "id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_GET.notification_id}}",
                  "data": {
                    "column": "id"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "DELETE\nFROM notifications\nWHERE id = :P1 /* {{$_GET.notification_id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.notification_id}}"
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
      },
      {
        "name": "",
        "module": "core",
        "action": "redirect",
        "options": {
          "url": "{{'/painel/chamados/detaill-followups/'+$_GET.ticket_token}}"
        }
      }
    ]
  }
}
JSON
);
?>