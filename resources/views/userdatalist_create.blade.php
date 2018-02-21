<?php
	$title = '使用者資料新增';
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/userdatalist_create.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary udl_new pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="\userdatalist" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<input type="hidden" name="formType" value="create">
		<div class="form-group">
			<label for="ud_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="ud_name" name="ud_name" data-toggle="tooltip" title="名稱不能為空">
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginname" class="col-md-4 col-sm-4 col-xs-4 control-label">登入帳號</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="ud_loginname" name="ud_loginname" data-toggle="tooltip" title="帳號不能為空">
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginpwd" class="col-md-4 col-sm-4 col-xs-4 control-label">登入密碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="ud_loginpwd" name="ud_loginpwd" data-toggle="tooltip" title="密碼不能為空">
			</div>
		</div>
		<div class="form-group">
			<label for="ud_loginpwd_confirm" class="col-md-4 col-sm-4 col-xs-4 control-label">確認密碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="ud_loginpwd_confirm" name="ud_loginpwd_confirm" data-toggle="tooltip" title="請再次確認密碼">
			</div>
		</div>
	</form>
</div>
@endsection
@section("content_footer")
@endsection