$(function(){
	// 修改的按鈕
	$('.so_modify').on('click', function() {
		$path = document.location.pathname;
		$option_id = $('.panel_detail form').find('[name="option_id"]').val();
		var action = $path+'/modify/'+$option_id;
		$('.panel_detail form').prop('action',action);
    $('.panel_detail form').submit();
  })

  // 下載的按鈕
	$('.so_download').on('click',function(){
    $path = document.location.pathname;
    $option_id = $('.panel_detail form').find('[name="option_id"]').val();
    $('.panel_detail form').prop('action', $path+'/download/'+$option_id);
    $('.panel_detail form').submit();
	})
})