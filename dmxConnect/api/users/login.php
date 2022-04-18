<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "text",
        "options": {
          "rules": {
            "core:required": {
              "message": "Obrigatório."
            }
          }
        },
        "name": "email"
      },
      {
        "type": "text",
        "options": {
          "rules": {
            "core:required": {
              "message": "Obrigatório."
            }
          }
        },
        "name": "password"
      },
      {
        "type": "text",
        "options": {
          "rules": {}
        },
        "name": "remember"
      }
    ]
  },
  "exec": {
    "steps": {
      "name": "identity",
      "module": "auth",
      "action": "login",
      "options": {
        "provider": "auth",
        "username": "{{$_POST.email}}",
        "password": "{{$_POST.password.sha1()}}"
      },
      "output": true,
      "meta": []
    }
  }
}
JSON
);
?>