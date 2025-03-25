<?php

session_start();
include "../../config/db.php";

$reser_ing = "예약신청";
$sql = "UPDATE reser set reser_ing = '".$reser_ing."' where reser_idx = '".$_GET['reser_idx']."'";
mysqli_query($con,$sql);

?>

<script>
    alert("예약이 신청되었습니다.");
    location.href="reser_list.html";
</script>