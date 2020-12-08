<?
include "admin.lib.php";

// echo $ir1;
// exit;

if($type=="W"){
  $sql = "INSERT INTO w_posting SET title='{$title}', content='{$content}', w_date=DEFAULT";
  $re = sql_query($sql);
  echo $sql;

  if($re){
    echo "성공이오!";
  }else{
    echo "실패했소!@!";
  }
}else if($type=="E"){
  $sql = "SELECT * FROM test_edit WHERE idx=4";
  $re = sql_fetch($sql);
  echo $re['content'];
}


?>
