<?php
	$title = "登入";
?>
@extends('__ams_login_head')
@section('content')
	<div class="container login_page">
		<form class="form_signin" action="/login" method="post">
			{!! csrf_field() !!}
			<h1 class="form_signin_heading">AMS</h1>
			<label for="ud_loginname" class="sr-only">Username</label>
				<input type="text" id="ud_loginname" class="form-control" name="ud_loginname" placeholder="帳號" required="" autofocus="">
			<label for="ud_loginpwd" class="sr-only">Password</label>
			<input type="password" id="ud_loginpwd" name="ud_loginpwd" class="form-control" placeholder="密碼" required="">
			<div class="error_box">
			@if($errors->any())
				<p>{{$errors->first()}}</p>
			@endif
			</div>
			<button class="btn btn-default btn-block" type="submit">登入</button>
		</form>
	</div>
{{-- 	<footer class="login_footer">

	</footer> --}}
@endsection