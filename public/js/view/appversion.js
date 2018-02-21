$(function(){
	// 停用正在啟用中的版本
	$('select').change(function(){
		$(this).parents('form').submit();
	})
})