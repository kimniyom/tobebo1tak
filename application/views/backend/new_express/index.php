<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
/*
  $list = array(
  array('url' => '', 'label' => 'menu1'),
  array('url' => '', 'label' => 'menu2')
  );
 * 
 */
$active = $head;
$list = "";
echo $model->breadcrumb_backend($list, $active);
?>
<h3><i class="fa fa-newspaper-o"></i> <?php echo $head ?></h3>
<hr/>
<div class="panel panel-success">
    <div class="panel-heading">
        <?php if ($setactive == 1) { ?>
            <input type="checkbox" id="lastnews" checked="checked" onclick="setactive(0)"/> 
        <?php } else { ?>
            <input type="checkbox" id="lastnews" onclick="setactive(1)"/> 
        <?php } ?>
        แสดงข้อมูลหน้าเว็บ | 

        <a href="<?php echo site_url('backend/newexpress/create') ?>">
            <button type="button" class="btn btn-success"><i class="fa fa-plus"></i> สร้างข่าวด่วน</button>
        </a>
    </div>
    <div class="panel-body">
        <table class="table" id="tb_news_express">
            <thead>
                <tr>
                    <th style=" width: 5%; text-align: center;">#</th>
                    <th>เรื่อง</th>
                    <th style=" text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($express->result() as $rs):
                    $i++;
                    ?>
                    <tr>
                        <td style=" text-align: center;"><?php echo $i; ?></td>
                        <td><?php echo $rs->title; ?> <font style="color:red;">(<?php echo $rs->create_date ?>)</font></td>
                        <td style=" text-align: center;">
                            <a href="<?php echo site_url('backend/newexpress/view/' . $rs->id) ?>" title="ราละเอียด">
                                <i class="fa fa-eye text-info"></i></a>
                            <a href="<?php echo site_url('backend/newexpress/update/' . $rs->id) ?>" title="แก้ไข">
                                <i class="fa fa-pencil text-primary"></i></a>
                            <a href="javascript:delete_express('<?php echo $rs->id ?>')" title="ลบ">
                                <i class="fa fa-trash text-danger"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tb_news_express").dataTable();
    });
    function delete_express(id) {
        var r = confirm("คุณต้องการลบ ใช่ หรือ ไม่ ...");
        if (r == true) {
            var url = "<?php echo site_url('backend/newexpress/delete') ?>";
            var data = {id: id};

            $.post(url, data, function (success) {
                window.location = "<?php echo site_url() ?>backend/newexpress";
            });
        }
    }
    
    function setactive(val){
        var url = "<?php echo site_url('backend/newexpress/setactive') ?>";
        var data = {val: val};
        $.post(url,data,function(datas){
            window.location.reload();
        });
    }
</script>