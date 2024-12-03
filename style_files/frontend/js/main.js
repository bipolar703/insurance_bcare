
/*   first slider in home  */

$(document).ready(function () {
    $('.main_slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        dotsClass: 'custom-dots',
        autoplay: true,
        autoplaySpeed: 2000,
        customPaging: function (slider, i) {
            // Display only 4 dots
            if (i < 4) {
                return '<span class="dot"></span>';
            }
            return '';
        },
    });

    // Set the active class on the first dot by default
    $('.custom-dots .dot').eq(0).addClass('active');

    $('.custom-dots .dot').on('click', function () {
        $('.custom-dots .dot').removeClass('active');
        $(this).addClass('active');
    });

    $('.main_slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        $('.custom-dots .dot').removeClass('active');
        $('.custom-dots .dot').eq(nextSlide).addClass('active');
    });

});

/*   first slider in home  */







/*  main manu script  */
$(document).ready(function () {
    // Initialize the Slick slider on the first tab
    $('.tab-content #tab1 .cars_slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500,
    });

    $('#myTabs1 a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var targetTabId = $(e.target).attr('href');
        $(targetTabId + ' .cars_slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 1500,
        });
    });

    $('#myTabs1 .nav-item:first-child a[data-toggle="tab"]').tab('show');
});








// $(document).ready(function () {

//     $('.slider-for').slick({
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         arrows: false,
//         draggable: false,
//         autoplay: false,
//         //   fade: true,
//         asNavFor: '.slider-nav',
//         responsive: [{
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1,
//                 arrows: true,
//             }
//         }]
//     });
//     $('.slider-nav').slick({
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         asNavFor: '.slider-for',
//         //   dots: true,
//         //   centerMode: true,
//         focusOnSelect: true,


//         arrows: false,
//         draggable: false,
//         autoplay: false,
//         responsive: [{
//             breakpoint: 768,
//             settings: {
//                 slidesToShow: 2,
//             }
//         },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1,
//             }
//         }
//         ]
//     });

// });










$(document).ready(function () {
    $('.componies_wrapper').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: true,
        arrows: false,
        dotsClass: 'custom-dots',
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [


            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true
                }
            },


            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                }
            }
        ],
        customPaging: function (slider, i) {
            // Display only 4 dots
            if (i < 4) {
                return '<span class="dot"></span>';
            }
            return '';
        },

    });
});



//  $(document).ready(function () {

//  $('.responsive').slick({
//   dots: true,
//   infinite: false,
//   speed: 300,
//   slidesToShow: 4,
//   slidesToScroll: 4,
//   responsive: [
//     {
//       breakpoint: 1024,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 3,
//         infinite: true,
//         dots: true
//       }
//     },
//     {
//       breakpoint: 600,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//     // You can unslick at a given breakpoint now by adding:
//     // settings: "unslick"
//     // instead of a settings object
//   ]
// });




//  });









/************* tasks script **************/
$(document).ready(function() {
    $('.listBtn').click(function() {
        // Remove the 'active' class from all buttons
        $('.listBtn').removeClass('active');
        
        // Add the 'active' class only to the clicked button
        $(this).addClass('active');
    });
});

/************* tasks script **************/

