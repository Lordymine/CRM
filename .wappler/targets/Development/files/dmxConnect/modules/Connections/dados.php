<?php
$exports = <<<'JSON'
{
  "name": "dados",
  "module": "dbconnector",
  "action": "connect",
  "options": {
    "server": "mysql",
    "databaseType": "MySQL",
    "connectionString": "mysql:host=localhost;sslverify=false;dbname=crm;user=root;charset=utf8",
    "meta": false
  }
}
JSON;
?>