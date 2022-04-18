<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "options": {
      "linkedFile": "/painel/chamados/gerenciar.php",
      "linkedForm": "serverconnectform1"
    },
    "$_POST": [
      {
        "type": "text",
        "fieldName": "title",
        "name": "title"
      },
      {
        "type": "text",
        "fieldName": "description",
        "name": "description"
      },
      {
        "type": "number",
        "fieldName": "status",
        "name": "status"
      },
      {
        "type": "number",
        "fieldName": "product_id",
        "name": "product_id"
      },
      {
        "type": "number",
        "fieldName": "department_id",
        "name": "department_id"
      },
      {
        "type": "number",
        "fieldName": "client_id",
        "name": "client_id"
      },
      {
        "type": "number",
        "fieldName": "responsible_id",
        "name": "responsible_id"
      },
      {
        "type": "number",
        "fieldName": "id",
        "name": "id"
      },
      {
        "type": "text",
        "name": "token"
      },
      {
        "type": "text",
        "fieldName": "send_email",
        "name": "send_email"
      },
      {
        "type": "file",
        "fieldName": "file",
        "name": "file",
        "sub": [
          {
            "type": "text",
            "name": "name"
          },
          {
            "type": "text",
            "name": "type"
          },
          {
            "type": "number",
            "name": "size"
          },
          {
            "type": "text",
            "name": "error"
          }
        ],
        "outputType": "file"
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
        "name": "cliente",
        "module": "dbconnector",
        "action": "single",
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
              },
              {
                "table": "users",
                "column": "email"
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
                  "value": "{{$_POST.client_id}}",
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
            "query": "SELECT id, fullname, email, token\nFROM users\nWHERE id = :P1 /* {{$_POST.client_id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.client_id}}"
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
            "name": "fullname",
            "type": "text"
          },
          {
            "name": "email",
            "type": "text"
          },
          {
            "name": "token",
            "type": "text"
          }
        ],
        "outputType": "object"
      },
      {
        "name": "responsavel",
        "module": "dbconnector",
        "action": "single",
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
              },
              {
                "table": "users",
                "column": "email"
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
                  "value": "{{$_POST.responsible_id}}",
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
            "query": "SELECT id, fullname, email\nFROM users\nWHERE id = :P1 /* {{$_POST.responsible_id}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.responsible_id}}"
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
            "name": "fullname",
            "type": "text"
          },
          {
            "name": "email",
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
          "if": "{{$_POST.file}}",
          "then": {
            "steps": {
              "name": "upload",
              "module": "upload",
              "action": "upload",
              "options": {
                "fields": "{{$_POST.file}}",
                "path": "/assets/uploads/files",
                "template": "{name}{_n}{ext}",
                "replaceSpace": true,
                "replaceDiacritics": true,
                "asciiOnly": true
              },
              "meta": [
                {
                  "name": "name",
                  "type": "text"
                },
                {
                  "name": "path",
                  "type": "text"
                },
                {
                  "name": "url",
                  "type": "text"
                },
                {
                  "name": "type",
                  "type": "text"
                },
                {
                  "name": "size",
                  "type": "text"
                },
                {
                  "name": "error",
                  "type": "number"
                }
              ],
              "outputType": "file"
            }
          }
        },
        "outputType": "boolean"
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{$_POST.id}}",
          "then": {
            "steps": [
              {
                "name": "update",
                "module": "dbupdater",
                "action": "update",
                "options": {
                  "connection": "dados",
                  "sql": {
                    "type": "update",
                    "values": [
                      {
                        "table": "tickets",
                        "column": "updated_at",
                        "type": "datetime",
                        "value": "{{NOW}}"
                      },
                      {
                        "table": "tickets",
                        "column": "title",
                        "type": "text",
                        "value": "{{$_POST.title}}"
                      },
                      {
                        "table": "tickets",
                        "column": "description",
                        "type": "text",
                        "value": "{{$_POST.description}}"
                      },
                      {
                        "table": "tickets",
                        "column": "status",
                        "type": "number",
                        "value": "{{$_POST.status}}"
                      },
                      {
                        "table": "tickets",
                        "column": "product_id",
                        "type": "number",
                        "value": "{{$_POST.product_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "department_id",
                        "type": "number",
                        "value": "{{$_POST.department_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "client_id",
                        "type": "number",
                        "value": "{{$_POST.client_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "responsible_id",
                        "type": "number",
                        "value": "{{$_POST.responsible_id}}"
                      }
                    ],
                    "table": "tickets",
                    "wheres": {
                      "condition": "AND",
                      "rules": [
                        {
                          "id": "id",
                          "type": "double",
                          "operator": "equal",
                          "value": "{{$_POST.id}}",
                          "data": {
                            "column": "id"
                          },
                          "operation": "="
                        }
                      ]
                    },
                    "query": "UPDATE tickets\nSET updated_at = :P1 /* {{NOW}} */, title = :P2 /* {{$_POST.title}} */, description = :P3 /* {{$_POST.description}} */, status = :P4 /* {{$_POST.status}} */, product_id = :P5 /* {{$_POST.product_id}} */, department_id = :P6 /* {{$_POST.department_id}} */, client_id = :P7 /* {{$_POST.client_id}} */, responsible_id = :P8 /* {{$_POST.responsible_id}} */\nWHERE id = :P9 /* {{$_POST.id}} */",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{NOW}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{$_POST.title}}"
                      },
                      {
                        "name": ":P3",
                        "type": "expression",
                        "value": "{{$_POST.description}}"
                      },
                      {
                        "name": ":P4",
                        "type": "expression",
                        "value": "{{$_POST.status}}"
                      },
                      {
                        "name": ":P5",
                        "type": "expression",
                        "value": "{{$_POST.product_id}}"
                      },
                      {
                        "name": ":P6",
                        "type": "expression",
                        "value": "{{$_POST.department_id}}"
                      },
                      {
                        "name": ":P7",
                        "type": "expression",
                        "value": "{{$_POST.client_id}}"
                      },
                      {
                        "name": ":P8",
                        "type": "expression",
                        "value": "{{$_POST.responsible_id}}"
                      },
                      {
                        "operator": "equal",
                        "type": "expression",
                        "name": ":P9",
                        "value": "{{$_POST.id}}"
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
                "name": "chamado_atualizado",
                "module": "dbconnector",
                "action": "single",
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
                          "id": "tickets.id",
                          "field": "tickets.id",
                          "type": "double",
                          "operator": "equal",
                          "value": "{{$_POST.id}}",
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
                    "query": "SELECT *\nFROM tickets\nWHERE id = :P1 /* {{$_POST.id}} */",
                    "params": [
                      {
                        "operator": "equal",
                        "type": "expression",
                        "name": ":P1",
                        "value": "{{$_POST.id}}"
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
                  }
                ],
                "outputType": "object"
              },
              {
                "name": "",
                "module": "core",
                "action": "condition",
                "options": {
                  "if": "{{$_POST.send_email}}",
                  "then": {
                    "steps": {
                      "name": "",
                      "module": "mail",
                      "action": "send",
                      "options": {
                        "instance": "mail",
                        "subject": "{{'O chamado '+chamado_atualizado.title+' recebeu uma nova interação.'}}",
                        "fromName": "Als Digital - Suporte",
                        "fromEmail": "suporte@alsdigital.com.br",
                        "replyTo": "suporte@alsdigital.com.br",
                        "toName": "{{cliente.fullname}}",
                        "toEmail": "{{cliente.email}}",
                        "contentType": "html",
                        "body": "<h2>Olá, {{cliente.fullname}}&nbsp;seu chamado teve uma nova interação.</h2><p>Atualizado em: <b>{{chamado_atualizado.updated_at.formatDate('dd/MM/yyyy - hh:mm')}}</b></p><p>Atualizado por:&nbsp;<b>{{responsavel.fullname}}</b><br><br></p><p><a href=\"https://{{$_SERVER.HTTP_HOST}}\">Clique aqui para ver o chamado</a></p><p></p><p><br></p><br><p></p>"
                      }
                    }
                  }
                },
                "outputType": "boolean"
              },
              {
                "name": "",
                "module": "core",
                "action": "condition",
                "options": {
                  "if": "{{upload.path}}",
                  "then": {
                    "steps": {
                      "name": "insert1",
                      "module": "dbupdater",
                      "action": "insert",
                      "options": {
                        "connection": "dados",
                        "sql": {
                          "type": "insert",
                          "values": [
                            {
                              "table": "files",
                              "column": "file_name",
                              "type": "text",
                              "value": "{{upload.name}}"
                            },
                            {
                              "table": "files",
                              "column": "file_url",
                              "type": "text",
                              "value": "{{upload.url}}"
                            },
                            {
                              "table": "files",
                              "column": "file_type",
                              "type": "text",
                              "value": "{{upload.type}}"
                            },
                            {
                              "table": "files",
                              "column": "created_at",
                              "type": "datetime",
                              "value": "{{NOW}}"
                            },
                            {
                              "table": "files",
                              "column": "ticket_id",
                              "type": "number",
                              "value": "{{$_POST.id}}"
                            },
                            {
                              "table": "files",
                              "column": "author_id",
                              "type": "number",
                              "value": "{{identity}}"
                            }
                          ],
                          "table": "files",
                          "returning": "id",
                          "query": "INSERT INTO files\n(file_name, file_url, file_type, created_at, ticket_id, author_id) VALUES (:P1 /* {{upload.name}} */, :P2 /* {{upload.url}} */, :P3 /* {{upload.type}} */, :P4 /* {{NOW}} */, :P5 /* {{$_POST.id}} */, :P6 /* {{identity}} */)",
                          "params": [
                            {
                              "name": ":P1",
                              "type": "expression",
                              "value": "{{upload.name}}"
                            },
                            {
                              "name": ":P2",
                              "type": "expression",
                              "value": "{{upload.url}}"
                            },
                            {
                              "name": ":P3",
                              "type": "expression",
                              "value": "{{upload.type}}"
                            },
                            {
                              "name": ":P4",
                              "type": "expression",
                              "value": "{{NOW}}"
                            },
                            {
                              "name": ":P5",
                              "type": "expression",
                              "value": "{{$_POST.id}}"
                            },
                            {
                              "name": ":P6",
                              "type": "expression",
                              "value": "{{identity}}"
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
                  }
                },
                "outputType": "boolean"
              }
            ]
          },
          "else": {
            "steps": [
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
                        "table": "tickets",
                        "column": "created_at",
                        "type": "datetime",
                        "value": "{{NOW}}"
                      },
                      {
                        "table": "tickets",
                        "column": "title",
                        "type": "text",
                        "value": "{{$_POST.title}}"
                      },
                      {
                        "table": "tickets",
                        "column": "description",
                        "type": "text",
                        "value": "{{$_POST.description}}"
                      },
                      {
                        "table": "tickets",
                        "column": "status",
                        "type": "number",
                        "value": "{{$_POST.status}}"
                      },
                      {
                        "table": "tickets",
                        "column": "product_id",
                        "type": "number",
                        "value": "{{$_POST.product_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "department_id",
                        "type": "number",
                        "value": "{{$_POST.department_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "client_id",
                        "type": "number",
                        "value": "{{$_POST.client_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "responsible_id",
                        "type": "number",
                        "value": "{{$_POST.responsible_id}}"
                      },
                      {
                        "table": "tickets",
                        "column": "token",
                        "type": "text",
                        "value": "{{TIMESTAMP.md5()}}"
                      }
                    ],
                    "table": "tickets",
                    "returning": "id",
                    "query": "INSERT INTO tickets\n(created_at, title, description, status, product_id, department_id, client_id, responsible_id, token) VALUES (:P1 /* {{NOW}} */, :P2 /* {{$_POST.title}} */, :P3 /* {{$_POST.description}} */, :P4 /* {{$_POST.status}} */, :P5 /* {{$_POST.product_id}} */, :P6 /* {{$_POST.department_id}} */, :P7 /* {{$_POST.client_id}} */, :P8 /* {{$_POST.responsible_id}} */, :P9 /* {{TIMESTAMP.md5()}} */)",
                    "params": [
                      {
                        "name": ":P1",
                        "type": "expression",
                        "value": "{{NOW}}"
                      },
                      {
                        "name": ":P2",
                        "type": "expression",
                        "value": "{{$_POST.title}}"
                      },
                      {
                        "name": ":P3",
                        "type": "expression",
                        "value": "{{$_POST.description}}"
                      },
                      {
                        "name": ":P4",
                        "type": "expression",
                        "value": "{{$_POST.status}}"
                      },
                      {
                        "name": ":P5",
                        "type": "expression",
                        "value": "{{$_POST.product_id}}"
                      },
                      {
                        "name": ":P6",
                        "type": "expression",
                        "value": "{{$_POST.department_id}}"
                      },
                      {
                        "name": ":P7",
                        "type": "expression",
                        "value": "{{$_POST.client_id}}"
                      },
                      {
                        "name": ":P8",
                        "type": "expression",
                        "value": "{{$_POST.responsible_id}}"
                      },
                      {
                        "name": ":P9",
                        "type": "expression",
                        "value": "{{TIMESTAMP.md5()}}"
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
                    "columns": [],
                    "table": {
                      "name": "tickets"
                    },
                    "joins": [],
                    "wheres": {
                      "condition": "AND",
                      "rules": [
                        {
                          "id": "tickets.id",
                          "field": "tickets.id",
                          "type": "double",
                          "operator": "equal",
                          "value": "{{insert.identity}}",
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
                    "query": "SELECT *\nFROM tickets\nWHERE id = :P1 /* {{insert.identity}} */",
                    "params": [
                      {
                        "operator": "equal",
                        "type": "expression",
                        "name": ":P1",
                        "value": "{{insert.identity}}"
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
                  }
                ],
                "outputType": "object"
              },
              {
                "name": "",
                "module": "core",
                "action": "condition",
                "options": {
                  "if": "{{$_POST.send_email}}",
                  "then": {
                    "steps": {
                      "name": "",
                      "module": "mail",
                      "action": "send",
                      "options": {
                        "instance": "mail",
                        "subject": "{{'Você recebeu um novo chamado '+chamado.title}}",
                        "fromName": "Als Digital - Suporte",
                        "fromEmail": "suporte@alsdigital.com.br",
                        "replyTo": "suporte@alsdigital.com.br",
                        "toName": "{{responsavel.fullname}}",
                        "toEmail": "{{responsavel.email}}",
                        "contentType": "html",
                        "body": "<h2>Olá,&nbsp;<b>{{responsavel.fullname}}</b> você recebeu um novo chamado.</h2><p>Data: <b>{{chamado.created_at.formatDate('dd/MM/yyyy - hh:mm')}}</b><br>Cliente:&nbsp;<b>{{cliente.fullname}}</b><br>Título:&nbsp;<b>{{chamado.title}}</b></p><p><a href=\"https://{{$_SERVER.HTTP_HOST}}\">Clique aqui para ver o chamado</a></p><p></p><p><br></p><br><p></p>"
                      }
                    }
                  }
                },
                "outputType": "boolean"
              },
              {
                "name": "",
                "module": "core",
                "action": "condition",
                "options": {
                  "if": "{{upload.path}}",
                  "then": {
                    "steps": {
                      "name": "insert_file",
                      "module": "dbupdater",
                      "action": "insert",
                      "options": {
                        "connection": "dados",
                        "sql": {
                          "type": "insert",
                          "values": [
                            {
                              "table": "files",
                              "column": "file_name",
                              "type": "text",
                              "value": "{{upload.name}}"
                            },
                            {
                              "table": "files",
                              "column": "file_url",
                              "type": "text",
                              "value": "{{upload.url}}"
                            },
                            {
                              "table": "files",
                              "column": "file_type",
                              "type": "text",
                              "value": "{{upload.type}}"
                            },
                            {
                              "table": "files",
                              "column": "created_at",
                              "type": "datetime",
                              "value": "{{NOW}}"
                            },
                            {
                              "table": "files",
                              "column": "ticket_id",
                              "type": "number",
                              "value": "{{insert.identity}}"
                            },
                            {
                              "table": "files",
                              "column": "author_id",
                              "type": "number",
                              "value": "{{identity}}"
                            }
                          ],
                          "table": "files",
                          "returning": "id",
                          "query": "INSERT INTO files\n(file_name, file_url, file_type, created_at, ticket_id, author_id) VALUES (:P1 /* {{upload.name}} */, :P2 /* {{upload.url}} */, :P3 /* {{upload.type}} */, :P4 /* {{NOW}} */, :P5 /* {{insert.identity}} */, :P6 /* {{identity}} */)",
                          "params": [
                            {
                              "name": ":P1",
                              "type": "expression",
                              "value": "{{upload.name}}"
                            },
                            {
                              "name": ":P2",
                              "type": "expression",
                              "value": "{{upload.url}}"
                            },
                            {
                              "name": ":P3",
                              "type": "expression",
                              "value": "{{upload.type}}"
                            },
                            {
                              "name": ":P4",
                              "type": "expression",
                              "value": "{{NOW}}"
                            },
                            {
                              "name": ":P5",
                              "type": "expression",
                              "value": "{{insert.identity}}"
                            },
                            {
                              "name": ":P6",
                              "type": "expression",
                              "value": "{{identity}}"
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
                  }
                },
                "outputType": "boolean"
              },
              {
                "name": "",
                "module": "core",
                "action": "condition",
                "options": {
                  "if": "{{identity == chamado.client_id}}",
                  "then": {
                    "steps": {
                      "name": "insert_notificacao_responsavel",
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
                              "value": "{{'Novo chamado criado nº '+chamado.id}}"
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
                              "value": "{{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}}"
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
                          "query": "INSERT INTO notifications\n(created_at, title, icon, url, status, user_id, ticket_id) VALUES (:P1 /* {{NOW}} */, :P2 /* {{'Novo chamado criado nº '+chamado.id}} */, 'fa fa-envelope', :P3 /* {{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}} */, '2', :P4 /* {{chamado.responsible_id}} */, :P5 /* {{chamado.id}} */)",
                          "params": [
                            {
                              "name": ":P1",
                              "type": "expression",
                              "value": "{{NOW}}"
                            },
                            {
                              "name": ":P2",
                              "type": "expression",
                              "value": "{{'Novo chamado criado nº '+chamado.id}}"
                            },
                            {
                              "name": ":P3",
                              "type": "expression",
                              "value": "{{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}}"
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
                  },
                  "else": {
                    "steps": {
                      "name": "insert_notificacao_cliente",
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
                              "value": "{{'Novo chamado criado nº '+chamado.id}}"
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
                              "value": "{{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}}"
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
                          "query": "INSERT INTO notifications\n(created_at, title, icon, url, status, user_id, ticket_id) VALUES (:P1 /* {{NOW}} */, :P2 /* {{'Novo chamado criado nº '+chamado.id}} */, 'fa fa-envelope', :P3 /* {{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}} */, '2', :P4 /* {{chamado.client_id}} */, :P5 /* {{chamado.id}} */)",
                          "params": [
                            {
                              "name": ":P1",
                              "type": "expression",
                              "value": "{{NOW}}"
                            },
                            {
                              "name": ":P2",
                              "type": "expression",
                              "value": "{{'Novo chamado criado nº '+chamado.id}}"
                            },
                            {
                              "name": ":P3",
                              "type": "expression",
                              "value": "{{'https://'+$_SERVER.HTTP_HOST+'/painel/chamados/detaill-followups/'+chamado.token}}"
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
                  }
                },
                "outputType": "boolean"
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