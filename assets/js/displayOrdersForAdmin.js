import $ from "jquery";


$(document).ready(function(){


displayOrders();


});

$(document).on('click', '.status_pending', function() {
    changeStatus($(this), 'w trakcie');
    var status=document.getElementById("status").innerHTML="hhh"


});

$(document).on('click','.status_delivered', function(){
    changeStatus($(this), 'dostarczone');
    var status = $(this).parent().find(".status");
    status.append().html("ukończono");

});

function displayOrders(){
    $.ajax(
        {
            url: '/{_locale}/order/made',
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


console.table(data);

                for (var i = 0; i < data.length; i++) {

                    var user= data[i];

                    var e = $('<tr class="bg-dark text-warning" id="info">' +
                        '<td><span class="user"></span></td>' +
                        '<td></td>' +

                        '<td><span id="total"></span></td>' +
                        '<td><span id="company"></span></td>'+

                        '<td><span class="status"></span></td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                        'Status </button>' +
                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                        '<a class="dropdown-item status_pending"id="pending" >W trakcie</a>' +
                        '<a class="dropdown-item status_delivered" id="delivered" href="#">Dostarczone</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        //     '<td>'+
                        //             '<button class="status_pending" id="pending" >W trakcie</button>'+
                        //             '<button  class="status_delivered" id="delivered" >Dostarczone</button>'+
                        // '</td>'+
                        '</tr>');


                    $('#user_orders').append(e);

                    $('.user', e).append().html(user['user']);
                    $('.status', e).append().html(user['status']);
                    $('#company', e).append().html(user['company']);


                    var totalPrice=0;

                    for (var j = 0; j < data[i].products.length; j++) {

                        var lastOne=data[i].products.length-1;

                        var order= data[i].products[j];
                        totalPrice+=order.price;



                            // totalPrice+=price;

                                var e = $('<tr>' +
                                    '<td><span></span></td>' +
                                    '<td><span class="product"></span></td>' +
                                    '<td><span class="price"></span></td>' +
                                    '<td></td>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                    '</tr>');

                                $('#user_orders').append(e);


                                $('.product', e).append().html(order['product']);
                                $('.price', e).append().html(order['price']);

                                if(j===lastOne){
                                    //Podsumowanie
                                    var f = $(


                                        '<tr class="table-info">' +
                                        '<td><span id="total">Podsumowanie</span></td>' +
                                        '<td></td>' +
                                        '<td><span id="total_price"></span></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>'
                                    );

                                    $('#admin_order_table').append(f);
                                    $('#total_price', f).append().html(totalPrice+' zł')
                                }
                        //
                        // $('#delivered').attr('id', order.user);
                        // $('#pending').attr('id', order.user);
                        // $("#info").attr('id', order.user);
                        //
                        // user = order['user'];

                    }










                }
                //     var order = data[j];
                //
                //     // var id=order['id'];
                //     // var price = order['price'];
                //
                //
                //
                //     if(!(user===order['user'] ) || i===0) {
                //
                //         user=order['user'];
                //         insertUser=order['user'];
                //         status=order['status'];
                //
                //
                //         if(!(i===0)||(i===(data.length-1))) {
                //             var f = $('<tr class="table-info">' +
                //                 '<td><span id="total">Podsumowanie</span></td>' +
                //                 '<td></td>' +
                //                 '<td><span id="total_price"></span></td>' +
                //                 '<td></td>' +
                //                 '<td></td>' +
                //                 '</tr>'
                //             );
                //
                //             $('#admin_order_table').append(f);
                //             $('#total_price', f).append().html(totalPrice+'zł')
                //         }
                //
                //
                //
                //     var e = $('<tr id="info">' +
                //         '<td><span class="user"></span></td>' +
                //
                //         '<td><span id="total"></span></td>' +
                //         '<td>'+
                //         '<td><span class="status"></span></td>' +
                //         '<td>'+
                //         '<div class="dropdown">'+
                //             '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                //                 'Status </button>'+
                //             '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'+
                //                 '<a class="dropdown-item status_pending"id="pending" >W trakcie</a>'+
                //                 '<a class="dropdown-item status_delivered" id="delivered" href="#">Dostarczone</a>'+
                //             '</div>'+
                //         '</div>'+
                //         '</td>'+
                //     //     '<td>'+
                //     //             '<button class="status_pending" id="pending" >W trakcie</button>'+
                //     //             '<button  class="status_delivered" id="delivered" >Dostarczone</button>'+
                //     // '</td>'+
                //         '</tr>');
                //
                //
                //     $('#user_orders').append(e);
                //
                //
                //
                //     $('.user', e).append().html(user);
                //     $('.status', e).append().html(order['status']);
                //
                //     $('#delivered').attr('id', order.user);
                //     $('#pending').attr('id',order.user);
                //     $("#info").attr('id', order.user);
                //
                //     user = order['user'];
                    // }
                //
                //     totalPrice+=price;
                //
                //         var e = $('<tr>' +
                //             '<td><span></span></td>' +
                //             '<td><span class="product"></span></td>' +
                //             '<td><span class="price"></span></td>' +
                //             '<td></td>'+
                //             '<td></td>'+
                //             '</tr>');
                //
                //         $('#user_orders').append(e);
                //
                //
                //         $('.product', e).append().html(order['product']);
                //         $('.price', e).append().html(order['price']);
                //
                // }


            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
            }
        }
    )

}

var changeStatus = function changeStatus(div, status){
    var id= $(div).attr('id');


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
            status=true;

            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
            }
        }
    )

}
