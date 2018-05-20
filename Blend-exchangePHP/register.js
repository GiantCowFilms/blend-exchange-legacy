var errorTimeout;

var errorElementTimeout;

function showError(text, elm) {
    $("#registerFormError").html(text);

    $("#registerFormError").insertBefore(elm);

    $(elm).removeClass("txtBlueError")
    //Delay is needed for reset due to a "bug?"
    setTimeout(function () { $(elm).addClass("txtBlueError") }, 10);

    $("#registerFormError").show();
    clearTimeout(errorElementTimeout);
    errorElementTimeout = setTimeout(function () {
        $("#registerFormError").hide();
    }, 8000);
}

function registerUser() {
    //How to read a form like a pro: use a loop to cycle through each...
    var formData = [];
    $('#registerForm input').each(function () {
        if ($(this).is(':checkbox')) {
            var value = $(this).is(":checked");
        } else {
            var value = $(this).val();
        }
        var name = $(this).attr('id');
        formData.push({ 
            name: name,
            value: value
        });
    });
    //Check against this... maybe /^[a-z0-9_\-!@#$%\^&]{5,20}$/

    //Make a data object
    var loginData = {};
    formData.forEach(function (elm,index) {
        loginData[elm.name] = elm.value;
    });
    //Hash the password
    loginData.password = CryptoJS.SHA256(loginData.password).toString();
    loginData.confirmPassword = CryptoJS.SHA256(loginData.confirmPassword).toString()

    console.log(loginData);

    $.ajax({
        url: "/users/register",
        type: "get",
        success: function (result) {
            //Parse the message
            message = JSON.parse(result);
            //Check if logged in
            if (message.status == 1) {
                location.reload();
            } else {
                showError(message.message, $('#' + message.field));
            }
        },
        data: loginData
    });
};

//Click event to login user
$(document).on("click", '#register', registerUser);