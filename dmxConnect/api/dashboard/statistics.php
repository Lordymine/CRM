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
        "name": "offset"
      },
      {
        "type": "text",
        "name": "limit"
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
          "provider": "auth",
          "permissions": [
            "admin"
          ]
        }
      },
      {
        "name": "identity",
        "module": "auth",
        "action": "identify",
        "options": {
          "provider": "auth"
        },
        "output": false,
        "meta": []
      },
      {
        "name": "query_status",
        "module": "dbconnector",
        "action": "select",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "status_tickets",
                "column": "id",
                "alias": "status_id"
              },
              {
                "table": "status_tickets",
                "column": "name",
                "alias": "status_name"
              },
              {
                "table": "status_tickets",
                "column": "color",
                "alias": "status_color"
              },
              {
                "table": "status_tickets",
                "column": "icon",
                "alias": "status_icon"
              }
            ],
            "table": {
              "name": "status_tickets"
            },
            "joins": [],
            "orders": [
              {
                "table": "status_tickets",
                "column": "name",
                "direction": "ASC",
                "recid": 1
              }
            ],
            "query": "SELECT id AS status_id, name AS status_name, color AS status_color, icon AS status_icon\nFROM status_tickets\nORDER BY name ASC",
            "params": []
          }
        },
        "output": false,
        "meta": [
          {
            "name": "status_id",
            "type": "text"
          },
          {
            "name": "status_name",
            "type": "text"
          },
          {
            "name": "status_color",
            "type": "text"
          },
          {
            "name": "status_icon",
            "type": "text"
          }
        ],
        "outputType": "array"
      },
      {
        "name": "status",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{query_status}}",
          "outputFields": [
            "status_id",
            "status_name",
            "status_color",
            "status_icon"
          ],
          "exec": {
            "steps": {
              "name": "tickets_by_status_id",
              "module": "dbconnector",
              "action": "paged",
              "options": {
                "connection": "dados",
                "sql": {
                  "type": "SELECT",
                  "columns": [],
                  "table": {
                    "name": "tickets"
                  },
                  "joins": [],
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "tickets.status",
                        "field": "tickets.status",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{status_id}}",
                        "data": {
                          "table": "tickets",
                          "column": "status",
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
                      "table": "tickets",
                      "column": "id",
                      "direction": "DESC",
                      "recid": 1
                    }
                  ],
                  "query": "SELECT *\nFROM tickets\nWHERE status = :P1 /* {{status_id}} */\nORDER BY id DESC\nFETCH NEXT 1 ROWS ONLY",
                  "params": [
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{status_id}}"
                    }
                  ],
                  "limit": 1
                }
              },
              "output": true,
              "meta": [
                {
                  "name": "offset",
                  "type": "number"
                },
                {
                  "name": "limit",
                  "type": "number"
                },
                {
                  "name": "total",
                  "type": "number"
                },
                {
                  "name": "page",
                  "type": "object",
                  "sub": [
                    {
                      "name": "offset",
                      "type": "object",
                      "sub": [
                        {
                          "name": "first",
                          "type": "number"
                        },
                        {
                          "name": "prev",
                          "type": "number"
                        },
                        {
                          "name": "next",
                          "type": "number"
                        },
                        {
                          "name": "last",
                          "type": "number"
                        }
                      ]
                    },
                    {
                      "name": "current",
                      "type": "number"
                    },
                    {
                      "name": "total",
                      "type": "number"
                    }
                  ]
                },
                {
                  "name": "data",
                  "type": "array",
                  "sub": [
                    {
                      "name": "id",
                      "type": "text"
                    },
                    {
                      "name": "created_at",
                      "type": "datetime"
                    },
                    {
                      "name": "updated_at",
                      "type": "datetime"
                    },
                    {
                      "name": "title",
                      "type": "text"
                    },
                    {
                      "name": "description",
                      "type": "text"
                    },
                    {
                      "name": "status",
                      "type": "number"
                    },
                    {
                      "name": "send_email",
                      "type": "number"
                    },
                    {
                      "name": "product_id",
                      "type": "text"
                    },
                    {
                      "name": "department_id",
                      "type": "text"
                    },
                    {
                      "name": "client_id",
                      "type": "text"
                    },
                    {
                      "name": "responsible_id",
                      "type": "text"
                    },
                    {
                      "name": "token",
                      "type": "text"
                    }
                  ]
                }
              ],
              "outputType": "object"
            }
          }
        },
        "output": true,
        "meta": [
          {
            "name": "$index",
            "type": "number"
          },
          {
            "name": "$number",
            "type": "number"
          },
          {
            "name": "$name",
            "type": "text"
          },
          {
            "name": "$value",
            "type": "object"
          },
          {
            "name": "status_id",
            "type": "text"
          },
          {
            "name": "status_name",
            "type": "text"
          },
          {
            "name": "status_color",
            "type": "text"
          },
          {
            "name": "status_icon",
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