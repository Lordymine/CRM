<!DOCTYPE html>
<html>

<head>
    <meta name="ac:route" content="/">
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
<h1 style="margin-bottom: 0; margin-top: 50px;"><b class="style2">CRM - RafaDev</b></h1>
        <div class="logo">
        </div>
        <div class="login-box">
            <form class="login-form" method="post" is="dmx-serverconnect-form" id="serverconnectform1" action="../dmxConnect/api/users/login.php" dmx-on:success="run([{run:{action:`notifies1.success(\'Login efetuado com sucesso!\')`}},{wait:{delay:1500}},{run:{action:`browser1.goto(\'/painel\')`}}])" dmx-on:error="notifies1.danger(lastError.message)" dmx-on:unauthorized="notifies1.danger('Usuário ou senha inválidos!')">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i> ENTRAR</h3>
                <div class="form-group">
                    <label class="control-label">E-MAIL</label>
                    <input class="form-control" type="text" autofocus name="email" data-msg-required="Obrigatório." required="" data-rule-email="" data-msg-email="Precisa ser um e-mail válido.">
                </div>
                <div class="form-group">
                    <label class="control-label">SENHA</label>
                    <input class="form-control" type="password" name="password" data-msg-required="Obrigatório." required="">
                </div>
                <div class="form-group">
                    <div class="utility">
                        <div class="animated-checkbox">
                            <label>
                                <input type="checkbox"><span class="label-text">Manter conectado</span>
                            </label>
                        </div>
                        <p class="semibold-text mb-2" style=""><a href="#" data-toggle="flip">Esqueceu a senha?</a></p>
                    </div>
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>ENTRAR</button>
                </div>
            </form>
            <form class="forget-form" method="post" is="dmx-serverconnect-form" id="serverconnectform2" action="../dmxConnect/api/users/forget_password.php" dmx-on:success="notifies1.success('E-mail enviado com sucesso!');serverconnectform2.reset()" dmx-on:error="notifies1.danger('Ops, Algo deu errado por favor nos avise sobre este erro.')" dmx-on:unauthorized="notifies1.danger('Este e-mail não existe!')">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Equeceu a senha?</h3>
                <div class="form-group">
                    <label class="control-label">EMAIL</label>
                    <input class="form-control" type="text" placeholder="Email" name="email" required="" data-msg-required="Obrigatório." data-rule-email="" data-msg-email="Precisa ser um e-mail válido.">
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit" dmx-bind:disabled="state.executing"><i class="fa fa-paper-plane-o fa-fw"></i> ENVIAR<span class="spinner-border spinner-border-sm" role="status" dmx-show="state.executing"></span>
                    </button>
                </div>
                <div class="form-group mt-3">
                    <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Voltar para o login</a></p>
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