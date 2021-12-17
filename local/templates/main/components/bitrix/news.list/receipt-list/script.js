$(function () {

	if ($(window).width() <= 1024) {
		$('.main-receipts-list .receipt-list')
			.addClass('owl-carousel')
			.owlCarousel({
				items: 2,
				dots: false,
				nav: true,
				navSpeed: 500,
				margin: 10,
				responsive: {
                    0: {
                    	items: 1,
                        nav: false,
                        dots: true,
                        dotSpeed: 500
					},
					576: {
                    	items: 2,
                        nav: false,
                        dots: true,
                        dotSpeed: 500
                    },
                    768: {items: 2}
				}
			})
	}

})