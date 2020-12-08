<?php
include "./admin.lib.php";

$sql = "SELECT * FROM w_customer WHERE mb_id='{$id}' && mb_type='A'";
$re = sql_fetch($sql);
$pass = base64_decode($re['mb_pass']);
$in_pass = base64_encode($pw);

if($pw!=$pass){
  alert_back("계정을 확인 해 주세요.");
  exit;
}else{
  $token = get_token();
  $_SESSION["mb_id"] = $id;
  $_SESSION["login"] = 1;
  $_SESSION["token"] = $token;

  $sql = "UPDATE w_customer SET token='{$token}' WHERE mb_id='{$id}' && mb_type='A'";
  sql_query($sql);
  move_page("./index.php");
}


?>

<!--
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>.nse_content{width:660px; height:500px;}</style>
  <script type="text/javascript" src="./nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
</head>
<body>
  <form name="nse" action="add_editor_data.php" method="post">
    <input type="hidden" name="jud" value="1" />
    <textarea name="ir1" id="ir1" class="nse_content"></textarea>
    <input type="button" onclick="submitContents(this)" value="전송" />
  </form>
</body>
</html>

<script type="text/javascript">
  var oEditors = [];
  nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "ir1",
      sSkinURI: "./nse_files/SmartEditor2Skin.html",
      fCreator: "createSEditor2"
  });
function submitContents(elClickedObj) {
    // 에디터의 내용이 textarea에 적용됩니다.
    oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
    // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

    try {
        elClickedObj.form.submit();
    } catch(e) {}
}
</script>
-->
