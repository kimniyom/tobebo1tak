<?php $path = base_url() . "assets/CK-Editor/"; ?>

<input type="hidden" id="_group_id" name="_group_id" value="<?= $groupnews->id ?>"/>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <label>ชื่อกลุ่ม</label>
        <input type="text" id="_groupname" name="_groupname" style="width:98%;" class="form-control input-mini" required="required" value="<?= $groupnews->groupname ?>" onkeyup="setheadupdate(this.value)"/>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <label>สีหัวข้อ</label>
        <input type="color" id="_headcolor" value="<?php echo $groupnews->headcolor ?>"/>
        <label>สีพื้นหลัง</label>
        <input type="color" id="_background" value="<?php echo $groupnews->background ?>"/>
        <button type="button" onclick="setcolorupdate()"><i class="fa fa-check"></i> ดูตัวอย่าง</button>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-lg-2">
        <label>จำนวน Column</label>
    </div>
    <div class="col-md-3 col-lg-3">
        <select id="_column" class="form-control" onchange="setcolumnsupdate()">
            <option value="3" <?php echo ($groupnews->column == 3) ? "selected" : ""; ?>>4</option>
            <option value="12" <?php echo ($groupnews->column == 12) ? "selected" : ""; ?>>1</option>
            <option value="6" <?php echo ($groupnews->column == 6) ? "selected" : ""; ?>>2</option>
            <option value="4" <?php echo ($groupnews->column == 4) ? "selected" : ""; ?>>3</option>
        </select>
    </div>
</div>
<label>ตัวอย่าง</label>
<div class="ex_update" style="padding: 10px; padding-top: 5px;">
    <div class="btn" id="_head_update" style=" border-radius: 0px; font-size: 20px; padding-left: 0px;">ชื่อกลุ่ม</div>
    <hr id="_hr" style=" margin: 0px; margin-bottom: 10px;"/>
    <div id="_ex_update"></div>
</div>

<script type="text/javascript">
    setheadupdate('<?= $groupnews->groupname ?>');
    function edit_groupnews() {
        var data = {
            id: $("#_group_id").val(),
            groupname: $("#_groupname").val(),
            headcolor: $("#_headcolor").val(),
            background: $("#_background").val(),
            column: $("#_column").val()
        };

        $.ajax({
            type: "POST",
            url: "<?= site_url('backend/groupnews/save_update') ?>",
            data: data,
            success: function () {
                window.location.reload();
            }
        });
    }
    /*Update*/
    function setcolumnsupdate() {
        var culumns = $("#_column").val();
        var colselect = (12 / culumns);
        var col = "";
        var buttonS = "<button type='button' class='btn btn-default btn-block'><h1><i class='fa fa-photo'></i></h1><hr/>";
        var buttonE = "</button>";
        for (i = 1; i < colselect + 1; i++) {
            col += "<div class='col-lg-" + culumns + "'>" + buttonS + i + buttonE + "</div>";
        }
        var ex = "<div class='row'>" + col + "</div>";
        $("#_ex_update").html(ex);
    }



    function setheadupdate(text) {
        $(".ex_update #_head_update").html("<b>" + text + "</b>");
    }

    function setcolorupdate() {
        var bg = $("#_background").val();
        var text = $("#_headcolor").val();
        var border = 'solid 2px ' + text;
        $(".ex_update").css({'background': bg});
        $(".ex_update #_head_update").css({'color': text});
        $(".ex_update #_hr").css({'border': border});
    }
</script>