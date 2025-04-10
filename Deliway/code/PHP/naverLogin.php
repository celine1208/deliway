<?php
session_start();
include "../../config/db.php";


define('NAVER_CLIENT_ID', 'xs5NNvCKl_SOpyZmxB3e');
define('NAVER_CLIENT_SECRET', 'kTuRKk3ptS');
define('NAVER_CALLBACK_URL', 'http://moondosa.dothome.co.kr/code/PHP/naverLogin.php');

$naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&code=".$_GET['code'];

$is_post = false;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $naver_curl);
curl_setopt($ch, CURLOPT_POST, $is_post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close ($ch);

if($status_code == 200){
    $responseArr = json_decode($response, true);

    $headers = array( 'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token']) );
    $is_post = false;
    $me_ch = curl_init();
    curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
    curl_setopt($me_ch, CURLOPT_POST, $is_post );
    curl_setopt($me_ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec ($me_ch);
    curl_close ($me_ch);
    $res_data = json_decode($res , true);

/*
"resultcode": "00",
"message": "success",
"response": {
"email": "";
"nickname": "";
"profile_image": "";
"age": "";
"gender": "";
"name": "";
"birthday": "";
}
*/
    $userId = $res_data['response']['id'];

    $sql = "SELECT * FROM member WHERE user_id='".$userId."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    if($row == 0) {
        echo "<script>alert('네이버로 로그인하였습니다. 정보 입력 페이지로 이동합니다.'); location.href='../login_terms.html?code=".$userId."';</script>";
    } else {
        $user_login = date("Y-m-d H:i:s");

        setcookie("user_id", $row['user_id'], (time() + 3600 * 24 * 30000), "/" );
        setcookie("user_idx", $row['user_idx'], (time() + 3600 * 24 * 30000), "/" );
        setcookie("user_name", $row['user_name'], (time() + 3600 * 24 * 30000), "/" );
        setcookie("user_ing", $row['user_ing'], time() + 3600 * 24 * 30000, "/" );

        $sql1 = "UPDATE member set user_login = '".$user_login."' where user_id = '".$userId."'";
        $result1 = mysqli_query($con,$sql1);
        echo "<script>alert('로그인되었습니다. 메인페이지로 이동합니다.'); location.href='../main.html';</script>";
    }
}

?>