<?php
	$title = '使用者權限設定'; // 管理者
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/userdatalist_auth.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary udl_auth pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="\userdatalist" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<input type="hidden" name="formType" value="updateAuth">
		<input type="hidden" name="ud_guid" value="{{ $UserData[0]->ud_guid }}">
		<div class="form-group">
			<label for="ud_name" class="col-md-4 col-sm-4 col-xs-4 control-label">使用者名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control" value="{{ $UserData[0]->ud_name }}" disabled>
			</div>
		</div>
		@foreach($UserAuth as $data)
		<div class="form-group">
			<label for="{{ $data->fd_name }}" class="col-md-4 col-sm-4 col-xs-4 control-label">{{ $data->fm_name }}</label>
			<div class="check_radio col-md-6 col-sm-6 col-xs-8" data-val="{{ $data->uda_browse }}">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="{{ $data->fd_id }}" value="0">
				   	拒絕
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="{{ $data->fd_id }}" value="1">
				    允許
				  </label>
				</div>
			</div>
		</div>
		@endforeach
	</form>
</div>
@endsection
@section("content_footer")
@endsection