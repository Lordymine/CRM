dmx.config({
  "login": {
    "query": [
      {
        "type": "text",
        "name": "token"
      }
    ]
  },
  "app_chamados": {
    "flow1": [
      {
        "name": "$param",
        "type": "object",
        "sub": [
          {
            "type": "text",
            "name": "id"
          },
          {
            "type": "text",
            "name": "nome_item"
          }
        ]
      }
    ],
    "modal_crud": {
      "meta": [
        {
          "name": "id",
          "type": "number"
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
          "type": "number"
        },
        {
          "name": "department_id",
          "type": "number"
        },
        {
          "name": "client_id",
          "type": "number"
        },
        {
          "name": "responsible_id",
          "type": "number"
        }
      ],
      "outputType": "array"
    },
    "query": [
      {
        "type": "text",
        "name": "status"
      }
    ]
  },
  "app_chamados_crud": {
    "query": [
      {
        "type": "text",
        "name": "token"
      }
    ]
  },
  "app_tipos_usuarios": {
    "data_detail_crud": {
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
    },
    "tableRepeat1": {
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
  },
  "app_followups_details": {
    "query": [
      {
        "type": "text",
        "name": "token"
      }
    ]
  },
  "app_topo_bar": {
    "rep_notifications_top": {
      "meta": [
        {
          "name": "id",
          "type": "text"
        },
        {
          "name": "created_at",
          "type": "datetime"
        },
        {
          "name": "title",
          "type": "text"
        },
        {
          "name": "icon",
          "type": "text"
        },
        {
          "name": "url",
          "type": "text"
        },
        {
          "name": "status",
          "type": "text"
        },
        {
          "name": "user_id",
          "type": "text"
        },
        {
          "name": "ticket_id",
          "type": "text"
        },
        {
          "name": "token",
          "type": "text"
        }
      ],
      "outputType": "array"
    }
  },
  "_template": {
    "rep_cards": {
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
          "name": "tickets_by_status_id",
          "type": "object",
          "sub": [
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
          ]
        }
      ],
      "outputType": "array"
    }
  }
});
