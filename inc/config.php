<?php
define("HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "demo");

$conn = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

function getUserAccessRoleByID($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT user_role FROM tbl_user_role WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['user_role'] ?? null; // Return null if no matching record is found
}
?>