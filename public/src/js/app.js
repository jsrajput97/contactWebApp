var contactId = 0;
var nameElement = null;
var numberElement = null;

var notification = {
    'message' : 'Number is already saved',
    'alert-type' : 'error'
};

setTimeout(
        function(){$('.err')[0].className = $('.err')[0].className.replace("hidden", "showen");
            setTimeout(    function(){
                $('.err')[0].className = $('.err')[0].className.replace("showen", "hidden");
            },5000);
        },
        0
);


$('#gridlist_a').on('click', function () {
    $length = $('.mobile')[0].children.length;
    $length1 = $('.set_table_data1').length;
    if($('#grid_list')[0].className === "fa fa-th")
    {
        $('#grid_list')[0].className = $('#grid_list')[0].className.replace("fa-th" , "fa-list");
        $('#iconText').text("List");
        document.cookie = "tableData = " + "table_data";
        for($i = 0; $i < $length; $i++)
        {
            $('#table_data1')[0].id = "table_data";
        }

    }
    else
    {
        $('#grid_list')[0].className = $('#grid_list')[0].className.replace("fa-list" , "fa-th");
        document.cookie = "tableData = " + "table_data1";
        $('#iconText').text("Grid");
        for($i = 0; $i < $length; $i++)
        {
            $('#table_data')[0].id = "table_data1";
        }
    }
});

$('#changePassword').on('click',function () {

    $('#change_password').find('.modal-body').find('#currentpassword').val(null);
    $('.posts').find('.post').find('.change_password').find('#change_password').modal();
});

$('#conimport').on('click',function () {
    console.log('hlo');
    $('.posts').find('.post').find('.import_contacts').find('#import_contacts').modal();

});

$('.navbar').find('.navbar-header').find('a').eq(1).on('click', function () {


    $('.create_contact').find('.modal-body').find('#name').val(null);
    $('.create_contact').find('.modal-body').find('#number').val(null);

    $('.posts').find('.post').find('.create_contact').find('#addContact').modal('show');
});



$('#updateC').on('click',function () {

    var username = $('.update_contact').find('.modal-body').find('#uname').val();
    var usernumber = $('.update_contact').find('.modal-body').find('#unumber').val();
    if(username === "" || usernumber === "")
    {
        if(username === "")
        {
            notification.message = 'Name should not empty';
            showMessage(notification);

        }
        if(usernumber === "")
        {
            notification.message = 'Number should not empty';
            showMessage(notification);
        }
    }

    else if (username.length > 23)
    {
        notification.message = 'Name is too large';
        showMessage(notification);
    }

    else if(isNaN(usernumber) || usernumber.length < 10)
    {
        notification.message = 'Number is not valid';
        showMessage(notification);
        $('.update_contact').find('.modal-body').find('#unumber').focus();
    }

    else
    {
        $.ajax({
            method: 'POST',
            url: url,
            data: {name: $('#uname').val(), number: $('#unumber').val(), contactId: contactId, _token: token}
        })
            .done(function (msg) {

                //toastr.success('Messages in here', 'Title', ["positionClass" => "toast-top-center"]);
                //toastr.success('Messages in here');

                // console.log(msg['message']);
                showMessage(msg['message']);

                $(nameElement).text(msg['name']);
                $(numberElement).text(msg['number']);
                $('.posts').find('.post').find('.update_contact').find('#updateContact').modal('hide');
            });
    }
});

function showMessage(notification) {
    //console.log(notification['alert-type']);
    //return;
    var type = notification['alert-type'];
    var message = notification['message'];
    var option = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "showToast",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    switch(type){
        case 'info':
            toastr.info(message,'',option);
            break;

        case 'warning':
            toastr.warning(message,'',option);
            break;

        case 'success':
            toastr.success(message,'',option);
            break;

        case 'error':
            toastr.error(message,'',option);
            break;
    }
    return;
}
document.cookie = "cnames = "+"";
$('#search_contact').val(null);

document.getElementById('search_contact').oninput = function() {
    $tableData = getCookie("tableData");
    document.cookie = "cnames = " + $('#search_contact').val();
    $("#displaycontact").load(" #displaycontact > *");
    //$(".posts").load(" .posts > *");

    $length1 = $('.set_table_data1').length;
    if($tableData === "table_data")
    {
        $('#grid_list')[0].className = $('#grid_list')[0].className.replace("fa-th" , "fa-list");
        $('#iconText').text("List");
        for($i = 0; $i < $length1; $i++)
        {
            $('.set_table_data1')[0].id = "table_data";
        }
    }
    else
    {
        $('#grid_list')[0].className = $('#grid_list')[0].className.replace("fa-list" , "fa-th");
        $('#iconText').text("Grid");
        for($i = 0; $i < $length1; $i++)
        {
            $('.set_table_data1')[0].id = "table_data1";
        }
    }

   /* if($('#search_contact').val() === "") {
        $('#gridlist_div')[0].style.visibility = "visible";
        $('#grid_list')[0].className = $('#grid_list')[0].className.replace("fa-list" , "fa-th");
    }
    else
    {
        $('#gridlist_div')[0].style.visibility = "hidden";

    }*/

};
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
};


function editContacts(event) {

    event.preventDefault();

    nameElement = event.target.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[0];
    var name = nameElement.textContent;
    numberElement = event.target.parentNode.parentNode.childNodes[3];
    var number = numberElement.textContent;
    /** @namespace event.target.parentNode.parentNode.dataset */
    contactId = event.target.parentNode.parentNode.dataset['contactid'];

    $('.update_contact').find('.modal-body').find('#uname').val(name);
    $('.update_contact').find('.modal-body').find('#unumber').val(number);

    $('.posts').find('.post').find('.update_contact').find('#updateContact').modal();
}