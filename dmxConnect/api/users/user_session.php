<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
[
  {
    "name": "identity",
    "module": "auth",
    "action": "identify",
    "options": {
      "provider": "auth"
    },
    "output": true,
    "meta": []
  },
  {
    "name": "user",
    "module": "dbconnector",
    "action": "single",
    "options": {
      "connection": "dados",
      "sql": {
        "type": "SELECT",
        "columns": [
          {
            "table": "users",
            "column": "fullname"
          },
          {
            "table": "users",
            "column": "avatar"
          },
          {
            "table": "users",
            "column": "permission_level"
          },
          {
            "table": "users",
            "column": "type_user_id"
          },
          {
            "table": "users",
            "column": "id"
          },
          {
            "table": "users",
            "column": "token"
          }
        ],
        "table": {
          "name": "users"
        },
        "joins": [],
        "wheres": {
          "condition": "AND",
          "rules": [
            {
              "id": "users.id",
              "field": "users.id",
              "type": "double",
              "operator": "equal",
              "value": "{{identity}}",
              "data": {
                "table": "users",
                "column": "id",
                "type": "number"
              },
              "operation": "="
            }
          ],
          "conditional": null,
          "valid": true
        },
        "query": "SELECT fullname, avatar, permission_level, type_user_id, id, token\nFROM users\nWHERE id = :P1 /* {{identity}} */",
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
    "output": true,
    "meta": [
      {
        "name": "fullname",
        "type": "text"
      },
      {
        "name": "avatar",
        "type": "text"
      },
      {
        "name": "permission_level",
        "type": "number"
      },
      {
        "name": "type_user_id",
        "type": "number"
      },
      {
        "name": "id",
        "type": "number"
      },
      {
        "name": "token",
        "type": "text"
      }
    ],
    "outputType": "object"
  },
  {
    "name": "user_name",
    "module": "core",
    "action": "setvalue",
    "options": {
      "value": "{{user.fullname.split(' ')[0]}}"
    },
    "output": true
  },
  {
    "name": "",
    "module": "core",
    "action": "condition",
    "options": {
      "if": "{{user.avatar}}",
      "then": {
        "steps": {
          "name": "user_avatar",
          "module": "core",
          "action": "setvalue",
          "options": {
            "value": "{{user.avatar}}"
          },
          "output": true
        }
      },
      "else": {
        "steps": {
          "name": "user_avatar",
          "module": "core",
          "action": "setvalue",
          "options": {
            "value": "/assets/uploads/usuario_semfoto.png"
          },
          "output": true
        }
      }
    },
    "outputType": "boolean"
  }
]
JSON
);
?>