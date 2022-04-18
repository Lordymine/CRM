<?php
// Database Type : "MySQL"
// Database Adapter : "mysql"
$exports = <<<'JSON'
{
    "name": "dados1",
    "module": "dbconnector",
    "action": "connect",
    "options": {
        "server": "mysql",
        "connectionString": "mysql:host=localhost;sslverify=false;dbname=crm;user=root;charset=utf8",
        "meta"  : false
    }
}
JSON;
?>