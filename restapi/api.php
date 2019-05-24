<?php

header('content-type: application/json');
$request = $_SERVER['REQUEST_METHOD'];
switch ($request){

    case 'GET':
        getuser();
    break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'),true);
        putmethod($data);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'),true);
        postmethod($data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'),true);
        deletemethod($data);
        break;

    default:
        break;
}

// this method is used for fetch data from database
function getuser()
{
    include "db.php";
    $sql = "SELECT * FROM user";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows["result"][] = $r;
        }
        echo json_encode($rows);
    }
    else{
        echo '{"result": "No data found"}';
    }
}

// this method is used for insert data into database
function postmethod($data)
{
    include "db.php";
    $name = $data["name"];
    $email = $data["email"];
    $sql = "INSERT INTO user(name,email,created_at) VALUES ('$name','$email',now())";
    if (mysqli_query($conn,$sql)){

        echo '{"result": "Data Inserted Successfully"}';
    }
    else{
        echo '{"result": "Data Insertion Failed"}';
    }
}

// this method is used for update data from database
function putmethod($data)
{
    include "db.php";
    $id = $data["id"];
    $name = $data["name"];
    $email = $data["email"];
    $sql = "UPDATE user SET name = '$name', email = '$email', created_at = now() WHERE id = '$id' ";
    if (mysqli_query($conn,$sql)){

        echo '{"result": "Data Updated Successfully"}';
    }
    else{
        echo '{"result": "Data Update operation Failed"}';
    }
}

// this method is used for delete data from database
function deletemethod($data)
{
    include "db.php";
    $id = $data["id"];
    $sql = "DELETE FROM user WHERE id = '$id'";
    if (mysqli_query($conn,$sql)){

        echo '{"result": "Data Deleted Successfully"}';
    }
    else{
        echo '{"result": "Data Delete Failed"}';
    }
}




?>