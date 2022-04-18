<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "status"
      },
      {
        "type": "text",
        "name": "title"
      },
      {
        "type": "text",
        "name": "offset"
      },
      {
        "type": "text",
        "name": "limit"
      },
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
        "name": "department"
      },
      {
        "type": "text",
        "name": "responsible"
      },
      {
        "type": "text",
        "name": "client_id"
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
        "output": false,
        "meta": []
      },
      {
        "name": "user_logado",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [
              {
                "table": "users",
                "column": "permission_level"
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
            "query": "SELECT permission_level\nFROM users\nWHERE id = :P1 /* {{identity}} */",
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
        "meta": [
          {
            "name": "permission_level",
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
          "if": "{{user_logado.permission_level >= 10}}",
          "then": {
            "steps": {
              "name": "query",
              "module": "dbconnector",
              "action": "paged",
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
                      "table": "status",
                      "column": "name",
                      "alias": "status_nome"
                    },
                    {
                      "table": "department_tickets",
                      "column": "name",
                      "alias": "departamento_nome"
                    },
                    {
                      "table": "clientes",
                      "column": "fullname",
                      "alias": "cliente_nome"
                    },
                    {
                      "table": "responsavel",
                      "column": "fullname",
                      "alias": "responsavel_nome"
                    }
                  ],
                  "table": {
                    "name": "tickets"
                  },
                  "joins": [
                    {
                      "table": "department_tickets",
                      "column": "*",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "department_tickets",
                            "column": "id",
                            "operator": "equal",
                            "value": {
                              "table": "tickets",
                              "column": "department_id"
                            },
                            "operation": "="
                          }
                        ]
                      }
                    },
                    {
                      "table": "users",
                      "column": "*",
                      "alias": "clientes",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "clientes",
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
                    },
                    {
                      "table": "status_tickets",
                      "column": "*",
                      "alias": "status",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "status",
                            "column": "id",
                            "operator": "equal",
                            "value": {
                              "table": "tickets",
                              "column": "status"
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
                        "id": "tickets.title",
                        "field": "tickets.title",
                        "type": "string",
                        "operator": "contains",
                        "value": "{{$_GET.title}}",
                        "data": {
                          "table": "tickets",
                          "column": "title",
                          "type": "text"
                        },
                        "operation": "LIKE"
                      },
                      {
                        "condition": "AND",
                        "rules": [
                          {
                            "id": "tickets.status",
                            "field": "tickets.status",
                            "type": "double",
                            "operator": "equal",
                            "value": "{{$_GET.status}}",
                            "data": {
                              "table": "tickets",
                              "column": "status",
                              "type": "number"
                            },
                            "operation": "="
                          }
                        ],
                        "conditional": "{{$_GET.status}}"
                      },
                      {
                        "condition": "AND",
                        "rules": [
                          {
                            "id": "tickets.client_id",
                            "field": "tickets.client_id",
                            "type": "double",
                            "operator": "equal",
                            "value": "{{$_GET.client_id}}",
                            "data": {
                              "table": "tickets",
                              "column": "client_id",
                              "type": "number"
                            },
                            "operation": "="
                          }
                        ],
                        "conditional": "{{$_GET.client_id}}"
                      },
                      {
                        "condition": "AND",
                        "rules": [
                          {
                            "id": "tickets.department_id",
                            "field": "tickets.department_id",
                            "type": "double",
                            "operator": "equal",
                            "value": "{{$_GET.department}}",
                            "data": {
                              "table": "tickets",
                              "column": "department_id",
                              "type": "number"
                            },
                            "operation": "="
                          }
                        ],
                        "conditional": "{{$_GET.department}}"
                      }
                    ],
                    "conditional": null,
                    "valid": true
                  },
                  "orders": [
                    {
                      "table": "tickets",
                      "column": "created_at",
                      "direction": "DESC",
                      "recid": 1
                    }
                  ],
                  "query": "SELECT tickets.*, status.name AS status_nome, department_tickets.name AS departamento_nome, clientes.fullname AS cliente_nome, responsavel.fullname AS responsavel_nome\nFROM tickets\nLEFT JOIN department_tickets ON (department_tickets.id = tickets.department_id) LEFT JOIN users AS clientes ON (clientes.id = tickets.client_id) LEFT JOIN users AS responsavel ON (responsavel.id = tickets.responsible_id) LEFT JOIN status_tickets AS status ON (status.id = tickets.status)\nWHERE tickets.title LIKE :P1 /* {{$_GET.title}} */ AND (tickets.status = :P2 /* {{$_GET.status}} */) AND (tickets.client_id = :P3 /* {{$_GET.client_id}} */) AND (tickets.department_id = :P4 /* {{$_GET.department}} */)\nORDER BY tickets.created_at DESC",
                  "params": [
                    {
                      "operator": "contains",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{$_GET.title}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P2",
                      "value": "{{$_GET.status}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P3",
                      "value": "{{$_GET.client_id}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P4",
                      "value": "{{$_GET.department}}"
                    }
                  ]
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
                    },
                    {
                      "name": "status_nome",
                      "type": "text"
                    },
                    {
                      "name": "departamento_nome",
                      "type": "text"
                    },
                    {
                      "name": "cliente_nome",
                      "type": "text"
                    },
                    {
                      "name": "responsavel_nome",
                      "type": "text"
                    }
                  ]
                }
              ],
              "outputType": "object"
            }
          },
          "else": {
            "steps": {
              "name": "query",
              "module": "dbconnector",
              "action": "paged",
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
                      "table": "status",
                      "column": "name",
                      "alias": "status_nome"
                    },
                    {
                      "table": "department_tickets",
                      "column": "name",
                      "alias": "departamento_nome"
                    },
                    {
                      "table": "clientes",
                      "column": "fullname",
                      "alias": "cliente_nome"
                    },
                    {
                      "table": "responsavel",
                      "column": "fullname",
                      "alias": "responsavel_nome"
                    }
                  ],
                  "table": {
                    "name": "tickets"
                  },
                  "joins": [
                    {
                      "table": "department_tickets",
                      "column": "*",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "department_tickets",
                            "column": "id",
                            "operator": "equal",
                            "value": {
                              "table": "tickets",
                              "column": "department_id"
                            },
                            "operation": "="
                          }
                        ]
                      }
                    },
                    {
                      "table": "users",
                      "column": "*",
                      "alias": "clientes",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "clientes",
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
                    },
                    {
                      "table": "status_tickets",
                      "column": "*",
                      "alias": "status",
                      "type": "LEFT",
                      "clauses": {
                        "condition": "AND",
                        "rules": [
                          {
                            "table": "status",
                            "column": "id",
                            "operator": "equal",
                            "value": {
                              "table": "tickets",
                              "column": "status"
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
                        "id": "tickets.title",
                        "field": "tickets.title",
                        "type": "string",
                        "operator": "contains",
                        "value": "{{$_GET.title}}",
                        "data": {
                          "table": "tickets",
                          "column": "title",
                          "type": "text"
                        },
                        "operation": "LIKE"
                      },
                      {
                        "condition": "AND",
                        "rules": [
                          {
                            "id": "tickets.status",
                            "field": "tickets.status",
                            "type": "double",
                            "operator": "equal",
                            "value": "{{$_GET.status}}",
                            "data": {
                              "table": "tickets",
                              "column": "status",
                              "type": "number"
                            },
                            "operation": "="
                          }
                        ],
                        "conditional": "{{$_GET.status}}"
                      },
                      {
                        "condition": "AND",
                        "rules": [
                          {
                            "id": "tickets.department_id",
                            "field": "tickets.department_id",
                            "type": "string",
                            "operator": "equal",
                            "value": "{{$_GET.department}}",
                            "data": {
                              "table": "tickets",
                              "column": "department_id",
                              "type": "number"
                            },
                            "operation": "="
                          }
                        ],
                        "conditional": "{{$_GET.department}}"
                      },
                      {
                        "id": "tickets.client_id",
                        "field": "tickets.client_id",
                        "type": "string",
                        "operator": "equal",
                        "value": "{{identity}}",
                        "data": {
                          "table": "tickets",
                          "column": "client_id",
                          "type": "text"
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
                      "column": "created_at",
                      "direction": "DESC",
                      "recid": 1
                    }
                  ],
                  "query": "SELECT tickets.*, status.name AS status_nome, department_tickets.name AS departamento_nome, clientes.fullname AS cliente_nome, responsavel.fullname AS responsavel_nome\nFROM tickets\nLEFT JOIN department_tickets ON (department_tickets.id = tickets.department_id) LEFT JOIN users AS clientes ON (clientes.id = tickets.client_id) LEFT JOIN users AS responsavel ON (responsavel.id = tickets.responsible_id) LEFT JOIN status_tickets AS status ON (status.id = tickets.status)\nWHERE tickets.title LIKE :P1 /* {{$_GET.title}} */ AND (tickets.status = :P2 /* {{$_GET.status}} */) AND (tickets.department_id = :P3 /* {{$_GET.department}} */) AND tickets.client_id = :P4 /* {{identity}} */\nORDER BY tickets.created_at DESC",
                  "params": [
                    {
                      "operator": "contains",
                      "type": "expression",
                      "name": ":P1",
                      "value": "{{$_GET.title}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P2",
                      "value": "{{$_GET.status}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P3",
                      "value": "{{$_GET.department}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P4",
                      "value": "{{identity}}"
                    }
                  ]
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
                    },
                    {
                      "name": "status_nome",
                      "type": "text"
                    },
                    {
                      "name": "departamento_nome",
                      "type": "text"
                    },
                    {
                      "name": "cliente_nome",
                      "type": "text"
                    },
                    {
                      "name": "responsavel_nome",
                      "type": "text"
                    }
                  ]
                }
              ],
              "outputType": "object"
            }
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