function do_login() {
    var base_url = $("#base_url").val();
    var url = base_url + "do_login";
    var username = $("#username").val();
    var password = $("#password").val();
    var data = {
        username: username,
        password: password
    };

    if (username == '' || password == '') {
        //alert("กรอกข้อมูลไม่ครบ");
        swal("Warning!", "กรอกข้อมูลไม่ครบ..!", "warning");
        return false;
    }

    $.post(url, data, function (success) {
        //alert(success);
        if (success == "Success") {
            window.location = base_url + "index.php/takmoph_admin";
        } else if (success == "NOSuccess") {
            swal("Warning!", "ไม่พบข้อมูล..!", "warning");
            window.location = base_url + "index.php/users/login";
        } else {
            window.location = base_url + "index.php/users/lock";
        }
    });
}

