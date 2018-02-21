<?php
$title = "程式版本資料";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/appversion.js"></script>

<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="list_search_form col-md-6 col-sm-6 col-xs-10 p_l_r_dis"></div>
  <div class="col-md-6 col-sm-6 col-xs-12 p_l_r_dis">
		<a href="/appversion/create" class="btn btn-success pull-right">新增</a>
	</div>
</div>
<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form name="sort_form" action="/appversion" method="get">
		@if(isset($sort))
			<input type="hidden" name="sort" value="{{ $sort }}">
			<input type="hidden" name="order" value="{{ $order }}">
		@else
			<input type="hidden" name="sort" value="">
			<input type="hidden" name="order" value="desc">
		@endif
	</form>
	<div class="sort_check appversion_style col-md-1 col-sm-1 col-xs-1 p_l_r_dis" data-val="ver_id">版本編號 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2" data-val="ver_status">程式狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="ver_filename">檔案名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
		<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="ver_major">主要元件 <i class="dis_none fa" aria-hidden="true"></i></div>
		<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="ver_minor">次要元件 <i class="dis_none fa" aria-hidden="true"></i></div>
		<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="ver_build">組建元件 <i class="dis_none fa" aria-hidden="true"></i></div>
		<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="ver_revision">修訂元件 <i class="dis_none fa" aria-hidden="true"></i></div>
	</div>
</div>
<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(count($VersionData)!=0)
		@foreach ($VersionData as $data)
			<form action="/appversion/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
				{!! csrf_field() !!}
				@if($data->ver_status == 1)
					<input type="hidden" name="formType" value="upDate">
				@else
					<input type="hidden" name="formType" value="">
				@endif
				<input type="hidden" name="ver_id" value="{{ $data->ver_id }}">
				<div class="col-md-1 col-sm-1 col-xs-1 p_l_r_dis">{{ $data->ver_id }}</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					@if($data->ver_status == 0)
						停用
					@elseif($data->ver_status == 1)
						<select class="form-control">
							<option>啟用</option>
							<option>停用</option>
						</select>
					@elseif($data->ver_status == 2)
						舊版
					@endif
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 p_l_r_dis">{{ $data->ver_filename }}</div>
				<div class="col-md-6 col-sm-6 col-xs-6 p_l_r_dis">
					<div class="col-md-3 col-sm-3 col-xs-3 text_left">
						{{ $data->ver_major }}
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 text_left">
						{{ $data->ver_minor }}
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 text_left">
						{{ $data->ver_build }}
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 text_left">
						{{ $data->ver_revision }}
				</div>
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
	@if(isset($sort))
		{{ $VersionData->appends(['sort' => $sort,'order' => $order]) }}
	@else
		{{ $VersionData }}
	@endif
</div>
@endsection