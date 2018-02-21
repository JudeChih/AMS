$(function(){
	$('.ud_modifypwd').on('click',function(){
		$path = document.location.pathname;
		action = $path + '/modifypwd';
		$('form').prop('action',action);
		$('form').submit();
	})
})