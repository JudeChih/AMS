$(function(){
  // 移除?後的參數
  var uri = window.location.toString();
  if (uri.indexOf("?") > 0) {
      var clean_uri = uri.substring(0, uri.indexOf("?"));
      window.history.replaceState({}, document.title, clean_uri);
  }

	$('.check_radio').each(function(){
		var val =	$(this).data('val');
		$(this).find('input').each(function(){
			if($(this).val() == val){
				$(this).prop('checked',true);
			}
		})
	})

	// 使用者權限設定的存檔按鈕
	$('.udl_auth').on('click',function(){
		var isFormValid = true;
		var token = $("input[name='_token']").val();
		var tt = $('input[name=tt]').val();
		var a = [];
		var ud_guid = $('input[name="ud_guid"]').val();
		$('input[type=radio]').each(function(){
			if($(this).prop('checked')){
				var j = {};
				j['fd_id'] = $(this).attr('name');
				j['uda_browse'] = $(this).val();
				a.push(j);
			}
		});
		$.ajax({
			url: '/userdatalist/save',
			type:'POST',
			cache:false,
			datatype:'json',
			data: {_token: token,ud_guid: ud_guid,ua:a,formType:'updateAuth'},
			beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
			success: function(data){
				alert(data);
				window.location="/userdatalist";
			},
			error: function(){
				console.log('error');
			}
		})
	})
})