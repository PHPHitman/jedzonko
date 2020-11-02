import $ from "jquery";

$('.searchbox').hide();
$('.add_company').hide();
$('.users_order').hide();



$(document).ready(function(){

    $('#orders_nav').on('click', function(){
        $('.food_container, .users_order').toggle("slow");
        // swap(orders,active);
    })

    $('#nav_add_company').on('click', function(){
        $('.food_container, .add_company').toggle("slow");
        // swap(orders,active);
    })


    $('#search').click(function(){
        $('.searchbox').toggle("slow");

    })

});

export function swap(clicked,active){

    if(!(clicked===active)){

        active.hide("slow");
        clicked.show("slow");
    }

}