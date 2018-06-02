<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    array('url' => 'toberegis/toberegis', 'label' => 'Dashboard')
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

<div class="modal fade" tabindex="-1" role="dialog" id="form-register-popup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="margin-top: 20%; margin-bottom: 30%;">
            <div class="col-md-3 col-lg-3">
                <label>อำเภอ</label>
                <select class="form-control" id="amphur" onchange="GetOffice()">
                    <option value="">เลือก</option>
                    <?php foreach ($amphur->result() as $am){ ?>
                    <option value="<?php echo $am->distid ?>"><?php echo $am->distname ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3 col-lg-3">
                        <label>ประเภท</label>
                <select class="form-control" id="type" onchange="GetOffice()">
                    <option value="">เลือก</option>
                    <?php foreach ($type->result() as $rs){ ?>
                    <option value="<?php echo $rs->id ?>"><?php echo $rs->typename ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3 col-lg-3">
                <div id="_office">
                <label>?</label>
                <select class="form-control" id="office">
                    <option value="">เลือก</option>
                </select>
                </div>
            </div>
            <div class="col-md-2 col-lg-2">
                <button type="button" class="btn btn-default btn-block" style="margin-top:23px;" onclick="register()">ตกลง</button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="register()">ตกลง</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#form-register-popup").modal();
    });

    function GetOffice(){
        var url = "<?php echo site_url('toberegis/toberegis/combooffice') ?>";
        var amphur = $("#amphur").val();
        var type = $("#type").val();
        var data = {amphur: amphur,type: type};
        if(amphur != "" && type !=""){
            $.post(url,data,function(datas){
                $("#_office").html(datas);
            });
        }
    }

    function register(){
        var amphur = $("#amphur").val();
        var type = $("#type").val();
        var office = $("#office").val();
        var url = "<?php echo site_url('toberegis/toberegis/register') ?>" + "/" + amphur + "/" + type + "/" + office;
        if(amphur != "" && type !="" && office != ""){
            window.location=url;
        } else {
            alert("เลือกข้อมูลไม่ครบ");
            return false;
        }
    }
</script>

