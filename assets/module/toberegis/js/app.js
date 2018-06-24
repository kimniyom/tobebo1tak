function saveuser() {
    var url = $("#urlsave").val();
    var urlredir = $("#urlredir").val();
    var name = $("#name").val();
    var lname = $("#lname").val();
    var username = $("#username").val();
    var password = $("#password").val();
    var type = $("#type").val();
    if (name == "" || lname == "" || username == "" || password == "" || type == "") {
        alert("กรอกข้อมูลไม่ครบ...");
        return false;
    }
    var data = {
        name: name,
        lname: lname,
        username: username,
        password: MD5(password),
        type: type
    };

    var urlcheck = $("#urlchecknulluser").val();
    var datacheck = {username: username};
    $.post(urlcheck, datacheck, function (datas) {
        if (datas == "0") {
            $.post(url, data, function (datas) {
                var id = datas.id;
                window.location = urlredir + "/" + id;
            }, 'json');
        } else {
            $("#usernull").html("<i class='fa fa-info'></i> มีคนใช้ชื่อนี้ในระบบแล้ว...");
            return false;
        }
    });

}

function login() {
    $("#error").html("");
    var url = $("#urllogin").val();
    var urldir = $("#urlredir").val();
    var username = $("#username").val();
    var password = MD5($("#password").val());
    var data = {
        username: username,
        password: password
    };

    if (username == '' || password == '') {
        $("#error").html("<i class='fa fa-info' style='color:red;'></i> !..กรอกข้อมูลที่มี * ไม่ครบ");
        return false;
    }

    $.post(url, data, function (datas) {
        if (datas.id != '0') {
            window.location = urldir + "/" + datas.id;
        } else {
            $("#error").html("<i class='fa fa-info' style='color:red;'></i> ไม่พบข้อมูล..!");
            return false;
        }
    }, 'json');
}
