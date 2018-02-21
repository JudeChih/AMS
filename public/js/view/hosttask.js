$(function(){
	// 修改的按鈕
	$('.ht_modify').on('click', function() {
    if ($('.panel_form form').hasClass('select_case')) {
      $path = document.location.pathname;
      $guid = $('.panel_form form.select_case').find('[name="host_guid"]').val();
      $task_id = $('.panel_form form.select_case').find('[name="task_id"]').val();
      $('.panel_form form.select_case').prop('method','get');
      $('.panel_form form.select_case').prop('action',$path+'/modify/'+$guid+'/'+$task_id);
      $('.panel_form form.select_case').submit();
    } else {
      alert('請選擇任一筆資料');
    }
  })

})