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
                <a class="nav-link px-3" href="product-crud.php">Product Manager</a>
                <a class="nav-link px-3 active" aria-current="page" href="#">Stock</a>
                <a class="nav-link px-3" href="orders.php">All Orders</a>
                <a class="nav-link px-3" href="reports-page.php">Generate Report</a>
        </nav>

        <div class=" p-5 m-5" id="stock-details-box">
                <p id="confirmer-box-stock"></p>
                <div class="d-flex">
                        <h1 class="">Your current stock is as follows:</h1>
                        <div class="search-box">
                                <input id="search-input-stock" type="text" autocomplete="off" placeholder="Search product..." />
                                <!-- <div class="result"></div> -->
                        </div>
                </div>   
        </div>

        <table class="table text-center align-middle">
                <thead>
                        <tr class="border border-dark">
                                <th scope="col">Item #</th>
                                <th scope="col">Item Picture</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Current Item Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                                
                                
                        </tr>
                </thead>
                <tbody id="stock-details-area">
                </tbody>
        </table>

        

        <!-- Modal for updating specific product's stock -->
        <div class="modal" tabindex="-1" id="update-stock-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Update Product Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="error-box-update-stock-modal"></p>
                        
                        <div class="form-group">
                            <label for="input-quantity-stock-update">Stock Quantity</label>
                            <input type="number" class="form-control" id="input-quantity-stock-update" placeholder="Enter stock quantity">
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="update-stock-button">Update Stock</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        
        <script>
                function fillStock() {
                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "fill-stock-page",
                                },
                                success: function(response) {
                                        $("#stock-details-area").html(response);
                                        

                                },
                        })
                }

                function toggleUpdateStock(product_id){
                        $.ajax({
                            type: "GET",
                            url: "controller.php",
                            data: {
                                    action: "toggle-update-stock",
                                    product_id: product_id
                            },
                            success: function(response) {
                                    // $("#tablerows-area-products-crud").html(response);

                                    const parsed_response = JSON.parse(response);
                                    // alert(response);
                
                                    // reset field values to currently set values of product
                                    document.getElementById("input-quantity-stock-update").value = parsed_response.p_stock_quantity;

                                    // give onclick attribute to update button
                               
                                    document.getElementById('update-stock-button').setAttribute('onclick',  'updateStock('.concat(product_id, ');') );
                            },
                        })

                        $('#update-stock-modal').modal('show');
                }

                function updateStock(product_id){
                        // take values of inputs, regardless of whether they have errors or not
                        const input_quantity_stock = document.getElementById("input-quantity-stock-update").value;

                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "update-stock",
                                        product_id: product_id,
                                        quantity_stock: input_quantity_stock

                                },
                                success: function(response) {
                                        const parsed_response = JSON.parse(response);

                                        if(parsed_response.status=="success"){
                                                $('#update-stock-modal').modal('hide');
                                                $('#confirmer-box-stock').html(parsed_response.confirmer_message);
                                                
                                                // only if user hasn't searched anything, then update the rows and show everything
                                                if ( $("#search-input-stock").val() == "" ){
                                                        fillStock();
                                                }

                                                // if user has searched, then only display the searched ones (how to implement??)

                                                
                                        }
                                        else if(parsed_response.status == "error"){
                                                $("#error-box-update-stock-modal").html(parsed_response.errors_list);
                                        }
                                },
                        })
                }

                $(document).ready(function(){
                        $('.search-box input[type="text"]').on("keyup input", function(){
                                /* Get input value on change */
                                var inputVal = $(this).val();
                                if(inputVal.length){
                                $.get("controller.php", {term: inputVal}).done(function(data){
                                        // Display the returned data in browser
                                        let parsed_data = JSON.parse(data);

                                        if(parsed_data.status == "success_rows"){
                                                // fill up the rows with the result
                                                $("#stock-details-area").html(parsed_data.response_html);

                                                $("#confirmer-box-stock").html(parsed_data.confirmer_message);
                                  
                                                
                                        }
                                        else if(parsed_data.status == "success_no_rows"){
                                                // let table rows stay empty
                                                $("#stock-details-area").html("");

                                                // display msg of no results
                                                $("#confirmer-box-stock").html(parsed_data.confirmer_message);
                                        }
                                        else {
                                                // display msg of no results
                                                $("#confirmer-box-stock").html(parsed_data.confirmer_message);
                                        }
                                        
                                });
                                } 
                                // i think this is called when search box is empty
                                else{
                                        fillStock();
                                        $("#confirmer-box-stock").html("");
                                // resultDropdown.empty();
                                }
                        });
                        
                        // Set search input value on click of result item
                        $(document).on("click", ".result p", function(){
                                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                                $(this).parent(".result").empty();
                        });
                });

                fillStock();

                
                

        </script>
</body>

</html>