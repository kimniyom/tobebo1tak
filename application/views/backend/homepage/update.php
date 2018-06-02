<label>เรื่อง</label>
<input type="text" class="form-control" id="update_title_name" value="<?php echo $result->title_name ?>"/>
<label>จำนวนที่ให้แสดง</label>
<input type="number" id="update_limit" value="<?php echo $result->limit ?>" class="form-control"/>
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6">
    <br/>
    <label>สีพื้นหลัง</label>
    <input type="color" id="update_box_color" value="<?php echo $result->box_color?>"/>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6">
    <br/>
    <label>สีข้อความหัวเรื่อง</label>
    <input type="color" id="update_head_color" value="<?php echo $result->head_color?>"/>
  </div>
</div>
<label>รูปแบบ</label>
<select id="update_type_id" class="form-control" onchange="update_get_style(this.value)">
    <option value="">== เลือกรูปแบบ ==</option>
    <?php foreach ($type->result() as $t): ?>
        <option value="<?php echo $t->id ?>" <?php
        if ($t->id == $result->type_id) {
            echo "selected";
        }
        ?>><?php echo $t->type_menu ?></option>
            <?php endforeach; ?>
</select>
<div class="row" style=" padding:0px;">
    <br/>
    <center>ตัวอย่าง</center><br/>
    <div class="col-sm-12 col-md-12 col-lg-12" id="update_full" style="height: 100px; display: none;">
        <div class="panel panel-default">
            <div class="panel-heading">เรื่อง</div>
            <div class="panel-body">
                ข้อมูล
            </div>
        </div>
    </div>
    <div id="update_half" style="display: none;">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="height: 100px;">
        <div class="panel panel-default">
            <div class="panel-heading">เรื่อง</div>
            <div class="panel-body">ข้อมูล</div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="height: 100px;">
        <div class="panel panel-default">
            <div class="panel-heading">เรื่อง</div>
            <div class="panel-body">ข้อมูล</div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var id = "<?php echo $result->type_id ?>";
        update_get_style(id);
    });

    function update_get_style(id) {
        if (id == '1') {
            $("#update_full").show();
            $("#update_half").hide();
        } else if (id == '2') {
            $("#update_half").show();
            $("#update_full").hide();
        } else {
            $("#update_half").hide();
            $("#update_full").hide();
        }
    }

    function save_update_homepage() {
        var url = "<?php echo site_url('backend/homepage/save_update_homepage') ?>";
        var title_name = $("#update_title_name").val();
        var type_id = $("#update_type_id").val();
        var id = "<?php echo $result->id ?>";
        var limit = $("#update_limit").val();
        var box_color = $("#update_box_color").val();
        var head_color = $("#update_head_color").val();
        var data = {
            id: id,
            title_name: title_name,
            type_id: type_id,
            limit: limit,
            box_color: box_color,
            head_color: head_color
        };
        if (title_name == '') {
            $("#title_name").focus();
            return false;
        }

        if (type_id == '') {
            alert("ยังไม่ได้เลือกรูปแบบ")
            return false;
        }

        $.post(url, data, function (success) {
            window.location.reload();
        });
    }
</script>
