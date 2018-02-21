$(function(){

	// 明細的按鈕
	$('.hd_detail').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $('form').find('input[name="formType"]').val('detail');
      $guid = $('.panel_form form.select_case').find('[name="host_guid"]').val();
      $path = document.location.pathname;
      $('.panel_form form.select_case').prop('action', $path+'/detail/'+$guid);
      $('.panel_form form.select_case').prop('method','get');
      // console.log($guid);
      $('.panel_form form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })
})