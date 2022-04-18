<!DOCTYPE html>
<html>

<head>
  <meta name="ac:route" content="/painel/usuarios/resete-de-senha/:token">
  <script src="/dmxAppConnect/dmxAppConnect.js"></script>
  <base href="/painel/">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <title>CRM - Suporte RafaDev</title>
  <script src="/js/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="/assets/css/mycss.css" />
  <link rel="stylesheet" href="/dmxAppConnect/dmxNotifications/dmxNotifications.css" />
  <script src="/dmxAppConnect/dmxNotifications/dmxNotifications.js" defer=""></script>
  <script src="/dmxAppConnect/dmxBrowser/dmxBrowser.js" defer=""></script>
  <link rel="stylesheet" href="/dmxAppConnect/dmxValidator/dmxValidator.css" />
  <script src="/dmxAppConnect/dmxValidator/dmxValidator.js" defer=""></script>
</head>

<body is="dmx-app" id="login">
  <dmx-notifications id="notifies1">

  </dmx-notifications>
  <div is="dmx-browser" id="browser1"></div>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <img src="/assets/images/logo_alsdigital.png" height="120" alt="Als Digital - Suporte">
    <div class="logo">
    </div>
    <div class="login-box">
      <form class="login-form" method="post" is="dmx-serverconnect-form" id="serverconnectform1" action="../dmxConnect/api/users/update_password.php"
        dmx-on:success="run([{run:{action:`notifies1.success(\'Login efetuado com sucesso!\')`}},{wait:{delay:1500}},{run:{action:`browser1.goto(\'/painel/login\')`}}])" dmx-on:error="notifies1.danger(lastError.message)"
        dmx-on:unauthorized="notifies1.danger('Usuário ou senha inválidos!')">
        <input id="inp_token" name="token" class="form-control" dmx-bind:value="query.token" type="hidden">
        <h5 class="login-head">RESET DE SENHA</h5>
        <div class="form-group">
          <label class="control-label">SENHA</label>
          <input class="form-control" type="password" name="password1" data-msg-required="Obrigatório." required="">
        </div>
        <div class="form-group">
          <label class="control-label">REPETIR</label>
          <input class="form-control" type="password" name="password" data-msg-required="Obrigatório." required="" data-rule-equalto="password1" data-msg-equalto="As senhas deven ser iguais!">
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <input type="checkbox">
              </label>
            </div>
            <p class="semibold-text mb-2"></p>
          </div>
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SALVAR</button>
        </div>
      </form>
    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="/assets/js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
  </script>
</body>

</html>