<?php
include "./admin_head.php";


if(!$type) $type="W";
$type=="E"? $type_txt="수정" : $type_txt="등록";

$pinfo = getPostingInfo($idx);

?>
<style></style>
<script type="text/javascript" src="./nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>

<div id="news_we">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">업계소식 <?=$type_txt?></h1>
    <p class="mb-4">업계소식 카테고리에 보여질 글을 <?=$type_txt?>합니다.</p>

    <div class="card shadow mb-4">
      <div class="card-header py-3 line_block">
      </div>
      <div class="card-body search_cont">
        <div class="table-responsive table_box">
          <div class="submit_btn">
            <input type="button" class="btn btn-info list_btn" onclick="moveList()" value="목록" />
          </div>
          <form name="nse" method="post">
            <input type="hidden" name="type" value="<?=$type?>" />
            <input type="hidden" name="idx" value="<?=$idx?>" />
            <input type="text" class="title_input" name="title" placeholder="제목을 입력하세요" value="<?=$pinfo['title']?>"/>
            <textarea name="content" id="ir1" class="nse_content"><?=$pinfo['content']?></textarea>
            <div class="submit_btn">
              <input type="button" class="btn btn-secondary posting_btn" onclick="posting(this)" value="등록" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  let oEditors = [];
  nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "ir1",
      sSkinURI: "./nse_files/SmartEditor2Skin.html",
      fCreator: "createSEditor2",
  });

  // function submitContents(elClickedObj) {
  //   // 에디터의 내용이 textarea에 적용됩니다.
  //   oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
  //   // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
  //
  //   try {
  //       elClickedObj.form.submit();
  //   } catch(e) {}
  // }

</script>

<? include "./admin_footer.php" ?>
