<?php
session_start();
include "../../config/db.php";

$user_idx = $_POST['user_idx'];
$review_idx = $_POST['review_idx'];
$reply_num = $_POST['reply_num'];
$reply_memo = $_POST['reply_memo'];
$reply_wdate = date("Y-m-d H:i:s");

$user_id = $_COOKIE['user_id'];
$sql_user = "SELECT user_idx FROM member WHERE user_id = '$user_id'";
$result_user = mysqli_query($con, $sql_user);
$row_user = mysqli_fetch_array($result_user);
$user_idx = $row_user['user_idx'];

$sql = "INSERT INTO reply (user_idx, review_idx, reply_num, reply_memo, reply_wdate) VALUES ('$user_idx', '$review_idx', '$reply_num', '$reply_memo', '$reply_wdate')";
mysqli_query($con,$sql);

?>

<script>
    alert("댓글이 등록되었습니다.");
    location.href="../review_detail.html?review_idx=<?php echo $review_idx; ?>";
</script>