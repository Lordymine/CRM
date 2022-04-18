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
    "steps": {
      "name": "query",
      "module": "dbconnector",
      "action": "select",
      "options": {
        "connection": "dados",
        "sql": {
          "type": "SELECT",
          "columns": [],
          "table": {
            "name": "type_user"
          },
          "joins": [],
          "orders": [
            {
              "table": "type_user",
              "column": "name",
              "direction": "ASC"
            }
          ],
          "query": "SELECT *\nFROM type_user\nORDER BY name ASC",
          "params": []
        }
      },
      "output": true,
      "meta": [
        {
          "name": "id",
          "type": "number"
        },
        {
          "name": "name",
          "type": "text"
        }
      ],
      "outputType": "array"
    }
  }
}
JSON
);
?>