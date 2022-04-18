<!-- Wappler include head-page="dashboard.php" appconnect="local" is="dmx-app" bootstrap4="custom" fontawesome_4="cdn" jquery_33="local" id="app_topo_bar" components="{dmxFormatter:{},dmxBootstrap4Navigation:{}}" -->
<dmx-serverconnect id="sc_list_notifications" url="/dmxConnect/api/notifications/list_notifications_by_user.php"></dmx-serverconnect>
<header class="app-header">
  <!-- Sidebar toggle button-->
<nav class="navbar navbar-expand-lg navbar-dark bg-transparent text-center">
<a class="navbar-brand text-center" href="#"><b class="style1">CRM</b></a>
</nav><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav">
    <li class="app-search">
      <button class="app-search__button"></button>
    </li>
    <!--Notification Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i><span class="badge badge-pill badge-danger" style="position: absolute; top: 10px; right: 2px;"
          dmx-show="sc_list_notifications.data.notifications.hasItems()">{{sc_list_notifications.data.total}}</span></a>
      <ul class="app-notification dropdown-menu dropdown-menu-right" style="width: 260px;" dmx-show="sc_list_notifications.data.total >= 1">
        <div class="app-notification__content">
          <li dmx-repeat:rep_notifications_top="sc_list_notifications.data.notifications"><a class="app-notification__item" dmx-bind:href="'/api/notifications/redirect-notification/'+id+'/'+token"><span class="app-notification__icon"><span
                  class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
              <div>
                <p class="app-notification__message">{{title}}</p>
                <p class="app-notification__meta">{{created_at}}</p>
              </div>
            </a>
          </li>
        </div>
      </ul>
    </li>
    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a class="dropdown-item" dmx-bind:href="/painel/usuarios/perfil/{{sc_user_session.data.user.token}}"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
        <li><a class="dropdown-item" href="/painel/chamados/gerenciar/novo"><i class="fa fa-plus fa-lg"></i> Novo Chamado</a></li>
        <li><a class="dropdown-item" href="/painel/usuarios/sair"><i class="fa fa-sign-out fa-lg"></i> Sair</a></li>
      </ul>
    </li>
  </ul>
</header>
