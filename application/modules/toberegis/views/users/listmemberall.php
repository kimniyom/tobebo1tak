<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <?php if ($result->num_rows() > 0) { ?>
            <div class="list-group">
                <?php foreach ($result->result() as $rs): ?>
                    <a href="<?php echo site_url('toberegis/toberegis/views/' . $this->takmoph_libraries->url_encode($rs->id)) ?>" class="list-group-item">
                        <?php echo ($rs->sex == "M") ? "<i class='fa fa-male'></i>" : "<i class='fa fa-female'></i>"; ?>
                        <?php echo $rs->name . ' ' . $rs->lname ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php } else { ?>
            <center>ไม่มีข้อมูล</center>
        <?php } ?>
    </div>
</div>

