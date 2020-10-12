
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything


// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
import './styles/app.css';


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.


import $ from 'jquery';
import 'slick-carousel';

$('#plus').hide();
$(document).ready( function () {
    $('.food').slick({
        dots: true,
        infinite: true,
        speed: 600,
        slidesToShow: 4,
        slidesToScroll: 4,
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
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });


});








