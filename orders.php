<?php
session_start();

if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // initialize cart array as session variable if not initialized yet}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Orders</title>
        <!-- ajax js and jquery -->
        <script src="js/jquery.js"></script>

        <!-- boostrap css -->
        <link rel="stylesheet" href="css/bootstrap.css" />
</head>

<body>
        <nav class="navbar justify-content-end bg-light">
                <a class="nav-link px-3" href="home.php">Home</a>
                <a class="nav-link px-3" href="cart.php">Checkout</a>
                <a class="nav-link px-3" href="product-crud.php">Product Manager</a>
                <a class="nav-link px-3" href="stock_page.php">Stock</a>
                <a class="nav-link px-3 active" aria-current="page" href="#">All Orders</a>
                <a class="nav-link px-3" href="reports-page.php">Generate Report</a>
        </nav>

        <h1>These are all the orders uptil now, in full detail:</h1>

        <!-- dynamically all add orders here from ORDERS JOIN ORDER_ITEMS -->
        <table class="table">
                <thead class="border border-dark">
                        <tr>
                                <th scope="col">Order #</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Email</th>
                                <th scope="col">Total Price</th>
                        </tr>
                </thead>
                <tbody id="all-orders-details-area"></tbody>
        </table>

        <!-- ajax js and jquery -->
        <script src="js/jquery.js"></script>

        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>

        <!-- custom js -->
        <script>
                $.ajax({
                        type: "GET",
                        url: "controller.php",
                        data: {
                                action: "fill-all-orders-orderspage",
                        },
                        success: function(response) {
                                $("#all-orders-details-area").html(response);
                        },
                });
        </script>
</body>

</html>