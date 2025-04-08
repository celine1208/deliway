<?php
session_start();
include "../../config/db.php";

$user_name = $_POST['user_name'];

$nickname_check = "SELECT * FROM member WHERE user_name='".$user_name."'";
$result_check = mysqli_query($con, $nickname_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo htmlspecialchars("중복된 닉네임입니다.");
} else {
    echo htmlspecialchars("사용 가능한 닉네임입니다.");
}
?>