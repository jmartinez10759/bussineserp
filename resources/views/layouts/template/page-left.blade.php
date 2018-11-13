<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 373px;">

      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ $photo_profile }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ $nombre_completo }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
          </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <!-- <input type="text" name="q" class="form-control" placeholder="Search..."> -->
            <input id="search_general" class="form-control" type="text" placeholder="Buscar ..." aria-label="Search" onkeyup="buscador_general(this,'#menu_principal',true)" />
          <!--   <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span> -->
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" id="menu_principal">
          <li class="header">MENU PRINCIPAL</li>
          {!! $MENU_DESKTOP !!}
        </ul>

      </section>

  </div>
  <!-- /.sidebar -->
</aside>
