<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "fullname"
      },
      {
        "type": "text",
        "name": "email"
      },
      {
        "type": "text",
        "name": "password"
      },
      {
        "type": "text",
        "name": "cellphone"
      },
      {
        "type": "text",
        "name": "cpf"
      },
      {
        "type": "text",
        "name": "cnpj"
      },
      {
        "type": "text",
        "name": "zipcode"
      },
      {
        "type": "text",
        "name": "address"
      },
      {
        "type": "text",
        "name": "neightborhood"
      },
      {
        "type": "text",
        "name": "city"
      },
      {
        "type": "text",
        "name": "uf"
      },
      {
        "type": "text",
        "name": "company"
      },
      {
        "type": "text",
        "name": "phone"
      },
      {
        "type": "file",
        "name": "avatar",
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
      },
      {
        "type": "number",
        "name": "status"
      },
      {
        "type": "number",
        "name": "type_user_id"
      },
      {
        "type": "number",
        "name": "permission_level"
      },
      {
        "type": "text",
        "name": "id"
      },
      {
        "type": "number",
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
        "name": "user",
        "module": "dbconnector",
        "action": "single",
        "options": {
          "connection": "dados",
          "sql": {
            "type": "SELECT",
            "columns": [],
            "table": {
              "name": "users"
            },
            "joins": [],
            "query": "SELECT *\nFROM users\nWHERE token = :P1 /* {{$_POST.token}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.token}}"
              }
            ],
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "users.token",
                  "field": "users.token",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_POST.token}}",
                  "data": {
                    "table": "users",
                    "column": "token",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            }
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
            "name": "password",
            "type": "text"
          },
          {
            "name": "cellphone",
            "type": "text"
          },
          {
            "name": "cpf",
            "type": "text"
          },
          {
            "name": "cnpj",
            "type": "text"
          },
          {
            "name": "zipcode",
            "type": "text"
          },
          {
            "name": "address",
            "type": "text"
          },
          {
            "name": "neightborhood",
            "type": "text"
          },
          {
            "name": "city",
            "type": "text"
          },
          {
            "name": "uf",
            "type": "text"
          },
          {
            "name": "company",
            "type": "text"
          },
          {
            "name": "phone",
            "type": "text"
          },
          {
            "name": "avatar",
            "type": "text"
          },
          {
            "name": "token",
            "type": "text"
          },
          {
            "name": "status",
            "type": "number"
          },
          {
            "name": "type_user_id",
            "type": "text"
          },
          {
            "name": "permission_level",
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
            "name": "department_id",
            "type": "number"
          }
        ],
        "outputType": "object"
      },
      {
        "name": "upload",
        "module": "upload",
        "action": "upload",
        "options": {
          "fields": "{{$_POST.avatar}}",
          "path": "/assets/uploads/users/{{$_POST.id}}",
          "template": "{guid}{ext}",
          "replaceSpace": true,
          "replaceDiacritics": true,
          "asciiOnly": true,
          "overwrite": true
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
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{upload.path}}",
          "then": {
            "steps": [
              {
                "name": "image",
                "module": "image",
                "action": "load",
                "options": {
                  "path": "{{upload.path}}",
                  "autoOrient": true
                },
                "outputType": "object",
                "meta": [
                  {
                    "name": "width",
                    "type": "number"
                  },
                  {
                    "name": "height",
                    "type": "number"
                  }
                ]
              },
              {
                "name": "",
                "module": "image",
                "action": "resize",
                "options": {
                  "instance": "image",
                  "width": 450
                }
              },
              {
                "name": "newImage",
                "module": "image",
                "action": "save",
                "options": {
                  "instance": "image",
                  "format": "auto",
                  "path": "/assets/uploads/users/{{$_POST.id}}",
                  "overwrite": true
                }
              },
              {
                "name": "fileExists",
                "module": "fs",
                "action": "exists",
                "options": {
                  "path": "{{'/assets/uploads/users/'+user.id+'/'+user.avatar}}",
                  "then": {
                    "steps": {
                      "name": "fileRemove",
                      "module": "fs",
                      "action": "remove",
                      "options": {
                        "path": "{{'/assets/uploads/users/'+user.id+'/'+user.avatar}}"
                      },
                      "outputType": "boolean"
                    }
                  }
                },
                "outputType": "boolean"
              }
            ]
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
            "steps": {
              "name": "update",
              "module": "dbupdater",
              "action": "update",
              "options": {
                "connection": "dados",
                "sql": {
                  "type": "update",
                  "values": [
                    {
                      "table": "users",
                      "column": "fullname",
                      "type": "text",
                      "value": "{{$_POST.fullname}}"
                    },
                    {
                      "table": "users",
                      "column": "email",
                      "type": "text",
                      "value": "{{$_POST.email}}"
                    },
                    {
                      "table": "users",
                      "column": "password",
                      "type": "text",
                      "value": "{{$_POST.password.sha1()}}",
                      "condition": "{{$_POST.password}}"
                    },
                    {
                      "table": "users",
                      "column": "cellphone",
                      "type": "text",
                      "value": "{{$_POST.cellphone}}"
                    },
                    {
                      "table": "users",
                      "column": "cpf",
                      "type": "text",
                      "value": "{{$_POST.cpf}}"
                    },
                    {
                      "table": "users",
                      "column": "cnpj",
                      "type": "text",
                      "value": "{{$_POST.cnpj}}"
                    },
                    {
                      "table": "users",
                      "column": "zipcode",
                      "type": "text",
                      "value": "{{$_POST.zipcode}}"
                    },
                    {
                      "table": "users",
                      "column": "address",
                      "type": "text",
                      "value": "{{$_POST.address}}"
                    },
                    {
                      "table": "users",
                      "column": "neightborhood",
                      "type": "text",
                      "value": "{{$_POST.neightborhood}}"
                    },
                    {
                      "table": "users",
                      "column": "city",
                      "type": "text",
                      "value": "{{$_POST.city}}"
                    },
                    {
                      "table": "users",
                      "column": "uf",
                      "type": "text",
                      "value": "{{$_POST.uf}}"
                    },
                    {
                      "table": "users",
                      "column": "company",
                      "type": "text",
                      "value": "{{$_POST.company}}"
                    },
                    {
                      "table": "users",
                      "column": "phone",
                      "type": "text",
                      "value": "{{$_POST.phone}}"
                    },
                    {
                      "table": "users",
                      "column": "avatar",
                      "type": "text",
                      "value": "{{upload.url}}",
                      "condition": "{{upload.url}}"
                    },
                    {
                      "table": "users",
                      "column": "status",
                      "type": "number",
                      "value": "{{$_POST.status}}"
                    },
                    {
                      "table": "users",
                      "column": "type_user_id",
                      "type": "number",
                      "value": "{{$_POST.type_user_id}}"
                    },
                    {
                      "table": "users",
                      "column": "permission_level",
                      "type": "number",
                      "value": "{{$_POST.permission_level}}"
                    },
                    {
                      "table": "users",
                      "column": "updated_at",
                      "type": "datetime",
                      "value": "{{NOW}}"
                    },
                    {
                      "table": "users",
                      "column": "department_id",
                      "type": "number",
                      "value": "{{$_POST.department_id}}"
                    }
                  ],
                  "table": "users",
                  "wheres": {
                    "condition": "AND",
                    "rules": [
                      {
                        "id": "id",
                        "field": "id",
                        "type": "double",
                        "operator": "equal",
                        "value": "{{$_POST.id}}",
                        "data": {
                          "column": "id"
                        },
                        "operation": "="
                      }
                    ],
                    "conditional": null,
                    "valid": true
                  },
                  "query": "UPDATE users\nSET fullname = :P1 /* {{$_POST.fullname}} */, email = :P2 /* {{$_POST.email}} */, password = :P3 /* {{$_POST.password.sha1()}} */, cellphone = :P4 /* {{$_POST.cellphone}} */, cpf = :P5 /* {{$_POST.cpf}} */, cnpj = :P6 /* {{$_POST.cnpj}} */, zipcode = :P7 /* {{$_POST.zipcode}} */, address = :P8 /* {{$_POST.address}} */, neightborhood = :P9 /* {{$_POST.neightborhood}} */, city = :P10 /* {{$_POST.city}} */, uf = :P11 /* {{$_POST.uf}} */, company = :P12 /* {{$_POST.company}} */, phone = :P13 /* {{$_POST.phone}} */, avatar = :P14 /* {{upload.url}} */, status = :P15 /* {{$_POST.status}} */, type_user_id = :P16 /* {{$_POST.type_user_id}} */, permission_level = :P17 /* {{$_POST.permission_level}} */, updated_at = :P18 /* {{NOW}} */, department_id = :P19 /* {{$_POST.department_id}} */\nWHERE id = :P20 /* {{$_POST.id}} */",
                  "params": [
                    {
                      "name": ":P1",
                      "type": "expression",
                      "value": "{{$_POST.fullname}}"
                    },
                    {
                      "name": ":P2",
                      "type": "expression",
                      "value": "{{$_POST.email}}"
                    },
                    {
                      "name": ":P3",
                      "type": "expression",
                      "value": "{{$_POST.password.sha1()}}"
                    },
                    {
                      "name": ":P4",
                      "type": "expression",
                      "value": "{{$_POST.cellphone}}"
                    },
                    {
                      "name": ":P5",
                      "type": "expression",
                      "value": "{{$_POST.cpf}}"
                    },
                    {
                      "name": ":P6",
                      "type": "expression",
                      "value": "{{$_POST.cnpj}}"
                    },
                    {
                      "name": ":P7",
                      "type": "expression",
                      "value": "{{$_POST.zipcode}}"
                    },
                    {
                      "name": ":P8",
                      "type": "expression",
                      "value": "{{$_POST.address}}"
                    },
                    {
                      "name": ":P9",
                      "type": "expression",
                      "value": "{{$_POST.neightborhood}}"
                    },
                    {
                      "name": ":P10",
                      "type": "expression",
                      "value": "{{$_POST.city}}"
                    },
                    {
                      "name": ":P11",
                      "type": "expression",
                      "value": "{{$_POST.uf}}"
                    },
                    {
                      "name": ":P12",
                      "type": "expression",
                      "value": "{{$_POST.company}}"
                    },
                    {
                      "name": ":P13",
                      "type": "expression",
                      "value": "{{$_POST.phone}}"
                    },
                    {
                      "name": ":P14",
                      "type": "expression",
                      "value": "{{upload.url}}"
                    },
                    {
                      "name": ":P15",
                      "type": "expression",
                      "value": "{{$_POST.status}}"
                    },
                    {
                      "name": ":P16",
                      "type": "expression",
                      "value": "{{$_POST.type_user_id}}"
                    },
                    {
                      "name": ":P17",
                      "type": "expression",
                      "value": "{{$_POST.permission_level}}"
                    },
                    {
                      "name": ":P18",
                      "type": "expression",
                      "value": "{{NOW}}"
                    },
                    {
                      "name": ":P19",
                      "type": "expression",
                      "value": "{{$_POST.department_id}}"
                    },
                    {
                      "operator": "equal",
                      "type": "expression",
                      "name": ":P20",
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
            }
          },
          "else": {
            "steps": {
              "name": "insert",
              "module": "dbupdater",
              "action": "insert",
              "options": {
                "connection": "dados",
                "sql": {
                  "type": "insert",
                  "values": [
                    {
                      "table": "users",
                      "column": "fullname",
                      "type": "text",
                      "value": "{{$_POST.fullname}}"
                    },
                    {
                      "table": "users",
                      "column": "email",
                      "type": "text",
                      "value": "{{$_POST.email}}"
                    },
                    {
                      "table": "users",
                      "column": "password",
                      "type": "text",
                      "value": "{{$_POST.password.sha1()}}"
                    },
                    {
                      "table": "users",
                      "column": "cellphone",
                      "type": "text",
                      "value": "{{$_POST.cellphone}}"
                    },
                    {
                      "table": "users",
                      "column": "cpf",
                      "type": "text",
                      "value": "{{$_POST.cpf}}"
                    },
                    {
                      "table": "users",
                      "column": "cnpj",
                      "type": "text",
                      "value": "{{$_POST.cnpj}}"
                    },
                    {
                      "table": "users",
                      "column": "zipcode",
                      "type": "text",
                      "value": "{{$_POST.zipcode}}"
                    },
                    {
                      "table": "users",
                      "column": "address",
                      "type": "text",
                      "value": "{{$_POST.address}}"
                    },
                    {
                      "table": "users",
                      "column": "neightborhood",
                      "type": "text",
                      "value": "{{$_POST.neightborhood}}"
                    },
                    {
                      "table": "users",
                      "column": "city",
                      "type": "text",
                      "value": "{{$_POST.city}}"
                    },
                    {
                      "table": "users",
                      "column": "uf",
                      "type": "text",
                      "value": "{{$_POST.uf}}"
                    },
                    {
                      "table": "users",
                      "column": "company",
                      "type": "text",
                      "value": "{{$_POST.company}}"
                    },
                    {
                      "table": "users",
                      "column": "phone",
                      "type": "text",
                      "value": "{{$_POST.phone}}"
                    },
                    {
                      "table": "users",
                      "column": "avatar",
                      "type": "text",
                      "value": "{{upload.url}}",
                      "condition": "{{upload.url}}"
                    },
                    {
                      "table": "users",
                      "column": "token",
                      "type": "text",
                      "value": "{{$_POST.email.md5(TIMESTAMP)}}"
                    },
                    {
                      "table": "users",
                      "column": "status",
                      "type": "number",
                      "value": "{{$_POST.status}}"
                    },
                    {
                      "table": "users",
                      "column": "type_user_id",
                      "type": "number",
                      "value": "{{$_POST.type_user_id}}"
                    },
                    {
                      "table": "users",
                      "column": "permission_level",
                      "type": "number",
                      "value": "{{$_POST.permission_level}}"
                    },
                    {
                      "table": "users",
                      "column": "created_at",
                      "type": "datetime",
                      "value": "{{NOW}}"
                    },
                    {
                      "table": "users",
                      "column": "department_id",
                      "type": "number",
                      "value": "{{$_POST.department_id}}"
                    }
                  ],
                  "table": "users",
                  "returning": "id",
                  "query": "INSERT INTO users\n(fullname, email, password, cellphone, cpf, cnpj, zipcode, address, neightborhood, city, uf, company, phone, avatar, token, status, type_user_id, permission_level, created_at, department_id) VALUES (:P1 /* {{$_POST.fullname}} */, :P2 /* {{$_POST.email}} */, :P3 /* {{$_POST.password.sha1()}} */, :P4 /* {{$_POST.cellphone}} */, :P5 /* {{$_POST.cpf}} */, :P6 /* {{$_POST.cnpj}} */, :P7 /* {{$_POST.zipcode}} */, :P8 /* {{$_POST.address}} */, :P9 /* {{$_POST.neightborhood}} */, :P10 /* {{$_POST.city}} */, :P11 /* {{$_POST.uf}} */, :P12 /* {{$_POST.company}} */, :P13 /* {{$_POST.phone}} */, :P14 /* {{upload.url}} */, :P15 /* {{$_POST.email.md5(TIMESTAMP)}} */, :P16 /* {{$_POST.status}} */, :P17 /* {{$_POST.type_user_id}} */, :P18 /* {{$_POST.permission_level}} */, :P19 /* {{NOW}} */, :P20 /* {{$_POST.department_id}} */)",
                  "params": [
                    {
                      "name": ":P1",
                      "type": "expression",
                      "value": "{{$_POST.fullname}}"
                    },
                    {
                      "name": ":P2",
                      "type": "expression",
                      "value": "{{$_POST.email}}"
                    },
                    {
                      "name": ":P3",
                      "type": "expression",
                      "value": "{{$_POST.password.sha1()}}"
                    },
                    {
                      "name": ":P4",
                      "type": "expression",
                      "value": "{{$_POST.cellphone}}"
                    },
                    {
                      "name": ":P5",
                      "type": "expression",
                      "value": "{{$_POST.cpf}}"
                    },
                    {
                      "name": ":P6",
                      "type": "expression",
                      "value": "{{$_POST.cnpj}}"
                    },
                    {
                      "name": ":P7",
                      "type": "expression",
                      "value": "{{$_POST.zipcode}}"
                    },
                    {
                      "name": ":P8",
                      "type": "expression",
                      "value": "{{$_POST.address}}"
                    },
                    {
                      "name": ":P9",
                      "type": "expression",
                      "value": "{{$_POST.neightborhood}}"
                    },
                    {
                      "name": ":P10",
                      "type": "expression",
                      "value": "{{$_POST.city}}"
                    },
                    {
                      "name": ":P11",
                      "type": "expression",
                      "value": "{{$_POST.uf}}"
                    },
                    {
                      "name": ":P12",
                      "type": "expression",
                      "value": "{{$_POST.company}}"
                    },
                    {
                      "name": ":P13",
                      "type": "expression",
                      "value": "{{$_POST.phone}}"
                    },
                    {
                      "name": ":P14",
                      "type": "expression",
                      "value": "{{upload.url}}"
                    },
                    {
                      "name": ":P15",
                      "type": "expression",
                      "value": "{{$_POST.email.md5(TIMESTAMP)}}"
                    },
                    {
                      "name": ":P16",
                      "type": "expression",
                      "value": "{{$_POST.status}}"
                    },
                    {
                      "name": ":P17",
                      "type": "expression",
                      "value": "{{$_POST.type_user_id}}"
                    },
                    {
                      "name": ":P18",
                      "type": "expression",
                      "value": "{{$_POST.permission_level}}"
                    },
                    {
                      "name": ":P19",
                      "type": "expression",
                      "value": "{{NOW}}"
                    },
                    {
                      "name": ":P20",
                      "type": "expression",
                      "value": "{{$_POST.department_id}}"
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
}
JSON
);
?>