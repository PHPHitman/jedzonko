import $ from "jquery";
import {deleteCompany} from "./companyAction";



var deleteOn=false;
export var currentCompany=null;


$(document).on('click', '#nav_delete_company', function(){
    deleteOn=true;
})

$(document).ready(function (){

    selectProductsByCompany('Rzeszowskie kulinaria');

    $('.category_card').on('click', function () {
        var companyId = $(this).attr('id');


        if(!deleteOn) {

            $('.food').remove();
            selectProductsByCompany(companyId);
        }else{

            var r = confirm("Usunąć firmę?");
            if (r == true) {
                deleteCompany(companyId);
                alert('Firma została usunięta')
            }

    debugger

        }
    })

});

function selectProductsByCompany(company){

    document.getElementById("company_label").innerHTML = company;
    currentCompany = company;

    $.ajax({
            url:        '/{_locale}/food/category',
            type:       'POST',

        data:{
            company:company,

        },

            success: function (data) {
            if(!data){

            }


        var foodCategory='';
                for(var i=0; i<data.length; i++){


                    var product = data[i];
                    var id=product.id;
                    var name=product.name;
                    var price = product.price;
                    var category =product.catName;
                    var image = product.image;


                        var e = $(
                            '<section class="food">'+
                            '<div>'+

                                     '<img id="card">'+
                                      '<span id="name"></span>'+
                                       '<span id="price"></span>'+

                            '</div>'+
                            '</section>'

                        )

                        $('.content').append(e);
                        e.attr('id',category);

                    $('#card').attr({
                        src:'/uploads/'+image,
                        class:'picture',
                        id:id,

                    }).data({
                        product_id:id,
                                });

                    // $('#card').parent().data('price',price)
                        $('#name',e).append().html(product['name']);
                        $('#price',e).append().html(''+price+' zł');

                    // $('.slider').slick('slickRemove', $('.slick-slide').index(this) - 1);


                }
                // document.getElementById('content').style.width = '0px';


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