'use strict';
{
	$(function () {
	// window.addEventListener('DOMContentLoaded', function () {
		var h = $(window).height();

		$('#loader-bg ,#loader').height(h).css('display', 'none');
		$('#wrap').css('display', 'block');
	});


	$(window).load(function () { //全ての読み込みが完了したら実行
		$('#loader-bg').delay(900).fadeOut(500);
		$('#loader').delay(600).fadeOut(400);
		$('#wrap').css('display', 'block');
	});

	//10秒たったら強制的にロード画面を非表示
	$(function () {
		setTimeout('stopload()', 10000);
	});

	// function stopload() {
	// 	$('#wrap').css('display', 'block');
	// 	$('#loader-bg').delay(900).fadeOut(800);
	// 	$('#loader').delay(600).fadeOut(300);
	// }

}
