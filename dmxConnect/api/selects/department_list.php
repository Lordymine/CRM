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
            "name": "department_tickets"
          },
          "joins": [],
          "orders": [
            {
              "table": "department_tickets",
              "column": "name",
              "direction": "ASC"
            }
          ],
          "query": "SELECT *\nFROM department_tickets\nORDER BY name ASC",
          "params": []
        }
      },
      "output": true,
      "meta": [
        {
          "name": "id",
          "type": "text"
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