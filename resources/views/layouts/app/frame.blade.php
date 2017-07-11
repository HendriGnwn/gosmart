<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <title>@yield('title') - {{ config('app.name', 'Go Smart') }}</title>

    @section('header')
        @include('layouts.app.header')
    @show

</head>

<body class="fixed-header dashboard">
    <nav class="page-sidebar" data-pages="sidebar">

        <div class="sidebar-header">
			<span style="z-index:-999; font-size:20px;" alt="logo" class="brand" height="22"width="78">Go Smart</span>
			
            <div class="sidebar-header-controls"> <button class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar" type="button"><i class="fa fs-12"></i></button>
            </div>
        </div>
      
        <div class="sidebar-menu">
              <ul class="menu-items">
                @include('layouts.app.menu')
              </ul>

              <div class="clearfix"></div>
          </div>

    </nav>
    <div class="page-container">
		<div class="header">
			<div class="container-fluid relative">
				<div class="pull-left full-height visible-sm visible-xs">
					<div class="header-inner">
						<a class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar" href="#"><span class="icon-set menu-hambuger"></span></a>
					</div>
				</div>


				<div class="pull-center hidden-md hidden-lg">
					<div class="header-inner">
						<div class="brand inline">
							<span style="z-index:-999; font-size:20px;" alt="logo" class="brand" height="22"width="78">Go Smart</span>
						</div>
					</div>
				</div>

			</div>


			<div class=" pull-left sm-table hidden-xs hidden-sm">
				<div class="header-inner">
					<div class="brand inline">
						<span style="z-index:-999; font-size:20px;" alt="logo" class="brand" height="22"width="78">Go Smart</span>
					</div>

				</div>
			</div>




			<div class=" pull-right">
				<div class="visible-lg visible-md m-t-10">


					<div class="dropdown pull-right">
						<button aria-expanded="false" aria-haspopup="true" class="profile-dropdown-toggle p-t-10 fs-16" data-toggle="dropdown" type="button"><span class="semi-bold p-t-10 font-heading">{{ Auth::User()->first_name }}</span></button>

						<ul class="dropdown-menu profile-dropdown" role="menu">

							<li>
								<a href="{{ url('profil/'.Auth::User()->id."/edit") }}"><i class="pg-settings_small"></i> Settings</a>
							</li>


							<li class="bg-master-lighter">
								<a class="clearfix" href="{{url('logout')}}" onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();"><span class="pull-left">Logout</span> <span class="pull-right"><i class="pg-power"></i></span></a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>


		<div class="page-content-wrapper">
			<div class="content">
        @if(!Request::is('display'))
				<div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner" style="transform: translateY(0px); opacity: 1;">
                    @yield('breadcrumbs', \Breadcrumbs::render(['Home']))
                </div>
            </div>
        </div>
        @endif
        @if(!Request::is('admin/dashboard') && !Request::is('home') && !Request::is('user/dashboard') && !Request::is('display'))
				<div class="container-fluid container-fixed-lg">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                @yield("title", "Title")
                            </div>
                            <div class="pull-right">
                                <div class="col-xs-12 no-padding">
                                    <div class="export-options-container"></div>
                                </div>
                            </div>

                            <p>@yield("description", "") &nbsp; @yield('button')</p>
                        </div>
                        <div class="panel-body ">
                            @yield("content")
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
          @yield("content")
        @endif

			</div>

			<!-- MODAL STICK UP  -->
        <div class="modal fade stick-up" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Hapus <span class="semi-bold">Data?</span></h5>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-danger btn-sm" onclick="hapus()">Ya, hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade stick-up" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Konfirmasi <span class="semi-bold">data</span> sudah done?</h5>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-warning btn-sm" onclick="confirm()">Ya, konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade stick-up" id="modalConfirmX" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Konfirmasi <span class="semi-bold">data</span> reservasi?</h5>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-primary btn-xs" onclick="confirm(1)">Confirm Reservation</button>
                        <button class="btn btn-danger btn-xs" onclick="confirm(2)">Cancel Reservation</button>
                    </div>
                </div>
            </div>
        </div>


        @include('layouts.app.footer')
		</div>
	</div>

    @section('scripts')
        @include('layouts.app.script')
        <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            $('.timess').html(h + ":" + m + ":" + s);
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        </script>
    @stack('script')
</body>
</html>
