<script type="text/javascript">
    Getimgprofile('<?php echo $user->token_key ?>');
    GetLastpost();
    $(document).ready(function () {
        var token = "<?php echo $user->token_key ?>";
        $('#file_upload').uploadify({
            'buttonText': 'กรุณาเลือกไฟล์ ...',
            'auto': true, //เปิดใช้การอัพโหลดแบบอัติโนมัติ
            'swf': '<?= base_url() ?>lib/images/uploadify.swf', //โฟเดอร์ที่เก็บไฟล์ปุ่มอัพโหลด
            'uploader': '<?= site_url('asbforum/users/uploadphoto') ?>' + "/" + token, //เมื่อ submit แล้วให้ action ไปที่ไฟล์ไหน
            'fileSizeLimit': '1MB', //อัพโหลดได้ครั้งละไม่เกิน 1024kb
            //'width': '350',
            //'height': '40',
            'fileTypeExts': '*.jpg; *.jpeg; *.JPG; *.JPEG; *.png;', //กำหนดชนิดของไฟล์ที่สามารถอัพโหลดได้
            'multi': false, //เปิดใช้งานการอัพโหลดแบบหลายไฟล์ในครั้งเดียว
            'queueSizeLimit': 1, //อัพโหลดได้ครั้งละ 5 ไฟล์
            'onUploadComplete': function (success) { //เมื่ออัพโหลดเสร็จแล้วให้เรียกใช้งาน function load()
                Getimgprofile(token);
            }
        });
    });

    function Getimgprofile(token) {
        var url = "<?php echo site_url('asbforum/users/getimgprofile') ?>";
        var data = {token: token};
        $.post(url, data, function (datas) {
            $("#profile-photo").html(datas);
        });
    }

    function GetLastpost() {
        var token_key = "<?php echo $user->token_key ?>";
        var url = "<?php echo site_url('asbforum/users/lastpost') ?>";
        var data = {token: token_key};
        $.post(url, data, function (datas) {
            $("#lastpost").html(datas);
        });
    }

    function postAll() {
        var token_key = "<?php echo $user->token_key ?>";
        var url = "<?php echo site_url('asbforum/users/post') ?>";
        var data = {token: token_key};
        $.post(url, data, function (datas) {
            $("#postall").html(datas);
        });
    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = "";
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active, "asbforum"); ?>

<h3 id="head_submenu">
    <i class="fa fa-file-text-o fa-2x text-warning"></i>
    <?php echo $head; ?>
</h3>

<hr id="hr"/>

<div class="row">
    <div class="col-md-3 col-lg-3">
        <div id="profile-photo"></div><br/>
        <label>แนบไฟล์ *.jpg; *.png;</label>
        <p>(Max-size: 1MB)</p>
        <input id="file_upload" name="file_upload" type="file" multiple>
        Username : <?php echo $user->username ?><br/>
        เข้าใช้งานล่าสุด : <?php echo $last_update ?><br/>
        ยืนยันตัวตน : 
        <?php
        if ($user->active == "Y")
            echo "<i class='fa fa-check text-success'></i>";
        else
            echo "<i class='fa fa-remove text-danger'></i>";
        ?><br/>
        <hr/>
        <button class="btn btn-default btn-block">
            <i class="fa fa-envelope text-danger"></i> ข้อความ <span class="badge">0</span>
        </button>
    </div>
    <div class="col-md-9 col-lg-9">
        ชื่อ - สกุล : 
        <?php
        $namelong = $user->name . "-" . $user->lname;
        if (!empty($namelong))
            echo $namelong;
        ?><br/>
        นามแฝง : <?php echo $user->alias ?><br/>
        อีเมล์ : <?php echo $user->email ?><br/>
        เบอร์โทรศัพท์ <?php
        if (!empty($user->tel))
            echo $user->tel;
        else
            echo "-";
        ?>
        <hr/>
        วันที่ลงทะเบียน : <?php echo $user->register_date ?><br/>
        แก้ไขล่าสุด : <?php echo $user->register_update ?><br/>
        <hr/>

        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#lastpost" aria-controls="home" role="tab" data-toggle="tab">กระทู้ล่าสุด</a></li>
                <li role="presentation"><a href="#postall" aria-controls="profile" role="tab" data-toggle="tab" onclick="postAll()">กระทู้ทั้งหมด <span class="badge"><?php echo $countpost ?></span></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="lastpost" style=" padding-top: 10px;"></div>
                <div role="tabpanel" class="tab-pane" id="postall" style=" padding-top: 10px;"></div>
            </div>

        </div>
        <button type="button" class="btn btn-default">อัตราการโพสต์</button>
    </div>
</div>
