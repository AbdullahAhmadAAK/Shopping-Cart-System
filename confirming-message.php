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
        <nav class="nav justify-content-end bg-black">
                <a class="nav-link" href="home.php">Home</a>
                <a class="nav-link" href="cart.php">Shopping Cart(Checkout)</a>
                <a class="nav-link" href="orders.php">All Orders</a>
        </nav>

        <div class="border border-dark bg-success p-5 m-5" id="confirming-message-box">
                <h1 class="">Your order details:</h1>


                <div id="details-area"></div>

                <a href="home.php"><button class="btn btn-dark">Go back to Home Page</button> </a>
        </div>
        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>
        <script>
                function fillConfirmer(order_id) {
                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "fill-confirming-message-page",
                                },
                                success: function(response) {
                                        $("#details-area").html(response);

                                },
                        })
                }

                fillConfirmer();
        </script>
</body>

</html>