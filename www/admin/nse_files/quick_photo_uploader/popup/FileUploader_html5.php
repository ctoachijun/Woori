<?php
 	$sFileInfo = '';
	$headers = array();
	foreach ($_SERVER as $k => $v){

		if(substr($k, 0, 9) == "HTTP_FILE"){
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		}
	}

  $today = date("Ymd");
  $timestamp = time();
	$file = new stdClass;
	// $file->name = rawurlencode($headers['file_name']);
  // 한글파일 깨져서 그냥 임의로 중복안되게 unixtime 붙여서 이름생성
  $test = explode(".", rawurldecode($headers['file_name']));
  $name = str_replace("\0", "", time().'-'.rand(0,100).'.'.$test[1]);
  $file->name = str_replace("\0", "", rawurldecode($name)); //


	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");



	$newPath = $_SERVER['DOCUMENT_ROOT'].'/admin/nse_files/img/editor_img/'.iconv("utf-8", "cp949", $file->name);

	if(file_put_contents($newPath, $file->content)) {
		$sFileInfo .= "&bNewLine=true";
		$sFileInfo .= "&sFileName=".$file->name;
		$sFileInfo .= "&sFileURL=/admin/nse_files/img/editor_img/".$file->name;
	}
	echo $sFileInfo;
 ?>
