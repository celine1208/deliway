<?php
session_start();
include "../../config/db.php";

$user_id = $_SESSION['user_id'];
$user_phone = $_SESSION['user_phone'];
$user_pass = $_SESSION['user_pass'];
$user_name = $_POST['user_name'];
$user_addr = $_POST['user_addr'];
$user_wdate = date("Y-m-d H:i:s");
$user_login = date("Y-m-d H:i:s");

$secret_pass = password_hash($user_pass, PASSWORD_DEFAULT);


// 회원가입 sql 실행
$sql = "INSERT INTO member (user_id, user_pass, user_name, user_phone, user_addr, user_type, user_wdate, user_ing, user_login)
        VALUES ('$user_id', '$secret_pass', '$user_name', '$user_phone', '$user_addr', '1', '$user_wdate', '1', '$user_login')";

$result = mysqli_query($con,$sql);

?>

<script>
    alert ('회원가입이 완료되었습니다');
    location.href="../login_confirm.html?user_id=<?php echo $user_id; ?>";
</script>