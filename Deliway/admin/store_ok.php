<?php
session_start();

$store_idx = $_POST['store_idx'];
$store_ing = $_POST['store_ing'];

$sql = "UPDATE store SET store_ing = '".$store_ing."' where store_idx='".$store_idx."'";
$result = mysqli_query($con,$sql);

?>

<script>
    alert('업체 승인을 완료하였습니다.');
    location.href="manager-store.html";
</script>