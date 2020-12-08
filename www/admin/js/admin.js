function chkLogin(){
  let id = $("#id").val().trim();
  let pw = $("#password").val().trim();

  if(!id){
    alert("아이디를 입력 해 주세요.");
    $("#id").val("");
    $("#id").focus();
    return false;
  }
  if(!pw){
    alert("비밀번호를 입력 해 주세요");
    return false;
  }
}

function sort_type(uri){
  let val = $("#msg_type").val();
  location.replace(uri+"?type="+val);
}

function del_msg(num){
  let msg_type = $("#msg_type").val();

  if(confirm("삭제 하시겠습니까?")){
    let box = {"w_type":"del_msg","idx":num,"msg_type":msg_type};
    $.ajax({
      url: "ajax.admin.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);

      console.log(json.sql);
      if(json.state=="Y"){
        alert("삭제 했습니다.");
        history.go(0);
      }else{
        alert(msg + "삭제에 실패 했습니다.");
      }
    });
  }
}


function show_rep(num){
  let ru = $("#msg_read").val();
  let stxt = $("#msg_stxt").val();
  let type = $("#msg_type").val();
  let box = {"w_type":"reply_list","idx":num,"ru":ru,"stxt":stxt,"type":type};

  $("input[name=msg_idx]").val(num);
  $("input[name=ru]").val(ru);
  $("#msg_stxt").val(stxt);

  $.ajax({
    url: "ajax.admin.php",
    type: "post",
    contentType:'application/x-www-form-urlencoded;charset=UTF8',
    data: box
  }).done(function(data){
    let json = JSON.parse(data);
    console.log(json.sql);
    $("#left_list").html(json.html1);
    $("#msg_cs").val(json.sel_msg);

    if(type=="A"){
      $("#sender_name").val("관리자");
      $("#submit_btn").html("");
    }else{
      $("#sender_name").val(json.comp_name);
    }
    if(json.reply){
      $("#reply_txt").val(json.reply);
      $("#reply_txt").attr("readonly",true);
    }else{
      $("#reply_txt").val("");
      $("#reply_txt").attr("readonly",false);
    }
    $("#msg_reply").show();

  });
}
function close_rep(){
  $("#msg_reply").hide();
}

function ru_rep(){
  let msg_idx = $("input[name=msg_idx]").val();
  show_rep(msg_idx);
}

function search_rep(){
  let msg_idx = $("input[name=msg_idx]").val();
  show_rep(msg_idx);
}

function send_reply(){
  let msg_idx = $("input[name=msg_idx]").val();
  let reply = $("#reply_txt").val().trim();
  let box = {"w_type":"insert_reply","idx":msg_idx,"reply":reply};

  if(!reply){
    alert("답장 내용을 입력 해 주세요");
    $("#reply_txt").val("");
    $("#reply_txt").focus();
    return false;
  }
  alert(reply);
  if(confirm("답장을 전송 하시겠습니까?")){
    $.ajax({
      url: "ajax.admin.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);
      // console.log(json.sql);
      if(json.state=="Y"){
        alert("전송 했습니다.");
        history.go(0);
      }else{
        alert("전송에 실패 했습니다.");
      }
    });
  }

}

function search_target(){
  let type = $("#t_type").val();
  let stxt = $("#stxt").val();
  let box = {"w_type":"search_target","type":type,"stxt":stxt};
  console.log(box);

  if(!type){
    alert("검색대상을 선택 해 주세요.");
    $("#t_type").focus();
    return false;
  }

  $.ajax({
    url: "ajax.admin.php",
    type: "post",
    contentType:'application/x-www-form-urlencoded;charset=UTF8',
    data: box
  }).done(function(data){
    let json = JSON.parse(data);
    // console.log(json.html);
    $("#search_data").html(json.html);
  });
}

function sel_target(mb_idx,mb_type){
  $("input[name=mb_idx]").val(mb_idx);
  $("input[name=mb_type]").val(mb_type);
  let compname_txt = "comp_name"+mb_idx;
  $("#target_name").val($("input[name="+compname_txt+"]").val());
}

function chg_back(obj){
  obj.style.background="#FBEFF5";
}
function remove_back(obj){
  obj.style.background="";
}

function send_AdminMsg(){
  let mb_idx = $("input[name=mb_idx]").val();
  let mb_type = $("input[name=mb_type]").val();
  let msg = $("#msg_cs").val().trim();

  if(!mb_idx){
    alert("메세지 전송대상을 검색 후 선택 해 주세요.");
    return false;
  }
  if(!msg){
    alert("전송 할 메세지 내용을 입력해 주세요");
    $("#msg_cs").val("");
    $("#msg_cs").focus();
    return false;
  }
  let box = {"w_type":"send_AdminMsg", "mb_idx":mb_idx, "mb_type":mb_type, "msg":msg};

  if(confirm("메세지를 전송 하시겠습니까?")){
    $.ajax({
      url: "ajax.admin.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);
      // console.log(json.html);
      if(json.state=="Y"){
        alert("전송 했습니다.");
        $("#msg_cs").val("");
        // $("input[type=button]").attr("disabled",true);
        // history.go(0);
      }else{
        alert("전송에 실패 했습니다.");
      }
    });
  }
}


function posting(elClickedObj) {
  // 에디터의 내용이 textarea에 적용됩니다.
  oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
  // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
  let type = $("input[name=type]").val();
  let title = $("input[name=title]").val();
  let idx = $("input[name=idx]").val();
  let content = $("#ir1").val();
  let box = {"w_type":"posting", "type":type, "title":title, "content":content, "idx":idx};

  if(confirm("등록하시겠습니까?")){
    $.ajax({
      url: "ajax.admin.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.sql);
      if(json.state=="Y"){
        alert("등록 했습니다.");
        // location.href="admin_news.php";
        location.replace("admin_news.php");
      }else{
        alert("등록에 실패 했습니다.");
      }
    });
  }
}

function moveList(){
  history.go(-1);
}
function edit_posting(idx){
  $("input[name=idx]").val(idx);
  $("input[name=type]").val("E");
  $("FORM").submit();
}

function del_posting(idx){
  let box = {"w_type":"del_posting", "idx":idx};
  if(confirm("삭제하시겠습니까?")){
    $.ajax({
      url: "ajax.admin.php",
      type: "post",
      contentType:'application/x-www-form-urlencoded;charset=UTF8',
      data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.sql);
      if(json.state=="Y"){
        alert("삭제 했습니다.");
        // location.href="admin_news.php";
        history.go(0);
      }else{
        alert("삭제에 실패 했습니다.");
      }
    });
  }
}
