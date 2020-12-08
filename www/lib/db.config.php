<?php
$host = "localhost";
$user = "softer060";
$pass = "softer060202";
$db = "softer060";

// DB서버에 접속
global $db_con;
$db_con = @mysqli_connect($host,$user,$pass,$db);
if(!$db_con){
  echo "DB접속 실패<br>";
  echo mysqli_connect_error();
  exit;
}


function sql_string($str){
  $box = mysqli_real_escape_string($db_con,$str);
  return $box;
}

function sql_query($sql){
  global $db_con;
    // Blind SQL Injection 취약점 해결
  $sql = trim($sql);
  // union의 사용을 허락하지 않습니다.
  //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
  $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
  // `information_schema` DB로의 접근을 허락하지 않습니다.
  $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);
  $result = mysqli_query($db_con,$sql);
  return $result;
}

function sql_fetch($sql){
    $result = sql_query($sql);
    $row = sql_fetch_array($result);
    return $row;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result){
  $row = @mysqli_fetch_assoc($result);
  return $row;
}

function sql_num_rows($result){
  return mysqli_num_rows($result);
}

// echo "jljljkljl";
// echo "<br>";
?>
