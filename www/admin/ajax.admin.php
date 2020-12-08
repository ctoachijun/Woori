<?php
include "./admin.lib.php";


switch($w_type){
  case "del_msg":

    $msg_type=="A" ? $tbl_name="w_msg_admin" : $tbl_name="w_msg";

    $sql = "UPDATE {$tbl_name} SET del='Y' WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    $output['sql'] = $sql;
  echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "reply_list" :

    if($type=="A"){
      $tbl_name = "w_msg_admin";
    }else{
      $tbl_name = "w_msg";
    }

    $sql = "SELECT * FROM {$tbl_name} WHERE idx={$idx}";
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

    // 읽음 안읽음 리스트표시
    if($ru==1){
      $mread = "&& msg_read='N'";
    }else if($ru==2){
      $mread = "&& msg_read='Y'";
    }else{
      $mread = "";
    }

    // 검색어를 포함한 리스트 표시
    if($stxt){
      $stxt = " && msg LIKE '%{$stxt}%'";
    }else{
      $stxt = "";
    }


    // 선택한 메세지 이외의 메세지기록 추출
    $asql = "SELECT * FROM {$tbl_name} WHERE mb_idx={$mb_idx} && idx!={$idx} {$mread} {$stxt} ORDER BY w_date DESC";
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
      <div class='cont_block' onclick='show_rep({$list_idx})'>
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
              <td colspan='3' class='td_msg'>{$msg}</td>
            </tr>
          </table>
        </div>
      </div>
      ";
    }

    $output['html1'] = $html1;
    $output['sel_msg'] = $sel_msg;
    $output['reply'] = $reply;
    $output['sql'] = $asql;
    $output['comp_name'] = $comp_name;
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

  case "search_target" :
    if($type=="C"){
      $tbl_name = "w_customer";
    }else if($type=="S"){
      $tbl_name = "w_supplier";
    }

    $sql = "SELECT * FROM {$tbl_name} WHERE comp_name LIKE '%{$stxt}%' && mb_id <> 'admin'";
    $re = sql_query($sql);

    while($rs = sql_fetch_array($re)){
      $mb_idx = $rs['idx'];
      $comp_name = $rs['comp_name'];
      $manager = $rs['manager'];
      $mtype = $rs['mb_type'];
      if($mtype=="C"){
        $type_txt = "Customer";
      }else if($mtype=="S"){
        $type_txt = "Supplier";
      }
      $country = $rs['country'];
      // 여기에 국가코드명으로 나라이름 받아오는 함수로 처리하기

      $class_name = "c_".$mb_idx;

      $html .= "
        <tr class='{$class_name}' onmouseover='chg_back(this)' onmouseout='remove_back(this)' onclick='sel_target({$mb_idx},\"{$mtype}\",\"{$class_name}\")'>
          <td class='cont_name'>{$comp_name}</td>
          <td class='cont_name'>{$manager}</td>
          <td class='cont_type'>{$type_txt}</td>
          <td class='cont_country'>{$country}</td>
          <input type='hidden' name='comp_name{$mb_idx}' value='{$comp_name}' />
        </tr>
      ";
    }
    $output['html'] = $html;

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "send_AdminMsg" :
    $sql = "INSERT INTO w_msg_admin SET mb_idx={$mb_idx}, mb_type='{$mb_type}', w_date=DEFAULT, msg='{$msg}'";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "posting" :
    if($type=="W"){
      $box = addslashes($content);
      // $box = $content;
      $sql = "INSERT INTO w_posting SET title='{$title}', content='{$box}', w_date=DEFAULT";
      $re = sql_query($sql);

      if($re){
        $output['state'] = "Y";
      }else{
        $output['state'] = "N";
      }
      $output['sql'] = $sql;
    }else if($type=="E"){
      $box = addslashes($content);
      $e_date = date("Y-m-d H:i:s");
      $sql = "UPDATE w_posting SET title='{$title}', content='{$box}', e_date='{$e_date}' WHERE idx={$idx}";

      $re = sql_query($sql);
      if($re){
        $output['state'] = "Y";
      }else{
        $output['state'] = "N";
      }
    }
    $output['sql'] = $sql;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "del_posting" :
    $sql = "UPDATE w_posting SET del='Y' WHERE idx={$idx}";
    $re = sql_query($sql);
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


}




 ?>
