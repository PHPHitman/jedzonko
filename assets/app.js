
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



var arr= [];



function putIdIntoArray($id){

        arr.push({
            "id":$id,
        });
}




$(document).ready(function(){
    $(".picture").on("click", function(event){

var id = $(this).data('product_id');
        // var value = $(this).data('value');

        // var ids = document.getElementById('picture').dataset.product_id;
        // var id = $('.picture').dataset.product_id;
            if ($('#' + id).length) {
                alert('Produkt już dodany');
            }
            else {
            $.ajax({
            url:        '/food/test',
            type:       'POST',
            dataType:   'json',
            data: {
                id: id,
                arr:JSON.stringify(arr)
            },
                success: function(data, status) {
                    // $('#food').append(e);

                        for (var i = 0; i < data.length; i++) {
                            var food = data[0];


                            var e = $('<tr>' +
                                '<td><span id="name"></span></td>' +
                                '<td><span id="price">zł</span></td>' +
                                '<td id="x"><button class="delete">USUN</button></td>' +
                                '</tr>');

                            $('#table').append(e);
                            e.attr('id', id);

                            $("#x").attr('id', id);

                            $('#name', e).append().html(food['name']);
                            $('#price', e).append().html(food['price']);
                            // $('#product').append(e);
                        }

                    putIdIntoArray(id);



                },

                    error : function (xhr, textStatus, errorThrown) {
                        alert('Ajax request failed.');
                    },



                 },

            );
}})});

function callFun() {


    $.ajax({

        url: '/food/collect',
        success: function (data) {
            alert(data);
        },
        error : function (xhr, textStatus, errorThrown) {
            alert('Nie wczytano funkcji');
        }
    })


}


//delete function
$(document).on('click', '.delete', function(){

    var id = $(this).parent().attr('id');

    var row = document.getElementById(id);

    $(row).remove();

});








