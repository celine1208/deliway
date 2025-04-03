<?php
session_start();
include "../config/db.php";

// 세션에서 user_id 가져오기
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    exit;
}
$user_id = $_SESSION['user_idx'];

// POST 데이터 받기
$store_name = mysqli_real_escape_string($con, $_POST['store_name']);
$store_memo = mysqli_real_escape_string($con, $_POST['store_memo']);
$store_address1 = mysqli_real_escape_string($con, $_POST['store_address1']);
$store_call = mysqli_real_escape_string($con, $_POST['store_call']);
$store_weekday1 = $_POST['store_weekday1'];
$store_weekday2 = $_POST['store_weekday2'];
$store_weekend1 = $_POST['store_weekend1'];
$store_weekend2 = $_POST['store_weekend2'];
$store_breaktime = $_POST['store_breaktime'];
$store_service = isset($_POST['store_service']) ? 1 : 0;
$store_reser1 = $_POST['store_reser1'];
$store_reser2 = $_POST['store_reser2'];
$store_pickup = isset($_POST['store_pickup']) ? 1 : 0;
$store_pickup1 = $_POST['store_pickup1'];
$store_option1_memo = mysqli_real_escape_string($con, $_POST['store_option1_memo']);
$store_option1 = isset($_POST['store_option1']) ? 1 : 0;
$store_option2 = isset($_POST['store_option2']) ? 1 : 0;
$store_option3 = isset($_POST['store_option3']) ? 1 : 0;
$store_option4 = isset($_POST['store_option4']) ? 1 : 0;
$store_option4_memo = mysqli_real_escape_string($con, $_POST['store_option4_memo']);
$store_keyword1 = mysqli_real_escape_string($con, $_POST['store_keyword1']);
$store_keyword2 = mysqli_real_escape_string($con, $_POST['store_keyword2']);
$store_keyword3 = mysqli_real_escape_string($con, $_POST['store_keyword3']);
$store_category = $_POST['store_category'];

$upload_dir = '../code/upload/';
$file_fields = ['file_name_2', 'file_name_3', 'file_name_4'];
$file_copied_fields = ['file_copied_2', 'file_copied_3', 'file_copied_4'];

$uploaded_files = ["", "", ""];
$copied_files = ["", "", ""];

// 기존 파일 유지 위한 쿼리 실행
$query = "SELECT file_copied_2, file_copied_3, file_copied_4 FROM store WHERE user_id='$user_id'";
$result = mysqli_query($con, $query);
$existing_files = mysqli_fetch_assoc($result);

foreach ($_FILES["upfile"]["name"] as $i => $file_name) {
    if (!empty($file_name)) {
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = date("Y_m_d_H_i_s") . "_$i.$file_ext";
        $uploaded_path = $upload_dir . $new_file_name;

        if ($_FILES["upfile"]["size"][$i] > 5120000) { // 5MB 제한
            echo "<script>alert('파일 크기가 5MB를 초과합니다.'); history.back();</script>";
            exit;
        }

        if (!move_uploaded_file($_FILES["upfile"]["tmp_name"][$i], $uploaded_path)) {
            echo "<script>alert('파일 업로드 실패.'); history.back();</script>";
            exit;
        }

        $uploaded_files[$i] = $_FILES["upfile"]["name"][$i];
        $copied_files[$i] = $new_file_name;
    } else {
        $copied_files[$i] = $existing_files[$file_copied_fields[$i]];
    }
}

// 데이터베이스 업데이트
$sql = "UPDATE store SET
        user_idx = '$user_idx',
        store_name = '$store_name',
        store_call = '$store_call',
        store_memo = '$store_memo',
        store_address1 = '$store_address1',
        store_weekday1 = '$store_weekday1',
        store_weekday2 = '$store_weekday2',
        store_weekend1 = '$store_weekend1',
        store_weekend2 = '$store_weekend2',
        store_breaktime = '$store_breaktime',
        store_service = '$store_service',
        store_reser1 = '$store_reser1',
        store_reser2 = '$store_reser2',
        store_pickup = '$store_pickup',
        store_pickup1 = '$store_pickup1',
        store_option1_memo = '$store_option1_memo',
        store_option1 = '$store_option1',
        store_option2 = '$store_option2',
        store_option3 = '$store_option3',
        store_option4 = '$store_option4',
        store_option4_memo = '$store_option4_memo',
        file_name_2 = '$uploaded_files[0]',
        file_name_3 = '$uploaded_files[1]',
        file_name_4 = '$uploaded_files[2]',
        file_copied_2 = '$copied_files[0]',
        file_copied_3 = '$copied_files[1]',
        file_copied_4 = '$copied_files[2]',
        store_keyword1 = '$store_keyword1',
        store_keyword2 = '$store_keyword2',
        store_keyword3 = '$store_keyword3',
        store_category = '$store_category'
        WHERE user_id = '$user_id'";

if (mysqli_query($con, $sql)) {
    echo "<script>alert('매장정보 수정이 완료되었습니다!'); location.href='owner_store.html';</script>";
} else {
    echo "<script>alert('오류 발생: " . mysqli_error($con) . "'); history.back();</script>";
}

mysqli_close($con);
?>