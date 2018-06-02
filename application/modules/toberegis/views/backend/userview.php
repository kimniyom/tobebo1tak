<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array('url' => 'asbforum/backend', 'label' => 'จัดการเว็บบอร์ด'),
    array('url' => 'asbforum/backend/user', 'label' => 'ผู้ใช้งาน')
);
$active = $head;
?>
<?php echo $model->breadcrumb_backend($list, $active); ?>

        <h3 id="head_submenu">
            <i class="fa fa-file-text-o fa-2x text-warning"></i>
            <?php
            echo $head;
            ?>
        </h3>
    
<hr id="hr"/>

<div class="row">
    <div class="col-md-3 col-lg-3">
        <img src="<?php echo base_url()?>assets/module/asbforum/images/profle-icon.png"/><br/>
        Username : <?php echo $user->username ?><br/>
        เข้าใช้งานล่าสุด : <?php echo $user->register_update ?><br/>
        ยืนยันตัวตน : 
        <?php if($user->active == "Y") 
            echo "<i class='fa fa-check text-success'></i>"; 
        else 
            echo "<i class='fa fa-remove text-danger'></i>"; ?><br/>
    </div>
    <div class="col-md-9 col-lg-9">
        ชื่อ - สกุล : <?php echo $user->name." ".$user->lname ?><br/>
        นามแฝง : <?php echo $user->alias ?><br/>
        อีเมล์ : <?php echo $user->email ?><br/>
        เบอร์โทรศัพท์ <?php echo $user->tel ?>
        <hr/>
        วันที่ลงทะเบียน : <?php echo $user->register_date ?><br/>
        แก้ไขล่าสุด : <?php echo $user->register_update ?><br/>
        <hr/>
        <button type="button" class="btn btn-default">โพสต์ทั้งหมด</button>
        <button type="button" class="btn btn-default">โพสต์ล่าสุด</button>
    </div>
</div>
