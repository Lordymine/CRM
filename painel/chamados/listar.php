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
  <meta name="ac:route" content="/painel/chamados/:status?">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/chamados/">
  <title>CRM - Chamados</title>
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
  <script src="/dmxAppConnect/dmxBootstrap4Modal/dmxBootstrap4Modal.js" defer=""></script>
  <script src="/dmxAppConnect/dmxDataTraversal/dmxDataTraversal.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/bootbox.all.min.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBootbox/dmxBootbox.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxAutocomplete/dmxAutocomplete.css" />
  <script src="/dmxAppConnect/dmxAutocomplete/dmxAutocomplete.js" defer=""></script>
  <script src="/dmxAppConnect/dmxFormatter/dmxFormatter.js" defer=""></script>
  <link rel="stylesheet" href="/assets/css/mycss.css" />
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_chamados">
  <dmx-serverconnect id="sc_list_tickets" url="/dmxConnect/api/tickets/list.php" site="projetocrm" dmx-param:limit="25" dmx-param:status="sel_status.value" dmx-param:department="sel_department.value" dmx-param:client_id="s_client.value">
  </dmx-serverconnect>
  <dmx-serverconnect id="sc_selects_filters" url="/dmxConnect/api/selects/selects_filters_tickets.php"></dmx-serverconnect>
  <script is="dmx-flow" id="flow1" type="text/dmx-flow">{
  meta: {
    $param: [
      {type: "text", name: "id"},
      {type: "text", name: "nome_item"}
    ]
  },
  exec: {
    steps: {
      bootbox.confirm: {
        title: "AVISO! ESTA AÇÃO É IRREVERSÍVEL",
        message: "{{'Deseja mesmo deletar o chamado '+$param.nome_item+'?'}}",
        buttons: {
          confirm: {label: "SIM", className: "btn-success"},
          cancel: {label: "NÃO", className: "btn-danger"}
        },
        size: "sm",
        locale: "br",
        backdrop: "true",
        then: {
          steps: [
            {
              serverConnect: {
                url: "/dmxConnect/api/tickets/delete.php",
                site: "projetocrm",
                params: {id: "{{$param.id}}"},
                name: "sc"
              }
            },
            {
              run: {action: "{{notifies1.info('Deletado com sucesso!')}}"}
            },
            {
              run: {action: "{{sc_list_tickets.load({})}}"}
            }
          ]
        }
      }
    }
  }
}</script>
  <dmx-datetime id="var_data_atual" interval="days"></dmx-datetime>
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
        <h1><i class="fa fa-bullhorn"></i>&nbsp;Chamados</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 tile">
        <div class="row">
          <div class="align-self-center col-12 mb-2 col-lg-2 mb-lg-0">
            <a href="/painel/chamados/gerenciar"><button id="btn1" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i>Novo</button></a>
          </div>
          <div class="align-self-center col-6 col-lg-3">
            <select id="sel_status" class="form-control" name="sel_status" dmx-bind:options="sc_selects_filters.data.status" optiontext="name" optionvalue="id" dmx-bind:value="query.status">
              <option value="">Status</option>
            </select>
          </div>
          <div class="align-self-center col-6 col-lg-3">
            <select id="sel_department" class="form-control" name="sel_department" dmx-bind:options="sc_selects_filters.data.departments" optiontext="name" optionvalue="id">
              <option value="">Departamento</option>
            </select>
          </div>
          <div class="align-self-center col-12 mt-2 col-lg-4 mt-lg-0">
            <input id="s_client" name="s_client" type="text" class="form-control" placeholder="Pesquisar" is="dmx-autocomplete" noresultslabel="Sem Resultados..." dmx-bind:data="sc_selects_filters.data.clients" optiontext="fullname" optionvalue="id">
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Chamado</th>
                    <th>Status</th>
                    <th>Departamento</th>
                    <th>Cliente</th>
                    <th>Responsável</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_tickets.data.query.data" id="tableRepeat1">
                  <tr>
                    <td dmx-class:data-vencida="((status == 1) &amp;&amp; (created_at.daysUntil(var_data_atual.datetime)) > 10 )">
                      <p class="mb-0">{{created_at.formatDate('dd/MM/yyyy - hh:mm')}}</p>
                      <p class="mb-0" dmx-show="created_at.daysUntil(var_data_atual.datetime) > 0 &amp;&amp; status != 2">Criado a <b>{{created_at.daysUntil(var_data_atual.datetime)}}</b> dias</p>
                      <p class="mb-0" dmx-show="created_at.daysUntil(var_data_atual.datetime) == 0"><i class="fa fa-star text-warning"></i>&nbsp;<b class="text-primary">Novo</b></p>
                    </td>
                    <td dmx-text="title"></td>
                    <td dmx-text="status_nome"></td>
                    <td dmx-text="departamento_nome"></td>
                    <td dmx-text="cliente_nome"></td>
                    <td dmx-text="responsavel_nome"></td>
                    <td>
                      <button id="btn4" class="btn btn-warning" dmx-on:click="browser1.goto('/painel/chamados/detaill-followups/'+token)"><i class="fa fa-pencil-square-o"></i> Interagir</button>
                      <button id="btn3" class="btn btn-danger" dmx-on:click="flow1.run({id: id, nome_item: title})"><i class="fa fa-trash-o"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-12">
            <ul class="pagination justify-content-center" dmx-populate="sc_list_tickets.data.query" dmx-generator="bs4paging">
              <li class="page-item" dmx-class:disabled="sc_list_tickets.data.query.page.current == 1" aria-label="First">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_tickets.load({offset: sc_list_tickets.data.query.page.offset.first})"><span aria-hidden="true">&lsaquo;&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_tickets.data.query.page.current == 1" aria-label="Previous">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_tickets.load({offset: sc_list_tickets.data.query.page.offset.prev})"><span aria-hidden="true">&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:active="title == sc_list_tickets.data.query.page.current" dmx-class:disabled="!active" dmx-repeat="sc_list_tickets.data.query.getServerConnectPagination(2,1,'...')">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_tickets.load({offset: (page-1)*sc_list_tickets.data.query.limit})">{{title}}</a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_tickets.data.query.page.current ==  sc_list_tickets.data.query.page.total" aria-label="Next">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_tickets.load({offset: sc_list_tickets.data.query.page.offset.next})"><span aria-hidden="true">&rsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_tickets.data.query.page.current ==  sc_list_tickets.data.query.page.total" aria-label="Last">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_tickets.load({offset: sc_list_tickets.data.query.page.offset.last})"><span aria-hidden="true">&rsaquo;&rsaquo;</span></a>
              </li>
            </ul>
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