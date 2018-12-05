 <header class="main-header">
        <!-- Logo -->
        <!-- <a href="{{route('list.empresas')}}" class="logo"> -->
        <a href="{{$url_previus}}" class="logo" title="Regresar a Listado de Empresas">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{{$empresa}}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{{$empresa}}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-primary {{$efect_notify_correo}}">.</span>
                  <span class="label label-success ">{{( $count_correo) }}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tu Tienes {{ ($count_correo) }} Mensajes </li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      @foreach ($emails as $correos)
                        <li><!-- start message -->
                          <a href="#">
                            <!-- <div class="pull-left">
                              <img src="" class="img-circle" alt="User Image">
                            </div> -->
                            <h4>
                              {{ $correos->asunto }}
                              <small><i class="fa fa-clock-o"></i> {{ time_fechas($correos->created_at,timestamp() )}}</small>
                            </h4>
                            <p>{{$correos->correo}}</p>
                          </a>
                        </li>
                      @endforeach
                      <!-- end message -->
                    </ul>
                  </li>
                  <!-- <li class="footer"><a href="#">See All Messages</a></li> -->
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu" {{$notify}}>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-primary {{$efect_notify}}">.</span>
                  <span class="label label-warning">{{$count_notify}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tu Tienes {{$count_notify}} Notificaciones</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      @foreach($notifications as $notificacion)
                        <li>
                          <!-- <a href="{{$base_url}}/configuracion/clientes" style="cursor:pointer;"> -->
                          <a onclick="update_notify({{ $notificacion->id }})" style="cursor:pointer;">
                            <h6>
                              <i class="fa fa-bell-o text-yellow"> {{ $notificacion->portal }}</i>
                               <small> <i class="fa fa-clock-o"></i> {{ time_fechas( $notificacion->created_at, timestamp() )}} </small>
                            </h6>
                            <small><p class="">{{ $notificacion->mensaje }}</p></small>
                          </a>
                        </li>
                      @endforeach

                      <!-- <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                          page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li> -->

                    </ul>
                  </li>
                  <li class="footer"></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu" style="display:none;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Create a nice theme
                            <small class="pull-right">40%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">40% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Some task I need to do
                            <small class="pull-right">60%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">60% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Make beautiful transitions
                            <small class="pull-right">80%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">80% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li>
                      <!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ $photo_profile }}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{ $nombre_completo }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{ $photo_profile }}" class="img-circle" alt="User Image">

                    <p>
                      {{ $nombre_completo }}
                      <small>{{$rol}}</small>
                      <!-- <small>{{$empresa}}</small> -->
                      <small>{{$sucursal}}</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <!-- <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                      </div>
                    </div> -->
                    <!-- /.row -->
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('perfiles')}} " class="btn btn-default btn-flat">
                          <i class="fa fa-user pull-left"></i>Perfil Usuario
                        </a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                        <i class="fa fa-sign-out pull-left"></i> Cerrar Sesión
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
                      <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
