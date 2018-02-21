<?php
$title = "系統設定編輯";
?>

@extends('__ams_head')
@section("content_body")
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary checkAndSave pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="/systemoption/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="formType" value="update">
		<input type="hidden" name="option_id" value="{{ $SystemOption[0]->option_id }}">
		<div class="form-group">
			<label for="api_url" class="col-md-4 col-sm-4 col-xs-4 control-label">API路徑</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="api_url" class="form-control check_unit" value="{{$SystemOption[0]->api_url}}" data-toggle="tooltip" title="請填寫API路徑">
			</div>
		</div>
		<div class="form-group">
			<label for="ftp_url" class="col-md-4 col-sm-4 col-xs-4 control-label">FTP路徑</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="ftp_url" class="form-control check_unit" value="{{$SystemOption[0]->ftp_url}}" data-toggle="tooltip" title="請填寫FTP路徑">
			</div>
		</div>
		<div class="form-group">
			<label for="ftp_directory" class="col-md-4 col-sm-4 col-xs-4 control-label">FTP資料夾</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="ftp_directory" class="form-control check_unit" value="{{$SystemOption[0]->ftp_directory}}" data-toggle="tooltip" title="請設定FTP資料夾路徑">
			</div>
		</div>
		<div class="form-group">
			<label for="ftp_user" class="col-md-4 col-sm-4 col-xs-4 control-label">FTP登入使用者</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="ftp_user" class="form-control check_unit" value="{{$SystemOption[0]->ftp_user}}" data-toggle="tooltip" title="請填入FTP登入帳號">
			</div>
		</div>
		<div class="form-group">
			<label for="ftp_pwd" class="col-md-4 col-sm-4 col-xs-4 control-label">FTP登入密碼</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="ftp_pwd" class="form-control check_unit" value="{{$SystemOption[0]->ftp_pwd}}" data-toggle="tooltip" title="請填入FTP登入密碼">
			</div>
		</div>
		<div class="form-group">
			<label for="sunwai_api_url" class="col-md-4 col-sm-4 col-xs-4 control-label">翔偉API路徑</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="sunwai_api_url" class="form-control" value="{{$SystemOption[0]->sunwai_api_url}}">
			</div>
		</div>
		<div class="form-group">
			<label for="sunwai_upload_parameter" class="col-md-4 col-sm-4 col-xs-4 control-label">更新的參數資料</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="sunwai_upload_parameter" class="form-control check_nuit" value="{{$SystemOption[0]->sunwai_upload_parameter}}" data-toggle="tooltip" title="請填入參數資料">
			</div>
		</div>
		<div class="form-group">
			<label for="sunwai_connect_interval" class="col-md-4 col-sm-4 col-xs-4 control-label">與伺服器連線間隔</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" name="sunwai_connect_interval" class="form-control check_unit" value="{{$SystemOption[0]->sunwai_connect_interval}}" data-toggle="tooltip" title="請設定連線間隔">
			</div>
		</div>
	</form>
</div>
@endsection
@section("content_footer")
@endsection