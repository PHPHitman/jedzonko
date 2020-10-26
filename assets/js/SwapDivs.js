import $ from "jquery";


// var orders =$('.users_order').hide();
var food =$('.food_container').show();

// orders.hide();


$(document).ready(function(){

    $('#orders_nav').click(function(){
      orders.show();
        // swap(orders,active);
    })
    $('#search').click(function(){
        $('container').toggle('orders food');

    })

});

export function swap(clicked,active){

    if(!(clicked===active)){

        active.hide("slow");
        clicked.show("slow");
    }

}