import $ from "jquery";
import {slick} from "./slick";

$(document).ready(function (){

    $('.category_card').one('click', function () {
        var id = $(this).attr('id');
        selectProductsWithCategory(id);
        alert('klik');

    })

});

function selectProductsWithCategory(company){
    $.ajax({
            url:        'food/category',
            type:       'POST',

        data:{
            company:company,

        },

            success: function (data) {


            //     var e=$('<section class="food"></section>');
            // $('.content').append(e)
                for(var i=0; i<data.length; i++){
                    var product = data[i];
                    var id=product.id;
                    var name=product.name;
                    var price = product.price;
                    var category =product.catName;
                    var image = product.image;

                    var e=$('<div class="product">'+
                                '<div>'+
                                    '<div class="img">'+
                                        '<img class="picture" id="card">'+
                                         '<span id="name"></span><br/>'+
                                         '<span id="price"></span>'+
                                    '</div>'+

                                '</div>'+
                            '</div>')

                    $('.content').find('#'+category).append(e);
                    $('#card').attr({
                        src:'/uploads/'+image,
                        class:'picture',
                        id:id,

                    }).data({
                        product_id:id,
                                });

                    $('#card').parent().data('price',price)

                        $('#name',e).append().html(name);
                        $('#price',e).append().html(price+' zł');


                }
                slick();

            },
            error : function (xhr, textStatus, errorThrown) {
            alert(data);
            }
        }
    )
}