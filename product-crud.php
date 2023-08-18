<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmed!</title>

        <!-- ajax js ands jquery -->
        <script src="js/jquery.js"></script>

        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.css" />
</head>

<body>
        <nav class="navbar justify-content-end bg-light">
                <a class="nav-link px-3" href="home.php">Home</a>
                <a class="nav-link px-3" href="cart.php">Checkout</a>
                <a class="nav-link px-3 active" aria-current="page" href="#">Product Manager</a>
                <a class="nav-link px-3" href="stock_page.php">Stock</a>
                <a class="nav-link px-3" href="orders.php">All Orders</a>
                <a class="nav-link px-3" href="reports-page.php">Generate Report</a>
        </nav>

        <h1>Manage your products here!</h1>
        <button onclick="toggleAddProduct()" class="btn btn-success">Add Product</button>
      
        <p id="confirmer-box-products-crud"></p>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody id="tablerows-area-products-crud">
              
            </tbody>
        </table>
       

        <!-- Modal for adding new product -->
        <form action="javascript:void(0);" method="post" enctype="multipart/form-data" id="form-add-product">
            <div class="modal" tabindex="-1" id="add-product-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <p id="error-box-add-modal"></p>

                            <input type="hidden" name="action" value="add-product-crud">

                            <div class="form-group">
                                <label for="input-name-product-add">Product Name</label>
                                <input type="text" class="form-control" id="input-name-product-add" name="input-name-product-add" placeholder="Enter product name">
                            </div>
                            <div class="form-group">
                                <label for="input-description-product-add">Product Description</label>
                                <input type="text" class="form-control" id="input-description-product-add" name="input-description-product-add" placeholder="Enter product description">
                            </div>
                            <div class="form-group">
                                <label for="input-image-product-add">Product Image</label><br>
                                <input type="file" id="input-image-product-add" name="input-image-product-add" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="input-price-product-add">Product Price</label>
                                <input type="number" class="form-control" id="input-price-product-add" name="input-price-product-add" placeholder="Enter product price">
                            </div>
                            <div class="form-group">
                                <label for="input-quantity-product-add">Initial Quantity in Stock</label>
                                <input type="number" class="form-control" id="input-quantity-product-add" name="input-quantity-product-add" placeholder="Enter initial number of items">
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="" type="submit" class="btn btn-primary" >Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal for updating specific product -->
        <form action="javascript:void(0);" method="post" enctype="multipart/form-data" id="form-update-product">
            <div class="modal" tabindex="-1" id="update-product-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">Update Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="error-box-update-modal"></p>

                            <input type="hidden" name="action" value="update-product-crud">
                            <input type="hidden" name="product-id" id="update-product-id-hidden-input">

                            <div class="form-group">
                                <label for="input-name-product-update">Product Name</label>
                                <input type="text" class="form-control" id="input-name-product-update" name="input-name-product-update" placeholder="Enter product name">
                            </div>
                            <div class="form-group">
                                <label for="input-description-product-update">Product Description</label>
                                <input type="text" class="form-control" id="input-description-product-update" name="input-description-product-update" placeholder="Enter product description">
                            </div>
                            <div class="form-group">
                                <label for="input-image-product-update">Product Image</label><br>
                                <input type="file" id="input-image-product-update" name="input-image-product-update" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="input-price-product-update">Product Price</label>
                                <input type="number" class="form-control" id="input-price-product-update" name="input-price-product-update" placeholder="Enter product price">
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="update-product-button" >Update Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal for deleting specific product -->

            <div class="modal" tabindex="-1" id="delete-product-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="error-box-delete-modal"></p>
                            <p>Are you sure you want to delete this product?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="delete-product-button" type="button" class="btn btn-primary">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
    

            
        


        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <script>
                function fillProductsCRUD() {
                    $.ajax({
                            type: "GET",
                            url: "controller.php",
                            data: {
                                    action: "fill-products-crud",
                            },
                            success: function(response) {
                                    $("#tablerows-area-products-crud").html(response);
                            },
                    })
                }

                function toggleAddProduct(){
                    // reset field values to empty
                    document.getElementById("input-name-product-add").value = "";
                    document.getElementById("input-description-product-add").value = "";
                    document.getElementById("input-image-product-add").value = "";
                    document.getElementById("input-price-product-add").value = 0;
                    document.getElementById("input-quantity-product-add").value = 0;

                    document.getElementById("error-box-add-modal").innerHTML = "";

                    $('#add-product-modal').modal('show');
                    
                }

                function toggleUpdateProduct(product_id){
                    
                    document.getElementById("update-product-id-hidden-input").value = product_id;
                    
                    // bring in the product's values with ajax
                    $.ajax({
                            type: "GET",
                            url: "controller.php",
                            data: {
                                    action: "toggle-update-product-crud",
                                    product_id: product_id
                            },
                            success: function(response) {
                                    // $("#tablerows-area-products-crud").html(response);

                                    const parsed_response = JSON.parse(response);
                                    // alert(response);
                
                                    // reset field values to currently set values of product
                                    document.getElementById("input-name-product-update").value = parsed_response.p_name;
                                    document.getElementById("input-description-product-update").value = parsed_response.p_description;
                                    document.getElementById("input-image-product-update").value = "";
                                    document.getElementById("input-price-product-update").value = parsed_response.p_price;
                                    

                                    // give onclick attribute to update button
                                    // document.getElementById("update-product-button").onclick = updateProduct(product_id);
                                    // document.getElementById("update-product-button").addEventListener("click", updateProduct());\
                                    
                                    // document.getElementById('update-product-button').setAttribute('onclick',  'updateProduct('.concat(product_id, ');') );
                            },
                    })

                    $('#update-product-modal').modal('show');
                }

                function toggleDeleteProduct(product_id){
                    $('#delete-product-modal').modal('show');
                    document.getElementById('delete-product-button').setAttribute('onclick',  'deleteProduct('.concat(product_id, ');') );
                }

                function addProduct(){

                    // take values of inputs, regardless of whether they have errors or not
                    const input_name_product = document.getElementById("input-name-product-add").value;
                    const input_description_product = document.getElementById("input-description-product-add").value;
                    const input_image_product = document.getElementById("input-image-product-add").value;
                    const input_price_product = document.getElementById("input-price-product-add").value;
                    const input_quantity_product = document.getElementById("input-quantity-product-add").value;

                    $.ajax({
                            type: "POST",
                            url: "controller.php",
                            data: {
                                    action: "add-product-crud",
                                    product_name: input_name_product,
                                    product_description: input_description_product,
                                    product_image: input_image_product,
                                    product_price: input_price_product,
                                    product_quantity: input_quantity_product

                            },
                            success: function(response) {

                                const parsed_response = JSON.parse(response);

                                if(parsed_response.status == "success"){
                                    $('#add-product-modal').modal('hide');
                                    $('#confirmer-box-products-crud').html(parsed_response.confirmer_message);
                                }
                                else if(parsed_response.status == "error"){
                                    $('#error-box-add-modal').html(parsed_response.errors_list);
                                    
                                }
                                
                                
                                fillProductsCRUD();

                            },
                    })

                    // $.post('http://example.com/form.php', {category:'client', type:'premium'});

                }

                function updateProduct(product_id){

                    // take values of inputs, regardless of whether they have errors or not
                    const input_name_product = document.getElementById("input-name-product-update").value;
                    const input_description_product = document.getElementById("input-description-product-update").value;
                    const input_image_product = document.getElementById("input-image-product-update").value;
                    const input_price_product = document.getElementById("input-price-product-update").value;

                    $.ajax({
                            type: "POST",
                            url: "controller.php",
                            data: {
                                    action: "update-product-crud",
                                    product_id: product_id,
                                    product_name: input_name_product,
                                    product_description: input_description_product,
                                    product_image: input_image_product,
                                    product_price: input_price_product

                            },
                            success: function(response) {
                                const parsed_response = JSON.parse(response);

                                if(parsed_response.status=="success"){
                                    $('#update-product-modal').modal('hide');
                                    $('#confirmer-box-products-crud').html(parsed_response.confirmer_message);
                                    fillProductsCRUD();
                                }
                                else if(parsed_response.status == "error"){
                                    $("#error-box-update-modal").html(parsed_response.errors_list);
                                }
                                
                                

                            },
                    })
                }
                
                function deleteProduct(product_id){
                    $.ajax({
                            type: "GET",
                            url: "controller.php",
                            data: {
                                    action: "delete-product-crud",
                                    product_id: product_id
                            },
                            success: function(response) {
                                const parsed_response = JSON.parse(response);

                                if(parsed_response.status=="success"){
                                    $('#delete-product-modal').modal('hide');
                                    $('#confirmer-box-products-crud').html(parsed_response.confirmer_message);
                                    fillProductsCRUD();
                                }
                                else if(parsed_response.status == "error"){
                                    $("#error-box-delete-modal").html(parsed_response.confirmer_message);
                                }
                                
                                

                            },
                    })
                }
                
                
                $(document).ready(function($) { 

                    fillProductsCRUD();

                    $("form#form-add-product").submit(function (event) {
                        
                        var formData = new FormData($("form#form-add-product")[0]);
                        // formData.append('action', "add-product-crud");

                        $.ajax({
                            type: "POST",
                            url: "controller.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            encode: true,
                        })
                        .done(function (data) {

                            console.log(data);

                            if(data.status == "success"){
                                    $('#add-product-modal').modal('hide');
                                    $('#confirmer-box-products-crud').html(data.confirmer_message);
                                }
                                else if(data.status == "error"){
                                    $('#error-box-add-modal').html(data.errors_list);
                                    
                                }
                                
                                
                                fillProductsCRUD();
                        });

                        event.preventDefault();
                    });
                    
                    $("form#form-update-product").submit(function (event) {
                        
                        var formData = new FormData($("form#form-update-product")[0]);
                        // formData.append('action', "add-product-crud");

                        $.ajax({
                            type: "POST",
                            url: "controller.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            encode: true,
                        })
                        .done(function (data) {

                            console.log(data);

                            if(data.status == "success"){
                                    $('#update-product-modal').modal('hide');
                                    $('#confirmer-box-products-crud').html(data.confirmer_message);
                                }
                                else if(data.status == "error"){
                                    $('#error-box-update-modal').html(data.errors_list);
                                    
                                }
                                
                                
                                fillProductsCRUD();
                        });

                        event.preventDefault();

                    }); 
                });

             
        </script>
</body>

</html>