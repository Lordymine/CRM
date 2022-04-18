<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_GET": [
      {
        "type": "text",
        "name": "cep"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "api",
      "module": "api",
      "action": "send",
      "options": {
        "url": "{{'https://viacep.com.br/ws/'+$_GET.cep+'/json/'}}",
        "schema": []
      },
      "output": true,
      "meta": [
        {
          "type": "object",
          "name": "data",
          "sub": [
            {
              "type": "text",
              "name": "cep"
            },
            {
              "type": "text",
              "name": "logradouro"
            },
            {
              "type": "text",
              "name": "complemento"
            },
            {
              "type": "text",
              "name": "bairro"
            },
            {
              "type": "text",
              "name": "localidade"
            },
            {
              "type": "text",
              "name": "uf"
            },
            {
              "type": "text",
              "name": "ibge"
            },
            {
              "type": "text",
              "name": "gia"
            },
            {
              "type": "text",
              "name": "ddd"
            },
            {
              "type": "text",
              "name": "siafi"
            }
          ]
        },
        {
          "type": "object",
          "name": "headers",
          "sub": [
            {
              "type": "text",
              "name": "access-control-allow-credentials"
            },
            {
              "type": "text",
              "name": "access-control-allow-headers"
            },
            {
              "type": "text",
              "name": "access-control-allow-methods"
            },
            {
              "type": "text",
              "name": "access-control-allow-origin"
            },
            {
              "type": "text",
              "name": "access-control-max-age"
            },
            {
              "type": "text",
              "name": "cache-control"
            },
            {
              "type": "text",
              "name": "connection"
            },
            {
              "type": "text",
              "name": "content-type"
            },
            {
              "type": "text",
              "name": "date"
            },
            {
              "type": "text",
              "name": "expires"
            },
            {
              "type": "text",
              "name": "pragma"
            },
            {
              "type": "text",
              "name": "server"
            },
            {
              "type": "text",
              "name": "transfer-encoding"
            }
          ]
        }
      ],
      "outputType": "object"
    }
  }
}
JSON
);
?>