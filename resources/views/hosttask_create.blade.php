<?php
	$title = "新增主機排程";
?>

@extends('__ams_head')
@section("content_body")
<script type="text/javascript" src="/js/view/hosttask_create.js"></script>
<div class="btn_group  col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<button type="button" class="btn btn-primary ht_new pull-right">存檔</button>
	<button type="button" class="btn btn-info btn_back pull-right">返回</button>
</div>
<div class="panel_detail col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
	<form action="/hosttask/save" class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis form-horizontal" method="post">
	{!! csrf_field() !!}
		<input type="hidden" name="formType" value="create">
		<div class="form-group">
			<label for="host_guid" class="col-md-4 col-sm-4 col-xs-4 control-label">指定主機</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<select class="form-control" name="host_guid">
					@foreach ($hostData as $data)
						<option value="{{ $data->host_guid }}">{{ $data->host_name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="task_name" class="col-md-4 col-sm-4 col-xs-4 control-label">排程名稱</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="task_name" name="task_name" data-toggle="tooltip" title="名稱不能為空">
			</div>
		</div>
		<div class="form-group">
			<label for="execute_type" class="col-md-4 col-sm-4 col-xs-4 control-label">執行類別</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="execute_type" value="1" checked>
				    軟體
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="execute_type" value="2">
				    程序
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="execute_type" value="3">
				    服務
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="execute_type" value="4">
				    PnP設備
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="task_start_date" class="col-md-4 col-sm-4 col-xs-4 control-label">開始執行日期</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="task_start_date" name="task_start_date" data-toggle="tooltip" title="請選擇起始日">
			</div>
		</div>
		<div class="form-group">
			<label for="task_end_date" class="col-md-4 col-sm-4 col-xs-4 control-label">結束執行日期</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<input type="text" class="form-control check_unit" id="task_end_date" name="task_end_date" data-toggle="tooltip" title="請選擇結束日">
			</div>
		</div>
		<div class="form-group">
			<label for="task_enable" class="col-md-4 col-sm-4 col-xs-4 control-label">是否啟動</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="task_enable" value="0" checked>
				    否
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="task_enable" value="1">
				    是
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="task_type" class="col-md-4 col-sm-4 col-xs-4 control-label" data-val="1">排程類別</label>
			<div class="col-md-6 col-sm-6 col-xs-8 task_type">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" value="1" name="task_type" checked><span> 每天</span>
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" value="2" name="task_type"><span> 每週</span>
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" value="3" name="task_type"><span> 每月</span>
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group task_interval">
			<label for="task_interval" class="col-md-4 col-sm-4 col-xs-4 control-label">排程間隔</label>
			<input type="hidden" name="task_interval">
			<input type="hidden" name="task_dayofweek">
			<input type="hidden" name="task_weekofmonth">
			<input type="hidden" name="task_dayofmonth">
			<div class="col-md-6 col-sm-6 col-xs-8 change_block everyday">
				<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
				  <input type="text" class="form-control" id="everyday" placeholder="每隔幾天" data-toggle="tooltip" title="不能小於1天，不能有小數點">
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-8 change_block everyweek dis_none">
				<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
					<input type="text" class="form-control" id="weeks" placeholder="每隔幾週" data-toggle="tooltip" title="不能小於1周，不能有小數點">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 p_l_r_dis">
					<select class="everydayofweek_select form-control" multiple="multiple" style="width:100%;">
						<option value="0">星期日</option>
						<option value="1">星期一</option>
						<option value="2">星期二</option>
						<option value="3">星期三</option>
						<option value="4">星期四</option>
						<option value="5">星期五</option>
						<option value="6">星期六</option>
					</select>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-8 change_block everymonth dis_none">
				<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
					<select class="everymonth_select form-control" multiple="multiple" style="width:100%;">
						<option value="1">一月</option>
						<option value="2">二月</option>
						<option value="3">三月</option>
						<option value="4">四月</option>
						<option value="5">五月</option>
						<option value="6">六月</option>
						<option value="7">七月</option>
						<option value="8">八月</option>
						<option value="9">九月</option>
						<option value="10">十月</option>
						<option value="11">十一月</option>
						<option value="12">十二月</option>
					</select>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 p_l_r_dis">
					<select class="everydayofmonth_select form-control" multiple="multiple" style="width:100%;">
						<option value="1">1日</option>
						<option value="2">2日</option>
						<option value="3">3日</option>
						<option value="4">4日</option>
						<option value="5">5日</option>
						<option value="6">6日</option>
						<option value="7">7日</option>
						<option value="8">8日</option>
						<option value="9">9日</option>
						<option value="10">10日</option>
						<option value="11">11日</option>
						<option value="12">12日</option>
						<option value="13">13日</option>
						<option value="14">14日</option>
						<option value="15">15日</option>
						<option value="16">16日</option>
						<option value="17">17日</option>
						<option value="18">18日</option>
						<option value="19">19日</option>
						<option value="20">20日</option>
						<option value="21">21日</option>
						<option value="22">22日</option>
						<option value="23">23日</option>
						<option value="24">24日</option>
						<option value="25">25日</option>
						<option value="26">26日</option>
						<option value="27">27日</option>
						<option value="28">28日</option>
						<option value="29">29日</option>
						<option value="30">30日</option>
						<option value="31">31日</option>
						<option value="99">最後一日</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="task_day_frequency" class="col-md-4 col-sm-4 col-xs-4 control-label">單日頻率類別</label>
			<div class="col-md-6 col-sm-6 col-xs-8 task_day_frequency">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="task_day_frequency" id="task_day_frequency1" value="1" checked>
				    指定時間
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="task_day_frequency" id="task_day_frequency2" value="2">
				    分鐘
				  </label>
				</div>
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <label>
				    <input type="radio" name="task_day_frequency" id="task_day_frequency3" value="3">
				    小時
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group task_day_interval">
			<label for="task_day_interval" class="col-md-4 col-sm-4 col-xs-4 control-label">單日間隔</label>
			<div class="col-md-6 col-sm-6 col-xs-8">
				<div class="radio col-md-3 col-sm-3 col-xs-3 p_l_r_dis">
				  <input type="text" class="form-control check_unit" id="task_day_interval" name="task_day_interval" data-toggle="tooltip" title="請填寫單日間隔">
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
@section("content_footer")

@endsection