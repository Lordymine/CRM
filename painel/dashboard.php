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
			"options": {"permissions":"admin","loginUrl":"/painel/login","forbiddenUrl":"/painel/chamados","provider":"auth"}
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
  <script src="/dmxAppConnect/dmxFormatter/dmxFormatter.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
</head>

<body class="app sidebar-mini" is="dmx-app" id="_template">
  <dmx-serverconnect id="sc_get_statistics" url="/dmxConnect/api/dashboard/statistics.php"></dmx-serverconnect>
  <!-- Navbar-->
  <?php require '_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '_sidebar_left.php'; ?>
  <div is="dmx-browser" id="browser1"></div>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-3" dmx-repeat:rep_cards="sc_get_statistics.data.status">
        <div class="widget-small primary coloured-icon" dmx-on:click="browser1.goto('/painel/chamados/'+status_id)" style="cursor: pointer;"><i dmx-bind:class="icon {{status_icon}} fa-3x" dmx-style:background-color.important="status_color"></i>
          <div class="info">
            <h4>{{status_name}}</h4>
            <p><b>{{tickets_by_status_id.total}}</b></p>
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