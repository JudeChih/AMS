<?php
	$title = '使用者資料修改'; // 管理者
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/userdatalist_modify.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary udl_save pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
@foreach ($UserData as $data)
	<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
		<form action="\userdatalist" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
		{!! csrf_field() !!}
			<input type="hidden" name="formType" value="updateData">
			<input type="hidden" name="ud_guid" value="{{ $data->ud_guid }}">
			<div class="form-group">
				<label for="ud_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control check_unit" id="ud_name" name="ud_name" value="{{ $data->ud_name }}" data-toggle="tooltip" title="名稱不能為空">
				</div>
			</div>
			<div class="form-group">
				<label for="ud_loginname" class="col-md-4 col-sm-4 col-xs-4 control-label">登入帳號</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" value="{{ $data->ud_loginname }}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label for="ud_loginpwd" class="col-md-4 col-sm-4 col-xs-4 control-label">登入密碼</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" id="ud_loginpwd" name="ud_loginpwd">
				</div>
			</div>
			<div class="form-group">
				<label for="ud_loginpwd_confirm" class="col-md-4 col-sm-4 col-xs-4 control-label">確認密碼</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" class="form-control" id="ud_loginpwd_confirm" name="ud_loginpwd_confirm">
				</div>
			</div>
			<div class="form-group">
				<label for="ud_status" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者狀態</label>
				<div class="user_radio col-md-6 col-sm-6 col-xs-8" data-val="{{ $data->ud_status }}">
					<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
					  <label>
					    <input type="radio" name="ud_status" value="0">
					    停用
					  </label>
					</div>
					<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
					  <label>
					    <input type="radio" name="ud_status" value="1">
					    正常
					  </label>
					</div>
				</div>
			</div>
		</form>
	</div>
@endforeach
@endsection
@section("content_footer")
@endsection