import $ from "jquery";

var arr= [];

$(document).ready(function(){

    $(".picture").on("click", function(event){
        addProductIntoOrder($(this));
        });

    $("#submit").on("click", function(event){
        sendIdArray();
    });

    $("#show").on("click",function(event){
        displayMadeOrders();
    });


});

//add product into order
function addProductIntoOrder($product){
    var id = $product.data('product_id');

    //check if product is already on list
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
                    array: JSON.stringify(arr)
                },
            //fetch sended data sended in controller request
                success: function(data, status) {
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
                    console.table(arr);
                },

                error : function (xhr, textStatus, errorThrown) {
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
    var index = arr.findIndex(function (person) {
        return person.id ==$productId
    });
    if (index > -1) {
        arr.splice(index, 1);
    }
}
//save id into order array
function putIdIntoArray($id){
    arr.push({
        "id": $id,
    });
}

//send order array if submit
function sendIdArray() {
    $.ajax({
        url:        '/food/collect',
        type:       'POST',
        data: {
            array: JSON.stringify(arr)
        },
        success: function (data) {
            alert(data);
        },
        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
}

//display accepted order

function displayMadeOrders() {


    $.ajax({
        url:        '/food/show',
        type:       'GET',
        dataType:   'json',
        data: {

        },
        success: function (data) {
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

                $('#name', e).append().html(food['id']);
                $('#price', e).append().html(food['name']);
                // $('#product').append(e);
            }
            putIdIntoArray(id);
            console.table(arr);
        },

        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
}