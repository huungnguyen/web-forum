<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>ForumIT</title>

		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

		<!-- Fonts -->
		<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script language="javascript">
			function notification_onclick(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
					url : "{{url('notification_onclick')}}",
					type : "post",
                    data: {
                        _token: CSRF_TOKEN
                    },

				});
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default" style="background-color: #66afe9">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					{{--<a class="navbar-brand" href=""><font size="5px"> ForumIT</font></a>--}}
					<a class="navbar-brand" href=""><font size="6px"><strong><i>ForumIT</i></strong></font></a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="{{ url('/') }}"><font size="4px">Home</font></a>
						</li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
						<li>
							<a href="{{ url('/auth/login') }}"><font size="4px">Login</font></a>
						</li>
						<li>
							<a href="{{ url('/auth/register') }}"><font size="4px">Register</font></a>
						</li>
						@else
						<li >
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-expanded="false"><font size="4px"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }}<span class="caret"></span></font></a>
							<ul class="dropdown-menu" role="menu">
								@if (Auth::user()->can_post())
								<li>
									<a href="{{ url('/new-post') }}">Add new post</a>
								</li>
								<li>
									<a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a>
								</li>
								@endif
								<li>
									<a href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
								</li>
								<li>
									<a href="{{ url('/auth/logout') }}">Logout</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-expanded="false"><font size="4px" >
									<span class="glyphicon glyphicon-bullhorn"></span>
									<span class="badge">
										{{$notifications->count()}}
									</span></font></a>
									<ul class="dropdown-menu" role="menu">
										@if(isset($notifications)&&$notifications->count())
											@foreach($notifications as $notification)
												<li><a href="{{url("$notification->slug")}}" >{{$notification->from_user.' had comment in '.$notification->title}}</a></li>
											@endforeach
												<li><a href="javascript:location.reload(true)" onclick="notification_onclick()">Đóng hết thông báo</a></li>
										@else
											<li>Không có thông báo</li>
										@endif
									</ul>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			{{--@if (Session::has('message'))--}}
			{{--<div class="flash alert-info">--}}
				{{--<p class="panel-body">--}}
					{{--{{ Session::get('message') }}--}}
				{{--</p>--}}
			{{--</div>--}}
			{{--@endif--}}
			{{--@if ($errors->any())--}}
			{{--<div class='flash alert-danger'>--}}
				{{--<ul class="panel-body">--}}
					{{--@foreach ( $errors->all() as $error )--}}
					{{--<li>--}}
						{{--{{ $error }}--}}
					{{--</li>--}}
					{{--@endforeach--}}
				{{--</ul>--}}
			{{--</div>--}}
			{{--@endif--}}
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>@yield('title')</h2>
							@yield('title-meta')
						</div>
						<div class="panel-body">
							@yield('content')
						</div>
					</div>
					<div>
						@yield('register')
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<p>Copyright &copy; 2015 | <a href="">
						</a>
					</p>
				</div>
			</div>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('/js/jquery.min-2.1.3.js') }}"></script>
		<script src="{{ asset('/js/bootstrap.min-3.3.1.js') }}"></script>
	</body>
</html>
