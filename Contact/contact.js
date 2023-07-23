function UserIsConnected() {
    const isLoggedIn = localStorage.getItem("user");
    if (isLoggedIn === null) {
        return false;
    } else {
        return true;
    }
}

if (UserIsConnected()) {
    $("#hiddenifconnected").hide();
    $("#nom").removeAttr("required");
    $("#prenom").removeAttr("required");
    const isLoggedIn = localStorage.getItem("user");
    const email = JSON.parse(isLoggedIn).email;
    $("#email")[0].value = email;
    console.log("connected");
} else {
    $("#hiddenifconnected").show();
    $("#nom").attr("required", "required");
    $("#prenom").attr("required", "required");
    console.log("not connected");
}


$("form").submit(event => {
    event.preventDefault();
    $("#message").val('');

    if (UserIsConnected()) {
        $.ajax({
            url: "../php/contact.php",
            type: "POST",
            dataType: "json",
            data: {
                email: $("#email").val(),
                message: $("#message").val(),
                id
            },
            success: (res) => {
                console.log(res);
            }
        });
    } else {
        $.ajax({
            url: "../php/contact.php",
            type: "POST",
            dataType: "json",
            data: {
                nom: $("#nom").val(),
                prenom: $("#prenom").val,
                email: $("#email").val(),
                message: $("#message").val()
            },
            success: (res) => {
                console.log(res);
            }
        });
    }
});