<?php
include "./admin_head.php";

$url = $REQUEST_URI;
$self = $PHP_SELF;



?>


<div id="msg_send">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">메세지 보내기</h1>
    <p class="mb-4">회원을 검색해 대상 회원에게 메세지를 보낼 수 있습니다.</p>

    <div class="card shadow mb-4">
      <div class="card-header py-3 line_block">
        <div class="search_top">
          <select id="t_type" name="type" class="form-control sel">
            <option value="">==선택==</option>
            <option value="C" <?=$type_selC?>>Customer</option>
            <option value="S" <?=$type_selS?>>Supplier</option>
          </select>
          <input type="text" name="stxt" id="stxt" class="form-control input_t" value="<?=$stxt?>" placeholder="회사명으로 검색"/>
          <input type="submit" value="찾기" class="form-control btn btn-success subbtn" onclick="search_target()"/>
        </div>
      </div>
      <div class="card-body search_cont">
          <div class="table-responsive table_box">
              <table class="table table-bordered" cellspacing="0">
                  <thead>
                    <tr class="nochg">
                      <th>회사명</th>
                      <th>담당자</th>
                      <th>분류</th>
                      <th>국가</th>
                    </tr>
                  </thead>
                  <tbody id="search_data">

                  </tbody>
              </table>
          </div>

          <div class='rep_right'>
            <div class='right_cont'>
              <div class='right_top'>
                <span class='text_bolder'>메세지 전송 대상 : <input type="text" id="target_name" readonly/></span>
                <div class='msg_cont'>
                  <textarea class='form-cntrol msg' id='msg_cs'></textarea>
                </div>
                <div class='submit_btn'>
                  <input type="hidden" name="mb_idx" />
                  <input type="hidden" name="mb_type" />
                  <input type="button" class="btn btn-secondary" value="전송" onclick="send_AdminMsg()"/>
                </div>
              </div>
            </div>
          </div>
    </div>

  </div>
</div>




<? include "./admin_footer.php" ?>
