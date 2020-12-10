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

$supp = getItemSupply($cate);
$iinfo = getItemInfo($idx,$cate);

// $pic_src = "/img/items/".$iinfo['img'];
if($iinfo['img']){
  $pic_src = "/img/items/".$iinfo['img'];
  // $pic_src = "<a href='{$pic_src}' target='_blank'><img src='{$pic_src}' /></a>";
}

if($type=="E"){
  $type_txt = "수정";
  $w_type = "edit_item";
  echo "
    <script>
      $(document).ready(function(){
        $('.file_custom1').css({'background': 'url({$pic_src})'});
        $('.file_custom1').css({'background-repeat': 'no-repeat'});
        $('.file_custom1').css({'background-size': 'contain'});
      });
    </script>
  ";
}else{
  $type_txt = "등록";
  $w_type = "insert_item";
}

?>

<div id="item_we">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?=$cate_txt?> <?=$type_txt?></h1>
    <p class="mb-4"><?=$cate_txt?> <?=$type_txt?> 및 우선공급자를 설정합니다.</p>

    <div class="card shadow mb-4">
      <div class="card-header line_block">
        <div class="item_title1">
          <p><?=$cate_txt?> <?=$type_txt?></p>
        </div>
        <div class="item_title2">
          <p>우선공급자 설정</p>
        </div>
        <div class="list_btn">
          <input type="button" class="btn btn-info list_btn" onclick="moveList()" value="목록" />
        </div>
      </div>
      <div class="card-body item_cont">
        <div class="table-responsive table_box">
          <form id="item_datas" enctype="multipart/form-data" onsubmit="return false;">
          <input type="hidden" name="w_type" value="<?=$w_type?>" />
          <input type="hidden" name="category" value="<?=$cate?>" />
          <input type="hidden" name="idx" value="<?=$idx?>" />
          <table class="table table-bordered" cellspacing="0">
              <tr>
                <td class="td_head">제품명</td>
                <td class="td_cont name"><input type="text" id="iname" name="name" class="form-control input_name" value="<?=$iinfo['name']?>" placeholder="제품명 입력"/></td>
              </tr>
              <tr>
                <td class="td_head">단중</td>
                <td class="td_cont weight"><input type="text" id="iweight" name="weight" class="form-control input_name" value="<?=$iinfo['weight']?>" maxlength="6" onkeyup="onlyNum(this)" placeholder="단위 : kg"/></td>
              </tr>
              <tr>
                <td class="td_head">도면번호</td>
                <td class="td_cont draw"><input type="text" id="idraw" name="draw_num" class="form-control input_name" value="<?=$iinfo['drawing_num']?>" placeholder="도면번호 입력"/></td>
              </tr>
              <tr>
                <td class="td_head">사진</td>
                <td class="td_cont img">
                  <div class="photo_box">
                    <div class="file_custom1">
                      <label for="pic1">+사진 추가</label>
                      <input type="file" id="pic1" name="pic1" value="<?=$iinfo['img']?>" />
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="submit_btn"><button class="btn btn-secondary" onclick="proc_we()"><?=$type_txt?></button></td>
              </tr>
            </table>
          </form>
        </div>

        <div class="table-responsive table_box_l">
          <table class="table table-bordered" cellspacing="0">
          <? for($i=1; $i<7; $i++){ ?>
              <tr>
                <td class="td_head">회사명</td>
                <td class="td_cont name"><input type="text" name="comp_name<?=$i?>" class="form-control input_name" placeholder="<?=$cate_txt?> 우선공급 suppler 회사명 입력" value="<?=$supp['comp_name'.$i]?>"/></td>
            <?  if($cate==1){  ?>
                <td class="td_head">단중</td>
                <td class="td_cont weight"><input type="text" name="weight<?=$i?>" class="form-control input_name" placeholder="예) 단중 00톤 이상" value="<?=$supp['weight'.$i]?>"/></td>
            <?  } ?>
              </tr>
          <? } ?>
              <tr>
                <td colspan="4" class="submit_btn"><button class="btn btn-secondary" onclick="supply_comp()">변경</button></td>
              </tr>
            </table>
          </form>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function(){
  $("#pic1").on("change", view_pic1);
});
</script>


<? include "./admin_footer.php" ?>
