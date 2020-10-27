import $ from "jquery";
$('.foodSearchImg').hide();
var searchedDiv=$('#searchedfood');
var searchedId=null;
var box = document.getElementById('searchbox');


$(document).ready(function(){

    box.addEventListener('input', function (){
        var text = box.value;
        if (text===""){
            searchedDiv.hide();
            $('.describe').hide();
        }else {
            $('.describe').show();
            searchedDiv.show();
            searchFood(text);
        }
    });
})

function searchFood(text){

        $.ajax({
                url:        'food/search',
                type:       'POST',
            // dataType: 'json',
            async:false,

            data:{
                search: text
            },
                success: function (data) {


                    for(var i=0; i<data.length;i++) {
                        var food = data[i];
                        for (var foods in food) {
                            var image = food.image;
                            var id = food.id;
                            var name = food.name;
                            var price= food.price;

                            findSearched(image, id, name, price);
                        }
                    }
                },
                error : function (xhr, textStatus, errorThrown) {

                    findSearched(false, false, false, false);
                }
            }
        )
}

function findSearched(image, id, name, price) {

    searchedId = image;
    var url='/uploads/'+searchedId;


    if (id===false) {
        $('.foodSearchImg').remove();
        $('.describe').show().html('Nie znaleziono produktu');

    } else {

        var e=$('<img class="foodSearchImg">'

        );

        $('#searchedfood').children().remove();
        $('#searchedfood').append(e);
        e.data('id', id);
        e.attr({
            src: url,
            id:id,
        });
        $('.name').html(''+name);
        $('.price').html(''+price+' zł');

    }
}








