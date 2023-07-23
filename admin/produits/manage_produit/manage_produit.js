function deleteArticle(id) {     
    $.ajax({
        url: "../../../php/admin/manage_produits.php", 
        type: "POST", 
        dataType: "json", 
        data: {
            choice: "delete",
            id
        },
        success: () => {
            $("#plouf" + id).remove(); 
        }
    });
}



function AfficherProduits() {
    $.ajax({
        url: "../../../php/admin/manage_produit.php",
        type: "GET",
        dataType: "json",
        success: function(res) {
            // console.log(res.produits);
            res.produits.forEach(function(product) {

            const ctn = $("<tbody></tbody>");
            ctn.addClass("w-100");
            ctn.attr("id", "plouf"); 

            const tr = $("<tr></tr>");

            const name = $("<td></td>").text(product.product_name);
            name.addClass("w-25");
            
            const img = $("<img>");
            img.attr("src", "../../../img/" + product.product_image);
            img.attr("alt", product.name);
            img.addClass("img-fluid w-100 h-50");

            const desc = $("<td></td>").text(product.product_description);

            const price = $("<td></td>").text(product.product_price);

            const btn_edit = $("<td><button></button></td>").text("Modifier");
            btn_edit.addClass("btn btn-primary");
            
            const btn_delete = $("<td><button></button></td>").text("Supprimer");
            btn_delete.addClass("btn btn-danger");
            btn_delete.attr("id", "btnb");

            $("#btnb").click( ()=> {
                deleteArticle(product.id_product);
            });

            tr.append(name, img, price, desc, btn_edit, btn_delete);
            ctn.append(tr);
            $("#plouf").append(ctn);
            });
        }
    });
}

AfficherProduits();





  



