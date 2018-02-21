<?php
$title = "新增程式版本";
?>

@extends('__ams_head')
@section("content_body")
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary checkAndSave pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="/appversion/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<input type="hidden" name="formType" value="create">
		<div class="form-group">
			<label for="ver_filename" class="col-md-4 col-sm-4 col-xs-4 control-label">檔案上傳</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="file" class="form-control check_unit" id="ver_filename" name="ver_filename" data-toggle="tooltip" title="必須上傳檔案">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_major" class="col-md-4 col-sm-4 col-xs-4 control-label">主要元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_major" name="ver_major" maxlength="5">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_minor" class="col-md-4 col-sm-4 col-xs-4 control-label">次要元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_minor" name="ver_minor" maxlength="5">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_build" class="col-md-4 col-sm-4 col-xs-4 control-label">組建元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_build" name="ver_build" maxlength="5">
			</div>
		</div>
		<div class="form-group">
			<label for="ver_revision" class="col-md-4 col-sm-4 col-xs-4 control-label">修訂元件值</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" id="ver_revision" name="ver_revision" maxlength="5">
			</div>
		</div>
	</form>
</div>
@endsection
@section("content_footer")

@endsection