<?php
session_start();

include "../../config/db.php";

$returnCode = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다
$restAPIKey = "e338c2e042766a107a064816c6fe85e2"; // REST API KEY
$callbackURI = urlencode("http://moondosa.dothome.co.kr/code/PHP/oauth.php"); // Call Back URL
//토큰
$getTokenUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$restAPIKey."&redirect_uri=".$callbackURI."&code=".$returnCode;

$isPost = false;
$ch = curl_init();                                    //1. curl 초기화
curl_setopt($ch, CURLOPT_URL, $getTokenUrl);          //2. URL 지정
curl_setopt($ch, CURLOPT_POST, $isPost);              //3. $isPost = false; ﻿ POST 통신이 아니므로
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       //﻿4.  true일 경우 curl_exec의 결과값을 return 하게 되어 변수에 저장 가능

$headers = array();                                   //header 배열 생성
$loginResponse = curl_exec ($ch);                     //4. $ch 실행
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //6. ﻿연결 리소스 핸들 컬에 대한 정보 얻기
curl_close ($ch);                                     //7. Close a cURL session

//사용자 정보 요청
$accessToken= json_decode($loginResponse)->access_token;      //Access Token만 따로 뺌
$header = "Bearer ".$accessToken; // Bearer 다음에 공백 추가
$getProfileUrl = "https://kapi.kakao.com/v2/user/me"; // 개인정보가져오는 url

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $getProfileUrl);
curl_setopt($ch, CURLOPT_POST, $isPost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = array();
$headers[] = "Authorization: ".$header;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$profileResponse = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);

$profileResponse = json_decode($profileResponse);
$userId = $profileResponse->id;
$userName = $profileResponse->properties->nickname;

$sql = "SELECT * FROM member WHERE user_id='".$userId."'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

if($row == 0) {
    echo "<script>alert('카카오로 로그인하였습니다. 정보 입력 페이지로 이동합니다.'); location.href='../login_terms.html?code=".$userId."';</script>";
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

?>