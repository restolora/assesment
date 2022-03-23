<?php
    require('./includes/class-autoloader.inc.php');
    $conn = new dbconnect();
    $query = new UsersController();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    if($query){
        $req = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER['REQUEST_METHOD'] : null; 
        switch ($req) {
            case 'POST':
                $request_body = file_get_contents('php://input');
                $POST = json_decode($request_body, true);// Works!

                $name = $POST['Name'];
                $email = $POST['Email'];
                $pass = $POST['Password'];
                $pass5 = md5($pass);
    
                $values = array(
                    "Name" => $email,
                    "Password" => $pass5,
                    "Email" => $email
                );
                $fields = array("email =");
                $data = array($email);
                $count = $conn->getIfExist("users", $fields, $data);
                if($count > 0){
                    $rslt['message'] = "Email is already taken.";
                    $rslt['data'] = "exist";
                    echo json_encode($rslt);

                }else{
                    $result = $query->newData($values);
                    $column = array("Email =");
                    $cdata = array($email);
                    $result = $query->showActiveData($column, $cdata);
                    $rslt['message'] = "Successfully Created";
                    $rslt['data'] = $result;
                    http_response_code(200);
                    echo json_encode($rslt);      

                }
                break;

            case 'GET':
                $data = $query->getAll();
                $rslt['message'] = "Fetching success";
                $rslt['data'] = $data;
                http_response_code(200);
                echo json_encode($rslt); 

                break;
            default:
                $rslt = json_decode();
                echo $rslt;
                break;
        }

    }
?>