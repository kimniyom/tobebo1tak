<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('detail_complain', {
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document']}, // Displays document group with its two subgroups.
                {name: 'clipboard', groups: ['clipboard', 'undo']}, // Group's name will be used to create voice label.
                '/', // Line break - next group will be placed in new line.
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'links'},
                {name: 'styles'},
                {name: 'colors'}
            ],
            //filebrowserBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html',
            //filebrowserImageBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Images',

            //removePlugins: 'bidi,forms,flash,iframe,tabletools,find',
            //removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About'
            removeButtons: 'Source,Print,Anchor,Subscript,Superscript,RemoveFormat'
        });
    });
</script>

<script type="text/javascript">
    Getcaptcha();
    function Send_complain() {
        var detail_complain = CKEDITOR.instances.detail_complain.getData();
        var url = "<?php echo site_url('complain/send_complain'); ?>";
        var name = $("#name").val();
        var email = $("#email").val();
        var tel = $("#tel").val();
        var card = $("#card").val();
        var head_complain = $("#head_complain").val();
        var captcha = $("#captcha").val();
        var word = $("#recaptcha").val();
        var detail = detail_complain;

        var data = {
            name: name,
            email: email,
            card: card,
            tel: tel,
            head_complain: head_complain,
            detail: detail
        };

        if (name == '' || email == '' || card == '' || head_complain == '' || detail == '') {
            alert("ท่านกรอกข้อมูลไม่ครบ ...");
            return false;
        }

        if (card.length != 13) {
            alert("เลขบัตรประชาชนไม่ถูกต้อง");
            return false;
        }

        if (captcha != word) {
            alert("กรอกรหัสภาพไม่ถูกต้อง");
            return false;
        }

        $.post(url, data, function (datas) {
            var id = datas.complain_id;
            window.location = "<?php echo site_url('complain/detail') ?>" + "/" + id;
        },"json");

    }

    function CheckNum() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
        }
    }

    function Getcaptcha() {
        var url = "<?php echo site_url('complain/SetCaptcha') ?>";
        var data = {};
        $.post(url, data, function (datas) {
            $("#getcaptcha").html(datas);
        });

    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();

$list = "";
$active = $head;
?>

<?php echo $model->breadcrumb($list, $active); ?>

        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>
    
<hr id="hr"/>
<div style=" color: #ff0000;">
    *กรุณากรอกข้อมูลที่เป็นจริงเท่านั้น เพื่อประโยชน์แก่ตัวท่านเอง<br/>
    *ข้อมูลของท่านจะเป็นความลับรู้เฉพาะผู้มีสิทธิ์เท่านั้น
</div>

<label>ชื่อผู้ร้องเรียน</label>
<input type="text" id="name" style="width: 98%;"/>
<label>อีเมล์ผู้ร้องเรียน</label>
<input type="email" id="email" style="width: 98%;"/>
<label>เลขบัตรประชาชน</label>
<input type="text" id="card" style="width: 98%;" onkeypress="CheckNum();" maxlength="13"/>
<label>เบอร์โทรศัพท์</label>
<input type="text" id="tel" style="width: 98%;" onkeypress="CheckNum();" maxlength="10"/>
<label>หัวข้อร้องเรียน</label>
<input type="text" id="head_complain" style="width: 98%;"/>
<label>รายละเอียด</label>
<textarea id="detail_complain" name="detail_complain" class="detail_complain"  rows="10" style="width: 98%;"></textarea>
<label>พิมพ์ตัวอักษรที่เห็นในรูปด้านล่าง</label>
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div id="getcaptcha"></div>
    </div>
    <div class="col-md-2 col-lg-2">
        <button type="button" class="btn btn-default btn-lg" onclick="Getcaptcha()"><i class="fa fa-refresh"></i></button>
    </div>
</div>
<div class="row" style=" margin-top: 10px;">
    <div class="col-md-6 col-lg-6">
        <input type="text" name="captcha" id="captcha" value=""/>
    </div>
</div>
<br/>
<hr id="hr"/>
<div class="row" style=" margin-top: 10px;">
    <div class="col-md-3 col-lg-3">
        <button type="button" class="btn btn-success btn-sm" onclick="Send_complain();">ส่งเรื่องร้องเรียน</button>
    </div>
</div>
