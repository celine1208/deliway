<?php

session_start();
include "../config/db.php";

$cate_userid = $_POST['cate_userid'];
$cate_name = $_POST['cate_name'];
$store_idx = $_POST['store_idx'];
$cate_idx = $_POST['cate_idx'];

$sql = "UPDATE menu_category SET cate_name = '$cate_name' WHERE cate_userid = '$cate_userid' AND store_idx = '$store_idx' AND cate_idx = '$cate_idx'";
mysqli_query($con, $sql);

?>

<script>
    alert("카테고리를 수정하였습니다.");
    location.href="menu_category.html";
</script>