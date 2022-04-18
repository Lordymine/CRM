<?php
$exports = <<<'JSON'
{
  "name": "auth",
  "module": "auth",
  "action": "provider",
  "options": {
    "connection": "dados",
    "secret": "#$*&5877854jkiu87784587874aww#$",
    "provider": "Database",
    "users": {
      "table": "users",
      "identity": "id",
      "username": "email",
      "password": "password"
    },
    "permissions": {
      "admin": {
        "table": "users",
        "identity": "id",
        "conditions": [
          {
            "column": "permission_level",
            "operator": ">=",
            "value": "10"
          },
          {
            "column": "status",
            "operator": "=",
            "value": "1"
          }
        ]
      },
      "clients": {
        "table": "users",
        "identity": "id",
        "conditions": [
          {
            "column": "permission_level",
            "operator": "=",
            "value": "2"
          },
          {
            "column": "status",
            "operator": "=",
            "value": "1"
          }
        ]
      },
      "employee": {
        "table": "users",
        "identity": "id",
        "conditions": [
          {
            "column": "permission_level",
            "operator": "=",
            "value": "5"
          },
          {
            "column": "status",
            "operator": "=",
            "value": "1"
          }
        ]
      }
    },
    "secure": true
  },
  "meta": [
    {
      "name": "identity",
      "type": "text"
    }
  ]
}
JSON;
?>