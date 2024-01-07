  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Pengelolaan Surat</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <link href={{asset('assets/vendor/fontawesome-free/css/all.min.css')}} rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
      <link href={{asset('assets/css/sb-admin-2.min.css')}} rel="stylesheet">
      <link href={{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}} rel="stylesheet">
  </head>
  <body id="page-top">
      <div id="wrapper">
          @if (Auth::check())
          <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
              <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                  <div class="sidebar-brand-icon">
                      <img style="width: 50px; height: 50px;" src="https://smkwikrama.sch.id/assets2/wikrama-logo.png" alt="">
                  </div>
                  <div class="sidebar-brand-text mx-3">Pengelolaan Surat</div>
              </a>
              <hr class="sidebar-divider my-0">
              <li class="nav-item active">
                  <a class="nav-link" href="{{ route('home') }}">
                      <i class="fas fa-fw fa-home"></i>
                      <span>Dashboard</span></a>
              </li>
              @if (Auth::user()->role == 'staff')
              <hr class="sidebar-divider">
              <div class="sidebar-heading">
                  Kelola Data
              </div>
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                      aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-user"></i>
                      <span>Data User</span>
                  </a>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <a class="collapse-item" href="{{ route('staff.home') }}">Data Staff Tata Usaha</a>
                          <a class="collapse-item" href="{{ route('guru.home') }}">Data Guru</a>
                      </div>
                  </div>
              </li>
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                      aria-expanded="true" aria-controls="collapseUtilities">
                      <i class="fas fa-fw fa-calculator"></i>
                      <span>Data Surat</span>
                  </a>
                  <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <a class="collapse-item" href="{{ route('klasifikasi.home') }}">Data Klasifikasi Surat</a>
                          <a class="collapse-item" href="{{ route('surat.home') }}">Data Surat</a>
                      </div>
                  </div>
              </li>
              @else
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('data') }}">
                      <i class="fas fa-fw fa-table"></i>
                      <span>Data Surat Masuk</span></a>
              </li>
              @endif
              <hr class="sidebar-divider">
              <div class="text-center d-none d-md-inline">
                  <button class="rounded-circle border-0" id="sidebarToggle"></button>
              </div>
          </ul>
          <div id="content-wrapper" class="d-flex flex-column">
              <div id="content">
                  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                          <i class="fa fa-bars"></i>
                      </button>
                      <ul class="navbar-nav ml-auto">
                          <div class="topbar-divider d-none d-sm-block"></div>
                          <li class="nav-item dropdown no-arrow">
                              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                  <img class="img-profile rounded-circle"
                                      src="assets/img/undraw_profile.svg">
                              </a>
                              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                  aria-labelledby="userDropdown">
                                  <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
                                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                      Logout
                                  </a>
                              </div>
                          </li>
                      </ul>
                  </nav>
                  @endif
                  <div class="container-fluid">
                      @if(Session::get('cantAccess'))
                          <div class="alert alert-danger">{{ Session::get('cantAccess') }}</div>
                      @endif
                      @yield('content')
                  </div>
              </div>
              <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title text-center" id="exampleModalLabel">Siap Untuk Logout?</h5>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <div class="modal-body">Apakah Kamu Yakin Ingin Logout?</div>
                          <div class="modal-footer">
                              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                              @if (Auth::check())
                                  <a class="btn btn-danger" href="{{route('logout')}}">Logout</a>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script src={{asset('assets/vendor/jquery/jquery.min.js')}}></script>
      <script src={{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}></script>
      <script src={{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}></script>
      <script src={{asset('assets/js/sb-admin-2.min.js')}}></script>
      <script src={{asset('assets/vendor/chart.js/Chart.min.js')}}></script>
      <script src={{asset('assets/js/demo/datatables-demo.js')}}></script>
      <script src={{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}></script>
      <script src={{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}></script>
      <script src={{ asset('assets/js/tinymce/tinymce.min.js') }} referrerpolicy="origin"></script>
      <script>
          tinymce.init({
              selector: 'textarea#myeditorinstance',
              plugins: 'code table lists',
              toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
          });
      </script>
  </body>
  </html>
