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
        "name": "query",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [],
            "table": {
              "name": "status"
            },
            "joins": [],
            "orders": [
              {
                "table": "status",
                "column": "name",
                "direction": "ASC"
              }
            ],
            "query": "SELECT *\nFROM status\nORDER BY name ASC",
            "params": []
          }
        },
        "output": true,
        "meta": [],
        "outputType": "array"
      }
    ]
  }
}
JSON
);
?>