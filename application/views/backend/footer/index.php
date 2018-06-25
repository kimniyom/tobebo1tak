
<?php $path = base_url() . "assets/CK-Editor/"; ?>
<script src="<?= base_url() ?>assets/CK-Editor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Modify By Kimniyom

        CKEDITOR.replace('footer', {
            //baseUrl: 'http://localhost/takmoph2015upgrad/EDITOR_FILE/',
            //baseDir = 'd:\inetpub\wwwroot\www.yourdomain.com\website\assets\images\',
            language: 'th',
            height: 300,
            uiColor: '#FFFFFF',
            removePlugins: 'bidi,forms,flash,iframe,div,find',//tabletools
            removeButtons: 'Anchor,Underline,Strike,Subscript,Superscript,Editing,Templates,Preview,NewPage,Source,Save,Scayt,About',
            filebrowserBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '<?php echo $path; ?>ckfinder/ckfinder.html?Type=Images',
            //filebrowserFlashBrowseUrl: '<?//php echo $path; ?>ckfinder/ckfinder.html?Type=Flash',
            filebrowserUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '<?php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                    //filebrowserFlashUploadUrl: '<?//php echo $path; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });
    function update() {
        var url = "<?php echo site_url('backend/footer/update') ?>";
        var footer = CKEDITOR.instances.footer.getData();
        if (footer == '') {
            alert("กรอกข้อมูลไม่ครบ ...");
            return false;
        }
        var data = {
            footer: footer
        };
        $.post(url, data, function (success) {
            window.location.reload();;
        });
    }
</script>


<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$navbarModel = new menubar_model();
$list = array(
    array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>

<div class="row" style=" margin: 0px; padding: 0px;">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;">
        <h3 id="head_submenu"><i class="fa fa-magic"></i> <?php echo $head ?></h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-right: 0px;">
        <?php echo $model->breadcrumb_backend($list, $active); ?>
    </div>
</div>

<hr id="hr"/>
<label>รายละเอียด</label>
<textarea id="footer" class="form-control"><?php echo $style->footer ?></textarea>
<hr/>

<button type="button" class="btn btn-default" onclick="update()">
    <i class="fa fa-save"></i> บันทึกการเปลี่ยนแปลง
</button>
<br/>
<br/>

<!--########################### Footer ########################-->
<nav class="navbar navbar-default" role="navigation" style=" margin: 0px; background: <?php echo $style->color_navbar; ?>" id="footer">
    <div style="color:<?php echo $style->color_text ?>; padding:10px;">
        <?php echo $style->footer ?>
        <hr style="border-top:solid 1px <?php echo $style->color_head ?>;"/>
        <div style="font-size:10px; color:#999999; text-align:center;">
          &copy; Create By The Assembler Themes | Kimniyom | Mini CMS
          <a href="http://www.theassembler.net" target="_blank">www.theassembler.net</a><br/>
        </div>
    </div>
</nav>
<!--########################### EndFooter #####################-->
