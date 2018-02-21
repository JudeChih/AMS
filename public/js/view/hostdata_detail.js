$(function(){
  // 移除?後的參數
  var uri = window.location.toString();
  if (uri.indexOf("?") > 0) {
      var clean_uri = uri.substring(0, uri.indexOf("?"));
      window.history.replaceState({}, document.title, clean_uri);
  }

	var plus = '<img class="plus" src="/images/plus.gif"> ';
	var minus = '<img class="minus" src="/images/minus.gif"> ';
	var folder_open = '<img class="folder_open" src="/images/folder_open.png" width="16"> ';
	var folder_close = '<img class="folder_close" src="/images/folder_close.png" width="16"> ';
	var sheet = '<img class="sheet" src="/images/sheet.gif"> ';

	$('.hostlistdetail_setting li').prepend(folder_close);
	$('.hostlistdetail_setting ul li ul li').each(function(){
		$(this).find('.folder_close').remove();
		$(this).prepend(sheet);
	});

	$('li').on('click','span',function(){
		if($(this).siblings('img').hasClass('folder_open')){
			$(this).siblings('ul').addClass('test_height');
			$(this).parent('li').prepend(folder_close);
			$(this).parent('li').find('.folder_open').remove();
		}else if($(this).siblings('img').hasClass('folder_close')){
			$(this).siblings('ul').removeClass('test_height');
			$(this).parent('li').prepend(folder_open);
			$(this).parent('li').find('.folder_close').remove();
		}
	})
})