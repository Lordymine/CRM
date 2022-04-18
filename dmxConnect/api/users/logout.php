<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
[
  {
    "name": "",
    "module": "auth",
    "action": "logout",
    "options": {
      "provider": "auth"
    }
  },
  {
    "name": "",
    "module": "core",
    "action": "redirect",
    "options": {
      "url": "/painel/login"
    }
  }
]
JSON
);
?>