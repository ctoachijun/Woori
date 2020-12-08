<?
require "../lib/db.config.php";
$host = $_SERVER["SERVER_NAME"];

ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
ini_set("url_rewriter.tags","");  // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
ini_set("session.cookie_lifetime",0);
// ini_set("session.cookie_domain",$host);
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();

//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);



/*
  여기서부터 함수 등록
*/

function get_token(){
  $token = "";
  $token1 = "";

  // 32비트의 보안키 생성
  // 리눅스 커널 안전성이 보장된 urandom 으로 보안키 생성
  $fp = @fopen('/dev/urandom','rb');
  if($fp !== FALSE) {
      $token .= @fread($fp,16);
      @fclose($fp);
      // echo "urandom";
  }else{
    // urandom 접속 실패시 보안키 작성
    $token = openssl_random_pseudo_bytes(16,$result);
  }

  // 바이너리 형식을 변환
  $box = bin2hex($token);
  // 64비트로 재암호화.
  $token = base64_encode(hash('sha512',$box,true));

  return $token;

}

function chk_token($token,$mb_id){
  $sql = "SELECT token FROM w_customer WHERE mb_id='{$mb_id}'";
  $re = sql_fetch($sql);
  $db_token = $re['token'];

  if($db_token != $token){
    return false;
  }else{
    return true;
  }
}

function alert($msg){
  echo "<script>";
  echo "alert('{$msg}');";
  echo "</script>";
}
function alert_back($msg){
  echo "<script>";
  echo "alert('{$msg}');";
  echo "history.go(-1);";
  echo "</script>";
}
function move_page($location){
  echo "<script>";
  echo "location.replace('{$location}');";
  echo "</script>";
}
function getCustomerInfo($idx){
  $sql = "SELECT * FROM w_customer WHERE idx={$idx}";
  $re = sql_fetch($sql);

  return $re;
}
function getSupplierInfo($idx){
  $sql = "SELECT * FROM w_supplier WHERE idx={$idx}";
  $re = sql_fetch($sql);

  return $re;
}


function getMsgList($type,$cur_page,$mb_id,$end,$stxt,$target){
  if($cur_page==1){
    $start=0;
  }else{
    $start = $cur_page * $end - $end;
  }
// echo "start : $start <br>";

  if($target=="CN"){
    $target_wh = " && t2.comp_name LIKE '%{$stxt}%'";
  }else if($target=="MN"){
    $target_wh = " && t2.manager LIKE '%{$stxt}%'";
  }else if($target=="MS"){
    $target_wh = " && t1.msg LIKE '%{$stxt}%'";
  }

  $type_wh = 1;
  $tbl_name = "w_msg";
  $ctbl_name = "w_customer";
  if($type=="A"){
    $tbl_name = "w_msg_admin";
  }else if($type=="S"){
    $type_wh = "mb_type='{$type}'";
    $ctbl_name = "w_supplier";

  }else if($type=="C"){
    $type_wh = "mb_type='{$type}'";
  }

  // 검색이 설정되어있으면 JOIN, 아니면 그냥.
  if($target=="AA"){
    $join_tbl = $tbl_name;
  }else{
    $join_tbl = $tbl_name." AS t1 INNER JOIN ".$ctbl_name." AS t2 ON t1.mb_idx = t2.idx";
    $type_wh = "t2.".$type_wh;
  }
  $where_txt = $type_wh.$target_wh;

  $sql = "SELECT * FROM {$join_tbl} WHERE {$where_txt} && del='N' ORDER BY w_date DESC LIMIT {$start},{$end}";
  // echo $sql;
  $re = sql_query($sql);

  while($rs = sql_fetch_array($re)){
    $idx = $rs['idx'];
    $mb_idx = $rs['mb_idx'];
    $mb_type = $rs['mb_type'];
    if($mb_type=="C"){
      $info = getCustomerInfo($mb_idx);
      $type_txt = "Customer";
    }else if($mb_type=="S"){
      $info = getSupplierInfo($mb_idx);
      $type_txt = "Supplier";
    }

    $comp_name = $info['comp_name'];
    $manager = $info['manager'];
    $w_date = $rs['w_date'];
    $msg = mb_strimwidth($rs['msg'],0,110,'...','utf-8');


    echo "<tr>";
    echo "<td class='cont_name'>{$comp_name}</td>";
    echo "<td class='cont_name'>{$manager}</td>";
    echo "<td class='cont_type'>{$type_txt}</td>";
    echo "<td class='cont_date'>{$w_date}</td>";
    echo "<td class='cont_msg'><a onclick='show_rep({$idx})'>{$msg}</a></td>";
    echo "<td class='cont_btn'><button class='form-control btn-danger' onclick='del_msg({$idx},\"{$target}\")'>삭제</button></td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td colspan='6'>";
  getPaging($tbl_name,$cur_page,$mb_id,$end,$where_txt,$type);
  echo "</td>";
  echo "</tr>";

}


function getPaging($table,$cur_page,$mb_id,$end,$where_txt,$type){
  // echo "cur : $cur_page <br>";
  // echo "end : $end <br>";

  $sql = "SELECT * FROM {$table} WHERE {$where_txt} && del='N'";
  // echo $sql;
  // 페이징
  $total_cnt = sql_num_rows(sql_query($sql));  // 전체 게시물수
  $page_rows = $end;  // 한페이지에 표시할 데이터 수
  $total_page = ceil($total_cnt / $page_rows); // 총 페이지수

    // 총페이지가 0이라면 1로 설정
  if($total_page == 0){
    ++$total_page;
  }

  $block_limit = 10; // 한 화면에 뿌려질 블럭 개수
  $total_block = ceil($total_page / $block_limit);  // 전체 블록수
  $cur_page = $cur_page ? $cur_page : 1;  // 현재 페이지
  $cur_block = ceil($cur_page / $block_limit); // 현재블럭 : 화면에 표시 될 페이지 리스트
  $first_page = (((ceil($cur_page / $block_limit) -1) * $block_limit) +1);  // 현재 블럭의 시작
  $end_page = $first_page + $block_limit - 1; // 현재 블럭의 마지막


  if($total_page < $end_page){
    $end_page = $total_page;
  }

  $prev = $first_page - 1;
  $next = $end_page + 1;
  // 페이징 준비 끝


  $sql = "SELECT * FROM {$table} WHERE {$where_txt} && del='N' ORDER BY w_date DESC LIMIT {$first_page},{$end_page}";
  // echo $sql;
  $total_cnt = sql_num_rows($sql);

  // 이전 블럭을 눌렀을때 현재 페이지 세팅.
  // $pre_block = $cur_page - $block_limit;
  $pre_block = $end_page - $block_limit;
  if($pre_block < $block_limit+1){
    $pre_block = $block_limit;
  }

  // 다음블럭의 첫번째 페이지 산출
  // $next_block = $cur_page + $block_limit;
  $next_block = $end_page + 1;
  if($next_block > $total_page){
    $next_block = (($cur_block + 1) * $block_limit) - ($block_limit-1);
  }

  // 이전 버튼을 눌렀을때 LIMIT 처리
  $prev_start = $first_page - $block_limit;
  $prev_end = $end_page - $block_limit;
  if($prev_start < $block_limit+1){
    $prev_start = 1;
    $prev_end = $block_limit;
  }

  // 다음 버튼을 눌렀을때 LIMIT 처리
  $next_start = $first_page + $block_limit;
  $next_end = $end_page + $block_limit;
  if($next_end > $total_page){
    $next_end = $total_page;
    if($next_start > $next_end){
      $next_start = $cur_block * $block_limit + 1;
    }
  }


  $cur_path = $_SERVER['SCRIPT_NAME'];
  $prev_url = $cur_path."?table={$table}&cur_page={$pre_block}&start={$prev_start}&end={$page_rows}&type={$type}";
  $next_url = $cur_path."?table={$table}&cur_page={$next_block}&start={$next_start}&end={$page_rows}&type={$type}";


  // 이전, 다음버튼 제어 처리
  if($cur_block == $total_block){
    $end_class = "disabled";
    $li_href2 = " ";
  }else{
    $end_class = " ";
    $li_href2 = "href='{$next_url}'";
  }
  if($cur_block == 1){
    $start_class = "disabled";
    $li_href1 = " ";
  }else{
    $start_class = " ";
    $li_href1 = "href='{$prev_url}'";
  }



  echo "<ul class='pagination'>";
    // <!-- li태그의 클래스에 disabled를 넣으면 마우스를 위에 올렸을 때 클릭 금지 마크가 나오고 클릭도 되지 않는다.-->
    // <!-- disabled의 의미는 앞의 페이지가 존재하지 않다는 뜻이다. -->
  echo "<li class='{$start_class}'>";
  echo "<a {$li_href1}><span>«</span></a>";
  echo "</li>";
  // <!-- li태그의 클래스에 active를 넣으면 색이 반전되고 클릭도 되지 않는다. -->
  // <!-- active의 의미는 현재 페이지의 의미이다. -->
  for($i=$first_page; $i<=$end_page; $i++){
    if($i==$cur_page){
      $act = "active";
      $cont = "<a>{$i}</a>";
    }else{
      $act = " ";
      $cur_url = $cur_path."?table={$table}&cur_page={$i}&end={$page_rows}&type={$type}";
      $cont = "<a href='{$cur_url}'>{$i}</a>";
    }
    echo "<li class='{$act}'>{$cont}</li>";
  }
  echo "<li class='{$end_class}'><a {$li_href2}><span>»</span></a></li>";
  echo "</ul>";

}


function getPosting($cur_page,$end,$num){
  if($cur_page==1){
    $start=0;
    $cnt = 1;
  }else{
    $start = $cur_page * $end - $end;
    $cnt = $cur_page * $end - ($end-1);
  }

  $sql = "SELECT * FROM w_posting WHERE del='N' ORDER BY w_date DESC LIMIT {$start},{$end}";
  $re = sql_query($sql);


  while($rs=sql_fetch_array($re)){
    $idx = $rs['idx'];
    $title = $rs['title'];

    // html 코드로 변환 후 이미지 안나오게, 최대한 한줄에 많이보이게 처리. (한계가 있.. ㅠㅠ)
    $box = htmlspecialchars_decode($rs['content']);
    $box2 = strpos($box,"<p>");
    $content_box = str_replace("<p>"," ",$box);
    $content_box = str_replace("</p>"," ",$content_box);
    $content_box = str_replace("<img"," ",$content_box);
    $content = mb_strimwidth($content_box,0,55,'...','utf-8');


    $wbox = explode(" ",$rs['w_date']);
    $w_date = $wbox[0];

    echo "
    <tr onmouseover='chg_back(this)' onmouseout='remove_back(this)'>
      <td class='cont_no'>{$cnt}</td>
      <td class='cont_title'>{$title}</td>
      <td class='cont_content'>{$content}</td>
      <td class='cont_date'>{$w_date}</td>
      <td class='cont_btn'>
        <button class='btn btn-secondary editbtn' onclick='edit_posting({$idx})'>수정</button>
        <button class='btn btn-danger delbtn' onclick='del_posting({$idx})'>삭제</button>
      </td>
    </tr>

    ";
    $cnt++;
  }

  echo "<tr>";
  echo "<td colspan='5'>";
  getPaging("w_posting",$cur_page,$mb_id,$end,1,$type);
  echo "</td>";
  echo "</tr>";

}


function getPostingInfo($idx){
  $sql = "SELECT * FROM w_posting WHERE idx={$idx}";
  $re = sql_fetch($sql);

  return $re;
}











?>
