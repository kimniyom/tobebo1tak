<?php
$userid = $this->session->userdata('tobe_user_id');
$this->db->where("user_id", $userid);
$privilege = $this->db->get("tobe_user_privilege")->row();
?>
<div class="list-group">
    <div class="list-group-item active">เมนู</div>
    <?php if ($privilege->news == 1) { ?>
        <a href="<?php echo site_url('toberegis/news/index') ?>" class="list-group-item"><i class='fa fa-file'></i> ข่าวประชาสัมพันธ์</a>
    <?php } else { ?>
        <div class="list-group-item disabled"><i class='fa fa-file'></i> ข่าวประชาสัมพันธ์</div>
    <?php } ?>
    <?php if ($privilege->activity == 1) { ?>
        <a href="" class="list-group-item"><i class='fa fa-photo'></i> รูปภาพกิจกรรม</a>
    <?php } else { ?>
        <div class="list-group-item disabled"><i class='fa fa-photo'></i> รูปภาพกิจกรรม</div>
    <?php } ?>
</div>