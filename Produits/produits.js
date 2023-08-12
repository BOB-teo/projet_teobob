const btn_admin = $("#btn_admin");
let isAdmin = localStorage.getItem("user");
isAdmin = JSON.parse(isAdmin);

console.log(isAdmin);

  
if (!localStorage.getItem("user") || isAdmin.admin === 0) {
     btn_admin.hide();
} else  {
    btn_admin.show();
}


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
            
            const img = $("<img></img>");
            img.attr("src", "../img/" + product.product_image);
            img.attr("alt", product.name);
            img.addClass("img-fluid w-100 h-50");

            const name = $("<h3></h3>").text(product.product_name); 

            const price = $("<p></p>").text(product.product_price + " €");

            const desc = $("<p></p").text(product.product_description);

            const main = $("<a></a>").attr("href", "product_id/product_id.html?id=" + product.id_product);
            main.addClass("text-decoration-none text-black");
            main.attr("id", product.id_product); 

            main.append(ctn, img, name, price, desc);
            $("#plouf").append(main);
            });
        }
    });
}

addProduct();