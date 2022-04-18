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
  <meta name="ac:route" content="/painel/produtos">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/produtos/">
  <title>Gerenciar Produtos - CRM RafaDev</title>
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
</head>

<body class="app sidebar-mini" is="dmx-app" id="app_produtos">
  <dmx-serverconnect id="sc_list_products" url="/dmxConnect/api/products/list.php" dmx-param:limit="12" dmx-param:name="inp_buscar.value"></dmx-serverconnect>
  <dmx-notifications id="notifies2"></dmx-notifications>
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
        <h1><i class="fa fa-shopping-cart"></i> Produtos</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 tile">
        <div class="row">
          <div class="align-self-center col-8">
            <button id="btn1" class="btn btn-primary" dmx-on:click="data_detail_crud.select(null);data_detail_crud.modal_crud.toggle()"><i class="fa fa-plus fa-fw"></i>Novo</button>
          </div>
          <div class="col-4 align-self-center">
            <input id="inp_buscar" name="buscar" type="text" class="form-control" placeholder="Pesquisar">
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Produto</th>
                    <th style="width: 120px;">Ações</th>
                  </tr>
                </thead>
                <tbody is="dmx-repeat" dmx-generator="bs4table" dmx-bind:repeat="sc_list_products.data.query.data" id="tableRepeat1">
                  <tr>
                    <td dmx-text="name"></td>
                    <td>
                      <button id="btn2" class="btn btn-info" dmx-on:click="data_detail_crud.select(id);data_detail_crud.modal_crud.toggle()"><i class="fa fa-pencil"></i></button>
                      <button id="btn3" class="btn btn-danger"
                        dmx-on:click="run({'bootbox.confirm':{title:'AVISO!',message:`\'Gostaria de deletar o produto \'+name+\'?\'`,buttons:{confirm:{label:'SIM',className:'btn-success'},cancel:{label:'NÃO',className:'btn-danger'}},size:'sm',locale:'br',backdrop:'true',then:{steps:[{serverConnect:{url:'/dmxConnect/api/products/delete.php',site:'projetocrm',params:{id:`id`},name:'sc'}},{run:{action:`notifies2.info(\'Produto deletado com sucesso!\');sc_list_products.load({})`}}]}}})"><i
                          class="fa fa-trash-o"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-12">
            <ul class="pagination justify-content-center" dmx-populate="sc_list_products.data.query" dmx-generator="bs4paging">
              <li class="page-item" dmx-class:disabled="sc_list_products.data.query.page.current == 1" aria-label="First">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_products.load({offset: sc_list_products.data.query.page.offset.first})"><span aria-hidden="true">&lsaquo;&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_products.data.query.page.current == 1" aria-label="Previous">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_products.load({offset: sc_list_products.data.query.page.offset.prev})"><span aria-hidden="true">&lsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:active="title == sc_list_products.data.query.page.current" dmx-class:disabled="!active" dmx-repeat="sc_list_products.data.query.getServerConnectPagination(2,1,'...')">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_products.load({offset: (page-1)*sc_list_products.data.query.limit})">{{title}}</a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_products.data.query.page.current ==  sc_list_products.data.query.page.total" aria-label="Next">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_products.load({offset: sc_list_products.data.query.page.offset.next})"><span aria-hidden="true">&rsaquo;</span></a>
              </li>
              <li class="page-item" dmx-class:disabled="sc_list_products.data.query.page.current ==  sc_list_products.data.query.page.total" aria-label="Last">
                <a href="javascript:void(0)" class="page-link" dmx-on:click="sc_list_products.load({offset: sc_list_products.data.query.page.offset.last})"><span aria-hidden="true">&rsaquo;&rsaquo;</span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div class="container" is="dmx-data-detail" id="data_detail_crud" dmx-bind:data="sc_list_products.data.query.data" key="id">
    <div class="modal fade" id="modal_crud" is="dmx-bs4-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Gerenciar Produto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form is="dmx-serverconnect-form" id="serverconnectform1" method="post" action="/dmxConnect/api/products/crud.php" dmx-generator="bootstrap4" dmx-form-type="vertical" dmx-populate="data_detail_crud.data"
              dmx-on:success="notifies2.success('Salvo com sucesso!');sc_list_products.load();data_detail_crud.modal_crud.toggle();data_detail_crud.modal_crud.serverconnectform1.reset()" dmx-on:error="notifies2.danger('Ops! Algo deu errado :(')">
              <input type="hidden" name="id" id="inp_id" dmx-bind:value="data_detail_crud.data.id">
              <div class="form-group">
                <label for="inp_name">Produto</label>
                <input type="text" class="form-control" id="inp_name" name="name" dmx-bind:value="data_detail_crud.data.name" aria-describedby="inp_name_help">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" dmx-bind:value="data_detail_crud.data.Save" dmx-bind:disabled="state.executing">Salvar</button>
              </div>
            </form>
          </div>
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