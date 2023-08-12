function deleteArticle(cart_id) {
    if (confirm("Voulez-vous supprimer cet article ?")) {
        $.ajax({
            url: "../php/cart.php",
            type: "POST",
            dataType: "json",
            data: {
                choice: "delete",
                id: cart_id,
            },
            success: () => {
                window.location.reload();
                $("#plouf" + cart_id).remove();
            }
        });
    } else {
        console.log("Suppression annulée.");
        return false;
    }
}


function addProduct() {

    console.log("ok");

    const userString = localStorage.getItem('user');
    const user = JSON.parse(userString);
    const id_user = user.id;

    $.ajax({
        url: "../php/cart.php",
        type: "GET",
        dataType: "json",
        data: {
            choice: "select",
            id_user: id_user,
        },
        success: function(res) {
            res.produits.forEach(function(product) {
            console.log(res.produits);

            console.log("ko");

            const ctn = $("<div></div>");
            ctn.addClass("card-body");
            
            const img = $("<img></img>");
            img.attr("src", "../img/" + product.product_image);
            img.attr("alt", product.name);
            img.addClass("img-fluid w-25");

            const name = $("<h5></h5>").text(product.product_name);
            name.addClass("card-title");

            const price = $("<p></p>").text(product.product_price + " €");
            price.addClass("card-text");

            const main = $("<div></div>");
            main.addClass("card mb-3");

            const btn_delete = $("<button></button>").attr("id", `${product.cart_id}`);
            btn_delete.text("Supprimer").addClass("btn btn-danger").click( (event)=> {
                event.preventDefault();
                console.log("ok");
                deleteArticle(product.cart_id);
            });

            main.append(ctn, img, name, price, btn_delete);
            $("#plouf").append(main);
            });
        },
    });
}

addProduct();