<?php
$title = "測試API專用頁";
?>

@extends('__ams_head')
@section("content_body")

<div class="test_style col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
	<h1>註冊Client端主機並回傳Host_GUID</h1>
	<form action="/signup" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<div class="form-group">
			<label for="host_name" class="col-md-4 col-sm-4 col-xs-4 control-label">主機名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="host_name" name="host_name">
			</div>
		</div>
		<button type="submit" class="btn btn-info" style="position:relative;left:28%;">送出</button>
	</form>
</div>
<div class="test_style col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
	<h1>回報版本編號</h1>
	<form action="/checkclient" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<div class="form-group">
			<label for="host_guid" class="col-md-4 col-sm-4 col-xs-4 control-label">主機代碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="host_guid" name="host_guid">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_major" class="col-md-4 col-sm-4 col-xs-4 control-label">主要元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_major" name="ver_major">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_minor" class="col-md-4 col-sm-4 col-xs-4 control-label">次要元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_minor" name="ver_minor">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_build" class="col-md-4 col-sm-4 col-xs-4 control-label">組建元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_build" name="ver_build">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_revision" class="col-md-4 col-sm-4 col-xs-4 control-label">修訂元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_revision" name="ver_revision">
			</div>
		</div>
		<button type="submit" class="btn btn-info " style="position:relative;left:28%;">送出</button>
	</form>
</div>
<div class="test_style col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
	<h1>取得Host Agent執行時所需的參數</h1>
	<form action="/gethost" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<div class="form-group">
			<label for="host_guid" class="col-md-4 col-sm-4 col-xs-4 control-label">主機代碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="host_guid" name="host_guid">
			</div>
		</div>
		<button type="submit" class="btn btn-info " style="position:relative;left:28%;">送出</button>
	</form>
</div>
<div class="test_style col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
	<h1>更新主機資料</h1>
	<form action="/updatehost" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<div class="form-group">
			<label for="host_name" class="col-md-4 col-sm-4 col-xs-4 control-label">主機代碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="host_name" name="host_name">
			</div>
		</div>
		<div class="form-group">
			<label for="file_name" class="col-md-4 col-sm-4 col-xs-4 control-label">檔案名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="file_name" name="file_name">
			</div>
		</div>
		<div class="form-group">
			<label for="update_type" class="col-md-4 col-sm-4 col-xs-4 control-label">更新類別</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="update_type" name="update_type">
			</div>
		</div>
		<div class="form-group">
			<label for="task_id" class="col-md-4 col-sm-4 col-xs-4 control-label">排程代碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="task_id" name="task_id">
			</div>
		</div>
		<button type="submit" class="btn btn-info " style="position:relative;left:28%;">送出</button>
	</form>
</div>
@endsection
@section("content_footer")
@endsection