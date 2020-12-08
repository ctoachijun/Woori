<?php
include "./admin_head.php";

if(!$type){
  $type = "T";
}
$type_sel_txt = "type_sel".$type;
$$type_sel_txt = "selected";

// echo "type : $type<br>";

if(!$target){
  $target = "AA";
}
$tg_sel_txt = "type_sel".$target;
$$tg_sel_txt = "selected";


if(!$cur_page){
  $cur_page = 1;
}
if(!$end){
  $end = 10;
}
if(!$ref){
  $ref = 1;
}
$url = $REQUEST_URI;
$self = $PHP_SELF;

// echo "target : $target - stxt : $stxt <br>";


?>

<div id="msg">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">메세지 확인 / 답장</h1>
    <p class="mb-4">각 회원들과 주고받은 메세지를 확인하고, 답장 전송이 가능합니다.</p>

    <div class="card shadow mb-4">
      <form method="POST" name="search" action="<?=$url?>">
        <!-- <input type="hidden" name="table" value="<?=$table?>" />
        <input type="hidden" name="cur_page" value="<?=$cur_page?>" />
        <input type="hidden" name="end" value="<?=$end?>" /> -->

      <div class="card-header py-3 line_block">
        <div class="search_left">
          <select id="target" name="target" class="form-control selt">
            <option value="AA" <?=$type_selAA?>>==선택==</option>
            <option value="CN" <?=$type_selCN?>>회사명</option>
            <option value="MN" <?=$type_selMN?>>담당자</option>
            <option value="MS" <?=$type_selMS?>>내용</option>
          </select>
          <input type="text" name="stxt" class="form-control input_t" value="<?=$stxt?>"/>
          <input type="submit" value="찾기" class="form-control btn btn-success subbtn" onclick=""/>
        </div>
        <div class="search_right">
          <select id="msg_type" name="type" class="form-control sel" onchange="sort_type('<?=$self?>')">
            <option value="T" <?=$type_selT?>>전체</option>
            <option value="C" <?=$type_selC?>>Customer</option>
            <option value="S" <?=$type_selS?>>Supplier</option>
            <option value="A" <?=$type_selA?>>Admin</option>
          </select>
        </div>
      </div>
      </form>

      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th>회사명</th>
                          <th>담당자</th>
                          <th>분류</th>
                          <th>작성일</th>
                          <th class="th_blank_r">내용</th>
                          <th class="th_blank"></th>
                      </tr>
                  </thead>
                  <tbody>
                    <? getMsgList($type,$cur_page,$mb_id,$end,$stxt,$target); ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>

    <div class="msg_reply" id="msg_reply">
      <div class="reply_cont">
        <div class='rep_left'>
          <div class='left_head'>
            <select class='form-control read_sel' id='msg_read' onchange='ru_rep()'>
              <option value='0'>전체메세지</option>
              <option value='2'>읽음</option>
              <option value='1'>안읽음</option>
            </select>
            <input type='text' id='msg_stxt' class='rep_stxt' name='rep_stxt'  placeholder="검색어 입력"/>
            <i class='fas fa-search btni' onclick="search_rep()"></i>
          </div>
          <div class='left_cont' id="left_list">

          </div>
        </div>
        <div class='rep_right'>
          <div class='right_head'>
            <i class='fas fa-times btni' onclick='close_rep()'></i>
          </div>
          <div class='right_cont'>
            <div class='right_top'>
              <span class='text_bolder'>보낸 사람 : <input type="text" class="sender" id="sender_name" value="" readonly/></span>
              <div class='msg_cont'>
                <textarea class='form-cntrol msg' id='msg_cs' readonly><?=$msg?></textarea>
              </div>
            </div>
            <div class="right_bottom">
              <span class='text_bolder'>답장</span>
              <div class='rep_cont'>
                <textarea class='input_rep' id="reply_txt"></textarea>
              </div>
            </div>
          </div>
          <div class="submit_btn" id="submit_btn">
            <input type="hidden" name="msg_idx" />
            <input type="hidden" name="ru" />
            <input type="button" class="btn btn-secondary" value="전송" onclick="send_reply()" />
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<? include "./admin_footer.php" ?>
