import $ from "jquery";


$(document).ready(function () {




    $(document).on('click','#btn_add_company', function () {


        var companyField = document.getElementById("company_name");
        var phoneField = document.getElementById("company_phone");

        var company=companyField.value;
        var phone = phoneField.value;

            addCompany(company, phone);

    })


});


function addCompany(company, phone){


    $.ajax({
        url: '/{_locale}/company/add',
        type: 'POST',

        data: {
            company: company,
            phone:phone,

        },

        success: function (data) {
            alert(data)
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(data);
        }
    })
}

export function deleteCompany(companyId){


    $.ajax({
        url: '/{_locale}/company/delete',
        type: 'POST',

        data: {
            company: companyId,
        },

        success: function (data) {
            alert(data)
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(data);
        }
    })
}


