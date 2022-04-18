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
			"options": {"permissions":"admin","loginUrl":"/painel/login","forbiddenUrl":"/painel/login/restrito","provider":"auth"}
		}
	]
}
JSON
, TRUE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="ac:route" content="/painel/usuarios">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/usuarios/">
  <title>CRM - RafaDev</title>
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
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxNotifications/dmxNotifications.css" />
  <script src="/dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxBootstrap4TableGenerator/dmxBootstrap4TableGenerator.css" />
  <script src="/dmxAppConnect/dmxBootstrap4PagingGenerator/dmxBootstrap4PagingGenerator.js" defer=""></script>
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_usuarios">
  <script is="dmx-flow" id="flow1" type="text/dmx-flow">{
  meta: {
    $param: [
      {type: "text", name: "id"}
    ]
  },
  exec: {
    steps: [
      {
        serverConnect: {
          url: "../../dmxConnect/api/users/delete_user.php",
          site: "projetocrm",
          params: {id: "{{$param.id}}"},
          name: "sc"
        }
      },
      {
        run: {action: "{{notifies1.info('Usuário deletado com sucesso!')}}"}
      },
      {
        run: {action: "{{sc_list_users.load({})}}"}
      }
    ]
  }
}</script>
  <dmx-serverconnect id="sc_list_users" url="/dmxConnect/api/users/list_user_by_type.php" dmx-param:tipo_usuario="sel_user_type.value" dmx-param:buscar="inp_buscar.value" dmx-param:limit="12"></dmx-serverconnect>
  <dmx-serverconnect id="sc_sel_type_user" url="/dmxConnect/api/selects/type_users.php"></dmx-serverconnect>
  <!-- Navbar-->
  <?php require '../_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '../_sidebar_left.php'; ?>
  <dmx-notifications id="notifies1"></dmx-notifications>
  <div is="dmx-browser" id="browser1">

  </div>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-users"></i> Usuários</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 tile">
        <div class="row">
          <div class="col-4 align-self-center">
            <a href="/painel/usuarios/perfil"><button id="btn1" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i>Novo</button></a>
          </div>
          <div class="col-4 align-self-center">
            <select id="sel_user_type" class="form-control" name="user_type_id" dmx-bind:options="sc_sel_type_user.data.query" optiontext="name" optionvalue="id">
              <option value="">Tipo</option>
            </select>
          </div>
          <div class="col-4 align-self-center">
            <input id="inp_buscar" name="buscar" type="text" class="form-control" placeholder="Pesquisar">
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Celular</th>
                    <th>Empresa</th>
                    <th style="width: 120px;">Ações</th>
                  </tr>
                </thead>
                <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_users.data.query.data" id="tableRepeat1">
                  <tr>
                    <td dmx-text="fullname"></td>
                    <td dmx-text="cellphone"></td>
                    <td dmx-text="company"></td>
                    <td>
                      <a href="" dmx-bind:href="'/painel/usuarios/perfil/'+token"><button id="btn2" class="btn btn-info"><i class="fa fa-pencil"></i></button></a>
                      <button id="btn3" class="btn btn-danger" dmx-on:click="flow1.run({id: id})"><i class="fa fa-trash-o"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-12">
            <ul class="pagination justify-content-center" dmx-populate="sc_list_users.data.query" dmx-generator="bs4paging">
              <li class="page-item" dmx-class:disabled="sc_list_users.data.query.page.current == 1" aria-label="First">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_users.load({offset: sc_list_users.data.query.page.offset.first})"><span aria-hidden="true">&lsaquo;&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_users.data.query.page.current == 1" aria-label="Previous">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_users.load({offset: sc_list_users.data.query.page.offset.prev})"><span aria-hidden="true">&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:active="title == sc_list_users.data.query.page.current" dmx-class:disabled="!active" dmx-repeat="sc_list_users.data.query.getServerConnectPagination(2,1,'...')">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_users.load({offset: (page-1)*sc_list_users.data.query.limit})">{{title}}</a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_users.data.query.page.current ==  sc_list_users.data.query.page.total" aria-label="Next">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_users.load({offset: sc_list_users.data.query.page.offset.next})"><span aria-hidden="true">&rsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_users.data.query.page.current ==  sc_list_users.data.query.page.total" aria-label="Last">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_users.load({offset: sc_list_users.data.query.page.offset.last})"><span aria-hidden="true">&rsaquo;&rsaquo;</span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Essential javascripts for application to work-->
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="/assets/js/plugins/pace.min.js"></script>
</body>

</html>