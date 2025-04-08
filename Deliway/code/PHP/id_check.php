<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];

// 이메일 중복 체크
$id_check = "SELECT * FROM member WHERE user_id='".$user_id."'";
$result_check = mysqli_query($con,$id_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo htmlspecialchars("중복된 아이디입니다.");
} else {
    echo htmlspecialchars("사용 가능한 아이디입니다.");
}
?>