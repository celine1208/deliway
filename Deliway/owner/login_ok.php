<?php
session_start();

include "../config/db.php";
include "./password.php";

$user_id = $_POST['user_id'];
$user_pass = $_POST['user_pass'];
$user_login = date("Y-m-d H:i:s");


$sql = "SELECT * FROM member where user_id= '".$user_id."' and user_type ='2'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

$hash_pass = $row['user_pass']; //암호화된 비밀번호를 변수에 담기

if (password_verify($user_pass,$hash_pass)){

    // 세션부여
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['user_name'] = $row['user_name'];

    $sql1 = "UPDATE member set user_login = '".$user_login."' where user_id = '".$user_id."'";
    
    echo "<script> alert('로그인에 성공하였습니다!'); location.href='owner_dashboard.html';</script>";

} else {
    echo "<script> alert('아이디 혹은 비밀번호를 확인하세요');history.back();</script>";
}

?>