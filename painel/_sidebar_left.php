<!-- Wappler include head-page="dashboard.php" appConnect="local" is="dmx-app" bootstrap4="custom" fontawesome_4="cdn" jquery_33="local" -->
<dmx-serverconnect id="sc_user_session" url="/dmxConnect/api/users/user_session.php"></dmx-serverconnect>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" height="50" dmx-bind:src="sc_user_session.data.user_avatar" dmx-bind:alt="sc_user_session.data.user_name" width="50">
    <div>
      <p class="app-sidebar__user-name">Olá, {{sc_user_session.data.user_name}}</p>
    </div>
  </div>
  <ul class="app-menu">
    <li dmx-show="sc_user_session.data.user.permission_level >= 10"><a class="app-menu__item" href="/painel" dmx-class:active="browser1.location.pathname == '/painel/'"><i class="app-menu__icon fa fa-dashboard"></i><span
          class="app-menu__label">Dashboard</span></a></li>
    <li dmx-show="sc_user_session.data.user.permission_level >= 10"><a class="app-menu__item" href="/painel/usuarios" dmx-class:active="browser1.location.pathname == '/painel/usuarios/'"><i class="app-menu__icon fa fa-users"></i><span
          class="app-menu__label">Usuários</span></a></li>
    <li><a class="app-menu__item text-white" dmx-bind:href="'/painel/usuarios/perfil/'+sc_user_session.data.user.token" dmx-class:active="browser1.location.pathname == '/painel/usuarios/perfil/'+sc_user_session.data.user.token"><i
          class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Meu Perfil</span></a></li>
    <li><a class="app-menu__item" href="/painel/chamados/" dmx-class:active="browser1.location.pathname == '/painel/chamados/'"><i class="app-menu__icon fa fa-bullhorn"></i><span class="app-menu__label">Chamados</span></a></li>
    <li dmx-show="sc_user_session.data.user.permission_level >= 10"><a class="app-menu__item" href="/painel/produtos" dmx-class:active="browser1.location.pathname == '/painel/produtos/'"><i class="app-menu__icon fa fa-shopping-cart"></i><span
          class="app-menu__label">Produtos</span></a></li>
    <li class="treeview" dmx-show="sc_user_session.data.user.permission_level >= 10"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Cadastros Básicos</span><i
          class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="/painel/departamentos-chamados"> Dep. Chamados</a></li>
        <li><a class="treeview-item" href="/painel/status-chamados"> Status Chamados</a></li>
        <li><a class="treeview-item" href="/painel/tipos-usuarios"> Tipos de Usuários</a></li>
      </ul>
    </li>
  </ul>
</aside>