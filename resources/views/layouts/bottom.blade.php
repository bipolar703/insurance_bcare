    <!-- JQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    {{-- Bootstrap 5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <!-- Fancy Box -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="{{ asset('style_files/frontend/js/slick.js') }}" type="text/javascript" charset="utf-8"></script>

    {{-- Animate On Scroll Library --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <script src="{{ asset('style_files/frontend/js/three.min.js') }}"></script>
    <script src="{{ asset('style_files/frontend/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('style_files/frontend/js/menu.js') }}" type="text/javascript"></script>

    <script>
        $('[data-fancybox]').fancybox({
            buttons: ['close'],
            wheel: false,
            transitionEffect: "slide",
            loop: true,
            toolbar: false,
            clickContent: false
        });

        //hero slider
        $('.heroSlider').slick({
            infinite: false,
            dots: true,
        });

        //partner slider
        $('.partnersSlider').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>
    </body>
    </html>
