<?php
//기본 리다이렉트
echo $_REQUEST["htImageInfo"];

$url = $_REQUEST["callback"] .'?callback_func='. $_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);
if (bSuccessUpload) { //성공 시 파일 사이즈와 URL 전송

	$tmp_name = $_FILES['Filedata']['tmp_name'];
	// $name = $_FILES['Filedata']['name'];
	$today = date("Y-m-d");
  $timestamp = time();
	$box = explode(".",$_FILES['Filedata']['name']);
	$whak = $box[1];

	$name = $today."_".$timestamp.".".$whak;
	// $new_path = "../upload/".urlencode($_FILES['Filedata']['name']);
	$new_path = "../upload/".urlencode($name);
	@move_uploaded_file($tmp_name, $new_path);
	$url .= "&bNewLine=true";
	$url .= "&sFileName=".urlencode(urlencode($name));
	//$url .= "&size=". $_FILES['Filedata']['size'];
	//아래 URL을 변경하시면 됩니다.
	// $url .= "&sFileURL=http://test.naver.com/popup/upload/".urlencode(urlencode($name));
	$url .= "&sFileURL=/admin/nse_files/files".urlencode(urlencode($name));
} else { //실패시 errstr=error 전송
	$url .= '&errstr=error';
}
header('Location: '. $url);
?>
