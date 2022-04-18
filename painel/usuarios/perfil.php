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
  <meta name="ac:route" content="/painel/usuarios/perfil/:token?">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/usuarios/">
  <title>CRM - RafaDev</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <!-- Font-icon css-->
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/dmxAppConnect/dmxBootstrap4Navigation/dmxBootstrap4Navigation.js" defer=""></script>
  <link rel="stylesheet" href="/fontawesome4/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/assets/css/main.css" />
  <link rel="stylesheet" href="/bootstrap/4/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/dmxAppConnect/dmxValidator/dmxValidator.css" />
  <script src="/dmxAppConnect/dmxValidator/dmxValidator.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxNotifications/dmxNotifications.css" />
  <script src="/dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
</head>

<body class="app sidebar-mini" is="dmx-app" id="_template">

  <dmx-serverconnect id="sc_get_user" url="/dmxConnect/api/users/get_user_update.php" dmx-param:token="query.token"></dmx-serverconnect>
  <dmx-serverconnect id="sc_list_type_user" url="/dmxConnect/api/selects/type_users.php"></dmx-serverconnect>
  <!-- Navbar-->
  <dmx-serverconnect id="sc_api_via_cep" url="/dmxConnect/api/integrations/viacep.php" noload></dmx-serverconnect>
  <dmx-serverconnect id="sc_sel_department_list" url="/dmxConnect/api/selects/department_list.php"></dmx-serverconnect><?php require '../_topo.php'; ?>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <?php require '../_sidebar_left.php'; ?>
  <dmx-notifications id="notifies1"></dmx-notifications>
  <div is="dmx-browser" id="browser1"></div>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-user"></i> Perfil</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <form is="dmx-serverconnect-form" id="serverconnectform1" method="post" action="../../dmxConnect/api/users/update_user.php" dmx-generator="bootstrap4" dmx-form-type="vertical" dmx-populate="sc_get_user.data.query"
            dmx-on:success="run([{run:{action:`notifies1.success(\'Cadastro salvo com sucesso!\')`}},{wait:{delay:1000}},{run:{action:`browser1.goto(\'/painel\')`}}])"
            dmx-on:error="notifies1.danger('Ops! algo deu errado por favor nos avise sobre isso.')">
            <input type="hidden" name="id" id="inp_id" dmx-bind:value="sc_get_user.data.query.id">
            <div class="form-row">
              <div class="col-12 col-lg-6 align-self-center">
                <div class="form-group">
                  <label for="inp_avatar">Foto</label>
                  <input type="file" class="form-control-file" id="inp_avatar" name="avatar" dmx-bind:value="sc_get_user.data.query.avatar" aria-describedby="inp_avatar_help">
                </div>
              </div>
              <div class="col-12 col-lg-6 text-center">
                <img class="img-thumbnail" style="max-height: 250px; width: 250px;" dmx-bind:src="inp_avatar.file.dataUrl ? inp_avatar.file.dataUrl : sc_get_user.data.user_avatar">
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_fullname">Nome Completo</label>
                  <input type="text" class="form-control" id="inp_fullname" name="fullname" dmx-bind:value="sc_get_user.data.query.fullname" aria-describedby="inp_fullname_help" required="" data-msg-required="Obrigatório.">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_email">Email</label>
                  <input type="text" class="form-control" id="inp_email" name="email" dmx-bind:value="sc_get_user.data.query.email" aria-describedby="inp_email_help" required="" data-msg-required="Obrigatório." data-rule-email=""
                    data-msg-email="Deve ser um e-mail válido!">
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_password">Senha</label>
                  <input type="password" class="form-control" id="inp_password1" name="password1" aria-describedby="inp_password_help">
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_password">Repetir senha</label>
                  <input type="password" class="form-control" id="inp_password" name="password" aria-describedby="inp_password_help" dmx-bind:required="inp_password1.value" data-rule-equalto="password1" data-msg-equalto="As senhas devem ser iguais!"
                    required="" data-msg-required="Obrigatório.">
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_cellphone">Celular</label>
                  <input type="text" class="form-control" id="inp_cellphone" name="cellphone" dmx-bind:value="sc_get_user.data.query.cellphone" aria-describedby="inp_cellphone_help" required="" data-msg-required="Obrigatório.">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_cpf">Cpf</label>
                  <input type="text" class="form-control cpf" id="inp_cpf" name="cpf" dmx-bind:value="sc_get_user.data.query.cpf" aria-describedby="inp_cpf_help" required="" data-msg-required="Obrigatório.">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_cnpj">Cnpj</label>
                  <input type="text" class="form-control" id="inp_cnpj" name="cnpj" dmx-bind:value="sc_get_user.data.query.cnpj" aria-describedby="inp_cnpj_help">
                </div>
              </div>
              <div class="col-12 col-lg-3">
                <div class="form-group">
                  <label for="inp_zipcode">Cep</label>
                  <input type="text" class="form-control cep" id="inp_zipcode" name="zipcode" dmx-bind:value="sc_get_user.data.query.zipcode" aria-describedby="inp_zipcode_help" dmx-on:change="sc_api_via_cep.load({cep: value})">
                </div>
              </div>

              <div class="col-12 col-lg-9">
                <div class="form-group">
                  <label for="inp_address">Endereço</label>
                  <input type="text" class="form-control" id="inp_address" name="address" dmx-bind:value="sc_api_via_cep.data.api.data.logradouro ? sc_api_via_cep.data.api.data.logradouro : sc_get_user.data.query.address"
                    aria-describedby="inp_address_help">
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="form-group">
                  <label for="inp_neightborhood">Bairro</label>
                  <input type="text" class="form-control" id="inp_neightborhood" name="neightborhood" dmx-bind:value="sc_api_via_cep.data.api.data.bairro ? sc_api_via_cep.data.api.data.bairro : sc_get_user.data.query.neightborhood"
                    aria-describedby="inp_neightborhood_help">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_city">Cidade</label>
                  <input type="text" class="form-control" id="inp_city" name="city" dmx-bind:value="sc_api_via_cep.data.api.data.localidade ? sc_api_via_cep.data.api.data.localidade : sc_get_user.data.query.city " aria-describedby="inp_city_help">
                </div>
              </div>
              <div class="col-12 col-lg-2">
                <div class="form-group">
                  <label for="inp_uf">UF</label>
                  <input type="text" class="form-control" id="inp_uf" name="uf" dmx-bind:value="sc_api_via_cep.data.api.data.uf ? sc_api_via_cep.data.api.data.uf : sc_get_user.data.query.uf" aria-describedby="inp_uf_help">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_company">Empresa</label>
                  <input type="text" class="form-control" id="inp_company" name="company" dmx-bind:value="sc_get_user.data.query.company" aria-describedby="inp_company_help">
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="inp_phone">Telefone Comercial</label>
                  <input type="text" class="form-control sp_celphones" id="inp_phone" name="phone" dmx-bind:value="sc_get_user.data.query.phone" aria-describedby="inp_phone_help">
                </div>
              </div>
              <div class="col-12 col-lg-3" is="dmx-if" id="conditional1" dmx-bind:condition="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_status">Status</label>
                  <select id="inp_status" class="form-control" name="status" dmx-bind:value="sc_get_user.data.query.status">
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-3" is="dmx-if" id="conditional2" dmx-bind:condition="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_type_user_id">Tipo de usuário</label>
                  <select id="inp_type_user_id" class="form-control" name="type_user_id" dmx-bind:value="sc_get_user.data.query.type_user_id" dmx-bind:options="sc_list_type_user.data.query" optiontext="name" optionvalue="id">
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-3" is="dmx-if" id="conditional3" dmx-bind:condition="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_permission_level">Permissão</label>
                  <select id="inp_permission_level" class="form-control" name="permission_level" dmx-bind:value="sc_get_user.data.query.permission_level">
                    <option value="10">Admin</option>
                    <option selected="" value="2">Cliente</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-3" is="dmx-if" id="conditional4" dmx-bind:condition="sc_user_session.data.user.permission_level >= 10">
                <div class="form-group">
                  <label for="inp_department_id">Departamento</label>
                  <select id="inp_department_id" class="form-control" name="department_id" dmx-bind:value="sc_get_user.data.query.department_id" dmx-bind:options="sc_sel_department_list.data.query" optiontext="name" optionvalue="id">
                    <option value="">Selecionar</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-lg-12 mt-4">
                <div class="progress text-center" dmx-show="uploadProgress.percent">
                  <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" dmx-bind:style="width: {{uploadProgress.percent}}%" dmx-bind:aria-valuenow="{{uploadProgress.percent}}" aria-valuemin="0"
                    aria-valuemax="100">
                    {{uploadProgress.percent}}%
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" dmx-bind:value="sc_get_user.data.query.Save" dmx-bind:disabled="state.executing"><i class="fa fa-check fa-fw"></i>Salvar<span class="spinner-border spinner-border-sm"
                    role="status" dmx-show="state.executing"></span>
                </button>
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
  <script src="/assets/js/mask/jquery.mask.js"></script>
  <script src="/assets/js/mask/mask.js"></script>
</body>

</html>