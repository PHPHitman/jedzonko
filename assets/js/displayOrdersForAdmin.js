import $ from "jquery";

$(document).ready(function(){
    $('.delete').show();
displayOrders();
    document.getElementById("edit_btn").addEventListener("click", editOrder);

});

function displayOrders(){
    $.ajax(
        {
            url: '/order/made',
            type: 'POST',
            async: false,
            dataType: 'json',

            success: function (data) {

                var user;
                var insertUser;
                var insertPrice=null;
                var status;
                var products;
                var price;
                var totalPrice=0;


                for (var i = 0; i < data.length; i++) {

                    var order = data[i];


                    if(user===order['user']) {
                        insertUser='';
                        status=''

                    }else{
                        user=order['user'];
                        insertUser=order['user'];
                        status=order['status'];
                        totalPrice+=order['price'];
                        

                    }



                    // if(name===order['user']) {
                    //     insertName='';
                    //     status='';
                    // }else{
                    //     name=order['user'];
                    //     insertName=order['user'];
                    //     status=order['status'];
                    // }

                        console.table(data[i]);
                        var e = $('<tr>' +
                            '<td><span class="name"></span></td>' +
                            '<td><span class="product"></span></td>' +
                            '<td><span class="price"></span></td>' +
                            '<td><span class="status"></span></td>' +

                            '</tr>');

                        $('#user_orders').append(e);


                        $('.name', e).append().html(insertUser);
                        $('.product', e).append().html(products);
                        $('.price', e).append().html(price);
                        $('.status', e).append().html(status);


                }

            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
            }
        }
    )
}

var editOrder = function editOrder(){

    $('.delete').show();
    $('#edit_btn').hide();
}

function deleteProductFromOrder(){
    $.ajax(
        {
            url: '/order/delete',
            type: 'POST',
            async: false,
            dataType: 'json',

            success: function (data) {
                alert(data);

            }
        })
}