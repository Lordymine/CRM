<?php
require('../dmxConnectLib/dmxConnect.php');

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
  <meta name="ac:route" content="/painel">
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
</head>

<body class="app sidebar-mini" is="dmx-app" id="_template">
  <!-- Navbar-->
  <?php require '_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '_sidebar_left.php'; ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-12">
                <p>A nice paragraph</p>
              </div>
            </div>
          </div>
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