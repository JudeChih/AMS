$(function(){
	// 移除?後的參數
  var uri = window.location.toString();
  if (uri.indexOf("?") > 0) {
      var clean_uri = uri.substring(0, uri.indexOf("?"));
      window.history.replaceState({}, document.title, clean_uri);
  }

	$('.ud_save').on('click',function(){
		var isFormValid = true;
		$('.check_unit').each(function(){
			var $this = $(this);
			if($.trim($this.val()).length === 0){
				$this.tooltip('show');
				isFormValid = false;
			}
		})
		if(isFormValid){
			if($('input[name=ud_loginpwd]').val() != $('input[name=ud_loginpwd_confirm]').val()){
				alert('密碼不ㄧ致，請重新輸入。')
				$('input[name=ud_loginpwd]').val('');
				$('input[name=ud_loginpwd_confirm]').val('');
				isFormValid = false;
			}
		}
		if(isFormValid){
			var action = $('form').prop('action');
			action = action + '/save';
			$('form').prop('action',action);
			$('form').submit();
		}
	})
})