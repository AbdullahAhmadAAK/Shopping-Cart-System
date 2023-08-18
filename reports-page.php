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
                <a class="nav-link px-3" href="stock_page.php">Stock</a>
                <a class="nav-link px-3" href="orders.php">All Orders</a>
                <a class="nav-link px-3 active" aria-current="page" href="">Generate Report</a>
        </nav>

        <div class="border border-dark p-5 m-5" id="confirming-message-box">
                <h1 class="mb-4">This is the generated report!</h1>
                <form class="m-3" action="javascript:void(0);" id="form-report">
                    <div class="d-flex" id="search-boxes-div">
                        
                        <input type="hidden" name="action" value="search-fill-report-rows">
                            
                        <p>Search by Customer Name</p>
                        <input type="text" name="cname-input-form-report" value="">
                        <p>Search by Customer Email</p>
                        <input type="text" name="cemail-input-form-report" value="">
                        <p>Search by Product Name</p>
                        <input type="text" name="pname-input-form-report" value="">
                        <button type="submit" class="btn btn-success">Search</button>
                        
                    </div>
                </form>

                <table class="table border border-dark">
                    <thead>
                        <tr>
                        <th scope="col">Order #</th>
                        <th scope="col">Customer Details</th>
                        <th scope="col">Products Details</th>
                        <th scope="col">Total Bill</th>
                        </tr>
                    </thead>
                    <tbody id="generated-report-table-body">
                        
                    </tbody>
                </table>
        </div>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <script>
            function fillRows() {
                var formData = new FormData($("form#form-report")[0]);

                $.ajax({
                    type: "POST",
                    url: "controller.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    encode: true,
                })
                .done(function (data) {

                    // console.log(data);
                    $('#generated-report-table-body').html(data);

                });
            }

            $(document).ready(function($) { 

                $("form#form-report").submit(function (event) {
                    var formData = new FormData($("form#form-report")[0]);

                    $.ajax({
                        type: "POST",
                        url: "controller.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        encode: true,
                    })
                    .done(function (data) {

                        // console.log(data);
                        $('#generated-report-table-body').html(data);
                      

                    });
                    
                });

                fillRows();
            })

                
        </script>
</body>

</html>