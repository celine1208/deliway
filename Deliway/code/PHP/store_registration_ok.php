<?php
session_start();

include "../../config/db.php";

$user_id = $_POST['user_id'];
$store_category = $_POST['store_category'];
$store_name = $_POST['store_name'];
$store_call = $_POST['store_call'];
$store_address1 = $_POST['store_address1'];
$store_address2 = $_POST['store_address2'];
$store_post = $_POST['store_post'];
$store_memo = $_POST['store_memo'];
$store_ing = "승인 대기";
$store_wdate = date("Y-m-d H:i:s");

$files = $_FILES["upfile"];
	$count = count($files["name"]);
			
	$upload_dir = '../upload/';
    
    // 다중
	for ($i=0; $i<$count; $i++)
	{
		$upfile_name[$i]     = $files["name"][$i];
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];
		$upfile_type[$i]     = $files["type"][$i];

		
		$upfile_size[$i]     = $files["size"][$i];
		$upfile_error[$i]    = $files["error"][$i];

	
		$file = explode(".", $upfile_name[$i]);
		$file_name = $file[0]; // 파일명
		$file_ext  = $file[1]; // 확장자명

		if (!$upfile_error[$i])
		{
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name."_".$i;
			$copied_file_name[$i] = $new_file_name.".".$file_ext;
			$uploaded_file[$i] = $upload_dir.$copied_file_name[$i];

			if( $upfile_size[$i]  > 51200000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 확인해주세요.');
				history.go(-1)
				</script>
				");
				exit;
			}

			if ( ($upfile_type[$i] != "image/gif") &&
				($upfile_type[$i] != "image/jpg") &&
				($upfile_type[$i] != "image/png") &&
				($upfile_type[$i] != "image/bmp") &&
				($upfile_type[$i] != "image/jpeg") )
			{
				echo("
					<script>
						alert('업로드가 불가능한 확장자입니다.');
						history.go(-1)
					</script>
					");
				exit;
			}

			if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) )
			{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
			}
		}
	}

	$sql = "INSERT INTO store (user_id, store_category, store_name, store_call, store_address1, store_memo, file_name_0, file_name_1, file_copied_0, file_copied_1, store_ing, store_post, store_address2) VALUES('".$user_id."', '".$store_category."', '".$store_name."', '".$store_call."', '".$store_address1."', '".$store_memo."', '".$upfile_name[0]."', '".$upfile_name[1]."', '".$copied_file_name[0]."', '".$copied_file_name[1]."', '".$store_ing."', '".$store_post."', '".$store_address2."')";
    mysqli_query($con,$sql);
    
?>

<script>
    alert('신청이 완료되었습니다. 승인 심사 완료까지는 영업일 기준 2-3일이 소요됩니다.');
    location.href = "../mypage.html"
</script>