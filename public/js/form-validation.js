$(document).ready(function () {
    var firstname = $('.validate-input input[name="firstname"]');
    var lastname = $('.validate-input input[name="lastname"]');
    var email = $('.validate-input input[name="email"]');
    var mobile_number = $('.validate-input input[name="mobile_number"]');
    var city = $('.validate-input input[name="city"]');

    // Input validation conditions
    $(".formValidate").submit(function () {
        var check = true;

        if ($(firstname).val().trim() == ""){
            alert(firstname);
            showValidate(firstname);
            check = false;
        } else {
            hideValidate(firstname);
        }

        if ($(lastname).val().trim() == ""){
            showValidate(lastname);
            check = false;
        } else {
            hideValidate(lastname);
        }

        if ($(city).val().trim() == ""){
            showValidate(email);
            check = false;
        } else {
            hideValidate(email);
        }

        if ($(email).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            showValidate(email);
            check = false;
        }else {
            hideValidate(email);
        }

        if ($(mobile_number).val().trim().match(/^[\+]?05[(]?[0-9]{1}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4}$/) == null) {
            showValidate(mobile_number);
            check = false;
        }else {
            hideValidate(mobile_number);
        }

        return check;
    });

    // // Hiding the alert after clicking on the field
    // $(".formValidate input").each(function () {
    //     $(this).focus(function () {
    //         hideValidate(this);
    //     });
    // });

    // showing the invalid alert
    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass("validateAlert");
        // $(thisAlert).removeClass("validateAlert2");
    }

    // Showing the valid alert
    // function showValid(input) {
    //     var thisAlert = $(input).parent();
    //
    //     $(thisAlert).addClass("validateAlert2");
    // }

    // Hiding the invalid alert
    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass("validateAlert");
    }
});
