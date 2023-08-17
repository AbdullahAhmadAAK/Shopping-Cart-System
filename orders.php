<?php
session_start();
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
        <nav class="nav justify-content-end bg-black">
                <a class="nav-link" href="home.php">Home</a>
                <a class="nav-link" href="cart.php">Shopping Cart(Checkout)</a>
                <a class="nav-link active" aria-current="page" href="#">All Orders</a>
        </nav>

        <h1>These are all the orders uptil now, in full detail:</h1>

        <!-- dynamically all add orders here from ORDERS JOIN ORDER_ITEMS -->
        <table class="table">
                <thead class="border border-dark">
                        <tr>
                                <th scope="col">Order ID</th>
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