<?php
$title = "系統設定";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/systemoption.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-warning so_modify pull-right">修改</button>
	<button type="button" class="btn btn-primary so_download pull-right">下載</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(count($OptionData)!=0)
		<form action="/systemoption" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="get">
			{!! csrf_field() !!}
			<input type="hidden" name="option_id" value="{{ $OptionData[0]->option_id }}">
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">API路徑</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->api_url}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">FTP路徑</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->ftp_url}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">FTP資料夾</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->ftp_directory}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">FTP登入使用者</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->ftp_user}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">FTP登入密碼</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->ftp_pwd}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">翔偉API路徑</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->sunwai_api_url}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">更新的參數資料</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->sunwai_upload_parameter}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 col-sm-4 col-xs-4 control-label">與伺服器連線間隔</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{$OptionData[0]->sunwai_connect_interval}}" disabled>
				</div>
			</div>
		</form>
  @else
		<p>查無資料</p>
  @endif
</div>
@endsection
@section("content_footer")
@endsection