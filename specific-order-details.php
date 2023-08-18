<?php
    session_start();
    $order_id = $_GET['order_id'];
    // echo $order_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Order Details!</title>

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
                <a class="nav-link px-3" href="reports-page.php">Generate Report</a>
        </nav>

        <div class="border border-dark p-5 m-5" id="order-info-box">
                <h1 class="">This order's details:</h1>


                <div id="order-info-area"></div>

                <a href="orders.php"><button class="btn btn-light">Go back to Orders Page</button> </a>
        </div>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <script>

            let order_id = <?= $order_id ?>;

              $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "view-specific-order",
                                        order_id: order_id
                                },
                                success: function(response) {
                                        $("#order-info-area").html(response);

                                },
                        })
        </script>
</body>

</html>