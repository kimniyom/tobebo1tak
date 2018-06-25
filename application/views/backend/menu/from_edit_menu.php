
<script type="text/javascript">
    function _select_icon(Id) {
        $("#_icon_id").val(Id);
        var url = "<?php echo site_url('menager_menu/get_icon'); ?>";
        var icon_id = Id;
        var data = {icon_id: icon_id};
        $.post(url, data,
                function (success) {
                    $("#icon_show").html(success);
                });//endpost
    }
    $(document).ready(function ( ) {

        var url = "<?= site_url('menager_menu/get_icon') ?>";
        var icon_id = $("#_icon_id").val();
        var data = {icon_id: icon_id};
        $.post(url, data,
                function (success) {
                    $("#icon_show").html(success);
                });//endpost

        $("#save_edit").click(function () {
            //alert("1234");
            var url = "<?= site_url('menager_menu/save_edit_menu') ?>";
            var mas_id = $("#_mas_id").val();
            var mas_menu = $("#_mas_menu").val();
            var bgcolor = $("#update_bgcolor").val();
            var textcolor = $("#update_textcolor").val();
            var icon_id = $("#_icon_id").val();
            var _link = $("#_page").val();

            var data = {
              mas_id: mas_id,
              mas_menu: mas_menu,
              bgcolor: bgcolor,
              textcolor: textcolor,
              _link: _link,
              icon_id: icon_id
            };

            $.post(url, data,
                    function (success) {
                        window.location.reload();
                    });// Endpost
        });
    });
</script>

<input type="hidden" id="_icon_id" value="<?php echo $mas_menu->icon_id; ?>"/>
<div class="well">
    <input type="hidden" id="icon" value="<?= $mas_menu->icon_id ?>" readonly="readonly" class="form-control input-sm"/>
    <div class="form-group">
        <label>รหัส : </label>
        <input type="text" id="_mas_id" value="<?= $mas_menu->id ?>" readonly="readonly" class="form-control input-sm"/>
    </div>
    <div class="form-group">
        <label>เมนู :</label>
        <input type="text" id="_mas_menu" value="<?= $mas_menu->mas_menu ?>" class="form-control input-sm"/>
    </div>

    <div class="form-group">
        <label>ไอคอน :</label>
        <div class="row">
            <div class=" col-lg-9 col-sm-9 col-md-9">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-smile-o"></i> เลือก icon
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style=" max-height: 300px; overflow: auto;">
                        <?php foreach ($icon->result() as $rs): ?>
                            <li>
                                <a href="javascript:_select_icon('<?php echo $rs->icon_id ?>')"><img src="<?php echo base_url() ?>icon_menu/<?php echo $rs->icon ?>" width="32"/><?php echo $rs->icon ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
            <div class=" col-lg-3 col-sm-3 col-md-3">
                <div class="btn btn-default" id="icon_show" style="margin-bottom:0px;"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>สีเมนู :</label>
        <div class="row">
          <div class="col-sm-12 col-md-10 col-lg-10">
            <button type="button" class="btn" style="background:#ff8981; color:#ff8981;" onclick="update_set_btn_color('#ff8981','#000000')">l</button>
            <button type="button" class="btn" style="background:#b58aff; color:#b58aff;" onclick="update_set_btn_color('#b58aff','#000000')">.</button>
            <button type="button" class="btn" style="background:#b9f6cc; color:#b9f6cc;" onclick="update_set_btn_color('#b9f6cc','#000000')">.</button>
            <button type="button" class="btn" style="background:#fffe8d; color:#fffe8d;" onclick="update_set_btn_color('#fffe8d','#000000')">.</button>
            <button type="button" class="btn" style="background:#84feff; color:#84feff;" onclick="update_set_btn_color('#84feff','#000000')">.</button>
            <button type="button" class="btn" style="background:#f5f5f5; color:#f5f5f5;" onclick="update_set_btn_color('#f5f5f5','#000000')">.</button>

            <button type="button" class="btn" style="background:#ff5254; color:#ff5254;" onclick="update_set_btn_color('#ff5254','#FFFFFF')">.</button>
            <button type="button" class="btn" style="background:#7e57c2; color:#7e57c2;" onclick="update_set_btn_color('#7e57c2','#FFFFFF')">.</button>
            <button type="button" class="btn" style="background:#1de9b6; color:#1de9b6;" onclick="update_set_btn_color('#1de9b6','#000000')">.</button>
            <button type="button" class="btn" style="background:#ffeb3c; color:#ffeb3c;" onclick="update_set_btn_color('#ffeb3c','#000000')">.</button>
            <button type="button" class="btn" style="background:#05a8f3; color:#05a8f3;" onclick="update_set_btn_color('#05a8f3','#FFFFFF')">.</button>
            <button type="button" class="btn" style="background:#999999; color:#999999;" onclick="update_set_btn_color('#999999','#FFFFFF')">.</button>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <div class="btn btn-block" id="update_bg_color" style="background:<?php echo $mas_menu->bgcolor ?>;">ตัวอย่าง</div>
      </div>
      <input type="hidden" id="update_bgcolor" value="<?php echo $mas_menu->bgcolor ?>"/>
      <input type="hidden" id="update_textcolor" value="<?php echo $mas_menu->textcolor ?>"/>
    </div>

    <?php if ($mas_menu->mas_status == '0') { ?>
        <div class="form-group">
            <label>ลิงค์ :</label>
            <input type="text" id="_page" value="<?= $mas_menu->link ?>" class="form-control input-sm"/>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
  function update_set_btn_color(color,text){
    $("#update_bgcolor").val(color);
    $("#update_textcolor").val(text);
    var style = {
      "background": color,
      "color": text
    }
    $("#update_bg_color").css(style);
  }
</script>
