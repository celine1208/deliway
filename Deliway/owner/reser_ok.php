<?php

session_start();
include  "../config/db.php";

$reser_idx = $_GET['reser_idx'];
$reser_ing = $_GET['reser_ing'];
$store_idx = $_GET['store_idx'];

if ($reser_ing == "1"){
    $reser_ing = "예약확정";
} else if ($reser_ing == "0")  {
    $reser_ing = "예약거절";
} else if ($reser_ing == "2") {
    $reser_ing = "방문완료";
}

$sql = "UPDATE reser SET reser_ing= '".$reser_ing."' where reser_idx = '".$reser_idx."'";
$result = mysqli_query($con, $sql);

?>

<script>
    alert("예약정보를 변경하였습니다.");
    location.href = "owner_reservation.html?store_idx=<?php echo $store_idx ?>";
</script>