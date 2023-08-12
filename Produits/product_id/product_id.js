function addProduct() {
    const urlParams = new URLSearchParams(window.location.search);

    const productId = urlParams.get('id');

    $.ajax({
        url: "../../php/product_id.php?id=" + productId,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res && res.produit_id && Array.isArray(res.produit_id)) {
                res.produit_id.map(function(product) {
                    const ctn = $("<div></div>");
                    ctn.addClass("col-md-6");
                    ctn.attr("id", product.id_product); 

                    const img = $("<img></img>");
                    img.attr("src", "../../img/" + product.product_image);
                    img.attr("alt", product.product_name);
                    img.addClass("img-fluid w-50 h-50");

                    const div = $("<div></div>");
                    div.addClass("col-md-6");
                    

                    const name = $("<h2></h2>").text(product.product_name); 

                    const price = $("<p></p>").text(product.product_price + " €");

                    // const desc = $("<p></p>").text(product.product_description);

                    const main = $("<div></div>").attr("href", "product_id/product_id.html");

                    div.append(name, price);
                    main.append(ctn, img, div);
                    $("#pluf").append(main);
                });
            } else {
                console.log("Invalid response format or produit_id is not an array.");
            }
        },
    });
}

addProduct();

$("#nbnarticle").hide();

$("#btnaddcart").click(function(event){
    event.preventDefault();

    const userString = localStorage.getItem('user');

    if (userString !== null) {
        const user = JSON.parse(userString);
        const id_user = user.id;

        console.log(id_user);

        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id'); 
        console.log(productId);

        $.ajax({
            url: "../../php/cart.php",
            type: "POST",
            dataType: "json",
            data: {
                choice: "insert",
                id_user: id_user,
                id_product: productId
            },
            success: function(res) {
                console.log(res);
                console.log("ok");

                let nombreArticles = parseInt($("#nbnarticle").text(), 10);
                nombreArticles++;
                console.log(nombreArticles);
                $("#nbnarticle").show();
                $("#nbnarticle").addClass("bg-white d-flex justify-content-center");
                $("#nbnarticle").text(nombreArticles);
            }, 
        })
    
    } else {
        alert("Veillez vous connecter pour profiter de ce service.");
        window.location.replace("../../login/login.html");
        return false;
    }
});





