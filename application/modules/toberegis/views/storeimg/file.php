<div class='row' style=" margin: 0px;">
    <?php
    $i = 0;
    foreach ($images->result() as $rs):
        $i++;
        $typefile = substr($rs->images, -3);
        if ($typefile == "pdf") {
            $icon = "Files-Pdf-icon.png";
        } else {
            $icon = "Files-Zip-icon.png";
        }
        ?>
           <div class='col-xs-6 col-sm-3 col-md-3 col-lg-3'>
                <div class="thumbnail">
                    <div class="container-card" style="height:120px; text-align: center;">
                   
                            <em style="font-size: 10px; position: absolute; right: 0px; top: 0px; z-index: 1;"><?php echo $rs->size_kb >= 1024 ? $rs->size_mb . "mb" : $rs->size_kb . "kb" ?></em>
                            <img src="<?php echo base_url() ?>icon_menu/<?php echo $icon ?>"  style="height: 96px; margin-top: 10px;"/>
                   
                    </div>
                    <div class="caption" style=" height: 50px; overflow: hidden;">
                        <?php echo $rs->images_name ?>
                    </div>

                    <!--
                    <button type="button" class="btn btn-default btn-sm">view</button> | 
                    -->
                    <button type="button" class="btn btn-default btn-sm" onclick="Addcontent('<?php echo $row->ref ?>','<?php echo $rs->images ?>','<?php echo $rs->images_name ?>','1')"><i class="fa fa-check"></i> เลือก</button> | 
                    <button type="button" class="btn btn-default btn-sm" onclick="popupeditimage('<?php echo $rs->id ?>', '<?php echo $rs->images_name ?>')">แก้ไข</button>
                    <button type="button" class="btn btn-default btn-sm" onclick="deleteimages('<?php echo $rs->id ?>')">ลบ</button>

                </div>
            </div>
            <?php
        endforeach;
        ?>
</div>



<script type="text/javascript">
    function popupeditimage(id, name) {
        $("#_idimg").val(id);
        $("#_imagename").val(name);
        $("#popupeditimagename").modal();
    }

    function saveeditimage() {
        var url = "<?php echo site_url('toberegis/storeimages/editimagename') ?>";
        var id = $("#_idimg").val();
        var name = $("#_imagename").val();
        if (name == "") {
            $("#_imagename").focus();
            return false;
        }
        var data = {id: id, name: name};
        $.post(url, data, function (datas) {
            getfolder("<?php echo $folder_id ?>");
            $("#popupeditimagename").modal('toggle');
        });
    }

    function deleteimages(id) {
        var url = "<?php echo site_url('toberegis/storeimages/deleteimages') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            getfolder("<?php echo $folder_id ?>");
        });
    }

</script>
