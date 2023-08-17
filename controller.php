<?php
//  connect to database
$link = mysqli_connect("localhost", "root", "", "suave_internship");


session_start();

if (isset($_GET['action']) && !empty($_GET["action"])) {

        if ($_GET['action'] == "includeItemInCart") {
                array_push($_SESSION['cart'], [$_GET['cart_product_id'], $_GET['product_quantity']]);
        }

        // dynamically fill all-orders-details-area in orders.html
        if ($_GET["action"] == "fill-all-orders-orderspage") {
                $sql = "SELECT * FROM orders NATURAL JOIN order_items NATURAL JOIN products NATURAL JOIN customers ORDER BY o_id DESC";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                        // OUTPUT DATA OF EACH ROW
                        $prev_order_id = "";
                        $sum = 0;

                        $last_o_id = 0;
                        $last_c_name = "";
                        $last_c_email = "";

                        while ($row = mysqli_fetch_assoc($result)) {
                                //  print order details IF this is 1st fetched order (of 1 item)




                                if ($prev_order_id != $row['o_id'] && $prev_order_id != "") {
                                        // print all details of order,

?>

                                        <tr>
                                                <td><?= $row['o_id'] ?></td>
                                                <td><?= $row['c_name'] ?></td>
                                                <td><?= $row['c_email'] ?></td>
                                                <td><?= $sum ?></td>

                                        </tr>

                        <?php


                                        $sum = 0; // resets sum to 0 at start of fetching, and between fetches of different orders!
                                }

                                $sum += $row['p_price'] * $row['p_quantity'];
                                $prev_order_id = $row['o_id'];

                                // assign values to 'last fetched' variables, just in case this is the last iteration of while loop
                                $last_o_id = $row['o_id'];
                                $last_c_name = $row['c_name'];
                                $last_c_email = $row['c_email'];
                        }

                        // print last fetched order's details, once you're out of the while loop!
                        ?>
                        <tr>
                                <td><?= $last_o_id ?></td>
                                <td><?= $last_c_name ?></td>
                                <td><?= $last_c_email ?></td>
                                <td><?= $sum ?></td>
                        </tr>
                        <?php
                } else {
                        echo "0 results";
                }
        }

        // dynamically fill all-items-area in home.html
        if ($_GET["action"] == "fill-all-items-homepage") {

                $sql = "SELECT * FROM products NATURAL JOIN stock_products";
                $result = mysqli_query($link, $sql);
                $cards_counter = 0;

                if (mysqli_num_rows($result) > 0) {
                        // OUTPUT DATA OF EACH ROW 
                        if ($cards_counter % 3 == 0 && $cards_counter == 0) {
                        ?>
                                <div class="row justify-content-center">
                                <?php
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                                if ($cards_counter % 3 == 0 && $cards_counter != 0) {

                                        echo '<div class="row justify-content-center">';
                                }
                                ?>

                                        <div class="card border border-dark m-3 text-white bg-dark <?php if ($row['p_stock_quantity'] == 0) echo 'opacity-75' ?>" style="width: 18rem;">

                                                <img src='<?= "./media/" . $row["p_picture_filename"] ?>' class="card-img-top mt-3" alt="..." height="200px" width="200px">
                                                <!-- how do i get pics to come here as img src??? -->
                                                <!-- apparently i need to keep the images here in url format in the db, then access that url here in the  -->
                                                <div class="card-body">
                                                        <h5 class="card-title"><?= $row["p_name"] ?></h5>
                                                        <p class="card-text"><?= $row["p_description"] ?></p>
                                                        <p>Price: <?= $row["p_price"] ?></p>
                                                        <p>Available stock:
                                                                <span id="stock_quantity_item_<?= $row['p_id'] ?>"><?= $row["p_stock_quantity"] ?></span>
                                                        </p>

                                                        <!-- <p class="text-danger" id="error_text_"></p> -->
                                                        <label for="num_items<?= $row["p_id"] ?>">Number</label>
                                                        <input id='num_items_<?= $row["p_id"] ?>' <?php if ($row['p_stock_quantity'] == 0) echo 'disabled'; ?> min=1 value=1 type="number">

                                                        <button id="buy_button_<?= $row["p_id"] ?>" <?php if ($row['p_stock_quantity'] == 0) echo 'disabled' ?> onclick='includeOneProduct(<?= $row["p_id"] ?>)' class="btn btn-primary">Buy</a>
                                                                <!-- need to log the user's response and store on sessionkey/cookie (implement in includeOneProduct() ) -->
                                                </div>
                                        </div>
                                <?php
                                $cards_counter++;
                                if ($cards_counter % 3 == 0 && $cards_counter != 0) {

                                        echo '</div>';
                                }
                        }
                        echo "</div>";
                } else {
                        // echo "0 results";
                }
        }


        // dynamically fill all selected-cart-items-area in cart,html
        if ($_GET["action"] == "fill-selected-items-cartpage") {

                for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {

                                ?>
                                <?php

                                $sql = "SELECT * FROM products WHERE p_id=" . $_SESSION['cart'][$i][0];
                                $result = mysqli_query($link, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                        // OUTPUT DATA OF EACH ROW (only 1 will be printed)

                                        while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                                <tr>
                                                        <td>
                                                                <h5> <?php echo $row["p_name"] ?> </h5>
                                                        </td>
                                                        <td>
                                                                <h5> <?php echo $_SESSION['cart'][$i][1] ?> </h5>
                                                        </td>
                                                        <td>
                                                                <h5> <?php echo $row["p_price"] ?> </h5>
                                                        </td>
                                                        <td>
                                                                <h5> <?php echo $_SESSION['cart'][$i][1] * $row["p_price"] ?></h5>
                                                        </td>
                                                </tr>
                                        <?php
                                        }

                                        ?>





                                <?php
                                } else {
                                        echo "0 results";
                                }
                        }
                }

                if ($_GET['action'] == "checkout-order") {

                        // INPUT VALIDATION
                        $customer_name_input = $_GET['customer_name'];
                        $customer_email_input = $_GET['customer_email'];
                        $customer_phone_number_input = $_GET['customer_phone_number'];

                        $error_name = $error_email = $error_phone = false;

                        // validating name input
                        if (!ctype_alpha(str_replace(' ', '', $customer_name_input))) {
                                $error_name = true;
                        }

                        // validating email input (already done in form frontend?) // shouldn't run if empty
                        if ($customer_email_input == "" || !filter_var($customer_email_input, FILTER_VALIDATE_EMAIL)) {
                                $error_email = true;
                        }

                        // echo "phone # is " . $customer_phone_number_input;



                        // validating phone input (11 digits, numbers only)

                        // we are assuming, frontend will send numbers only. we will treat it as string so that initial 0 isn't truncated
                        if (strlen($customer_phone_number_input) != 11) {
                                $error_phone = true;
                        }


                        if (!$error_name && !$error_email && !$error_phone) {
                                // CUSTOMER INSERTION

                                // prep sql statement
                                $sql_customer = "SELECT * FROM customers WHERE c_email = '" . $_GET["customer_email"] . "' AND c_phone= " . "'" . $_GET["customer_phone_number"] . "'"; // c_email and c_phone only for vlaidation
                                $result = mysqli_query($link, $sql_customer);
                                $status_customer_verification = "";

                                // if neither customer email nor username NOT FOUND in table customers
                                if (mysqli_num_rows($result) == 0) {
                                        // confirm that username and id not taken

                                        $sql_customer_verification = "SELECT * FROM customers WHERE c_email = '" . $_GET["customer_email"]  . "' OR c_phone = " . $_GET["customer_phone_number"];
                                        $result_verification = mysqli_query($link, $sql_customer_verification);
                                        if (mysqli_num_rows($result_verification) == 0) {
                                                // both username and id are unique
                                                // insert new customer into customers table
                                                $sql_customer_insertion = "INSERT INTO customers ( c_name, c_email, c_phone ) VALUES ( '" . $_GET["customer_name"] . "', '" . $_GET["customer_email"] . "', '" . $_GET["customer_phone_number"] .  "' )";
                                                if (mysqli_query($link, $sql_customer_insertion)) {
                                                        // stmt executed successfulyy
                                                } else {
                                                        echo "Error: " . $sql_customer_insertion . "<br>" . mysqli_error($link);
                                                }

                                                $status_customer_verification = true;
                                        } else {
                                                echo "Error: Email and Phone # don't match each other in records!";
                                                $status_customer_verification = false;
                                        }
                                }
                                // if 1 unique entry exists, all ok for next steps, do nothing
                                else if (mysqli_num_rows($result) == 1) {
                                        $status_customer_verification = true;
                                }

                                // if multiple entries exist for username and id, then there is conflict. this ID and username DONT MATCH to 1 customer
                                // else if (mysqli_num_rows($result) > 1) {
                                //         echo "Error: Mismatched ID and Username";
                                //         $status_customer_verification = false;
                                // }


                                if ($status_customer_verification) {
                                        // insert into Orders table ONCE (done correctly)
                                        $customer_id_input = mysqli_insert_id($link);

                                        $sql = "INSERT INTO orders (c_id) VALUES (" . $customer_id_input . ")"; // prepare sql query
                                        if (mysqli_query($link, $sql)) {
                                                // echo "New record created successfully in ORDERS table";
                                        } else {
                                                echo "Error: " . $sql . "<br>" . mysqli_error($link);
                                        }


                                        // insert into OrderItems AS MANY TIMES AS NEEDED (iterate over sesson array length) AND update stock_items table
                                        $order_id = mysqli_insert_id($link);

                                        for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {

                                                // INSERT INTO ORDER_ITEMS TABLE
                                                $sql_item = "INSERT INTO order_items (o_id, p_id, p_quantity) VALUES (" . $order_id . ", " . $_SESSION['cart'][$i][0] . ", " . $_SESSION['cart'][$i][1] . ")";

                                                if (mysqli_query($link, $sql_item)) {
                                                        // echo "New record created successfully in ORDER_ITEMS table";
                                                } else {
                                                        echo "Error: " . $sql_item . "<br>" . mysqli_error($link);
                                                }

                                                // UPDATE STOCK_ITEMS TABLE
                                                $sql_stock = "UPDATE stock_products SET p_stock_quantity = p_stock_quantity - " . $_SESSION['cart'][$i][1] . " WHERE p_id = " . $_SESSION['cart'][$i][0];

                                                if (mysqli_query($link, $sql_stock)) {
                                                        // echo "Stock item record updated successfully";
                                                } else {
                                                        echo "Error updating stock items record: " . mysqli_error($link);
                                                }
                                        }

                                        // clear session variable that contains all items
                                        $_SESSION['cart'] = [];
                                        $_SESSION['last_order_id'] = $order_id;
                                        echo "Success!"; // shows frontend that everything ran perfectly, orderItems orders and/or customers updated

                                }
                        } else {
                                $array_errors = [];
                                array_push($array_errors, $error_name, $error_email, $error_phone);
                                echo json_encode($array_errors);
                        }
                }

                if ($_GET['action'] == 'cancel-order') {
                        $_SESSION['cart'] = [];
                }

                if ($_GET['action'] == 'fill-confirming-message-page') {
                        $last_id = $_SESSION['last_order_id'];

                        // get all details of last order only

                        $sql = "SELECT * FROM orders NATURAL JOIN order_items NATURAL JOIN products NATURAL JOIN customers WHERE o_id = '" . $last_id . "'";
                        $result = mysqli_query($link, $sql);
                        $c_name = "";
                        $c_email = "";
                        $c_phone = 0;

                        if (mysqli_num_rows($result) > 0) {
                                // OUTPUT DATA OF EACH ROW

                                $sum = 0;
                                $text_list = "<ul>";

                                while ($row = mysqli_fetch_assoc($result)) {
                                        $sum += $row['p_price'] * $row['p_quantity'];
                                        $text_list = $text_list . "<li>" . $row['p_quantity'] . " " . $row['p_name'] . "</li>";
                                        if ($c_name == "" && $c_email == "" && $c_phone == 0) {
                                                $c_name = $row['c_name'];
                                                $c_email = $row['c_email'];
                                                $c_phone = $row['c_phone'];
                                        }
                                }

                                $text_list = $text_list . "</ul>"

                                ?>
                                <p>Your total bill was <?php echo $sum ?></p>
                                <p>Your items were as follows:</p>
                                <?php echo  $text_list ?>
                                <p> Customer Name: <?= $c_name ?> </p>
                                <p> Customer Email: <?= $c_email ?></p>
                                <p>Customer Phone Number: <?= $c_phone ?> </p>

        <?php
                        } else {
                                echo "0 results";
                        }
                }
        }
