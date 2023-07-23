$("form").submit((event) => { // A la soumission du formulaire
event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page

$.ajax({
    url: "../php/login.php",
    type: "POST",
    dataType: "json", 
    data: { 
        email: $("#email").val(),
        pwd: $("#password").val()
    },
    success: (res) => {
        if (res.success) { //? Si la réponse est un succès alors
            localStorage.setItem("user", JSON.stringify(res.user)); // J'ajoute mon utilisateur dans mon localStorage
            window.location.replace("../index/index.html"); // Je redirige mon utilisateur vers ma page d'accueil
        } else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur //! J'affiche une boite de dialogue avec l'erreur
    }
});
});
