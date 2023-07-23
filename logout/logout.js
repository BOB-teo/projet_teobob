function UserIsConnected() {
    const isLoggedIn = localStorage.getItem("user");
    console.log(isLoggedIn);
    if (isLoggedIn === null) {
        return false;
    } else {
        return true;
    }
}

$("#btnlogin").ready( () => {
     if (UserIsConnected()) {
       $("#btnlogin").text("Déconnexion");
    }
});

console.log(UserIsConnected());

$("#btnlogin").click( () => {
    if (UserIsConnected()) {
        $("#btnlogin").removeAttr("href");
        $("#btnlogin").text("Connexion");
        $.ajax({
            url: "../php/logout.php",
            type: "GET",
            dataType: "json",
            success: () => {
                localStorage.removeItem("user");
            }
        });
        UserIsConnected();
        console.log(UserIsConnected()); 
    }
    else { 
        $("#btnlogin").attr("href", "../login/login.html");
    };
});
