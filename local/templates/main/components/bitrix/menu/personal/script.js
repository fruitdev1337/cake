$(function () {

	$(document).on('click', '.lk__nav_item.current a', function (e) {
		e.preventDefault();
		$('.lk__nav').toggleClass('open');
    })

})