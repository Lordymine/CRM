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
  <meta name="ac:route" content="/painel/usuarios">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/">
  <title>CRM - Als Digital</title>
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
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_usuarios">
  <!-- Navbar-->
  <?php require '_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '_sidebar_left.php'; ?>
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
            <button id="btn1" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i>Novo</button>
          </div>
          <div class="col-4 align-self-center">
            <select id="sel_user_type" class="form-control" name="user_type_id">
              <option value="1">Option One</option>
              <option value="2">Option Two</option>
              <option value="3">Option Three</option>
            </select>
          </div>
          <div class="col-4 align-self-center">
            <input id="inp_buscar" name="buscar" type="text" class="form-control" placeholder="Pesquisar">
          </div>
        </div>
        <div class="row mt-3"></div>
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