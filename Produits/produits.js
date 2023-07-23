function addProduct() {
    $.ajax({
        url: "../php/produits.php",
        type: "GET",
        dataType: "json",
        success: function(res) {
            console.log(res.produits);
            res.produits.forEach(function(product) {

            const ctn = $("<div></div>");
            ctn.addClass("col-md-3 mt-5");
            ctn.attr("id", product.id_product); 
            
            const img = $("<img></img>");
            img.attr("src", "../img/" + product.product_image);
            img.attr("alt", product.name);
            img.addClass("img-fluid w-100 h-50");

            const name = $("<h3></h3>").text(product.product_name);

            const price = $("<p></p>").text(product.product_price);

            const desc = $("<p></p>").text(product.product_description);

            const main = $("<div></div>");

            main.append(ctn, img, name, price, desc);
            $("#plouf").append(main);
            });
        }
    });
}

addProduct();


const btn_admin = $("#btn_admin");
let isAdmin = localStorage.getItem("user");
isAdmin = JSON.parse(isAdmin);


if (isAdmin.admin === 0) {
    btn_admin.hide();
} else  {
    btn_admin.show();
}

console.log(isAdmin.admin);

$("#btn_admin").click(function() {
    window.location.replace("../")
});
