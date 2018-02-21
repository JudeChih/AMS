<?php
	$title = "主機排程設定";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/hosttask.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<div class="task_search_form col-md-6 col-sm-6 col-xs-10 p_l_r_dis"></div>
  <div class="col-md-6 col-sm-6 col-xs-12 p_l_r_dis">
  	<button type="button" class="btn btn-danger btn_remove pull-right">刪除</button>
		<button type="button" class="btn btn-warning ht_modify pull-right">修改</button>
		<a href="/hosttask/create" class="btn btn-success btn_new pull-right">新增</a>
	</div>
</div>
<div class="panel_subtitle col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form name="sort_form" action="/hosttask" method="get">
		@if(isset($sort))
			<input type="hidden" name="sort" value="{{ $sort }}">
			<input type="hidden" name="order" value="{{ $order }}">
		@else
			<input type="hidden" name="sort" value="">
			<input type="hidden" name="order" value="desc">
		@endif
	</form>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="host_name">主機名稱 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="execute_type">執行類別 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="task_last_date">最後執行日 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-3 col-sm-3 col-xs-3 p_l_r_dis" data-val="task_next_date">下次執行日 <i class="dis_none fa" aria-hidden="true"></i></div>
	<div class="sort_check col-md-2 col-sm-2 col-xs-2 p_l_r_dis" data-val="task_enable">啟用狀態 <i class="dis_none fa" aria-hidden="true"></i></div>
</div>
<div class="panel_form col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	@if(count($TaskData)!=0)
		@foreach ($TaskData as $data)
			<form action="/hosttask" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis" method="post">
				{!! csrf_field() !!}
				<input type="hidden" name="formType" value="">
				<input type="hidden" name="host_guid" value="{{ $data->host_guid }}">
				<input type="hidden" name="task_id" value="{{$data->task_id}}">
				<div class="col-md-2 col-sm-2 col-xs-2">{{ $data->host_name }}</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">
					@if($data->execute_type == 0)
						未選擇
					@elseif($data->execute_type == 1)
						軟體
					@elseif($data->execute_type == 2)
						程序
					@elseif($data->execute_type == 3)
						服務
					@elseif($data->execute_type == 4)
						PnP設備
					@endif
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 text_left">
					@if($data->task_last_date == '')
						尚未排定
					@else
						{{ $data->task_last_date }}
					@endif
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 text_left">
					@if($data->task_next_date == '')
						尚未排定
					@else
						{{ $data->task_next_date }}
					@endif
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text_left">
					@if($data->task_enable == 0)
						未啟動
					@elseif($data->task_enable == 1)
						已啟動
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
	@if(isset($sort))
		{{ $TaskData->appends(['sort' => $sort,'order' => $order]) }}
	@else
		{{ $TaskData }}
	@endif
</div>
@endsection