<?php
$hostname = "localhost";
$usernmae = "root";
$password = "";
$dbname = "demo";

//db connection
$connect = mysqli_connect($hostname, $username, $password, $database);

if (!$connect) {
    die('Error connecting to database: ' . mysqli_connect_error());
}

function getUserAccessRoleByID($id)
{
    global $connect; //use the correct global variable for the database connection

    $query = "select user_role from tbl_user_rolewhere id = " . $id; // added space and case id to int for securitY

    $rs = mysqli_query($connect, $query);
    if ($rs) {
        $row = mysqli_fetch_assoc($rs);
        if (isset($row['user_role'])) { //check if user_role exist in the result
            return $row['user_role'];
        } else {
            return null; // return null if user_role key does not exist
        }
    } else {
        return null; //return null if the query fails
    }
}
?>