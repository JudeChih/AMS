$(function(){
  // 提示欄位未填的功能，初始化
	$('[data-toggle="tooltip"]').tooltip();

  if(!$('.sort_check').hasClass('fa-caret-down')){
    $('.sort_check').eq(0).find('i').removeClass('dis_none');
    $('.sort_check').eq(0).find('i').addClass('fa-caret-down');
  }

  change_up_down();

  $('.sort_check').on('click',function(){
    var aa = $(this).data('val');
    var bb = $('form[name="sort_form"]').find('input[name="sort"]').val();
    var cc = $('form[name="sort_form"]').find('input[name="order"]').val();
    if(aa==bb && cc=='desc'){
      $('form[name="sort_form"]').find('input[name="order"]').val('asc');
    }else if(aa==bb && cc=='asc'){
      $('form[name="sort_form"]').find('input[name="order"]').val('desc');
    }else{
      $('form[name="sort_form"]').find('input[name="sort"]').val(aa);
      $('form[name="sort_form"]').find('input[name="order"]').val('desc');
    }
    $('form[name="sort_form"]').submit();
  })

	//easy-sidebar-toggle-right
	$('.easy-sidebar-toggle').click(function(e) {
		e.preventDefault();
		$('body').toggleClass('toggled');
		$('.navbar.easy-sidebar').removeClass('toggled');
	});

  // 返回上一頁
  $('.btn_back').on('click',function(){
    $path = document.location.pathname;
    $path = $path.split("/");
    window.location="/"+$path[1];
  })

	// 權限設定的按鈕
	$('.btn_authority').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $path = document.location.pathname;
      $('.panel_form form.select_case').prop('action',$path+'/auth');
      $('.panel_form form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })

	// 修改的按鈕
	$('.btn_modify').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $path = document.location.pathname;
      $('.panel_form form.select_case').prop('action',$path+'/modify');
      $('.panel_form form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })

 	// 明細的按鈕
	$('.btn_detail').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $('form').find('input[name="formType"]').val('detail');
      $path = document.location.pathname;
      $('.panel_form form.select_case').prop('action', $path+'/detail');
      $('.panel_form form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })

	// 下載的按鈕
	$('.btn_download').on('click',function(){
    $path = document.location.pathname;
    $('.panel_detail form').prop('action', $path+'/download');
    $('.panel_detail form').submit();
	})

  // 檢查並存檔的按鈕
  $('.checkAndSave').on('click', function() {
  	// 先判斷必填欄位
    var isFormValid = checkForm();
    // 然後送出表單
    if(isFormValid){
    	$('.panel_detail form').submit();
    }
  })

  // 刪除的按鈕
  $('.btn_remove').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $('form').find('input[name="formType"]').val('remove');
      $path = document.location.pathname;
      $('.panel_form').find('form.select_case').prop('action', $path+'/save');
      $('.panel_form').find('form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })

  // 修改、新增、刪除之後在頁面會跳出的小視窗，確認的按鈕
  $('.btn_yes').on('click', function() {
    $('.prompt_body').fadeOut(400, function() {
      $('.prompt_body').remove();
    });
  })

  // 選擇一筆資料的highlight
  $('.panel_form form').on('click', function() {
    if ($(this).hasClass('select_case')) {
      $(this).removeClass('select_case')
    } else {
      $(this).siblings('form').removeClass('select_case');
      $(this).addClass('select_case');
    }
  })

  // 排序的變更
  function change_up_down(){
    $('.sort_check').each(function(){
      var a = $(this).data('val');
      var b = $('form[name="sort_form"]').find('input[name="sort"]').val();
      var c = $('form[name="sort_form"]').find('input[name="order"]').val();
      var i = $(this).find('i');
      if(a == b){
        $('.sort_check').each(function(){
        	$(this).find('i').addClass('dis_none');
        });
        i.removeClass('dis_none');
        switch (c){
          case 'asc':
            i.addClass('fa-caret-up');
            break;
          case 'desc':
            i.addClass('fa-caret-down');
            break;
        }
      }
    })
  }

  // 表單送出前的判斷
  function checkForm(){
  	var isFormValid = true;
  	$('.check_unit').each(function(){
  		var $this = $(this);
  		if($.trim($this.val()).length === 0){
  			$this.tooltip('show');
  			isFormValid = false;
  		}
  	})
  	return isFormValid;
  }
})