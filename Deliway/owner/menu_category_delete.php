<?php

session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.html';</script>";
    exit;
}

$cate_idx = $_POST['cate_idx'];
$cate_name = $_POST['cate_name'];

$sql = "DELETE FROM menu_category WHERE cate_idx = '$cate_idx'";
mysqli_query($con, $sql);

?>

<script>
    alert("카테고리를 삭제하였습니다.");
    location.href="menu_category.html";
</script>