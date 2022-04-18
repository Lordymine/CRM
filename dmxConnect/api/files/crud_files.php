<?php
require('../../../dmxConnectLib/dmxConnect.php');


$app = new \lib\App();

$app->define(<<<'JSON'
{
  "meta": {
    "$_POST": [
      {
        "type": "file",
        "multiple": true,
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
        "outputType": "array"
      },
      {
        "type": "text",
        "name": "ticket_id"
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
        "outputType": "array"
      },
      {
        "name": "rep_upload",
        "module": "core",
        "action": "repeat",
        "options": {
          "repeat": "{{upload}}",
          "outputFields": [],
          "exec": {
            "steps": {
              "name": "",
              "module": "core",
              "action": "condition",
              "options": {
                "if": "{{path}}",
                "then": {
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
                            "table": "files",
                            "column": "file_name",
                            "type": "text",
                            "value": "{{name}}"
                          },
                          {
                            "table": "files",
                            "column": "file_url",
                            "type": "text",
                            "value": "{{url}}"
                          },
                          {
                            "table": "files",
                            "column": "file_type",
                            "type": "text",
                            "value": "{{type}}"
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
                            "type": "text",
                            "value": "{{$_POST.ticket_id}}"
                          },
                          {
                            "table": "files",
                            "column": "author_id",
                            "type": "text",
                            "value": "{{identity}}"
                          }
                        ],
                        "table": "files",
                        "returning": "id",
                        "query": "INSERT INTO files\n(file_name, file_url, file_type, created_at, ticket_id, author_id) VALUES (:P1 /* {{name}} */, :P2 /* {{url}} */, :P3 /* {{type}} */, :P4 /* {{NOW}} */, :P5 /* {{$_POST.ticket_id}} */, :P6 /* {{identity}} */)",
                        "params": [
                          {
                            "name": ":P1",
                            "type": "expression",
                            "value": "{{name}}"
                          },
                          {
                            "name": ":P2",
                            "type": "expression",
                            "value": "{{url}}"
                          },
                          {
                            "name": ":P3",
                            "type": "expression",
                            "value": "{{type}}"
                          },
                          {
                            "name": ":P4",
                            "type": "expression",
                            "value": "{{NOW}}"
                          },
                          {
                            "name": ":P5",
                            "type": "expression",
                            "value": "{{$_POST.ticket_id}}"
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
          }
        },
        "output": true,
        "meta": [
          {
            "name": "$index",
            "type": "number"
          },
          {
            "name": "$number",
            "type": "number"
          },
          {
            "name": "$name",
            "type": "text"
          },
          {
            "name": "$value",
            "type": "object"
          },
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
        "outputType": "array"
      }
    ]
  }
}
JSON
);
?>