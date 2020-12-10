<?php
include "./admin_head.php";

if($cate==1){
  $cate_txt = "주조품";
}else if($cate==2){
  $cate_txt = "단조품";
}else if($cate==3){
  $cate_txt = "제관품";
}else if($cate==4){
  $cate_txt = "조립품";
}

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

<div id="item">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?=$cate_txt?> </h1>
    <p class="mb-4"><?=$cate_txt?>에 대한 정보를 관리합니다.</p>

    <div class="card shadow mb-4">
      <div class="card-header py-3 line_block">
        <form action="./admin_item_we.php">
          <input type='hidden' value="<?=$cate?>" name="cate" />
          <input type="hidden" name="type" />
          <input type="hidden" name="idx" />
        </form>
      </div>
      <div class="card-body item_cont">
        <div class="table-responsive table_box">
          <div class="write_box">
            <a href="admin_item_we.php?cate=<?=$cate?>"><button class="btn btn-success write_btn">등록</button></a>
          </div>
          <table class="table table-bordered" cellspacing="0">
              <tr>
                <th>No.</th>
                <th>이름</th>
                <th>단중</th>
                <th>도면번호</th>
                <th>이미지</th>
                <th>등록일</th>
                <th></th>
              </tr>
            <? getItemList($cur_page,$end,$cate); ?>            
            </table>
        </div>
    </div>

  </div>
</div>




<? include "./admin_footer.php" ?>
