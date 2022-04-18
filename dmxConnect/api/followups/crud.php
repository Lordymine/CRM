<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "description"
      },
      {
        "type": "text",
        "name": "ticket_id"
      }
    ],
    "$_SERVER": [
      {
        "type": "text",
        "name": "HTTP_HOST"
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
        "name": "identity",
        "module": "auth",
        "action": "identify",
        "options": {
          "provider": "auth"
        },
        "meta": []
      },
      {
        "name": "insert",
        "module": "dbupdater",
        "action": "insert",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "insert",
            "values": [
              {
                "table": "followups",
                "column": "created_at",
                "type": "datetime",
                "value": "{{NOW}}"
              },
              {
                "table": "followups",
                "column": "description",
                "type": "text",
                "value": "{{$_POST.description}}"
              },
              {
                "table": "followups",
                "column": "author_id",
                "type": "text",
                "value": "{{identity}}"
              },
              {
                "table": "followups",
                "column": "ticket_id",
                "type": "text",
                "value": "{{$_POST.ticket_id}}"
              }
            ],
            "table": "followups",
            "returning": "id",
            "query": "INSERT INTO followups\n(created_at, description, author_id, ticket_id) VALUES (:P1 /* {{NOW}} */, :P2 /* {{$_POST.description}} */, :P3 /* {{identity}} */, :P4 /* {{$_POST.ticket_id}} */)",
            "params": [
              {
                "name": ":P1",
                "type": "expression",
                "value": "{{NOW}}"
              },
              {
                "name": ":P2",
                "type": "expression",
                "value": "{{$_POST.description}}"
              },
              {
                "name": ":P3",
                "type": "expression",
                "value": "{{identity}}"
              },
              {
                "name": ":P4",
                "type": "expression",
                "value": "{{$_POST.ticket_id}}"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "identity",
            "type": "text"
          },
          {
            "name": "affected",
            "type": "number"
          }
        ]
      },
      {
        "name": "chamado",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "tickets",
                "column": "*"
              },
              {
                "table": "cliente",
                "column": "fullname",
                "alias": "cliente_nome"
              },
              {
                "table": "cliente",
                "column": "email",
                "alias": "cliente_email"
              },
              {
                "table": "responsavel",
                "column": "fullname",
                "alias": "responsavel_nome"
              },
              {
                "table": "responsavel",
                "column": "email",
                "alias": "responsavel_email"
              }
            ],
            "table": {
              "name": "tickets"
            },
            "joins": [
              {
                "table": "users",
                "column": "*",
                "alias": "cliente",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "cliente",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "client_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              },
              {
                "table": "users",
                "column": "*",
                "alias": "responsavel",
                "type": "LEFT",
                "clauses": {
                  "condition": "AND",
                  "rules": [
                    {
                      "table": "responsavel",
                      "column": "id",
                      "operator": "equal",
                      "value": {
                        "table": "tickets",
                        "column": "responsible_id"
                      },
                      "operation": "="
                    }
                  ]
                }
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "tickets.id",
                  "field": "tickets.id",
                  "type": "double",
                  "operator": "equal",
                  "value": "{{$_POST.ticket_id}}",
                  "data": {
                    "table": "tickets",
                    "column": "id",
                    "type": "number"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT tickets.*, cliente.fullname AS cliente_nome, cliente.email AS cliente_email, responsavel.fullname AS responsavel_nome, responsavel.email AS responsavel_email\nFROM tickets\nLEFT JOIN users AS cliente ON (cliente.id = tickets.client_id) LEFT JOIN users AS responsavel ON (responsavel.id = tickets.responsible_id)\nWHERE tickets.id = :P1 /* {{$_POST.ticket_id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.ticket_id}}"
              }
            ]
          }
        },
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
          },
          {
            "name": "cliente_nome",
            "type": "text"
          },
          {
            "name": "cliente_email",
            "type": "text"
          },
          {
            "name": "responsavel_nome",
            "type": "text"
          },
          {
            "name": "responsavel_email",
            "type": "text"
          }
        ],
        "outputType": "object"
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{chamado.responsible_id == identity}}",
          "then": {
            "steps": [
              {
                "name": "",
                "module": "mail",
                "action": "send",
                "options": {
                  "instance": "mail",
                  "subject": "{{'Existe uma nova interação no chamado '+chamado.title}}",
                  "fromName": "Als Digital",
                  "fromEmail": "suporte@alsdigital.com.br",
                  "replyTo": "suporte@alsdigital.com.br",
                  "toName": "{{chamado.cliente_nome}}",
                  "toEmail": "{{chamado.cliente_email}}",
                  "contentType": "html",
                  "body": "<h2><span style=\"font-weight: normal;\">Olá&nbsp;</span>{{chamado.cliente_nome}}<span style=\"font-weight: normal;\"> o chamado&nbsp;</span>{{chamado.title}}<span style=\"font-weight: normal;\"> teve uma nova interação.</span></h2><h2><span style=\"font-weight: normal;\">Para mais informações por favor </span>clique no link abaixo<span style=\"font-weight: normal;\">.</span></h2><h2 style=\"text-align: center;\"><b><a href=\"https://{{$_SERVER.HTTP_HOST}}\">Clique aqui</a></b></h2>"
                }
              },
              {
                "name": "insert_notification_cliente",
                "module": "dbupdater",
                "action": "insert",
                "options": {
                  "connection": "dados",
                  "sql": {
                    "type": "insert",
                    "values": [
                      {
                        "table": "notifications",
                        "column": "created_at",
                        "type": "datetime",
                        "value": "{{NOW}}"
                      },
                      {
                        "table": "notifications",
                        "column": "title",
                        "type": "text",
                        "value": "{{'Você teve uma nova interação no chamado Nº '+chamado.id}}"
                      },
                      {
                        "table": "notifications",
                        "column": "icon",
                        "type": "text",
                        "value": "fa fa-envelope"
                      },
                      {
                        "table": "notifications",
                        "column": "url",
                        "type": "text",
                        "value": "{{'/painel/chamados/detaill-followups/'+chamado.token}}"
                      },
                      {
                        "table": "notifications",
                        "column": "status",
                        "type": "text",
                        "value": "2"
                      },
                      {
                        "table": "notifications",
                        "column": "user_id",
                        "type": "text",
                        "value": "{{chamado.client_id}}"
                      },
                      {
                        "table": "notifications",
                        "column": "ticket_id",
                        "type": "text",
                        "value": "{{chamado.id}}"
                      }
                    ],
                    "table": "notifications",
                    "returning": "id",
                    "query": "INSERT INTO notifications\n(created_at, title, icon, url, status, user_id, ticket_id) VALUES (:P1 /* {{NOW}} */, :P2 /* {{'Você teve uma nova interação no chamado Nº '+chamado.id}} */, 'fa fa-envelope', :P3 /* {{'/painel/chamados/detaill-followups/'+chamado.token}} */, '2', :P4 /* {{chamado.client_id}} */, :P5 /* {{chamado.id}} */)",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{NOW}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{'Você teve uma nova interação no chamado Nº '+chamado.id}}"
                      },
                      {
                        "name": ":P3",
                        "type": "expression",
                        "value": "{{'/painel/chamados/detaill-followups/'+chamado.token}}"
                      },
                      {
                        "name": ":P4",
                        "type": "expression",
                        "value": "{{chamado.client_id}}"
                      },
                      {
                        "name": ":P5",
                        "type": "expression",
                        "value": "{{chamado.id}}"
                      }
                    ]
                  }
                },
                "meta": [
                  {
                    "name": "identity",
                    "type": "text"
                  },
                  {
                    "name": "affected",
                    "type": "number"
                  }
                ]
              }
            ]
          },
          "else": {
            "steps": [
              {
                "name": "",
                "module": "mail",
                "action": "send",
                "options": {
                  "instance": "mail",
                  "subject": "{{'Existe uma nova interação no chamado '+chamado.title}}",
                  "fromName": "Als Digital",
                  "fromEmail": "suporte@alsdigital.com.br",
                  "replyTo": "suporte@alsdigital.com.br",
                  "toEmail": "{{chamado.responsavel_email}}",
                  "contentType": "html",
                  "body": "<h2><span style=\"font-weight: normal;\">Olá&nbsp;</span>{{chamado.responsavel_nome}}<span style=\"font-weight: normal;\"> o chamado&nbsp;</span>{{chamado.title}}<span style=\"font-weight: normal;\"> teve uma nova interação.</span></h2><h2><span style=\"font-weight: normal;\">Para mais informações por favor </span>clique no link abaixo<span style=\"font-weight: normal;\">.</span></h2><h2 style=\"text-align: center;\"><b><a href=\"https://{{$_SERVER.HTTP_HOST}}\">Clique aqui</a></b></h2>",
                  "toName": "{{chamado.responsavel_nome}}"
                }
              },
              {
                "name": "insert_notification_responsavel",
                "module": "dbupdater",
                "action": "insert",
                "options": {
                  "connection": "dados",
                  "sql": {
                    "type": "insert",
                    "values": [
                      {
                        "table": "notifications",
                        "column": "created_at",
                        "type": "datetime",
                        "value": "{{NOW}}"
                      },
                      {
                        "table": "notifications",
                        "column": "title",
                        "type": "text",
                        "value": "{{'Você teve uma nova interação no chamado Nº '+chamado.id}}"
                      },
                      {
                        "table": "notifications",
                        "column": "icon",
                        "type": "text",
                        "value": "fa fa-envelope"
                      },
                      {
                        "table": "notifications",
                        "column": "url",
                        "type": "text",
                        "value": "{{'/painel/chamados/detaill-followups/'+chamado.token}}"
                      },
                      {
                        "table": "notifications",
                        "column": "status",
                        "type": "text",
                        "value": "2"
                      },
                      {
                        "table": "notifications",
                        "column": "user_id",
                        "type": "text",
                        "value": "{{chamado.responsible_id}}"
                      },
                      {
                        "table": "notifications",
                        "column": "ticket_id",
                        "type": "text",
                        "value": "{{chamado.id}}"
                      }
                    ],
                    "table": "notifications",
                    "returning": "id",
                    "query": "INSERT INTO notifications\n(created_at, title, icon, url, status, user_id, ticket_id) VALUES (:P1 /* {{NOW}} */, :P2 /* {{'Você teve uma nova interação no chamado Nº '+chamado.id}} */, 'fa fa-envelope', :P3 /* {{'/painel/chamados/detaill-followups/'+chamado.token}} */, '2', :P4 /* {{chamado.responsible_id}} */, :P5 /* {{chamado.id}} */)",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{NOW}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{'Você teve uma nova interação no chamado Nº '+chamado.id}}"
                      },
                      {
                        "name": ":P3",
                        "type": "expression",
                        "value": "{{'/painel/chamados/detaill-followups/'+chamado.token}}"
                      },
                      {
                        "name": ":P4",
                        "type": "expression",
                        "value": "{{chamado.responsible_id}}"
                      },
                      {
                        "name": ":P5",
                        "type": "expression",
                        "value": "{{chamado.id}}"
                      }
                    ]
                  }
                },
                "meta": [
                  {
                    "name": "identity",
                    "type": "text"
                  },
                  {
                    "name": "affected",
                    "type": "number"
                  }
                ]
              }
            ]
          }
        },
        "outputType": "boolean"
      }
    ]
  }
}
JSON
);
?>