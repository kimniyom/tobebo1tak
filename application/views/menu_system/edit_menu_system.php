<div class="panel panel-default">
    <div class="panel-heading">
        แก้ไขเมนูระบบ
    </div>
    <div class="panel-body">
        <input type="hidden" id="menu_id" value="<?php echo $menu_id; ?>"/>
        <label>หัวข้อ</label>
        <input type="text" id="menu_name" class="form-control" value="<?php echo $result->system_title; ?>"/>
        <label>ลิงค์</label>
        <input type="text" id="menu_link" class="form-control" value="<?php echo $result->link; ?>"/>
    </div>
    <div class="panel-footer" style="text-align: center;">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <?php if (!empty($result->system_images)) { ?>
                        <img src="<?php echo base_url(); ?>icon_menu/<?php echo $result->system_images; ?>"/>
                    <?php } else { ?>
                        ไม่มีรูปภาพ<br/>
                    <?php } ?>
                </div>
                <a href="<?php echo site_url('takmoph_admin/from_upload_images_menu_system/' . $menu_id); ?>">
                    <div class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i> แก้ไขรูป</div></a>
            </div>
        </div>
    </div>
</div>
