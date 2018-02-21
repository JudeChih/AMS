<?php
$title = "使用者資料";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/userdata.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-warning ud_modifypwd pull-right">修改密碼</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="/userdata" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="ud_guid" value="{{ $UserData[0]->ud_guid }}">
		<div class="form-group">
			<label for="ud_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" value="{{ $UserData[0]->ud_name }}" disabled>
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginname" class="col-md-4 col-sm-4 col-xs-4 control-label">登入帳號</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" value="{{ $UserData[0]->ud_loginname }}" disabled>
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginpwd" class="col-md-4 col-sm-4 col-xs-4 control-label">登入密碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ud_loginpwd" name="ud_loginpwd" disabled>
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginpwd_confirm" class="col-md-4 col-sm-4 col-xs-4 control-label">確認密碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ud_loginpwd_confirm" name="ud_loginpwd_confirm" disabled>
			</div>
		</div>
	</form>
</div>
@endsection
@section("content_footer")
<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
</div>
@endsection