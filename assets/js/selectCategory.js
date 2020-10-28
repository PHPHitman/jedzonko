import $ from "jquery";
import {slick} from "./slick";

var currentCompany=null;
$(document).ready(function (){

    $('.category_card').on('click', function () {

        var companyId = $(this).attr('id');
            if(currentCompany!==companyId) {

                selectProductsByCompany(companyId);
                currentCompany = companyId;
            }

    })

});

function selectProductsByCompany(company){


    $.ajax({
            url:        'food/category',
            type:       'POST',

        data:{
            company:company,

        },

            success: function (data) {


$(".food").remove();


            //     var e=$('<section class="food"></section>');
            // $('.content').append(e)
        var foodCategory='';
                for(var i=0; i<data.length; i++){


                    var product = data[i];
                    var id=product.id;
                    var name=product.name;
                    var price = product.price;
                    var category =product.catName;
                    var image = product.image;


                        var e = $(
                            // '<section class="food">'+
                        //     '<div>'+
                        //         '<div>'+
                                     '<img id="card">'+
                                      // '<span id="name"></span><br/>'+
                                      //  '<span id="price"></span>'
                            //     '</div>'+
                            // '</div>'+
                            // '</section>'

                        )

                        $('#picture').append(e);
                        e.attr('id',category);

                    $('#card').attr({
                        src:'/uploads/'+image,
                        class:'picture',
                        id:id,

                    }).data({
                        product_id:id,
                                });

                    // $('#card').parent().data('price',price)

                        $('#name',e).append().html(name);
                        $('#price',e).append().html(price+' zł');

                    // $('.slider').slick('slickRemove', $('.slick-slide').index(this) - 1);
                    slick();

                }
                // document.getElementById('content').style.width = '0px';
                slick();

            },
            error : function (xhr, textStatus, errorThrown) {
            alert(data);
            }
        }
    )
}

function removeNodes(){
    const parent = document.getElementById("dania")
    while (parent.firstChild) {
        parent.firstChild.remove();
    }
    $('#dania').load(document.URL +  ' #dania');
    return true;
}