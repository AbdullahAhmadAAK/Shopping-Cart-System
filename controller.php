<?php
//  connect to database
$link = mysqli_connect("localhost", "root", "", "internship_abdullah_ahmad");


session_start();

if(isset($_POST['action']) && !empty($_POST["action"])){
        
        if($_POST['action'] == "add-product-crud"){

                // get inputs
                $input_name = $_POST['input-name-product-add'];
                $input_description = $_POST['input-description-product-add'];
                $input_price = $_POST['input-price-product-add'];
                $input_quantity = $_POST['input-quantity-product-add'];

                // create boolean error variables
                $error_name = $error_description = $error_image = $error_price = $error_quantity = false;
        
                $errors_array = [];

                /* validate inputs */

                // error in name, if contains characters other than a-z A-Z OR if empty
                if( !ctype_alpha(str_replace(" ", "", $input_name)) || $input_name == "")
                        $error_name = true;
                        
                // error in description, if empty
                if($input_description == "")
                        $error_description = true; 

                // error in image, if
                $allowed_image_extension = array(
                        "png",
                        "jpg",
                        "jpeg"
                        );

                // error in price, if price is negative or if it contains a '-' in middle of it
                if($input_price <= 0 || !ctype_digit($input_price)) 
                        $error_price = true;

                // error in quantity, if quantity is negative or if it contains a '-' in middle of it
                if($input_quantity <= 0 || !ctype_digit($input_quantity))
                        $error_quantity = true;


                // IMAGE GETTING AND VALIDATION
                $input_image = $_FILES['input-image-product-add']['name']; 
                if($input_image == "")
                        $error_image = true;

                if(!$error_image){

                        $error_image = true; 

                        $target_dir = "media/";
                        $target_file = $target_dir . basename($_FILES["input-image-product-add"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        // Check if image file is a actual image or fake image
                        if(isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["input-image-product-add"]["tmp_name"]);
                                if($check !== false) {
                                        // echo "File is an image - " . $check["mime"] . ".";
                                        $uploadOk = 1;
                                } else {
                                        // echo "File is not an image.";
                                        $uploadOk = 0;
                                        // $error_image = true;
                                }
                        }

                        // Check if file already exists
                        if (file_exists($target_file)) {
                                // echo "Sorry, file already exists.";
                                $error_image = false;
                                $uploadOk = 0;
                        }

                        // Check file size
                        if ($_FILES["input-image-product-add"]["size"] > 500000) {
                                // echo "Sorry, your file is too large.";
                                // $error_image = true;
                                $uploadOk = 0;
                        }

                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                                // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                // $error_image = true;
                                $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                                // $error_image = true;
                                // echo "Sorry, your file was not uploaded.";
                                // if everything is ok, try to upload file
                        } else {
                                if (move_uploaded_file($_FILES["input-image-product-add"]["tmp_name"], $target_file)) {
                                        // echo "The file ". htmlspecialchars( basename( $_FILES["input-image-product-add"]["name"])). " has been uploaded.";
                                        $error_image = false;
                                } else {
                                        // echo "Sorry, there was an error uploading your file.";
                                }
                        }

                }

                // if no errors, insert into db
                if(!$error_name && !$error_description && !$error_image && !$error_price && !$error_quantity){
                        
                        // prepare  // do i need to handle error here? how?
                        if( $stmt = $link->prepare("
                        INSERT INTO products (p_name, p_description, p_price, p_picture_filename) 
                        VALUES (?, ?, ?, ?)
                        ") ){
                                // bind
                                $stmt->bind_param("ssis", $param_name, $param_description, $param_price, $param_image);

                                // set parameters 
                                $param_name = $input_name;
                                $param_description = $input_description;
                                $param_price = $input_price;
                                $param_image = $input_image;
                                
                                // execute
                                $stmt->execute();
                                $stmt->close();

                                if( $stmt = $link->prepare("
                                INSERT INTO stock_products (p_id, p_stock_quantity) 
                                VALUES (?, ?)
                                ") ){
                                        // bind
                                        $stmt->bind_param("ii", $param_id, $param_quantity);

                                        // set parameters 
                                        $param_id = mysqli_insert_id($link);
                                        $param_quantity = $input_quantity;
                                     
                                        // execute
                                        $stmt->execute();
                                        $stmt->close();

                                        echo json_encode(array("status" => "success", "errors_list" => $errors_array, "confirmer_message" => "Successfully added employee!"));
                                }
                                
                                else{
                                        // do nothing
                                }
                        }

                        else{
                                // do nothing
                        }
                        

                        
                }

                else{
                        
                        if($error_name)
                                array_push($errors_array, "Please write name in correct format!");
                        if($error_description)
                                array_push($errors_array, "Please write description in correct format!");
                        if($error_image)
                                array_push($errors_array, "Please upload image in correct format!");
                        if($error_price)
                                array_push($errors_array, "Please write price in correct format!");
                        if($error_quantity)
                                array_push($errors_array, "Please write quantity in correct format!");

                        echo json_encode(array("status" => "error", "errors_list" => $errors_array, "confirmer_message" => "Can't add employee!"));
                }
        }

        if($_POST['action'] == "update-product-crud"){

                // get inputs
                $input_id = $_POST['product-id'];
                $input_name = $_POST['input-name-product-update'];
                $input_description = $_POST['input-description-product-update'];
                $input_price = $_POST['input-price-product-update'];

                // create boolean error variables
                $error_name = $error_description = $error_image = $error_price = false;
                $errors_array = [];

                /* validate inputs */

                // error in name, if contains characters other than a-z A-Z OR if empty
                if( !ctype_alpha(str_replace(" ", "", $input_name)) || $input_name == "")
                        $error_name = true;
                        
                // error in description, if empty
                if($input_description == "")
                        $error_description = true; 

                // error in image, if
                $allowed_image_extension = array(
                        "png",
                        "jpg",
                        "jpeg"
                        );

                // if($input_image == "")
                //         $error_image = true;

                // error in price, if price is negative or if it contains a '-' in middle of it
                if($input_price <= 0 || !ctype_digit($input_price)) 
                        $error_price = true;

                // IMAGE GETTING AND VALIDATION
                $image_uploaded = false;
                $input_image = $_FILES['input-image-product-update']['name'];
                if($input_image != "")
                        $image_uploaded = true;

                if($image_uploaded){
                        // we will run sql query to find name of old file (then we'll unlink/delete it)
                        $old_image_filename = "";

                        $sql = "SELECT p_picture_filename
                        FROM products
                        WHERE p_id = " . $input_id;

                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $old_image_filename = $row['p_picture_filename'];

                        // UPLOAD FILE LOCALLY

                        $target_dir = "media/";
                        $target_file = $target_dir . basename($_FILES["input-image-product-update"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        // Check if image file is a actual image or fake image
                        if(isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["input-image-product-update"]["tmp_name"]);
                                if($check !== false) {
                                        // echo "File is an image - " . $check["mime"] . ".";
                                        $uploadOk = 1;
                                } else {
                                        // echo "File is not an image.";
                                        $uploadOk = 0;
                                        // $error_image = true;
                                }
                        }

                        // Check if file already exists
                        if (file_exists($target_file)) {
                                // echo "Sorry, file already exists.";
                                $error_image = false;
                                $uploadOk = 0;
                        }

                        // Check file size
                        if ($_FILES["input-image-product-update"]["size"] > 500000) {
                                // echo "Sorry, your file is too large.";
                                // $error_image = true;
                                $uploadOk = 0;
                        }

                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                                // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                // $error_image = true;
                                $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                                // $error_image = true;
                                // echo "Sorry, your file was not uploaded.";
                                // if everything is ok, try to upload file
                        } else {
                                if (move_uploaded_file($_FILES["input-image-product-update"]["tmp_name"], $target_file)) {
                                        // echo "The file ". htmlspecialchars( basename( $_FILES["input-image-product-update"]["name"])). " has been uploaded.";
                                        $error_image = false;

                                        // if image uploaded, delete old image too from local storage folder
                                        $old_image_filename = "./media/" . $old_image_filename;
                                        if (!unlink($old_image_filename)) {
                                                // echo ("$file_pointer cannot be deleted due to an error");
                                        }
                                        else {
                                                // echo ("$file_pointer has been deleted");
                                        }

                                } else {
                                        // echo "Sorry, there was an error uploading your file.";
                                }
                        }
                }
                
                

                if(!$error_name && !$error_description && !$error_image && !$error_price){
                        // update in db
                        if($image_uploaded){
                                $sql_img = ", p_picture_filename = ? ";
                        } else{
                                $sql_img = "";
                        }
                                
                        $sql = "UPDATE products
                        SET p_name = ?, p_description = ?, p_price = ? ". $sql_img ."
                        WHERE p_id = ?";

                        if( $stmt = $link->prepare($sql) ) {
                                // bind
                                if($image_uploaded){
                                        $stmt->bind_param("ssisi", $param_name, $param_description, $param_price, $param_picture_filename, $param_id);
                                } else{
                                        $stmt->bind_param("ssii", $param_name, $param_description, $param_price, $param_id);
                                }

                                // set parameters 
                                $param_name = $input_name;
                                $param_description = $input_description;
                                $param_price = $input_price;
                                if($image_uploaded)
                                        $param_picture_filename = $input_image;
                                $param_id = $input_id;
                             
                                // execute
                                $stmt->execute();
                                $stmt->close();

                                echo json_encode(array("status" => "success", "errors_list" => $errors_array, "confirmer_message" => "Successfully updated employee!"));
                        }

                        else{
                                // do nothing
                        }
                }
                else{
                        if($error_name)
                                array_push($errors_array, "Please write name in correct format!");
                        if($error_description)
                                array_push($errors_array, "Please write description in correct format!");
                        if($error_image)
                                array_push($errors_array, "Please upload image in correct format!");
                        if($error_price)
                                array_push($errors_array, "Please write price in correct format!");

                        echo json_encode(array("status" => "error", "errors_list" => $errors_array, "confirmer_message" => "Can't update employee!"));
                }
        }

        if($_POST['action'] == "search-fill-report-rows"){

                // get input variables 
                $input_search_cname = trim( $_POST['cname-input-form-report'] );
                $input_search_cemail = trim( $_POST['cemail-input-form-report'] );
                $input_search_pname = trim( $_POST['pname-input-form-report'] );

                // no need for validation, anything works i think
                // however need to format them within %, like this % input %
                if($input_search_cname == "")
                        $input_search_cname = "%%";
                else 
                        $input_search_cname = "%" . $input_search_cname . "%";

                if($input_search_cemail == "")
                        $input_search_cemail = "%%";
                else 
                        $input_search_cemail = "%" . $input_search_cemail . "%";

                if($input_search_cname == "")
                        $input_search_pname = "%%";
                else 
                        $input_search_pname = "%" . $input_search_pname . "%";

                // do the query, you can't get error before this
                $sql = "SELECT *
                FROM customers AS c
                JOIN orders AS o ON c.c_id = o.c_id
                JOIN order_items AS oi ON o.o_id = oi.o_id
                JOIN products AS p ON oi.p_id = p.p_id
                WHERE c.c_name LIKE '" . $input_search_cname . 
                "' AND c.c_email LIKE '" . $input_search_cemail .
                "' AND p.p_name LIKE '" . $input_search_pname .
                "' GROUP BY o.o_id";

                $result = mysqli_query($link, $sql);

                if(mysqli_num_rows($result) > 0){
                        // display rows
                        $counter = 1;
                        while($row = mysqli_fetch_assoc($result)){
                              ?>

                              <tr>
                                <th> <?= $counter ?> </th>
                                <td>
                                        <p><?= $row['c_name'] ?></p>
                                        <p><?= $row['c_email'] ?></p>
                                        <p><?= $row['c_phone'] ?></p>
                                </td>
                                <td>
                                
                                <?php

                                // subquery for looping through indiividual items of each order and displaying in the td element
                                $sql_subquery = "SELECT *
                                FROM orders AS o
                                JOIN order_items oi ON o.o_id = oi.o_id
                                JOIN products p ON oi.p_id = p.p_id 
                                WHERE o.o_id = " . $row['o_id'];

                                $result_subquery = mysqli_query($link, $sql_subquery);
                                if(mysqli_num_rows($result_subquery) > 0 ){
                                ?>
                                        <table class="table border border-dark">
                                                <thead>
                                                        <tr>
                                                                <th scope="col" class="col-3">Name</th>
                                                                <th scope="col" class="col-3">Unit Price</th>
                                                                <th scope="col" class="col-3">Quantity</th>
                                                                <th scope="col" class="col-3">Total Price</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                        <?php
                                        while($row_subquery = mysqli_fetch_assoc($result_subquery)){
                                                ?>
                                                <!-- make minitable for each product -->
                                                
                                                        <tr>
                                                                <td class="col-3"><?= $row_subquery['p_name'] ?></td>
                                                                <td class="col-3"><?= $row_subquery['p_price'] ?></td>
                                                                <td class="col-3"><?= $row_subquery['p_quantity'] ?></td>
                                                                <td class="col-3"><?= $row_subquery['p_quantity'] * $row_subquery['p_price']?></td>
                                                        </tr>
                                                        
                                              
                                        
                                                <?php
                                        }

                                        ?>
                                                </tbody>
                                        </table>

                                        <?php
                                }
                                else {
                                        // do nothing
                                }

                                ?>

                                </td>
                                <td><?= $row['o_bill'] ?></td>
                              </tr>  

                              <?php  
                              $counter++;
                        }
                        
                }
                else {
                        // don't display
                        echo "<p>No results found!</p>";
                }
        }
}


if (( isset($_GET['action']) && !empty($_GET["action"])) ) {

        if ($_GET['action'] == "includeItemInCart") {
                array_push($_SESSION['cart'], array("cart_item_id"=>$_GET['cart_product_id'], "cart_item_quantity"=>$_GET['product_quantity'] ));
        }

        // dynamically fill all-orders-details-area in orders.html
        if ($_GET["action"] == "fill-all-orders-orderspage") {
                // $sql = "SELECT * FROM orders NATURAL JOIN order_items NATURAL JOIN products NATURAL JOIN customers ORDER BY o_id DESC";
                $sql = "SELECT *
                FROM orders AS o
                JOIN order_items AS oi ON o.o_id = oi.o_id
                JOIN customers AS c ON o.c_id = c.c_id
                GROUP BY o.o_id
                ORDER BY oi.o_id DESC
                ";

                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                        // OUTPUT DATA OF EACH ROW
                
                        $order_idx = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                        <td><a href="specific-order-details.php?order_id=<?= $row['o_id'] ?>"><?= $order_idx ?></a></td>
                                        <td><?= $row['c_name'] ?></td>
                                        <td><?= $row['c_email'] ?></td>
                                        <td><?= $row['o_bill']?></td>
                                </tr>
                                <?php

                                $order_idx++;
                                
                        }

                
                   
                        
                } else {
                        echo "0 results";
                }
        }

        // dynamically fill all-items-area in home.html
        if ($_GET["action"] == "fill-all-items-homepage") {

                $sql = "SELECT * 
                FROM products 
                JOIN stock_products ON products.p_id = stock_products.p_id";

                $result = mysqli_query($link, $sql);
                $cards_counter = 0;

                if (mysqli_num_rows($result) > 0) {
                        // OUTPUT DATA OF EACH ROW 
                        if ($cards_counter % 3 == 0 && $cards_counter == 0) {
                                ?>
                                <div class="container">
                                        <div class="row">
                                <?php
                        }


                        while ($row = mysqli_fetch_assoc($result)) {
                                // if ($cards_counter % 3 == 0 && $cards_counter != 0) {

                                //         echo '<div class="row justify-content-center">';
                                // }
                                ?>
                                        <div class="col-4 gy-2 mx-auto">
                                                <div class="card border border-dark text-white bg-dark mx-auto my-auto" style="width: 18rem;">

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

                                                                <label for="num_items_<?= $row["p_id"] ?>">Number</label>
                                                                <input id='num_items_<?= $row["p_id"] ?>' <?php if ($row['p_stock_quantity'] == 0) echo 'disabled'; ?> min=1 value=1 type="number">

                                                                <!-- need to log the user's response and store on sessionkey/cookie (implement in includeOneProduct() ) -->
                                                                <button id="buy_button_<?= $row["p_id"] ?>" <?php if ($row['p_stock_quantity'] == 0) echo 'disabled' ?> onclick='includeOneProduct(<?= $row["p_id"] ?>)' class="btn btn-primary">Buy</button>
                                                                        
                                                                <p class="text-success opacity-0" id="add_cart_message_<?=$row['p_id']?>">Added to Cart &check;</p>
                                                                
                                                        </div>
                                                </div>
                                        </div>
                                <?php
                                // $cards_counter++;
                                // if ($cards_counter % 3 == 0 && $cards_counter != 0) {

                                //         echo '</div>';
                                // }
                        }
                        ?>
                                </div>
                        </div>
                        <?php
                } else {
                        // echo "0 results";
                }
        }


        // dynamically fill all selected-cart-items-area in cart,html
        if ($_GET["action"] == "fill-selected-items-cartpage") {
                foreach($_SESSION['cart'] as $cart_item){

                        ?>
                        <?php

                        $sql = "SELECT * 
                        FROM products 
                        WHERE p_id=" . $cart_item["cart_item_id"];

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
                                                        <h5> <?php echo $cart_item["cart_item_quantity"] ?> </h5>
                                                </td>
                                                <td>
                                                        <h5> <?php echo $row["p_price"] ?> </h5>
                                                </td>
                                                <td>
                                                        <h5> <?php echo $cart_item["cart_item_quantity"] * $row["p_price"] ?></h5>
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
                        $sql_customer = "SELECT * 
                        FROM customers 
                        WHERE c_email = '" . $_GET["customer_email"] . 
                        "' OR c_phone= " . "'" . $_GET["customer_phone_number"] . 
                        "'"; // only c_email OR c_phone for validation

                        $result = mysqli_query($link, $sql_customer);
                        $status_customer_verification = "";
                
                        // if neither customer email nor username NOT FOUND in table customers, gotta creeate new customer then add order by his name
                        if (mysqli_num_rows($result) == 0) {
                
                                // we don't have customer details, so need to insert customer into customers table
                                $sql_customer_insertion = "INSERT INTO customers ( c_name, c_email, c_phone ) VALUES ( '" . $_GET["customer_name"] . "', '" . $_GET["customer_email"] . "', '" . $_GET["customer_phone_number"] .  "' )";
                                if (mysqli_query($link, $sql_customer_insertion)) {
                                        $customer_id_input = mysqli_insert_id($link);
                                } else {
                                        echo "Error: " . $sql_customer_insertion . "<br>" . mysqli_error($link);
                                }

                                // customer is ready, can now add order by his nname
                                $status_customer_verification = true;
                                
                                // get customer_id of already present customer in customers table
                                $customer_id_input = $row['c_id'];

                        }
                        // if 1 unique entry exists, can add entry by that customer 
                        else if (mysqli_num_rows($result) == 1) {
                                // customer already exists, can add order by his name
                                $status_customer_verification = true;

                                // get customer_id of already present customer in customers table
                                $row = mysqli_fetch_assoc($result);
                                $customer_id_input = $row['c_id'];
                        }
                        // if more than 1 entry, then don't know which customer to add record by. don't make order!
                        else {
                                echo "Can't add order as there is mismatch of Customer Phone # and Email Address!";
                                $status_customer_verification = false;
                        }

                        // FAULTY ORDER BILL GENERATION: NEED TO FIX!!!
                        if ($status_customer_verification) {
                                // insert into Orders table ONCE (NOT WORKING!)
                                $total_order_bill = 0; 
                                $array_ids = [];

                                foreach($_SESSION['cart'] as $cart_item){
                                        array_push($array_ids, $cart_item['cart_item_id']);
                                }
                                
                                $sql_bill_generation = "SELECT * 
                                FROM products 
                                WHERE p_id IN ( ";

                                $counter = 1;
                                foreach($array_ids as $id){
                                        if($counter == sizeof($array_ids))
                                                $sql_bill_generation .= $id;
                                        else 
                                                $sql_bill_generation .= $id . ", ";

                                        $counter++;
                                }

                                $sql_bill_generation = $sql_bill_generation . " )";

                                $result_bill_generation = mysqli_query($link, $sql_bill_generation);

                                if(mysqli_num_rows($result_bill_generation) > 0){
                                        while($row = mysqli_fetch_assoc($result_bill_generation)){

                                                // search for db's row's ID in session cart array
                                                foreach($_SESSION['cart'] as $cart_item){
                                                        if($cart_item["cart_item_id"] == $row["p_id"]){
                                                                $idx_cart = array_search($cart_item, $_SESSION['cart']);
                                                                break;
                                                        }
                                                }
                                                
                                                $total_order_bill += $_SESSION['cart'][$idx_cart]["cart_item_quantity"] * $row['p_price'];
                                        }
                                }

                                else{
                                        // do nothing
                                }

                                $sql = "INSERT INTO orders (c_id, o_bill) 
                                VALUES (" . $customer_id_input . ", " . $total_order_bill .  ")"; // prepare sql query

                                if (mysqli_query($link, $sql)) {
                                        // echo "New record created successfully in ORDERS table";
                                } else {
                                        echo "Error: " . $sql . "<br>" . mysqli_error($link);
                                }


                                // insert into OrderItems AS MANY TIMES AS NEEDED (iterate over sesson array length) AND update stock_items table (NOT WORKING!)
                                $order_id = mysqli_insert_id($link);

                                // for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                                foreach($_SESSION['cart'] as $cart_item){

                                        // INSERT INTO ORDER_ITEMS TABLE
                                        $sql_item = "INSERT INTO order_items (o_id, p_id, p_quantity) 
                                        VALUES (" . $order_id . ", " . $cart_item["cart_item_id"] . ", " . $cart_item["cart_item_quantity"] . ")";

                                        if (mysqli_query($link, $sql_item)) {
                                                // echo "New record created successfully in ORDER_ITEMS table";
                                        } else {
                                                echo "Error: " . $sql_item . "<br>" . mysqli_error($link);
                                        }

                                        // UPDATE STOCK_ITEMS TABLE
                                        $sql_stock = "UPDATE stock_products 
                                        SET p_stock_quantity = p_stock_quantity - " . $cart_item["cart_item_quantity"] . 
                                        " WHERE p_id = " . $cart_item["cart_item_id"];

                                        if (mysqli_query($link, $sql_stock)) {
                                                // echo "Stock item record updated successfully";
                                        } else {
                                                echo "Error updating stock items record: " . mysqli_error($link);
                                        }
                                }

                                
                                $_SESSION['cart'] = []; // clear session variable that contains all cart items
                                $_SESSION['last_order_id'] = $order_id; // oasses current order id to session, so that relevant confirming message can be displayed
                                echo "Success!"; // shows frontend that everything ran perfectly, orderItems orders and/or customers updated

                        }
                } 
                else {
                        $array_errors = [];
                        array_push($array_errors, $error_name, $error_email, $error_phone);
                        echo json_encode($array_errors);
                }
        }

        if ($_GET['action'] == 'clear-cart') {
                $_SESSION['cart'] = [];
        }

        if ($_GET['action'] == 'fill-confirming-message-page') {
                $last_id = $_SESSION['last_order_id'];

                // get all details of last order only
                $sql = "SELECT * 
                FROM orders 
                JOIN order_items ON orders.o_id = order_items.o_id 
                JOIN products ON order_items.p_id = products.p_id 
                JOIN customers ON orders.c_id = customers.c_id
                WHERE order_items.o_id = '" . $last_id . "'";

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

                        $text_list = $text_list . "</ul>";
                        

                        ?>
                        <p> Customer Name: <?= $c_name ?> </p>
                        <p> Customer Email: <?= $c_email ?></p>
                        <p>Customer Phone Number: <?= $c_phone ?> </p>

                        <p>Your total bill was <?php echo $sum ?></p>
                        <p>Your items were as follows:</p>
                        <?php echo  $text_list ?>
                        

                <?php
                } else {
                        echo "0 results";
                }
        }

        if($_GET['action'] == 'view-specific-order'){
                
                $sql = "SELECT * 
                FROM orders 
                JOIN order_items ON orders.o_id = order_items.o_id 
                JOIN products ON order_items.p_id = products.p_id
                JOIN customers ON orders.c_id = customers.c_id
                WHERE order_items.o_id = " . $_GET['order_id'];


                $result = mysqli_query($link, $sql);
                if(mysqli_num_rows($result) > 0){

                        $sum = 0;
                        
                        while ($row = mysqli_fetch_assoc($result)) { // will run some times

                                if(!isset($customer_name) && !isset($customer_email) && !isset($customer_phone)){
                                        $customer_name = $row['c_name'];
                                        $customer_email = $row['c_email'];
                                        $customer_phone = $row['c_phone'];

                                        ?>
                                        
                                        
                                        <p>Customer Name: <?= $customer_name ?></p>
                                        <p>Customer Email: <?= $customer_email ?></p>
                                        <p>Customer Phone #: <?= $customer_phone ?></p>

                                        <table class="table">
                                                <thead>
                                                        <tr>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Unit Price</th>
                                                                <th scope="col">Total Price</th>
                                                        </tr>
                                                </thead>
                                                <tbody>

                                        <?php
                                }
                        ?>

                                                        <tr>
                                                                <td>
                                                                        <?php echo $row["p_quantity"] ?>
                                                                <td>
                                                                        <?php echo $row["p_name"] ?> 
                                                                </td>
                                                                <td>
                                                                        <?php echo $row["p_price"] ?>
                                                                </td>
                                                                <td>
                                                                        <?php echo $row["p_price"] * $row["p_quantity"] ?>
                                                                </td>
                                                        </tr>
                                
                        <?php
                        $sum += $row["p_price"] * $row["p_quantity"];
                        }       

                        
                        ?>
                                <tr>
                                        <td colspan="2"></td>
                                        <td>Total Bill</td>
                                        <td><?= $sum ?></td>
                                </tr>
                                </tbody>
                        </table>
                        
                        <?php

                } else {
                        echo "0 results";
                }
                

        
        }

        if($_GET['action'] == "fill-stock-page"){

                $sql = "SELECT * FROM stock_products JOIN products ON stock_products.p_id = products.p_id";
                $result = mysqli_query($link, $sql);

                if(mysqli_num_rows($result) > 0){
                        $items_counter = 1;
                        
                        while($row = mysqli_fetch_assoc($result)){
                                ?>
                                        <tr class="border border-dark">
                                                <th><?= $items_counter ?></th>
                                                <td><img src="./media/<?= $row['p_picture_filename'] ?>" alt="" width="200px" height="200px"></td>
                                                <td><?= $row['p_name']?></td>
                                                <td><?= $row['p_stock_quantity'] ?></td>
                                                <td class="h1">
                                                        <?php if($row['p_stock_quantity'] > 0) echo "&#x2714;"; else echo "&#x2716;";?> 
                                                </td>
                                                <td scope="col"><button class="btn btn-primary" onclick="toggleUpdateStock(<?= $row['p_id'] ?>)">Update</button></td>
                                        </tr> 

                                <?php
                                $items_counter++;
                        }

                }
                else{
                        echo "There are no items in stock! Please add some items to your inventory.";
                }
        }

        // ALL CODE FOR PRODUCT MANAGER PAGE

        // this will render the product manager page initially. read rows and display
        if($_GET['action'] == "fill-products-crud"){

                $counter = 1;
                $sql = "SELECT *
                FROM products";

                $result = $link->query($sql);
                

                if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                        <th><?= $counter ?></th>
                                        <td><?= $row['p_name'] ?></td>
                                        <td><?= $row['p_description'] ?></td>
                                        <td><?= $row['p_price'] ?></td>
                                        <td> 
                                                <img src="./media/<?= $row['p_picture_filename'] ?>" alt="" height="200px" width="200px">
                                                
                                        </td>
                                        <td>
                                                <button class="btn btn-primary" onclick="toggleUpdateProduct(<?= $row['p_id'] ?>)">Update</button>
                                                <button class="btn btn-danger" onclick="toggleDeleteProduct(<?= $row['p_id'] ?>)">Delete</button>
                                        </td>
                                </tr>
                                <?php
                                $counter++;
                        }
                } 
                else {
                        echo "0 results";
                }
                
                
                
        }

        if($_GET['action'] == "toggle-update-product-crud"){
                $product_id = $_GET['product_id'];
        
                $sql = "SELECT *
                FROM products
                WHERE p_id = " . $product_id;

                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                        // output data of the 1 row we get!
                        $row = $result->fetch_assoc();

                        echo json_encode(array( "p_name"=>$row['p_name'], "p_description"=>$row['p_description'], "p_price"=>$row['p_price'], "p_image"=>$row['p_picture_filename'] ));            
                } 
                else {
                        echo "0 results";
                }
        }

        if($_GET['action'] == "delete-product-crud"){
                $input_id = $_GET['product_id'];

                // remove file from local storage too. save filename now
                $sql = "SELECT p_picture_filename
                FROM products
                WHERE p_id = " . $input_id;

                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $old_image_filename = $row['p_picture_filename'];


                $sql = "DELETE FROM products
                WHERE p_id = ?";

                // delete from products table
                if( $stmt = $link->prepare($sql) ){
                        // bind
                        $stmt->bind_param("i", $param_id);

                        // set parameters 
                        $param_id = $input_id;

                        // execute
                        $stmt->execute();
                        $stmt->close();

                        // now delete from stock_products table
                        $sql = "DELETE FROM stock_products
                        WHERE p_id = ?";

                        if( $stmt = $link->prepare($sql) ){
                                // bind
                                $stmt->bind_param("i", $param_id);

                                // set parameters 
                                $param_id = $input_id;

                                // execute
                                $stmt->execute();
                                $stmt->close();

                                // now that record of product has been deleted, we can safely unlink old image too from local storage as it's no longer needed
                                $old_image_filename = "./media/" . $old_image_filename;
                                if (!unlink($old_image_filename)) {
                                        // echo ("$file_pointer cannot be deleted due to an error");
                                }
                                else {
                                        // echo ("$file_pointer has been deleted");
                                }


                                // send confirmation msg
                                echo json_encode(array("status" => "success", "confirmer_message" => "Succesfully deleted employee!"));
                        }
                        else{
                                // send error msg
                                echo json_encode(array("status" => "error", "confirmer_message" => "Can't delete employee! Error while deleting from stock_products table."));
                        }
                        

                        
                }
                else{
                        // send error msg
                        echo json_encode(array("status" => "error", "confirmer_message" => "Can't delete employee! Error while deleting from products table."));
                }
        }

        if($_GET['action'] == "toggle-update-stock"){
                $product_id = $_GET['product_id'];
        
                $sql = "SELECT *
                FROM stock_products
                WHERE p_id = " . $product_id;

                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                        // output data of the 1 row we get!
                        $row = $result->fetch_assoc();

                        echo json_encode(array( "p_stock_quantity"=>$row['p_stock_quantity'] ));            
                } 
                else {
                        echo "0 results";
                }
        }

        if($_GET['action'] == "update-stock"){
                // get inputs
                $input_quantity = $_GET['quantity_stock'];
                $input_id = $_GET['product_id'];

                // declare error variables
                $error_quantity = false;
                $errors_array = [];

                // validate
                if($input_quantity < 0)
                        $error_quantity = true;

                // if no error, proceed
                if(!$error_quantity){

                        $sql = "UPDATE stock_products
                        SET p_stock_quantity = ?
                        WHERE p_id = ?";

                        if( $stmt = $link->prepare($sql) ) {
                                // bind
                                $stmt->bind_param("ii", $param_stock_quantity, $param_id);

                                // set parameters 
                                $param_stock_quantity = $input_quantity;
                                $param_id = $input_id;
                        
                                // execute
                                $stmt->execute();
                                $stmt->close();

                                echo json_encode(array("status" => "success", "errors_list" => $errors_array, "confirmer_message" => "Successfully updated stock!"));
                        }

                        else{
                                // do nothing
                        }


                }

                // if error, send appropriate error message
                else{
                        if($error_quantity)
                                array_push($errors_array, "Please write quantity in valid format!");

                        echo json_encode(array("status" => "error", "errors_list" => $errors_array, "confirmer_message" => "Can't update stock!"));
                }
        }
                
}

if(isset($_REQUEST["term"])){
                // Prepare a select statement
                $sql = "SELECT * 
                FROM products 
                JOIN stock_products ON products.p_id = stock_products.p_id
                WHERE p_name LIKE ?";
                
                if($stmt = mysqli_prepare($link, $sql)){
                        $response_table_rows = "";    

                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_term);
                        
                        // Set parameters
                        $param_term = $_REQUEST["term"] . '%';
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                                $result = mysqli_stmt_get_result($stmt);
                                
                                // Check number of rows in the result set
                                if(mysqli_num_rows($result) > 0){
                                        $response_table_rows = "";
                                        $items_counter = 1;

                                        // Fetch result rows as an associative array
                                        // while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        //         $response_table_rows = $response_table_rows . "<p>" . $row["p_name"] . "</p>";
                                        // }

                                        while($row = mysqli_fetch_assoc($result)){
                                               
                                                $response_table_rows .= '
                                                <tr class="border border-dark">
                                                        <th>' . $items_counter . '</th>
                                                        <td><img src="./media/ ' . $row['p_picture_filename'] . '" alt="" width="200px" height="200px"></td>
                                                        <td>' . $row['p_name'] . '</td>
                                                        <td>' . $row['p_stock_quantity'] . '</td>
                                                        <td class="h1">';
                                                                
                                                if($row['p_stock_quantity'] > 0) 
                                                        $response_table_rows.= "&#x2714;";
                                                else 
                                                        $response_table_rows .= "&#x2716;";
                                                       
                                                
                                                $response_table_rows .= '
                                                        </td>
                                                                <td scope="col"><button class="btn btn-primary" onclick="toggleUpdateStock(' . $row['p_id'] . ')">Update</button></td>
                                                        </tr> 
                                                ';
                                                
                                               // converrt this html to php in response table rows
                                         
                                                $items_counter++;
                                        }

                                        echo json_encode(array("status"=>"success_rows", "response_html"=>$response_table_rows, "confirmer_message"=>"We found some records!"));
                                } 
                                else{
                                        echo json_encode(array("status"=>"success_no_rows", "response_html"=>$response_table_rows, "confirmer_message"=>"No records found!"));
                                }
                        } else{
                                echo json_encode(array("status"=>"error", "response_html"=>$response_table_rows, "confirmer_message"=>"ERROR: Could not able to execute $sql. " . mysqli_error($link)));

                        }
                }
                 
                // Close statement
                mysqli_stmt_close($stmt);
            }