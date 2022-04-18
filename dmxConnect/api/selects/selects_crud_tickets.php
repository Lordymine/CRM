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
      },
      {
        "type": "text",
        "name": "department_id"
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
        "name": "status",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [],
            "table": {
              "name": "status_tickets"
            },
            "joins": [],
            "orders": [
              {
                "table": "status_tickets",
                "column": "name",
                "direction": "ASC"
              }
            ],
            "query": "SELECT *\nFROM status_tickets\nORDER BY name ASC",
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
          },
          {
            "name": "color",
            "type": "text"
          },
          {
            "name": "icon",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "products",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [],
            "table": {
              "name": "products"
            },
            "joins": [],
            "orders": [
              {
                "table": "products",
                "column": "name",
                "direction": "ASC"
              }
            ],
            "query": "SELECT *\nFROM products\nORDER BY name ASC",
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
      },
      {
        "name": "departments",
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
      },
      {
        "name": "clients",
        "module": "dbconnector",
        "action": "select",
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
                "column": "id"
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
                  "id": "users.type_user_id",
                  "field": "users.type_user_id",
                  "type": "double",
                  "operator": "equal",
                  "value": 1,
                  "data": {
                    "table": "users",
                    "column": "type_user_id",
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
                "table": "users",
                "column": "fullname",
                "direction": "ASC",
                "recid": 1
              }
            ],
            "query": "SELECT fullname, id\nFROM users\nWHERE type_user_id = 1\nORDER BY fullname ASC",
            "params": []
          }
        },
        "output": true,
        "meta": [
          {
            "name": "fullname",
            "type": "text"
          },
          {
            "name": "id",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "responsable",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "users",
                "column": "id"
              },
              {
                "table": "users",
                "column": "fullname"
              }
            ],
            "table": {
              "name": "users"
            },
            "joins": [],
            "orders": [
              {
                "table": "users",
                "column": "fullname",
                "direction": "ASC",
                "recid": 1
              }
            ],
            "query": "SELECT id, fullname\nFROM users\nWHERE type_user_id <> 1 AND (department_id = :P1 /* {{$_GET.department_id}} */)\nORDER BY fullname ASC",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_GET.department_id}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "users.type_user_id",
                  "field": "users.type_user_id",
                  "type": "string",
                  "operator": "not_equal",
                  "value": 1,
                  "data": {
                    "table": "users",
                    "column": "type_user_id",
                    "type": "number"
                  },
                  "operation": "<>"
                },
                {
                  "condition": "AND",
                  "rules": [
                    {
                      "id": "users.department_id",
                      "field": "users.department_id",
                      "type": "double",
                      "operator": "equal",
                      "value": "{{$_GET.department_id}}",
                      "data": {
                        "table": "users",
                        "column": "department_id",
                        "type": "number"
                      },
                      "operation": "="
                    }
                  ],
                  "conditional": "{{$_GET.department_id}}"
                }
              ],
              "conditional": null,
              "valid": true
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "id",
            "type": "text"
          },
          {
            "name": "fullname",
            "type": "text"
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