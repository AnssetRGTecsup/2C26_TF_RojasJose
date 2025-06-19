<?php
    require __DIR__ . '/../../Utils/Connection.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
    $response = [
        'success' => false,
        'message' => '',
        'data' => null
    ];
    
    $data = json_decode(file_get_contents("php://input"), true);

    $UserValue = $data["value"];
    $UserType = $data["type"];
    $UserNickname = $data["nickname"];
    $UserEmail = $data["email"];
    $UserPassword = $data["password"];

    $stmt = $conn->prepare("CALL Update_User(?,?,?,?,?)");

    if($stmt == false){
        $response['message'] = "Error preparing statement: ". $conn->error;
        
        $conn->close();

        echo json_encode($response);

        exit();
    }else{

    }

    $stmt->bind_param("sssss", $UserValue, $UserValue, $UserNickname, $UserEmail, $UserPassword);

    $execute_result = $stmt->execute();
    
    echo "Exectued";

    if($execute_result == true){

        $result = $stmt->get_result();
        
        if($result->num_rows > 0){

            $user_data = $result->fetch_assoc();
            $response['success'] = true;
            $response['message'] = "User data updated succesfully";
            $response['data'] =  $user_data;

            echo $user_data;
        }else{
            $response['message'] = "No user found with value: " . $UserValue;
        }

        $result->free();
    }else if($execute_result == false){

        $response['message'] = "Error calling stored procedure: " . $stmt->error;

        $stmt->close();
        $conn->close();

        echo json_encode($response);

        exit();
    }else{
        $response['message'] = "Unexpected result from execute: " . var_export($execute_result, true) . "<br>";
        
        $stmt->close();
        $conn->close();

        echo json_encode($response);

        exit();
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
?>