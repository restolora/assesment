<?php 

include 'sup-autoloader.inc.php';
$conn = new dbconnect();

if(isset($_POST['registration'])){
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$cpass = $_POST['con-pass'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$contact = $_POST['contact'];
	$address = $_POST['address'];
	$company = $_POST['company'];
	$sec = $_POST['sec'];
	$address = $_POST['address'];

	$pass = md5($pass);
	$vkey = md5(time());
	$values = array(
		"email" => $email,
		"password" => $pass,
		"first_name" => $fname,	
		"last_name" => $lname,
		"contact" => $contact,
		"address" => $address,
		"company_name" => $company,
		"sec_number" => $sec,
		"vkey" => $vkey		
	);
	$fields = array("email =");
	$data = array($email);
	$count = $conn->getIfExist("users", $fields, $data);
	if($count > 0){
		echo 2;
	}else{
		$query = new UsersContr();
		$result = $query->newData($values,"Registration Error");
		if($result == ""){
			echo 1;
		}else{
			echo "Registration Error:".$result; 
		}	
	}
}
// ajax
if(isset($_POST['login'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$pass = md5($pass);

		$fields = array("email =", "password =");
		$data = array($email, $pass);
		$count = $conn->getIfExist("users", $fields, $data);
		if($count > 0){
			$query = new UsersView();
			$column = array("email =");
			$data = array($email);
			$result = $query->showActiveData($column, $data);

			foreach ($result as $data) {
				$user_ID = $data['user_ID'];
			}
			session_start();
			$_SESSION['user_ID'] = $user_ID;
			echo $count;
		}else{
			echo 2;
		}
	}
}




	$conn = new Connection();

	// $table ='users';
	// $set = array('fullname =', 'email =', 'password =');
	// $where = array('userID =');
	// $data = ($fullname, $email, $password, $userID);
	// $result = $conn->update($table, $set, $where, $data);
	// if($result != ''){
	// 	print_r($result);
	// }





















if(isset($_POST['products'])){
	$query = new ProductsView();
	$column = array("is_active =");
	$data = array("1");
	$records = $query->showActiveData($column, $data);
	$output = "";
	if($records){
		foreach ($records as $data) {
			$output .= '
						<div class="col-lg-4 col-sm-6">
                            <div class="product-item">
                                <div class="pi-pic">
                                	<input type="hidden" name="quantity" id="quantity" value="1">
                                    <img src="./img/product/'.$data['prod_image'].'" alt="">
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon"><button type="submit" name="add_to_cart" id="add_to_cart" value="'.$data['prod_ID'].'"><i class="icon_bag_alt"></i>Add to Cart</button></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">'.$data['category_name'].'</div>
                                    <a href="#">
                                        <h5>'.$data['prod_name'].'</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
						';
		}
	}else{
		$output .= "No data found!";	
	}
	echo $output;		
	
}

if(isset($_POST['getCategory'])){
	$query = new CategoriesView();
	$fields = array("category_ID IN(SELECT DISTINCT(prod_category) FROM products) =");
	$data = array("1");
	$result = $query->showActiveData($fields, $data);
	$records="";
	if($result){
		foreach ($result as $data) {
			# code...
			$records .= '<li><a href="shop.php?c='.$data['category_name'].'&p=1">'.ucfirst($data['category_name']).'</a></li>';
		}
	}
	echo $records;
}
if(isset($_POST['add_to_cart'])){
	$id = $_POST['id'];
	$user = $_POST['user'];
	$quantity = $_POST['quantity'];
	$query = new CartContr();
	$values1 = array("prod_ID =","user_ID =");
	$data = array($id, $user);
	$count = $conn->getIfExist("cart", $values1, $data);
	if($count > 0){
		$sql = new CartView();
		$column = array("prod_ID =", "user_ID =");
		$cdata = array($id, $user);
		$result = $sql->showActiveData($column, $cdata);
		foreach ($result as $data) {
			$cartquantity = $data['quantity'];
		}
		if($quantity == 1){
			$newQuantity = $cartquantity + 1;
		}else{
			$newQuantity = $quantity;
		}
		$setValues = array("quantity");
		$values = array("prod_ID","user_ID");
		$data = array($newQuantity,$id,$user);
		$result = $query->editData1($setValues, $values, $data);
		echo 2;
	}else{
		$values = array(
			"prod_ID" => $id,
			"user_ID" => $user,
			"quantity" => $quantity
		);
		$result = $query->newData($values);
		if($result == ""){
			echo 1;
		}else{
			echo $result;
		}	
	}
}
if(isset($_POST['cartNo'])){
	$user_ID = $_POST['user_ID'];
	$column = array("user_ID =");
	$data = array($user_ID);
	$count = $conn->getIfExist("cart",$column, $data);
	echo $count;
}
if(isset($_POST['cartItems'])){
	$user_ID = $_POST['user_ID'];
	$column = array("user_ID =");
	$data = array($user_ID);
	$sql = new CartView();
	$result = $sql->showActiveData($column, $data);
	$out = "";
	if ($result) {
		# code...
		foreach ($result as $data) {
			$out .='<tr>
				        <td class="si-pic"><img src="img/product/'.$data['prod_image'].'" alt=""></td>
				        <td class="si-text">
				            <div class="product-selected">
				                <!-- <p>$60.00 x 1</p> -->
				                <h6>'.$data['quantity'].' x '.ucfirst($data['prod_name']).'</h6>
				            </div>
				        </td>
				        <td class="si-close">
				            <i class="ti-close"></i>
				        </td>
				    </tr>';
		}
		echo $out;
	}else{
		$out .='<tr>
			        <td class="si-text">
			            <div class="product-selected">			            
			                <h6>No items selected.</h6>
			            </div>
			        </td>
			        <td class="si-close">
			        </td>
			    </tr>';
		echo $out;
	}

}

if (isset($_POST['viewCart'])) {
	$user_ID = $_POST['user_ID'];
	$column = array("user_ID =");
	$data = array($user_ID);
	$sql = new CartView();
	$result = $sql->showActiveData($column, $data);
	$out = "";
	foreach ($result as $data) {
		$out .='<tr>
                    <td class="cart-pic first-row"><img src="img/product/'.$data['prod_image'].'" alt=""></td>
                    <td class="cart-title first-row">
                        <h5>'.ucfirst($data['prod_name']).'</h5>
                    </td>
                    <td class="total-price first-row">$60.00</td>
                    <td class="qua-col first-row">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="number" min="1" name="quantity[]" id="'.$data['cart_ID'].'" value="'.$data['quantity'].'">
                                <input type="hidden" name="cart_ID[]" value="'.$data['cart_ID'].'">
                            </div>
                        </div>
                    </td>
                    <td class="close-td first-row"><button type="button" class="btn btn-sm btn-danger remove_from_cart" id="'.$data['cart_ID'].'" style="padding-bottom: 0;"><i class="ti-close"></i></button></td>
                </tr>
				';
	}
	echo $out;
}
if (isset($_POST['updateqty'])) {
	// echo 'cart';
	$id = $_POST['id'];
	$newqty = $_POST['qty'];
	$query = new CartContr();
	$setValues = array("quantity");
	$values = array("cart_ID");
	$data = array($newqty,$id);
	$result = $query->editData1($setValues, $values, $data);
	if($result == ""){
		echo 1;
	}else{
		echo $result;
	}
}
if(isset($_POST['update_quotation_qty'])){
	// echo 'quotation';
	$id = $_POST['id'];
	$newqty = $_POST['qty'];
	$query = new QuotationItemsContr();
	$setValues = array("quantity");
	$values = array("q_items_ID");
	$data = array($newqty,$id);
	$result = $query->editData1($setValues, $values, $data);
	if($result == ""){
		echo 1;
	}else{
		echo $result;
	}
}
if(isset($_POST['q_table_items'])){
	$q_head_ID = $_POST['q_head_ID'];
	$status = $_POST['status'];

	// getting the mark-up
	$query = new QuotationHeaderView();
    $column = array("q_head_ID =");
    $data = array($q_head_ID);
    $result1 = $query->showActiveData($column,$data);    
    if($result1){
      foreach ($result1 as $data) {	        
        $mark_up = $data['mark_up'];
        $status = $data['status'];
        $total_amount = $data['total_amount'];
      }
    }


	$query = new QuotationItemsView();
    $column = array("q_head_ID =");
    $data = array($q_head_ID);
    $result = $query->showActiveData($column,$data); 
    $records = "";
    $sum_of_total = 0;
    $idx = 0;
    if ($result) {
        foreach ($result as $data) {
            $idx = $idx + 1; 
            $unit_price = getTotalVat($data['prod_unit_price']) * $mark_up;
            $total_price = $data['prod_unit_price'] * $data['quantity'] ;              
            $total_price = getTotalVat($total_price) * $mark_up;
            $sum_of_total = $sum_of_total + $total_price;
            $total = number_format($sum_of_total,2);
            $records .= '
                <tr>
                    <td>'.$idx.'</td>
                    <td class=""><img class="prod_image" style="width:70px;" src="img/product/'.$data["prod_image"].'"> &nbsp '.$data['prod_name'].'<h6></td>
                    <td class=" "><h6>'.$data['unit_name'].'</h6></td>
                    <td class="text-center"><h6>'.$data['prod_min_order'].'<h6></td>
                    <td class="qua-col first-row">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="number" min="'.$data['prod_min_order'].'" name="quantity[]" class="q-qty" id="'.$data['q_items_ID'].'" value="'.$data['quantity'].'">
                                <input type="hidden" name="q_items_ID[]" value="'.$data['q_items_ID'].'">
                            </div>
                        </div>                                                  
                    </td>
                    ';
            if($status == 3){
                $records .= '        
                        <td align="right" class=" "><h6>Php '.number_format($unit_price,2).'</h6></td>
                        <td align="right" class=" last "><h6>Php '.number_format($total_price,2).'</h6></td>
                    </tr>';
            }
        }
        if($status == 3){
            $records  .='
            <tr class="even pointer">
                    <td colspan="6" align="right"><h5>VATable Sales: </h5></td>
                    <td align="right"><h5>Php '.number_format(vatable($sum_of_total),2).'</h5></td>
            </tr>
            <tr class="even pointer">
                    <td colspan="6" align="right"><h5>VAT Amount: </h5></td>
                    <td align="right"><h5>Php '.number_format(vatAmount($sum_of_total),2).'</h5></td>
            </tr>
            <tr class="even pointer">
                    <td colspan="6" align="right"><h5>Total: </h5></td>
                    <td align="right"><h5><b>Php <span class="total_amount" id="'.$sum_of_total.'">'.$total.'</span></b></h5></td>
            </tr>';
        }
        echo $records;
    } 


}
// proceed to checkout 
if(isset($_POST['checkout'])){
	
	$quantity = $_POST['quantity'];
	$q_items_ID = $_POST['q_items_ID'];
	$count = count($quantity) - 1;	
	// var_dump($quantity);
	// updating selected quantity of items
	for ($i=0; $i <= $count ; $i++) { 
		$cart = new QuotationItemsContr();
		$setValues = array("quantity");
		$values = array("q_items_ID");
		$data = array($quantity[$i],$q_items_ID[$i]);
		$result = $cart->editData1($setValues, $values, $data);
		echo $result;
	}
}




// product remove from cart

if(isset($_POST['remove_from_cart'])){
	$cart_ID = $_POST['id'];
	$query = new CartContr();
	$values = array(
		'cart_ID' => $cart_ID
	);
	$result = $query->delData($values);	
	if($result == ""){
		echo 1;
	}else{
		echo $result;
	}

}

if(isset($_POST['rfq'])){
	$user_ID = $_POST['user_ID'];
	$quantity = $_POST['quantity'];
	$cart_ID = $_POST['cart_ID'];
	$count = count($quantity) - 1;	
	// var_dump($quantity);
	// updating selected quantity of items
	for ($i=0; $i <= $count ; $i++) { 
		$cart = new CartContr();
		$setValues = array("quantity");
		$values = array("cart_ID");
		$data = array($quantity[$i],$cart_ID[$i]);
		$result = $cart->editData1($setValues, $values, $data);
	}
	if($result == ""){
		// making quotation records
		$date = date("Y-m-d");
		$today = date("Ymd"); 
		$rand = strtoupper(substr(uniqid(sha1(time())),0,7));
		$q_ID = 'AMD'.$today . $rand;	

		$query = new QuotationHeaderContr();
		$values = array(
			"q_head_ID" => $q_ID,
			"user_ID" => $user_ID,
			"date" => $date
		);
		$result = $query->newData($values);
		if($result == ""){
			// FETCHING CART ITEMS OF USER TO QUOTATION ITEMS TABLE
			$column = array("user_ID =");
			$data = array($user_ID);
			$sql = new CartView();
			$result3 = $sql->showActiveData($column, $data);
			foreach ($result3 as $data) {
				$cart_ID = $data['cart_ID'];
				$prod_ID = $data['prod_ID'];
				$quantity = $data['quantity'];

				// INSERTING CART ItEM PRODUCtS TO QUOTATION ITEMS TABLE
				$query = new QuotationItemsContr();
				$values = array(
					"q_head_ID" => $q_ID,
					"prod_ID" => $prod_ID,
					"quantity" => $quantity
				);
				$result = $query->newData($values);

				// delete cart items
				$cartValues = array("cart_ID" => $cart_ID);
				$cartResult = $cart->delData($cartValues);
				if($cartResult != ""){
					echo $cartResult;
				}
			}	
			if($result == ""){
				echo 1;
			}else{
				echo $result;
			}
		}else{
			echo $result;
		}
	}else{
		echo $result;
	}
}


if(isset($_POST['place_order'])){
	$quotation_ID = $_POST['quotation_ID'];
	$user_ID = $_POST['user_ID'];
	$total_amount = $_POST['total_amount'];
	$shipping_address = $_POST['shipping_address'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$contact = $_POST['contact'];
	$date = date('Y-m-d');
	// insert new orders
	$query = new OrdersContr();
	$values = array(
		"quotation_ID" => $quotation_ID,
		"user_ID" => $user_ID,
		"total_amount" => $total_amount,
		"shipping_address" => $shipping_address,
		"country" => $country,
		"city" => $city,
		"contact" => $contact,
		"date" => $date
	);
	// var_dump($values);
	$result = $query->newData($values);
	if($result == ""){

		$sql = new QuotationHeaderContr();
		$setValues = array('status');
		$values = array('q_head_ID');
		$data = array(4,$quotation_ID);
		$result = $sql->editData1($setValues, $values, $data);
		if($result == ""){
			echo 1;
		}else{
			echo 'Error updating quotation status: '.$result;
		}
	}else{
		echo $result;
	}

}


if(isset($_POST['cancel_quotation'])){
	$id = $_POST['id'];
	$status = 5;
	$sql = new QuotationHeaderContr();
	$setValues = array('status');
	$values = array('q_head_ID');
	$data = array($status,$id);
	$result = $sql->editData1($setValues, $values, $data);
	if($result == ""){
		echo 1;
	}else{
		echo 'Error updating quotation status: '.$result;
	}
}


// change password

if(isset($_POST['current_p'])){
	$user_ID = $_POST['user_ID'];
	$current_p = $_POST['current_p'];
	$new_p = $_POST['new_p'];
	$confirm_p = $_POST['confirm_p'];
	$fields = array("user_ID =", 'password =');
	$data = array($user_ID, md5($current_p));
	$count = $conn->getIfExist("users", $fields, $data);
	if($count >= 1){
		if(strlen($new_p) >= 8){
			if($new_p == $confirm_p){

				$query = new UsersContr();
				$set = array('password');
				$where = array('user_ID');
				$data = array(md5($new_p), $user_ID);
				$result = $query->editData1($set, $where, $data);
				if($result != ""){
					echo $result;
				}
			}else{
				echo '1';
			}
		}else{
			echo '2';
		}
	}else{
		echo '3';
	}


}