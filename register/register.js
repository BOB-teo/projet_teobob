$("form").submit(event => { // A la soumission du formulaire
    event.preventDefault(); // J'empêche le comportement par défaut de l'événement. Ici la soumission du formulaire recharge la page

    $.ajax({
        url: "../php/register.php", // URL cible
        type: "POST", // Type de méthode de requête HTTP
        dataType: "json", // Type de réponse attendue
        data: { // Donnée(s) à envoyer s'il y en a
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            birthdate: $("#birthdate").val(),
            email: $("#email").val(),
            pwd: $("#password").val()
        },
        success: (res) => {
            //? Si la réponse est un succès alors
            if (res.success) window.location.replace("../login/login.html"); //? Je redirige vers la page de connexion
            else alert(res.error); //! J'affiche une boite de dialogue avec l'erreur //! J'affiche une boite de dialogue avec l'erreur
        }
    });
});