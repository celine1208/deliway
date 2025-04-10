<?php
session_start();
include "../../config/db.php";

$user_phone = $_POST['user_phone'];

$user_id = $_POST['user_id'];
$user_pass = $_POST['user_pass'];
$user_pass1 = $_POST['user_pass1'];

if ($_POST['code'] == "") {
    // 아이디 중복 체크
    $id_check = "SELECT * FROM member WHERE user_id='$user_id'";
    $result_check = mysqli_query($con, $id_check);
    if (mysqli_num_rows($result_check) >= 1) {
        echo "<script> alert('중복된 아이디입니다'); history.back();</script>";
        exit;
    }

    // 비밀번호 확인
    if ($user_pass !== $user_pass1) {
        echo "<script>alert('비밀번호가 다릅니다.'); history.back();</script>";
        exit;
    }
}

// 전화번호 중복 체크 (둘 다 공통)
$num_check = "SELECT * FROM member WHERE user_phone='$user_phone'";
$result1_check = mysqli_query($con, $num_check);
if (mysqli_num_rows($result1_check) >= 1) {
    echo "<script> alert('중복된 전화번호입니다'); history.back();</script>";
    exit;
}

$_SESSION['user_id'] = $user_id;
$_SESSION['user_phone'] = $user_phone;
$_SESSION['user_pass'] = $user_pass;

?>

<script>
    alert ('다음단계로 진행하겠습니다');
    location.href="../login_info.html?user_id=<?php echo $user_id; ?>";
</script>