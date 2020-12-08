<?php
include "./admin.lib.php";


switch($w_type){
  case "del_msg":
    $sql = "UPDATE w_msg SET del='Y' WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

  echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "reply_list" :
    $sql = "SELECT * FROM w_msg WHERE idx={$idx}";
    $re = sql_fetch($sql);

    $mb_idx = $re['mb_idx'];
    $mb_type = $re['mb_type'];
    $msg_read = $re['msg_read'];
    $sel_msg = $re['msg'];
    $reply = $re['reply'];


    // 고객 정보에서 쓸 데이터를 추출
    if($mb_type=="C"){
      $mire = getCustomerInfo($mb_idx);
    }else if($mb_type=="S"){
      $mire = getSupplierInfo($mb_idx);
    }
    $profile_img = $mire['profile_img'];
    $comp_name = $mire['comp_name'];

    $profile_img = "test.png";

    // 선택한 메세지 이외의 메세지기록 추출
    $asql = "SELECT * FROM w_msg WHERE mb_idx={$mb_idx} && idx!={$idx} ORDER BY w_date DESC";
    $are = sql_query($asql);

    while($rs = sql_fetch_array($are)){
      $list_idx = $rs['idx'];
      $list_read = $rs['msg_read'];
      $wdbox = explode(" ",$rs['w_date']);
      $w_date = date("y.m.d",strtotime($wdbox[0]));
      $msg = mb_strimwidth($rs['msg'],0,70,'...','utf-8');

      if($list_read == "N"){
        $read_txt = "안읽음";
      }else{
        $read_txt = "";
      }

      $html1 .= "
      <div class='cont_block'>
        <div class='p_img'>
          <img src='../img/profile/{$profile_img}' />
        </div>
        <div class='text'>
          <table>
            <tr>
              <td class='td_name'>{$comp_name}</td>
              <td class='td_read'>{$read_txt}</td>
              <td class='td_date'>{$w_date}</td>
            </tr>
            <tr>
              <td colspan='3' class='td_msg' onclick='show_rep({$list_idx})'>{$msg}</td>
            </tr>
          </table>
        </div>
      </div>
      ";
    }

    $output['html1'] = $html1;
    $output['sel_msg'] = $sel_msg;
    $output['reply'] = $reply;
    $output['sql'] = $sql;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "insert_reply" :
    $r_date = date("Y-m-d H:i:s");
    $sql = "UPDATE w_msg SET reply='{$reply}', r_date='{$r_date}' WHERE idx={$idx}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;



}




 ?>
