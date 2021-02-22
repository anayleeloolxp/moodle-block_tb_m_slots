require(["jquery"],function($) {
    
    $(document).ready(function() {

        $('.tb_m_slots').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            autoplay: true,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    dots: false,
                    margin: 20
                }
            }
        });
    });    
});