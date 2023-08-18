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
        <title>Shopping Cart</title>
        <!-- ajax js and jquery -->
        <script src="js/jquery.js"></script>

        <!-- boostrap css -->
        <link rel="stylesheet" href="css/bootstrap.css" />
</head>

<body>
        <nav class="navbar justify-content-end bg-light">
                <a class="nav-link px-3" href="home.php">Home</a>
                <a class="nav-link px-3 active" aria-current="page" href="#">Checkout</a>
                <a class="nav-link px-3" href="product-crud.php">Product Manager</a>
                <a class="nav-link px-3" href="stock_page.php">Stock</a>
                <a class="nav-link px-3" href="orders.php">All Orders</a>
                <a class="nav-link px-3" href="reports-page.php">Generate Report</a>
        </nav>

        <!-- dyanamically fill all selected cart items -->
        <table class="table">
                <thead>
                        <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Quantity</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Total Price</th>
                        </tr>
                </thead>
                <tbody id="selected-cart-items-area"></tbody>
        </table>


        <?php
        if ($_SESSION['cart'] != []) { ?>
                <div id="customer_form" class="border border-dark w-25 mx-auto p-3 ">

                        <div class="form-group">
                                <label for="">Customer Name</label>
                                <input id="c_name_checkout" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                                <label for="">Email Address</label>
                                <input id="c_email_checkout" type="email" class="form-control">
                        </div>

                        <div class="form-group">
                                <label for="">Phone #</label>
                                <input id="c_phone_number_checkout" type="number" class="form-control">
                        </div>

                        <a href="home.php" onclick="clearCart()"><button class="btn btn-danger">Cancel</button></a>
                        <button class="btn btn-primary" onclick="checkoutOrder()">Checkout</button>
                </div>

        <?php } ?>





        <!-- provide bill of items and display total price -->

        <!-- ask user to provide details of himself (Customer ID) and click Checkout button -->
        <script src="js/bootstrap.js"></script>

        <script>
                fillCartpage();
                if (document.getElementById("customer_form") != null)
                        document.getElementById("customer_form").classList.remove("d-none");

                function fillCartpage() {
                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "fill-selected-items-cartpage",
                                },
                                success: function(response) {
                                        $("#selected-cart-items-area").html(response);
                                        // alert(response);
                                },
                        });
                }


                function checkoutOrder() {

                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "checkout-order",
                                        customer_name: document.getElementById("c_name_checkout").value,
                                        customer_email: document.getElementById("c_email_checkout").value,
                                        customer_phone_number: document.getElementById("c_phone_number_checkout").value
                                },
                                success: function(response) {
                                        // $("#selected-cart-items-area").html(response);
                                        if (response == "Success!") {
                                                alert(response);
                                                fillCartpage();
                                                document.getElementById("customer_form").classList.add("d-none");

                                                // go to confirming-message.php
                                                location.href = 'http://localhost/439-Internship-Work/shopping-cart-system-27June2023/confirming-message.php';


                                        }
                                        // else if (JSON.parse(response).isArray()) {
                                        //         alert("imim an ary");
                                        //         // stay there, display error
                                        // } 
                                        else if (response[0] == "[") {
                                                let errors_array = JSON.parse(response);
                                                //  according to errors, display messages
                                                let text = "";

                                                if (errors_array[0])
                                                        text += "Please enter name in correct format!";
                                                if (errors_array[1])
                                                        text += "Please enter email in correct format!";
                                                if (errors_array[2])
                                                        text += "Please enter phone number in correct format!"


                                                alert(text);


                                        } else {
                                                alert(response);
                                        }

                                },
                        });


                }

                function clearCart() {
                        $.ajax({
                                type: "GET",
                                url: "controller.php",
                                data: {
                                        action: "clear-cart",
                                },
                                success: function(response) {
                                        // do nothing

                                },
                        })
                }
        </script>
</body>

</html>