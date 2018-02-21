<?php
$title = "使用者資料";
?>
@extends('__ams_head')
@section("content_body")
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="task_search_form col-md-6 col-sm-6 col-xs-10 p_l_r_dis"></div>
  <div class="col-md-6 col-sm-6 col-xs-12 p_l_r_dis">
  	<button type="button" class="btn btn-danger btn_remove pull-right">刪除</button>
  	<button type="button" class="btn btn-info btn_authority pull-right">權限設定</button>
		<button type="button" class="btn btn-warning btn_modify pull-right">修改</button>
		<a href="/userdatalist/create" class="btn btn-success btn_new pull-right">新增</a>
	</div>
</div>
<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form name="sort_form" action="/userdatalist" method="get">
		@if(isset($sort))
			<input type="hidden" name="sort" value="{{ $sort }}">
			<input type="hidden" name="order" value="{{ $order }}">
		@else
			<input type="hidden" name="sort" value="">
			<input type="hidden" name="order" value="desc">
		@endif
	</form>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ud_name">使用者名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ud_loginname">登入帳號 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-6 col-sm-6 col-xs-6 p_l_r_dis" data-val="ud_guid">使用者代碼 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="ud_status">使用者狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
</div>
<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(count($UserData)!=0)
		@foreach ($UserData as $data)
			<form action="/userdatalist" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="formType" value="">
				<input type="hidden" name="ud_guid" value="{{ $data->ud_guid }}">
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">{{ $data->ud_name }}</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">{{ $data->ud_loginname }}</div>
				<div class="col-md-6 col-sm-6 col-xs-6 text_left">{{ $data->ud_guid }}</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					@if($data->ud_status == 0)
						停用
					@elseif($data->ud_status == 1)
						正常
					@endif
				</div>
			</form>
  	@endforeach
  @else
		<p>查無資料</p>
  @endif
</div>
@endsection
@section("content_footer")
<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(isset($sort) && isset($UserData))
		{{ $UserData->appends(['sort' => $sort,'order' => $order]) }}
	@else
		@if(isset($UserData))
			{{ $UserData }}
		@endif
	@endif
</div>
@endsection