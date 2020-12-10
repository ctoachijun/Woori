<?php
include "./admin_head.php";

if(!$cur_page){
  $cur_page = 1;
}
if(!$end){
  $end = 10;
}
if(!$ref){
  $ref = 1;
}


?>

<div id="quo">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">업계소식 관리</h1>
    <p class="mb-4">업계소식 카테고리에 보여지는 글을 관리합니다.</p>

    <div class="card shadow mb-4">
      <div class="card-header py-3 line_block">
        <div class="search_top">
          <form method="POST" action="admin_news_we.php" name="editdata">
            <input type="hidden" name="idx">
            <input type="hidden" name="type">
          </form>
        </div>
      </div>
      <div class="card-body search_cont">
        <div class="table-responsive table_box">
          <div class="write_box">
            <a href="admin_news_we.php"><button class="btn btn-success write_btn">글쓰기</button></a>
          </div>
          <table class="table table-bordered" cellspacing="0">
              <tr>
                <th>No.</th>
                <th>제목</th>
                <th>내용</th>
                <th>작성일</th>
                <th></th>
              </tr>
            <? getPosting($cur_page,$end,$num); ?>
            </table>
        </div>
    </div>

  </div>
</div>




<? include "./admin_footer.php" ?>
