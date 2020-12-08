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
  if(confirm(num+"삭제 하시겠습니까?")){
    let box = {"w_type":"del_msg","idx":num}
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
  let box = {"w_type":"reply_list","idx":num};
  $("input[name=msg_idx]").val(num);
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

function send_reply(){
  let msg_idx = $("input[name=msg_idx]").val();
  let reply = $("#reply_txt").val();
  let box = {"w_type":"insert_reply","idx":msg_idx,"reply":reply};

  $.ajax({
    url: "ajax.admin.php",
    type: "post",
    contentType:'application/x-www-form-urlencoded;charset=UTF8',
    data: box
  }).done(function(data){
    let json = JSON.parse(data);
    console.log(json.sql);
    if(json.state=="Y"){
      alert("전송 했습니다.");
      history.go(0);
    }else{
      alert("전송에 실패 했습니다.");
    }
  });




}
