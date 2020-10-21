import $ from "jquery";

var productsArray= [];
var orderMade=null;

$('.orders').hide();
$('.sidebar').hide();


$(document).ready(function(){

    checkIfOrderExist();

});

function displayElements($status){

    if ($status) {
        $('.delete_all').one('click', clickHandler);
        displayMadeOrders();
        // $('.orders').show();
        // $('.sidebar').hide();



    } else {

        $('.orders').hide();

        $(".picture").on("click", function (event) {
            $('.sidebar').show();
            addProductIntoOrder($(this));

        });

        $("#submit").off().on("click", function (event) {
            $('.sidebar').remove("slow");
            sendIdArray();
            updateDiv();



        });
    }

}

function checkIfOrderExist(){

    $.ajax({
        url:        'food/check',
        type:       'POST',
            async:false,

        success: function (data) {

            if(data==1) {
                displayElements(true);
            }
            else{
                displayElements(false);
            }
        },
        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }

    }

    )


}
//add product into order
function addProductIntoOrder($product){


    var id = $product.data('product_id');

    //check if product is already on list
    if (!$('#' + id).length) {


        $.ajax({
                url: '/food/add',
                type: 'POST',
                dataType: 'json',

                async: false,
                data: {
                    id: id,
                    array: JSON.stringify(productsArray)
                },
                //fetch sended data sended in controller request
                success: function (data, status) {
                    for (var i = 0; i < data.length; i++) {
                        var food = data[i];

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

                error: function (xhr, textStatus, errorThrown) {
                    alert('Ajax request failed.');
                },
            },
        );
    }

}

//delete product from order list
$(document).on('click', '.delete', function(){

    var id = $(this).parent().attr('id');
    var row = document.getElementById(id);
    $(row).remove();

    deleteProductFromArray(id);


});

//delete product from array
function deleteProductFromArray($productId) {
    var index = productsArray.findIndex(function (person) {
        return person.id ==$productId
    });
    if (index > -1) {
        productsArray.splice(index, 1);
    }
}

//save id into order array
function putIdIntoArray($id){
    productsArray.push({
        "id": $id,
    });
}

//send order array if submit
function sendIdArray() {


    $.ajax({
        url:        '/food/save',
        type:       'POST',
        async:false,
        data: {
            array: JSON.stringify(productsArray)
        },
        success: function (data) {

alert(data)


        },
        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
    $('#table').children().remove();
productsArray=[];
displayMadeOrders();
}

//display order made by user
function displayMadeOrders() {

    $('#orders').children().remove();
    $.ajax({
        url:        '/food/show',
        type:       'POST',
        dataType:   'json',
        async:false,
        headers: { "cache-control": "no-cache" },

        success: function (data, status) {


            for (var i = 0; i < data.length; i++) {
               var food = data[i];

                if(i===data.length-1){
                    var e=$('<tr class="table-info">' +
                        '<td><span id="total">Podsumowanie</span></td>'+
                        '<td><span id="total_price"></span></td>'+
                        '</tr>');
                    $('#orders').append(e);
                    $('#total_price', e).append().html(food['total_price']+'zł');
                }
                else {

                    var e = $('<tr id="product">' +
                        '<td><span id="food_name"></span></td>' +
                        '<td><span id="food_price"></span></td>' +
                        '<td id="delete_product"><button class="delete">USUN</button></td>' +
                        '</tr>');

                    $('#orders').append(e);
                    // e.attr('id', id);
                    $("#product").attr('id', food['id']);

                    $('#food_name', e).append().html(food['product']);
                    $('#food_price', e).append().html(food['price'] + 'zł');

                }


                // $('#product').append(e);
            }
            $('.delete').hide();
            console.table(productsArray);
        },

        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
    $('.sidebar').hide();
    $('.orders').show("slow");
    document.getElementById("delete_all").addEventListener("click", clickHandler);

}

//check if order exist and set status
function setStatus($isExist){
    orderMade=$isExist;
}

//delete all from Order
var clickHandler= function deleteAllFromOrder(){
    $.ajax({
        url: '/order/delete/all',
        type: 'POST',
        async:false,

        success: function (data) {
            alert(data);

        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })


    checkIfOrderExist();
    setStatus(false);


}

function updateDiv()
{
    $( "#table" ).load(window.location.href + " #table" );
}