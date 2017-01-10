<?php
error_reporting(E_ALL ^ E_DEPRECATED);
/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data

  /**
 * check for POST request 
 */
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include DB_function
    require_once 'DB_Functions.php';
    $db = new DB_Functions();

    // response Array
    $response = array("tag" => $tag, "error" => FALSE);

    // checking tag
    if ($tag == 'login') {
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            $response["error"] = FALSE;
            $response["user_id"] = $user["user_id"];
		    $response["cercle_long"] = $user["cercle_long"];
			$response["cercle_lat"] = $user["cercle_lat"];

            $response["user"]["name"] = $user["user_name"];
            $response["user"]["email"] = $user["user_email"];
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = TRUE;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } else if ($tag == 'register') {
        // Request type is Register new user
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check if user is already existed
        if ($db->isUserExisted($email)) {
            // user is already existed - error response
            $response["error"] = TRUE;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
        } else {
            // store user
            $user = $db->storeUser($name, $email, $password);
            if ($user) {
                // user stored successfully
                $response["error"] = FALSE;
                $response["uid"] = $user["user_id"];
				
				$response["cercle_long"] = $user["cercle_long"];
				$response["cercle_lat"] = $user["cercle_lat"];
                $response["user"]["name"] = $user["user_name"];
                $response["user"]["email"] = $user["user_email"];
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = TRUE;
                $response["error_msg"] = "Error occured in Registartion";
                echo json_encode($response);
            }
        }
    } else
		if ($tag == 'position'){
			
			 $userId = $_POST['email'];
			 $longitude = $_POST['longitude'];
		     $latitude = $_POST['latitude'];
			 
			 $con=mysqli_connect("localhost","root","","loginregister");
// Check connection
	if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			
			$result = mysqli_query($con,"UPDATE  users   SET longitude= '$longitude',latitude='$latitude' WHERE user_id='$userId' ") or die(mysqli_error($con));
            //$cercle = mysqli_query($con,"SELECT * FROM users WHERE user_id='$userId'") or die(mysqli_error($con));
			
			//$data = mysqli_fetch_array($cercle)
			     $response["error"] = FALSE;
				 $response["logitudeCercle"] = "33";
                 $response["latitudeCercle"] = "-6";
                 
				
		}
	
	else{
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown 'tag' value. It should be either 'login' or 'register'";
        echo json_encode($response);
    }
} else {
    ?><html><head>
	<title>Starting Android | API</title>
</head>
<body style="background:#2c3e50;">
	<div style="margin:0 auto; margin-top:200px;width:60%;">
		<img src="logo_api.png" alt="Starting Android">
		
	</div>

</body></html><?php
}
?>