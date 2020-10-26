import $ from "jquery";

$(document).ready(function(){

displayOrders();




});

$(document).on('click', '.status_pending', function() {
    changeStatus($(this), 'w trakcie');
});

$(document).on('click','.status_delivered', function(){
    changeStatus($(this), 'dostarczone');

});

function displayOrders(){
    $.ajax(
        {
            url: '/order/made',
            type: 'POST',
            async: false,
            dataType: 'json',

            success: function (data) {

                var user=data[i];
                var insertUser;
                var insertPrice=null;
                var status;
                var products;
                var price;
                var totalPrice=0;


                for (var i = 0; i < data.length; i++) {

                    var order = data[i];
                    totalPrice+=order['price'];
                    var id=order['id'];


                    if(user===order['user']) {


                    }else{
                        user=order['user'];
                        insertUser=order['user'];
                        status=order['status'];

                    var e = $('<tr id="info">' +
                        '<td><span class="user"></span></td>' +
                        '<td></td>' +
                        // '<td><span id="total"></span></td>' +
                        '<td>'+
                        '<td><span class="status"></span></td>' +
                        '<td>'+
                                '<button class="status_pending" id="pending" >W trakcie</button>'+
                                '<button  class="status_delivered" id="delivered" >Dostarczone</button>'+
                    '</td>'+
                        '</tr>');


                    $('#user_orders').append(e);



                    $('.user', e).append().html(user);
                    $('.status', e).append().html(order['status']);
                    $('#delivered').attr('id', id);
                    $('#pending').attr('id',id);
                    $("#info").attr('id', order.user);

                    user = order['user'];
                    }

                        var e = $('<tr>' +
                            '<td><span></span></td>' +
                            '<td><span class="product"></span></td>' +
                            '<td><span class="price"></span></td>' +
                            '<td></td>'+
                            '</tr>');

                        $('#user_orders').append(e);


                        $('.product', e).append().html(order['product']);
                        $('.price', e).append().html(order['price']);

                }

            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
            }
        }
    )

}

var changeStatus = function changeStatus(div, status){
    var id= $(div).parent().parent().attr('id');
    alert(id);
    $.ajax(
        {
            url: '/order/status',
            type: 'POST',
            async: false,
            data: {
                id:id,
                status:status
            },

            success: function (data) {


            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
            }
        }
    )
}
