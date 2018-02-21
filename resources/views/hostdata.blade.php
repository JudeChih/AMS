<?php
	$title = "主機列表";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/hostdata.js"></script>
<div class="btn_group col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="list_search_form col-md-6 col-sm-6 col-xs-10 p_l_r_dis"></div>
  <div class="col-md-6 col-sm-6 col-xs-12 p_l_r_dis">
  	<button type="button" class="btn btn-danger btn_remove pull-right">刪除</button>
		<button type="button" class="btn btn-warning hd_detail pull-right">明細</button>
	</div>
</div>
<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form name="sort_form" action="/hostdata" method="get">
		@if(isset($sort))
			<input type="hidden" name="sort" value="{{ $sort }}">
			<input type="hidden" name="order" value="{{ $order }}">
		@else
			<input type="hidden" name="sort" value="">
			<input type="hidden" name="order" value="desc">
		@endif
	</form>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="host_name">主機名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="host_cpu">中央處理器型號 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="host_ram">記憶體 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="host_motherboard">主機板 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="host_os">作業系統 <i class="dis_none fa" aria-hidden="true"></i></div>
</div>
<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(count($HostData)!=0)
		@foreach ($HostData as $data)
			<form action="/hostdata" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="formType" value="">
				<input type="hidden" name="host_guid" value="{{ $data->host_guid }}">
				<div class="col-md-2 col-sm-2 col-xs-2">{{ $data->host_name }}</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">
					{{ $data->host_cpu }}
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 text_left">
					{{ $data->host_ram }}
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 text_left">
					{{ $data->host_motherboard }}
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">
					{{ $data->host_os }}
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
		{{ $HostData->appends(['sort' => $sort,'order' => $order]) }}
	@else
		{{ $HostData }}
	@endif
</div>
@endsection