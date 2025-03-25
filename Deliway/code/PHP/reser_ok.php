<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];
$store_idx = $_POST['store_idx'];
$reser_ing = $_POST['reser_ing'];
$reser_day = $_POST['reser_day'];
$reser_name = $_POST['reser_name'];
$reser_number = $_POST['reser_number'];
$reser_memo = $_POST['reser_memo'];
$reser_pickup = isset($_POST['reser_pickup']) ? '1': '0';
$reser_place = $_POST['reser_place'];
$reser_wdate = date("Y-m-d H:i:s");

$sql = "INSERT INTO reser (user_id, store_idx, reser_ing, reser_day, reser_name, reser_number, reser_memo, reser_pickup, reser_place, reser_wdate) VALUES ('".$user_id."', '".$store_idx."', '".$reser_ing."', '".$reser_day."', '".$reser_name."', '".$reser_number."', '".$reser_memo."', '".$reser_pickup."', '".$reser_place."', '".$reser_wdate."')";

mysqli_query($con,$sql);

if (!mysqli_query($con, $sql)) {
    echo "쿼리 오류: " . mysqli_error($con);
}

?>

<script>
    alert("");
    location.href="../reser_list.html";
</script>