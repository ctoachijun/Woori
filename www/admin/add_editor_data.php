<?
include "admin_head.php";

// echo $ir1;
// exit;
if($jud==1){
  $sql = "INSERT INTO test_edit SET content='{$ir1}'";
  $re = sql_query($sql);

  if($re){
    echo "성공이오!";
  }else{
    echo "실패했소!@!";
  }
}else if($jud==2){
  $sql = "SELECT * FROM test_edit WHERE idx=4";
  $re = sql_fetch($sql);
  echo $re['content'];
}


?>
