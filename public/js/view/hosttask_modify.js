$(function(){
  // 移除?後的參數
  var uri = window.location.toString();
  if (uri.indexOf("?") > 0) {
      var clean_uri = uri.substring(0, uri.indexOf("?"));
      window.history.replaceState({}, document.title, clean_uri);
  }

	// datetimepicker的賦予
	$('#task_start_date').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		language: 'zh-TW',
		weekStart: 7,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 3,
		minView: 0,
		forceParse: 0
	});
	$('#task_end_date').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss',
		language: 'zh-TW',
		weekStart: 7,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 3,
		minView: 0,
		forceParse: 0
	});

	// 存檔的按鈕
  $('.ht_save').on('click', function() {
  	// 檢查必填欄位是否確實填寫
    var isFormValid = checkForm();
    // 檢查開始日是否在結束日之前
    if(isFormValid){
     	isFormValid = checkDate();
     	if(!isFormValid){
     		alert("結束日不能早於開始日")
     		$('input[name=task_start_date]').val('');
  			$('input[name=task_end_date]').val('');
     	}
    }
    if(isFormValid){
    	var action = $('form').attr('action');
      action = action + '/save';
      $('form').prop('action',action);
    	$('.panel_detail form').submit();
    }
  })

	// select2的賦予
	reset_select2();

	// 單日間隔欄位的預設
	change_day_block(1); // 預設為指定時間

	// 判別val變更radio
	$('.task_radio').find('.radio').each(function(){
		var val = $(this).parent('.task_radio').data('val');
		var task_radio = $(this).parent('.task_radio');
		if($(this).find('input').val() == val){
			$(this).find('input').prop('checked',true);
			if(task_radio.hasClass('task_type')){
				change_task_block(val);
				// 修改頁面，排成間隔的設定
				if($('input[name=formType]').val() == 'update'){
					val = parseInt(val);
					switch(val){
						case 1:
							var interval_val = $('input[name=task_interval]').data('val');
							$('.everyday').find('input').val(interval_val);
							var interval = $('.interval').data('val');
							$('.interval').prop('value',interval);
						break;
						case 2:
							var interval_val = $('input[name=task_interval]').data('val');
							var dayofweek_val = $('input[name=task_dayofweek]').data('val');
							// 轉字串
							$('#weeks').val(interval_val);
							dayofweek_val = ''+dayofweek_val;
							if(dayofweek_val.indexOf(';') > 0){
								dayofweek_val = dayofweek_val.split(';');
							}
							// $('.everyweek_select').select2().val(interval_val).change();
							$('.everydayofweek_select').select2().val(dayofweek_val).change();
							var interval = $('.interval').data('val');
							$('.interval').prop('value',interval);
							var dayofweek = $('.dayofweek').data('val');
							$('.dayofweek').val(dayofweek);
						break;
						case 3:
							var interval_val = $('input[name=task_interval]').data('val');
							var weekofmonth_val = $('input[name=task_weekofmonth]').data('val');
							var dayofmonth_val = $('input[name=task_dayofmonth]').data('val');
							// 轉字串
							interval_val = ''+interval_val;
							weekofmonth_val = ''+weekofmonth_val;
							dayofmonth_val = ''+dayofmonth_val;
							if(interval_val.indexOf(';') > 0){
								interval_val = interval_val.split(';');
							}
							if(weekofmonth_val.indexOf(';') > 0){
								weekofmonth_val = weekofmonth_val.split(';');
							}
							if(dayofmonth_val.indexOf(';') > 0){
								dayofmonth_val = dayofmonth_val.split(';');
							}
							$('.everymonth_select').select2().val(interval_val).change();
							$('.everyweekofmonth_select').select2().val(weekofmonth_val).change();
							$('.everydayofmonth_select').select2().val(dayofmonth_val).change();
							var interval = $('.interval').data('val');
							$('.interval').prop('value',interval);
							var dayofmonth = $('.dayofmonth').data('val');
							$('.dayofmonth').val(dayofmonth);
						break;
					}
				}
			}else if(task_radio.hasClass('task_day_frequency')){
				change_day_block(val);
				$('#task_day_interval').val($('#task_day_interval').attr('value'));
			}
		}
	})

	// 每天
	$('.everyday input').change(function(){
		var val = $(this).val();
		$('.task_interval input[name=task_interval]').val(val);
	})

	// 每週
	$('.everyweek #weeks').change(function(){
		var val = $(this).val();
		$('.task_interval input[name=task_interval]').val(val);
	})
	$('.everyweek .everydayofweek_select').change(function(){
		var val = '';
		$(this).find('option:selected').each(function(){
			if(val == ''){
				val = $(this).val();
			}else{
				val = val + ';' + $(this).val();
			}
		})
		$('.task_interval input[name=task_dayofweek]').val(val);
	})

	// 每月
	$('.everymonth .everymonth_select').change(function(){
		var val = '';
		$(this).find('option:selected').each(function(){
			if(val == ''){
				val = $(this).val();
			}else{
				val = val + ';' + $(this).val();
			}
		})
		$('.task_interval input[name=task_interval]').val(val);
	});
	$('.everymonth .everydayofmonth_select').change(function(){
		var val = '';
		$(this).find('option:selected').each(function(){
			if(val == ''){
				val = $(this).val();
			}else{
				val = val + ';' + $(this).val();
			}
		})
		$('.task_interval input[name=task_dayofmonth]').val(val);
	})

	// 排程類別一變更，排程間隔跟著變換
	$('input[name=task_type]').change(function(){
		var val = $(this).val();
		change_task_block(val);
	});

	// 單日頻率類別一變更，單日間隔跟著變換
	$('input[name=task_day_frequency]').change(function(){
		var val = $(this).val();
		change_day_block(val);
	});

	// 動態判斷 單日間隔輸入的值是否正確
	$('#task_day_interval').change(function(){
		var val;
		$('.task_day_frequency .radio').each(function(){
			if($(this).find('input').prop('checked')){
				val = $(this).find('input').val();
			}
		});
		switch(val){
			case '1':
				break;
			case '2':
				var aa = $(this).val();
				if( aa < 0 || isNaN(aa) ){
					alert('只能輸入大於0的數字')
					$(this).val('');
				}
				break;
			case '3':
				var aa = $(this).val();
				if(aa > 12 || aa < 1 || isNaN(aa) ){
					alert('只能輸入1到12的數字')
					$(this).val('');
				}
				break;
		}
	})

	// function功能區
	function reset_select2(){
		// 排程間隔 重設
		$('.everydayofweek_select').select2().val(null).trigger("change");
		$('.everymonth_select').select2().val(null).trigger("change");
		$('.everydayofmonth_select').select2().val(null).trigger("change");

		$('.everydayofweek_select').select2({
			placeholder: "請選擇禮拜幾",
		});
		$('.everymonth_select').select2({
			placeholder: "請選擇哪幾月",
		});
		$('.everydayofmonth_select').select2({
			placeholder: "請選擇哪幾天",
		});
	}

	function change_task_block(val){
		val = val-1;
		$('.task_interval .change_block').eq(val).removeClass('dis_none').siblings('.change_block').addClass('dis_none');
		$('.task_interval input').val('');
		reset_select2();
		$('.task_interval').removeClass('dis_none');
	}

	function change_day_block(val){
		val = parseInt(val);
		switch(val){
			case 1:
				$('.task_day_interval').removeClass('dis_none').find('input').addClass('specify_time').datetimepicker({
					format: 'hh:ii',
					language: 'zh-TW',
					weekStart: 7,
					autoclose: 1,
					startView: 1,
					minView: 0,
					forceParse: 0
				}).attr('placeholder', '指定時間').val('');
				break;
			case 2:
				$('.task_day_interval').removeClass('dis_none').find('input').removeClass('specify_time').datetimepicker('remove').attr('placeholder', '請輸入大於0的數字').val('');
				break;
			case 3:
				$('.task_day_interval').removeClass('dis_none').find('input').removeClass('specify_time').datetimepicker('remove').attr('placeholder', '最多間隔12小時').val('');
				break;
		}
	}

	// 檢查必填欄位是否填寫
  function checkForm(){
  	var isFormValid = true;
  	$('.check_unit').each(function(){
  		var $this = $(this);
  		if($.trim($this.val()).length === 0){
  			$this.tooltip('show');
  			isFormValid = false;
  		}
  	})
  	var task_type = $('input[name=task_type]:checked').val();
  	if(task_type == 1){
  		if($('input[name=task_interval]').val() < 1){
  			$('#everyday').tooltip('show');
  			isFormValid = false;
  		}
  	}else if(task_type == 2){
  		if($('input[name=task_interval]').val() < 1){
  			$('#weeks').tooltip('show');
  			isFormValid = false;
  		}
  	}
  	return isFormValid;
  }

  // 檢查起始日是否小於結束日
  function checkDate(){
  	var isFormValid = true;
  	// 以下s開頭代表start、e開頭代表end
  	var s = $('input[name=task_start_date]').val();
  	var e = $('input[name=task_end_date]').val();

  	// 開始日期切割
  	s = s.split(" ");
  	s_date = s[0].split("-");
  	s_time = s[1].split(":");

  	// 結束日切割
  	e = e.split(" ");
  	e_date = e[0].split("-");
  	e_time = e[1].split(":");

  	// 開始日年月日時分秒
  	s_year = s_date[0];
  	s_month = s_date[1];
  	s_day = s_date[2];
  	s_hour = s_time[0];
  	s_minute = s_time[1];
  	s_second = s_time[2];
  	// 結束日年月日時分秒
  	e_year = e_date[0];
  	e_month = e_date[1];
  	e_day = e_date[2];
  	e_hour = e_time[0];
  	e_minute = e_time[1];
  	e_second = e_time[2];
  	// 開始判斷
  	if(s_year > e_year){
  		isFormValid = false;
  	}else if(s_year == e_year && s_month > e_month){
  		isFormValid = false;
  	}else if(s_year == e_year && s_month == e_month && s_day > e_day){
  		isFormValid = false;
  	}else if(s_year == e_year && s_month == e_month && s_day == e_day && s_hour > e_hour){
  		isFormValid = false;
  	}else if(s_year == e_year && s_month == e_month && s_day == e_day && s_hour == e_hour && s_minute > e_minute){
  		isFormValid = false;
  	}else if(s_year == e_year && s_month == e_month && s_day == e_day && s_hour == e_hour && s_minute == e_minute && s_second > e_second){
  		isFormValid = false;
  	}
  	return isFormValid;
  }
})