function deleteArticle(id, img) {
     $.ajax({
         url: "../../../php/admin/manage_produits.php",
         type: "POST",
         dataType: "json",
         data: {
             choice: "delete",
             id,
             img
         },
         success: () => {
             $("#plouf" + id).remove();
         }
     });
}



function AfficherProduits() {
    $.ajax({
        url: "../../../php/admin/manage_produits.php",
        type: "GET",
        dataType: "json",
        data: {
            choice: "select"
        },
        success: function(res) {
            res.produits.forEach(function(product) {

            const tr = $("<tr></tr>").attr("id", `plouf${product.id_product}`).html(   // Template literals
                `<td>${product.product_name}</td>
                <td><img src='../../../img/${product.product_image}' alt='' class='img-fluid w-50'></td>
                <td>${product.product_description}</td>
                <td>${product.product_price} €</td>`
                );


            const btn_update = $("<button></button>").attr("id", `${product.id_product}`).text("Modifier").addClass("btn btn-warning").click( ()=> {
                window.scrollTo(0,0);
                $("#update").show();
                $("#insert").hide();

                console.log(product.id_product);

                let id = product.id_product;
                id = $("#id").val(id);

                let old_img = product.product_image;
                old_img = $("#old_img").val(old_img);

                let name = product.product_name;
                name = $("#productName").val(name);

                let desc = product.product_description;
                desc = $("#productDescription").val(desc);

                let price = product.product_price;
                price = $("#productPrice").val(price);

                console.log(product.product_image);
            });

            const btn_delete = $("<button></button>").attr("id", `${product.id_product}`).text("Supprimer").addClass("btn btn-danger").click( ()=> {
                deleteArticle(product.id_product, product.product_image);
            });

            const td_update = $("<td></td>").append(btn_update);
            const td_delete = $("<td></td>").append(btn_delete);


            tr.append(td_update, td_delete);
            $("#plouf").append(tr);
            });
        }
    });
}

AfficherProduits();

$("#update").hide();


$("#insert").click(function(event) {
    event.preventDefault();

    const fd = new FormData();
    fd.append("choice", "insert");
    fd.append("name", $("#productName").val());
    fd.append("desc", $("#productDescription").val());
    fd.append("price", $("#productPrice").val());
    fd.append("img", $("#picture")[0].files[0]);

    $.ajax({
                url: "../../../php/admin/manage_produits.php",
                type: "POST",
                dataType: "json",
                contentType: false,
                processData: false,
                cache: false,
                data: fd,
                success: function() {
                    location.reload();
                }
            });
});


$("#update").click(function(event) {
    event.preventDefault();
    console.log("ko");
    console.log($("#picture")[0].files[0]);

    const fd = new FormData();
    fd.append("choice", "update");
    fd.append("name", $("#productName").val());
    fd.append("desc", $("#productDescription").val());
    fd.append("price", $("#productPrice").val());
    fd.append("id", $("#id").val());
    fd.append("img", $("#picture")[0].files[0]);
    fd.append("old_img", $("#old_img").val());
    $.ajax({
        url: "../../../php/admin/manage_produits.php",
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,
        data: fd,
        success: function() {
                    console.log("ok");
                    location.reload();
                    alert("Produit modifié avec succès");
                }
    });

});