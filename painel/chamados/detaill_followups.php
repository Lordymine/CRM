<?php
require('../../dmxConnectLib/dmxConnect.php');

$app = new \lib\App();

$app->exec(<<<'JSON'
{
	"steps": [
		"Connections/dados",
		"SecurityProviders/auth",
		{
			"module": "auth",
			"action": "restrict",
			"options": {"loginUrl":"/painel/login","forbiddenUrl":"/painel/usuario/restrito","provider":"auth"}
		}
	]
}
JSON
, TRUE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="ac:route" content="/painel/chamados/detaill-followups/:token">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/chamados/">
  <title>Interações com o chamado - CRM RafaDev</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" href="/assets/css/main.css">
  <link rel="stylesheet" href="/bootstrap/4/css/bootstrap.min.css" />
  <!-- Font-icon css-->
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/dmxAppConnect/dmxBootstrap4Navigation/dmxBootstrap4Navigation.js" defer=""></script>
  <link rel="stylesheet" href="/fontawesome4/css/font-awesome.min.css" />
  <script src="/dmxAppConnect/dmxFormatter/dmxFormatter.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootstrap4Modal/dmxBootstrap4Modal.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxNotifications/dmxNotifications.css" />
  <script src="/dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxBootstrap4TableGenerator/dmxBootstrap4TableGenerator.css" />
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/bootbox.all.min.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/dmxBootbox.js" defer=""></script>
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_followups_details">
  <dmx-serverconnect id="sc_get_ticket" url="/dmxConnect/api/tickets/get_ticket_by_token.php" dmx-param:token="query.token"></dmx-serverconnect>
  <dmx-serverconnect id="sc_list_follows" url="/dmxConnect/api/followups/list_follows_by_id_tickets.php" dmx-param:ticket_id="sc_get_ticket.data.query.id"></dmx-serverconnect>
  <dmx-serverconnect id="sc_list_files" url="/dmxConnect/api/files/list_files_by_id_ticket.php" dmx-param:ticket_id="sc_get_ticket.data.query.id"></dmx-serverconnect>
  <dmx-notifications id="notifies1"></dmx-notifications>
  <div is="dmx-browser" id="browser1"></div>
  <!-- Navbar-->
  <?php require '../_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '../_sidebar_left.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-eye"></i> Interações - {{sc_get_ticket.data.query.title}}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="row">
            <div class="col-12 mb-3 text-right">
              <button id="btn2" class="btn btn-info" dmx-on:click="browser1.goto('/painel/chamados/gerenciar/'+sc_get_ticket.data.query.token)"><i class="fa fa-pencil"></i> Editar</button>
            </div>
            <div class="col-4">
              <p><b>Prioridade: </b>Normal</p>
              <p><b>Produto contratado: </b>{{sc_get_ticket.data.query.produto_nome}}</p>
            </div>
            <div class="col-4">
              <p><b>Departamento: </b>{{sc_get_ticket.data.query.departamento_nome}}</p>
              <p><b>Responsável: </b>{{sc_get_ticket.data.query.responsavel_nome}}</p>
            </div>
            <div class="col-4">
              <p><b>Aberto por:&nbsp; </b>{{sc_get_ticket.data.query.cliente_nome.split(' ')[0]}}</p>
              <p><b>Status:&nbsp; </b>{{sc_get_ticket.data.query.status_nome}}</p>
            </div>
          </div>
          <div class="row mt-3 mb-3">
            <hr>
            <div class="col">
              <p dmx-html="sc_get_ticket.data.query.description">{{sc_get_ticket.data.query.description}}</p>
            </div>
            <hr>
          </div>
          <div class="row">
            <div class="col-12 mt-2 mb-2">
              <h6>Observações</h6>
            </div>
            <div class="col-12 mt-2 mb-2">
              <button id="btn1" class="btn btn-primary" dmx-on:click="modal1.toggle()"><i class="fa fa-pencil"></i>Interagir</button>
            </div>
            <div class="col-12 mt-2 mb-2" dmx-show="sc_list_follows.data.query.hasItems()">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                  <thead>
                    <tr>
                      <th style="width: 150px;">Data</th>
                      <th style="">Por</th>
                      <th>Descrição</th>
                    </tr>
                  </thead>
                  <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_follows.data.query" id="tableRepeat1">
                    <tr>
                      <td dmx-text="created_at.formatDate('dd/MM/yyyy - hh:mm')"></td>
                      <td dmx-text="autor.split(' ')[0]"></td>
                      <td dmx-text="description"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col">
              <form is="dmx-serverconnect-form" id="form_upload" method="post" action="/dmxConnect/api/files/crud_files.php" dmx-generator="bootstrap4" dmx-form-type="vertical"
                dmx-on:success="form_upload.reset();sc_list_files.load();notifies1.success('Arquivo enviado com sucesso!')" dmx-on:error="notifies1.danger(lastError.message)"><input type="hidden" name="ticket_id" id="inp_ticket_id"
                  dmx-bind:value="sc_get_ticket.data.query.id">
                <div class="form-group">
                  <label for="inp_file"><b>Enviar anexo</b></label>
                  <input type="file" class="form-control-file" id="inp_file" name="file[]" aria-describedby="inp_file_help" multiple="true">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" dmx-bind:disabled="state.executing">Enviar<span class="spinner-border spinner-border-sm" role="status" dmx-show="state.executing"></span>
                  </button>
                </div>
              </form>
            </div>
            <div class="col-12 mt-4" dmx-show="sc_list_files.data.query.hasItems()">
              <h5>Anexos</h5>
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm">
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th>Arquivo</th>
                      <th>Tipo</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_files.data.query" id="tableRepeat2">
                    <tr>
                      <td dmx-text="created_at.formatDate('dd/MM/yyyy')"></td>
                      <td dmx-text="file_name"></td>
                      <td dmx-text="file_type"></td>
                      <td>
                        <a href="" dmx-bind:href="file_url" download><button id="btn2" class="btn btn-info"><i class="fa fa-download"></i>Baixar</button></a>
                        <button id="btn3" class="btn btn-danger"
                          dmx-on:click="run({'bootbox.confirm':{message:'Deseja mesmo deletar este arquivo?',buttons:{confirm:{label:'SIM',className:'btn-success'},cancel:{label:'NÃO',className:'btn-danger'}},size:'sm',locale:'br',backdrop:'true',title:'AVISO!',then:{steps:[{serverConnect:{url:'/dmxConnect/api/files/delete.php',site:'projetocrm',params:{id:`id`},name:'sc'}},{run:{action:`sc_list_files.load({});notifies1.info(\'Deletado com sucesso!\')`}}]}}})"><i
                            class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>
  <div class="modal fade" id="modal1" is="dmx-bs4-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Anotação</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form is="dmx-serverconnect-form" id="serverconnectform1" method="post" action="/dmxConnect/api/followups/crud.php" dmx-generator="bootstrap4" dmx-form-type="vertical"
            dmx-on:success="notifies1.success('Salvo com sucesso!');modal1.toggle();modal1.serverconnectform1.reset();sc_list_follows.load({})">
            <input type="hidden" name="ticket_id" id="inp_ticket_id" dmx-bind:value="sc_get_ticket.data.query.id">
            <div class="form-group">
              <textarea id="inp_description" name="description" rows="6" placeholder="Descrição" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block" dmx-bind:disabled="state.executing">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Essential javascripts for application to work-->
  <script src="/bootstrap/4/js/popper.min.js"></script>
  <script src="/bootstrap/4/js/bootstrap.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="/assets/js/plugins/pace.min.js"></script>
</body>

</html>