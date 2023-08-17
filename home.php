<?php

session_start();

// anytime you turn back to home page, cart should be emptied
// $_SESSION['cart'] = [];


if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // initialize cart array as session variable if not initialized yet}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>

        <!-- ajax js ands jquery -->
        <script src="js/jquery.js"></script>

        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.css" />
</head>

<body>
        <nav class="nav justify-content-end bg-black">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                <a class="nav-link" href="cart.php">Shopping Cart(Checkout)</a>
                <a class="nav-link" href="orders.php">All Orders</a>
        </nav>

        <h1>Please select whatever items interest you, and choose quantity!</h1>

        <!-- dynamically add cards here for each product in the database's table products -->
        <div class="" id="all-items-area"></div>

        <!-- bootstrap js -->
        <script src="js/bootstrap.js"></script>

        <!-- custom js -->
        <script>
                // empty array
                let shopping_cart = []; // to disable relevant buttons, and update their quantity. {p_id, p_quantity}
                <?php
                for ($i = 0; $i <  sizeof($_SESSION['cart']); $i++) {

                ?>
                        shopping_cart.push({
                                p_id: <?= $_SESSION['cart'][$i][0] ?>,
                                p_quantity: <?= $_SESSION['cart'][$i][1] ?>
                        })
                <?php
                }
                ?>

                function updateDisabledTags() {

                        shopping_cart.forEach((order_item) => { // order item has id of products that has been selected in cart
                                const quantity_field = document.getElementById("num_items_" + order_item["p_id"]);
                                const buy_button = document.getElementById("buy_button_" + order_item["p_id"]);

                                quantity_field.setAttribute("disabled", "");
                                quantity_field.value = order_item["p_quantity"];
                                buy_button.setAttribute("disabled", "");

                        });
                }

                function includeOneProduct(item_id) {

                        // do some processing
                        const quantity = document.getElementById("num_items_" + item_id).value;
                        const quantity_field = document.getElementById("num_items_" + item_id);
                        const buy_button = document.getElementById("buy_button_" + item_id);
                        const stock_quantity = document.getElementById("stock_quantity_item_" + item_id).innerHTML;

                        if (quantity > 0 && stock_quantity - quantity >= 0) {
                                // do these actions only if valid input
                                //   console.log(
                                //     "Item " + item_id + " was purchased " + quantity + " times."
                                //   );

                                // document.getElementById("error_text_" + item_id).innerHTML = "";

                                buy_button.setAttribute("disabled", "");
                                quantity_field.setAttribute("disabled", "");

                                $.ajax({
                                        type: "GET",
                                        url: "controller.php",
                                        data: {
                                                action: "includeItemInCart",
                                                cart_product_id: item_id,
                                                product_quantity: quantity,
                                        },
                                        success: function(response) {
                                                // $("#all-items-area").html(response);
                                        },
                                });

                                //   shopping_cart.push({ p_id: item_id, p_quantity: quantity });
                        }
                        // else if (quantity <= 0 || quantity == "") {
                        //         document.getElementById("error_text_" + item_id).innerHTML =
                        //                 "Please write correct input!";
                        // }
                }

                // simple ajax to ask for data to fill sale items
                $.ajax({
                        type: "GET",
                        url: "controller.php",
                        data: {
                                action: "fill-all-items-homepage",
                        },
                        success: function(response) {
                                $("#all-items-area").html(response);
                                updateDisabledTags();
                        },
                });
        </script>
</body>

</html>