$(function(){
	// 使用者資料新增的存檔按鈕
	$('.udl_new').on('click',function(){
		var isFormValid = true;
		$('.check_unit').each(function(){
			var $this = $(this);
			if($.trim($this.val()).length === 0){
				$this.tooltip('show');
				isFormValid = false;
			}
		})
		if($('input[name=ud_loginpwd]').val() != $('input[name=ud_loginpwd_confirm]').val()){
			alert('密碼不ㄧ致，請重新輸入。')
			$('input[name=ud_loginpwd]').val('');
			$('input[name=ud_loginpwd_confirm]').val('');
			isFormValid = false;
		}
		if(isFormValid){
			var action = $('form').prop('action');
			action = action + '/save';
			$('form').prop('action',action);
			$('form').submit();
		}
	})
})