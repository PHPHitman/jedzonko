import $ from "jquery";
import {swap} from "./SwapDivs";
import {deleteCompany, deleteOn} from "./companyAction";
var madeOrderStatus='';
var productsArray= [];
var madeOrderArray=[];
var deleteFromMade= [];
var productsPrice=0;
var orderMade=null;

var active = $('.orders').hide();
var edit = $('.sidebar').hide();



$(document).ready(function(){

    //
    //
    // const inputYML = 'input.yml';
    // const outputJSON = 'output.json';
    // const yaml = require('js-yaml');
    // const fs = require('fs');
    // const obj = yaml.load(fs.readFileSync(inputYML, {encoding: 'utf-8'}));
    //
    // console.table(obj);
    checkIfOrderExist();

//delete product from order list
    $(document).on('click', '.delete', function(){

        var id = $(this).parent().attr('id');
        var price=$(this).parent().parent().data('price');
        var row = document.getElementById(id);
        $(row).remove();

        deleteProductFromArray(id);
        productsPrice-=price;
        updatePrice();

        console.table()
    });

    $(document).on('click', '.delete_made', function(){

            var id = $(this).parent();
            var price=$(this).parent().parent().data('price');
             productsPrice-=price;

            putIdIntoDeleteProduct(id);

            var attr=id.attr('id');
            var row = document.getElementById(attr);
            $(row).remove();

            updatePrice();




    });

});

function getTranslation(){
    $.ajax({
            url: '/translation',
            type: 'POST',
        success: function (data) {

                alert(data)

            console.log(data['json']);
    },
    error : function (xhr, textStatus, errorThrown) {
        alert(textStatus);
    }
    }
    )
}


function updatePrice(){
    document.getElementById("total_price").innerHTML = productsPrice+' zł';
}
function displayElements($status){

    madeOrderArray=[];
    if ($status) {

        $(document).on('click','#edit_btn', function () {

            $('.sidebar').show();
            for (var i = 0; i < madeOrderArray.length; i++) {
                var product = madeOrderArray[i].id;

                addMadeProductsIntoOrder(product);

            }
            displayElements(false);

        });

        $('.delete_all').on('click', function(event){

            event.preventDefault();
            event.stopImmediatePropagation();
            deleteAllFromOrder();
        });


        displayMadeOrders();




        if(!(madeOrderStatus=='niedostarczone')) {
            $('#edit_btn').hide();
        }
    } else {

        $('.orders').hide();


        $(document).on('click', '.picture', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();


                $('.sidebar').show();

                addProductIntoOrder($(this));

                deleteCompany($(this));

        });


        $(document).on('click', '.foodSearchImg', function(){
            $('.sidebar').show();
            addProductIntoOrder($(this));
        });

        $("#submit").off().on("click", function (event) {
            $('.sidebar').remove("slow");
            sendIdArray();
            productsPrice=0;
        });



    }
}

function checkIfOrderExist(){

    $.ajax({
        url:        '/{_locale}/food/check',
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
export function addProductIntoOrder($product){

    var id = $product.attr('id');

    //check if product is already on list
    if (!(checkIfProductsInArray(id))) {


    }

        $.ajax({
                url: '/{_locale}/food/add',
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
                        var price = food['price'];

                        var e = $('<tr>' +
                            '<td><span id="name"></span></td>' +
                            '<td><span id="price">zł</span></td>' +
                            '<td id="delete">' +
                            '<button class="btn btn-danger btn-sm delete">'+
                                'X</button></td>' +
                            '</tr>');

                        $('#table').append(e);
                        e.attr('id', id);
                        e.attr({
                            'data-price':price});

                        $('#delete').attr('id', id);



                        $('#name', e).append().html(food['name']);
                        $('#price', e).append().html(price+ ' zł');

                        productsPrice+=price;
                        updatePrice();




                        // $('#product').append(e);
                    }
                    putIdIntoArray(id);

                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Ajax request failed.');
                },
            },
        )
    return false;

}




function deleteProductFromArray($productId) {
    var index = productsArray.findIndex(function (food) {
        return food.id ==$productId
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

function putIdIntoMadeOrderArray($id){
    madeOrderArray.push({
        "id": $id,
    });
}
function putIdIntoDeleteProduct($id){

    var data= $id.data('product_id')
    deleteFromMade.push({
        "id": data,
    });
}




//send order array if submit
function sendIdArray() {

    $.ajax({
        url:        '/{_locale}/food/save',
        type:       'POST',
        async:false,
        data: {
            array: JSON.stringify(productsArray),
            deleteArray: JSON.stringify(deleteFromMade)
        },
        success: function (data) {
            alert('Zamówienie zostało złożone');
            $('#table').children().remove();
        },
        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
    
productsArray=[];
madeOrderArray=[];

checkIfOrderExist();
}


//display order made by user
function displayMadeOrders() {
    madeOrderArray=[];

    $('#orders').children().remove();
    $.ajax({
        url:        '/{_locale}/food/show',
        type:       'POST',
        dataType:   'json',
        async:false,
        headers: { "cache-control": "no-cache" },

        success: function (data, status) {


            for (var i = 0; i < data.length; i++) {
               var food = data[i];
               var id=food.id;
               var orderStatus = food.status;



                if(i===data.length-1){
                    var e=$(
                        '<tr class="table-info">' +
                            '<td><span><section>{%trans%}</section>Podsumowanie<section>{%endtrans%}</section></span></td>'+
                            '<td><span id="total_price"></span></td>'+
                        '</tr>'+
                        '<tr class="status">' +
                            '<td><span>Status</span></td>'+
                            '<td><span id="status"></span></td>'+
                        '</tr>'+
                        '<tr>' +
                             '<td><span>Firma</span></td>'+
                             '<td><span id="company_order"></span></td>'+
                        '</tr>'

                    );
                    $('#orders').append(e);
                    $('#total_price', e).append().html(food['total_price']+'zł');

                    $('#status', e).append().html(orderStatus);
                    $('#company_order', e).append().html(food.company);
                    madeOrderStatus=orderStatus;


                }

                else {

                    var e = $('<tr id="product">' +
                        '<td><span id="food_name"></span></td>' +
                        '<td><span id="food_price"></span></td>' +
                        '</tr>');

                    $('#orders').append(e);
                    // e.attr('id', id);
                    $("#product").attr('id', id);
                    $("#delete_product").attr('id', id);


                    $('#food_name', e).append().html(food['product']);
                    $('#food_price', e).append().html(food['price'] + 'zł');

                    putIdIntoMadeOrderArray(id);
                }
            }

        },

        error : function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
    $('.sidebar').hide();
    $('.orders').show("slow");
    // document.getElementById("delete_all").addEventListener("click", clickHandler);

}

//check if order exist and set status
function setStatus($isExist){
    orderMade=$isExist;
}

//delete all from Order
function deleteAllFromOrder(){
    $.ajax({
        url: '/{_locale}/order/delete/all',
        type: 'POST',
        async:false,

        success: function (data) {
            alert('Zamówienie zostało usunięte');

        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus);
        }
    })
    madeOrderArray=[];



    $('.orders').hide();
    setStatus(false);


}


function checkIfProductsInArray(idElement) {

    var exist =false;

    for (var i = 0; i < productsArray.length; i++) {
        var product = productsArray[i];
        if(product.id===idElement){
            exist=true;
        }
    }

    for (var i = 0; i < madeOrderArray.length; i++) {
        var food = madeOrderArray[i];
        if(food.id===idElement){
            exist=true;
        }
    }

    return exist;
}

function addMadeProductsIntoOrder(product){
    var id = product;


        $.ajax({
                url: '/{_locale}/food/add',
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
                        var productId=food.id;
                        var price=food['price'];

                        var e = $('<tr>' +
                            '<td><span id="name"></span></td>' +
                            '<td><span id="price">zł</span></td>' +
                            '<td id="delete"><button class="btn btn-danger delete_made">' +
                            'X</button></td>' +
                            '</tr>');

                        $('#table').append(e);
                        e.attr('id', id);
                        e.attr({
                            'data-price':price});
                        $("#delete").data('product_id', id);
                        $("#delete").attr('id', id);

                        $('#name', e).append().html(food['name']);
                        $('#price', e).append().html(price +' zł');
                        // $('#product').append(e);
                        productsPrice+=price;

                        updatePrice();



                    }



                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Ajax request failed.');
                },
            },
        )

}

