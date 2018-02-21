<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta id="token" name="token" content="{{ csrf_token() }}">
	<title>{{ isset($title) ? $title.' | ' : '首頁 | ' }}AMS資產管理</title>

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" href="/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/css/sass/stylesheets/style.css">

	<script type="text/javascript" src="/js/plugin/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="/js/plugin/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/plugin/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="/js/plugin/bootstrap-datetimepicker.zh-TW.js"></script>
	<script type="text/javascript" src="/js/plugin/select2.min.js"></script>
	<script type="text/javascript" src="/js/general.js"></script>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      {{-- <a class="navbar-brand" href="/index"><img src="/images/logo-sunwai.png"></a> --}}
	    </div>
	    <div class="collapse navbar-collapse a_href" id="bs-example-navbar-collapse-1">
	    	<ul class="nav navbar-nav nav_menu">
		    	@foreach (Session::get('fm') as $fm)
		    		@foreach (Session::get('authLevel') as $authLevel)
		    			@if ($authLevel->fm_id == $fm->fm_id)
		    				<li><a href="{{$authLevel->fd_path}}">{{$fm->fm_name}}</a></li>
		    			@endif
		    		@endforeach
		    	@endforeach
	    	</ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> 登出</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a><i class="fa fa-user" aria-hidden="true"></i> {{ Session::get('ud_name') }}</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container-fluid">
    <div class="row">
			<div class="panel panel-primary col-md-10 col-sm-12 col-md-offset-1 col-xs-12 p_l_r_dis">
			  <div class="panel-heading col-md-12 col-sm-12 col-xs-12">
			    <h1><?= isset($title) ? $title : '' ?></h1>
			  </div>
			  <div class="panel-body p_all_dis col-md-12 col-sm-12 col-xs-12">
			    @yield('content_body')
			  </div>
  			<div class="panel-footer panel-primary col-md-12 col-sm-12 col-xs-12">
  				@yield('content_footer')
  			</div>
			</div>
    </div>
	</div>
	<footer>
		<div>Copyright © 2017 翔偉資安科技</div>
	</footer>
@if($errors->any())
  <div class="prompt_body">
    <div class="prompt_box panel-primary">
  		<div class="panel-heading">
      	<h3>提示框</h3>
      </div>
      <h2>{{$errors->first()}}</h2>
      <button type="button" class="btn btn-primary btn_yes">確認</button>
    </div>
  </div>
@endif
</body>
</html>