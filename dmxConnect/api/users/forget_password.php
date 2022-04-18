<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "name": "email"
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
            "wheres": {
              "condition": "AND",
              "rules": [
                {
                  "id": "users.email",
                  "field": "users.email",
                  "type": "string",
                  "operator": "equal",
                  "value": "{{$_POST.email.lowercase().trim()}}",
                  "data": {
                    "table": "users",
                    "column": "email",
                    "type": "text"
                  },
                  "operation": "="
                }
              ],
              "conditional": null,
              "valid": true
            },
            "query": "SELECT *\nFROM users\nWHERE email = :P1 /* {{$_POST.email.lowercase().trim()}} */",
            "params": [
              {
                "operator": "equal",
                "type": "expression",
                "name": ":P1",
                "value": "{{$_POST.email.lowercase().trim()}}"
              }
            ]
          }
        },
        "meta": [
          {
            "name": "id",
            "type": "number"
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
            "name": "permission_level",
            "type": "text"
          },
          {
            "name": "status",
            "type": "number"
          },
          {
            "name": "type_user_id",
            "type": "number"
          }
        ],
        "outputType": "object"
      },
      {
        "name": "",
        "module": "core",
        "action": "condition",
        "options": {
          "if": "{{user}}",
          "then": {
            "steps": {
              "name": "",
              "module": "mail",
              "action": "send",
              "options": {
                "instance": "mail",
                "subject": "Recuperação de senha",
                "fromName": "Als Digital  - Suporte",
                "fromEmail": "suporte@alsdigital.com.br",
                "replyTo": "suporte@alsdigital.com.br",
                "toName": "{{user.fullname}}",
                "toEmail": "{{user.email}}",
                "contentType": "html",
                "embedImages": true,
                "body": "<p>Olá,&nbsp;<b>{{user.fullname.split(' ')[0]}} você solicitou a troca de senha em nosso sistema</b></p><p><b>Por favor clique no link abaixo para resetar sua senha</b></p><h2><b><a href=\"https://{{$_SERVER.HTTP_HOST+'/painel/usuarios/resete-de-senha/'+user.token}}\">Clique aqui para trocar sua senha</a></b></h2><p><b><br></b></p>"
              }
            }
          },
          "else": {
            "steps": {
              "name": "error",
              "module": "core",
              "action": "response",
              "options": {
                "status": 401,
                "data": "Este email não existe!"
              }
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