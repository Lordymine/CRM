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
  <meta name="ac:route" content="/painel/chamados/gerenciar/:token?">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/chamados/">
  <title>Gerenciar Chamados - CRM RafaDev</title>
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.js"></script>
  <script src="/dmxAppConnect/dmxSummernote/dmxSummernote.js" defer=""></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote/dist/lang/summernote-pt-BR.js"></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxNotifications/dmxNotifications.css" />
  <script src="/dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxBootstrap4TableGenerator/dmxBootstrap4TableGenerator.css" />
  <script src="/dmxAppConnect/dmxFormatter/dmxFormatter.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/bootbox.all.min.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/dmxBootbox.js" defer=""></script>
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_chamados_crud">
  <dmx-serverconnect id="sc_get_tickect_by_token" url="/dmxConnect/api/tickets/get_ticket_by_token.php" dmx-param:token="query.token"></dmx-serverconnect>
  <dmx-serverconnect id="sc_selects" url="/dmxConnect/api/selects/selects_crud_tickets.php" dmx-param:department_id="serverconnectform1.inp_department_id.value"></dmx-serverconnect>
  <dmx-serverconnect id="sc_list_files_by_id" url="/dmxConnect/api/files/list_files_by_id_ticket.php" dmx-param:ticket_id="serverconnectform1.inp_id.value"></dmx-serverconnect>
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
        <h1><i class="fa fa-bullhorn"></i>&nbsp;Gerenciar chamados</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <form is="dmx-serverconnect-form" id="serverconnectform1" method="post" action="/dmxConnect/api/tickets/crud.php" dmx-generator="bootstrap4" dmx-form-type="vertical" dmx-populate="sc_get_tickect_by_token.data.query"
            dmx-on:success="run([{run:{action:`notifies1.success(\'Salvo com sucesso!\')`}},{wait:{delay:1000}},{run:{action:`browser1.goto(\'/painel/chamados\')`}}])" dmx-on:error="notifies1.danger('Ops, Algo deu errado!')">
            <input type="hidden" name="id" id="inp_id" dmx-bind:value="sc_get_tickect_by_token.data.query.id">
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label for="inp_title">Título</label>
                  <input type="text" class="form-control" id="inp_title" name="title" dmx-bind:value="sc_get_tickect_by_token.data.query.title" aria-describedby="inp_title_help">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label for="inp_description">Descrição</label>
                  <textarea id="inp_description" name="description" dmx-bind:value="sc_get_tickect_by_token.data.query.description" class="form-control" is="dmx-summernote"
                    dmx-bind:toolbar="[['style',['style']],['font',['bold','underline','clear']],['fontname',['fontname']],['color',['color']],['para',['ul','ol','paragraph']],['table',['table']],['insert',['link','picture','video']],['view',['fullscreen','codeview','help']]]"
                    style="" lang="pt-BR" min-height="260"></textarea>
                </div>
              </div>
            </div>
            <div class="form-row">

              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_product_id">Produto</label>
                  <select id="inp_product_id" class="form-control" name="product_id" dmx-bind:value="sc_get_tickect_by_token.data.query.product_id" dmx-bind:options="sc_selects.data.products" optionvalue="id" optiontext="name">
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_department_id">Departamento</label>
                  <select id="inp_department_id" class="form-control" name="department_id" dmx-bind:value="sc_get_tickect_by_token.data.query.department_id" dmx-bind:options="sc_selects.data.departments" optiontext="name" optionvalue="id">
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col">
                <div class="form-group">
                  <label for="inp_responsible_id">Responsável</label>
                  <select id="inp_responsible_id" class="form-control" name="responsible_id" dmx-bind:value="sc_get_tickect_by_token.data.query.responsible_id" dmx-bind:options="sc_selects.data.responsable" optiontext="fullname" optionvalue="id">
                  </select>
                </div>
              </div>

              <div class="col-12 col-lg-6" dmx-show="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_client_id">Cliente</label>
                  <select id="inp_client_id" class="form-control" name="client_id" dmx-bind:value="sc_get_tickect_by_token.data.query.client_id ? sc_get_tickect_by_token.data.query.client_id : sc_user_session.data.user.id"
                    dmx-bind:options="sc_selects.data.clients" optiontext="fullname" optionvalue="id">
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-6" dmx-show="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_status">Status</label>
                  <select id="inp_status" class="form-control" name="status" dmx-bind:value="sc_get_tickect_by_token.data.query.status" dmx-bind:options="sc_selects.data.status" optiontext="name" optionvalue="id">
                  </select>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col" dmx-show="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="inp_send_email" name="send_email">
                    <label class="form-check-label" for="inp_send_email">Avisar por e-mail</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row mb-3">
              <div class="col-12">
                <p><i class="fa fa-paperclip fa-fw"></i><b>Selecionar anexos</b></p>
                <input id="file" name="file" type="file" class="form-control-file">
              </div>
              <div class="col-12 mt-3 mb-3" dmx-show="sc_list_files_by_id.data.query.hasItems()">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                      <tr>
                        <th>Data</th>
                        <th>Arquivo</th>
                        <th>Tipo</th>
                        <th style="width: 80px;">Delete</th>
                      </tr>
                    </thead>
                    <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_files_by_id.data.query" id="tableRepeat1">
                      <tr>
                        <td dmx-text="created_at.formatDate('dd/MM/yyyy - hh:mm')"></td>
                        <td dmx-text="file_name"></td>
                        <td dmx-text="file_type"></td>
                        <td>
                          <button id="btn1" class="btn btn-danger btn-sm"
                            dmx-on:click="run({'bootbox.confirm':{title:'AVISO!',message:'Deseja mesmo deletar este arquivo?',buttons:{confirm:{label:'SIM',className:'btn-success'},cancel:{label:'NÃO',className:'btn-danger'}},size:'sm',locale:'br',backdrop:'true',then:{steps:[{serverConnect:{url:'/dmxConnect/api/files/delete.php',site:'projetocrm',params:{id:`id`},name:'sc'}},{run:{action:`notifies1.info(\'Deletado com sucesso!\')`}},{run:{action:`sc_list_files_by_id.load({})`}}]}}})"><i
                              class="fa fa-trash-o"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block" dmx-bind:value="sc_get_tickect_by_token.data.query.Save" dmx-bind:disabled="state.executing"><i class="fa fa-check fa-fw"></i>Salvar<span
                      class="spinner-border spinner-border-sm" role="status" dmx-show="state.executing"></span>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <!-- Essential javascripts for application to work-->
  <script src="/bootstrap/4/js/popper.min.js"></script>
  <script src="/bootstrap/4/js/bootstrap.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="/assets/js/plugins/pace.min.js"></script>
</body>

</html>