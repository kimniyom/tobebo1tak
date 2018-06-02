<style type="text/css">
	.row{
		margin-bottom: 10px;
	}
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array('url' => 'toberegis/occupation', 'label' => 'อาชีพ,สถานบริการ,หน่วยงาน,โรงเรียน')
);
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
<?php echo $level ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2 col-lg-2">รหัส *ถ้ามี</div>
            <div class="col-md-5 col-lg-5">
                <input type="text" name="code" id="code" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-lg-2">name</div>
            <div class="col-md-10 col-lg-10">
                <input type="text" name="name" id="name" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-lg-2">final</div>
            <div class="col-md-10 col-lg-10">
                <input type="radio" name="final" id="final" value="0" checked="checked" /> No
                <input type="radio" name="final" id="final" value="1" /> Yes
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-10 col-lg-10">
                <button type="button" class="btn btn-success" onclick="saveoccupation()"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function saveoccupation(){
        var url = "<?php echo site_url('toberegis/occupation/save') ?>";
        var name = $("#name").val();
        var code = $("#code").val();
        var final = $("input[name='final']:checked").val();
        var upper = "<?php echo $upper ?>";
        var level = "<?php echo $level ?>";
        if(name == ""){
            alert("กรอกข้อมูลไม่ครบ...");
            return false;
        }
        var data = {code: code,name: name,final: final,upper: upper,level: level};
        $.post(url,data,function(datas){
            if(final == 0){
                var id = datas.id;
                window.location="<?php echo site_url('toberegis/occupation/create/') ?>" + "/" + id;
            } else {
                var uppers = datas.upper;
                window.location="<?php echo site_url('toberegis/occupation/index/') ?>" + "/" + uppers;
            }
        },'json');
    }
</script>