<?php
	$title = "主機明細";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/hostdata_detail.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary btn_download pull-right">下載</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail hostlistdetail_setting col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="/hostdata/download" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="get">
	{!! csrf_field() !!}
		<input type="hidden" name="host_guid" value="{{ $HostData[0]->host_guid }}">
		<div class="col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
			<div class="form-group">
				<label for="host_name" class="col-md-4 col-sm-4 col-xs-4 control-label">主機名稱</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" disabled value="{{ $HostData[0]->host_name }}">
				</div>
			</div>
			<div class="form-group">
				<label for="host_cpu" class="col-md-4 col-sm-4 col-xs-4 control-label">處理器型號</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" disabled value="{{ $HostData[0]->host_cpu }}">
				</div>
			</div>
			<div class="form-group">
				<label for="host_ram" class="col-md-4 col-sm-4 col-xs-4 control-label">記憶體</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" disabled value="{{ $HostData[0]->host_ram }}">
				</div>
			</div>
			<div class="form-group">
				<label for="host_motherboard" class="col-md-4 col-sm-4 col-xs-4 control-label">主機板</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" disabled value="{{ $HostData[0]->host_motherboard }}">
				</div>
			</div>
			<div class="form-group">
				<label for="host_os" class="col-md-4 col-sm-4 col-xs-4 control-label">作業系統
				</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" disabled value="{{ $HostData[0]->host_os }}">
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
			@if(isset($ListData))
				{!! $ListData !!}
			@else
				查無任何資料
			@endif
		</div>
	</form>
@endsection
@section("content_footer")

@endsection