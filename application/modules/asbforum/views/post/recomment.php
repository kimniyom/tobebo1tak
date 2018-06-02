<script type="text/javascript">

    function SetImgResponsiverecomment(BoxID) {
        var BoxComment = BoxID;
        var tn_array = $(BoxComment + ' img').map(function () {
            return $(this).attr("id");
        });

        for (var i = 0; i < tn_array.length; i++) {
            var tagimg = tn_array[i];
            var widthimg = $(BoxComment).width();
            var img = $(BoxComment + " #" + tagimg).width();
            if (img >= widthimg) {
                $(BoxComment + " #" + tagimg).addClass("img-responsive");
                $(BoxComment + " #" + tagimg).css({"width": "auto", "height": "auto"});
            }
        }

    }
</script>

<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
?>
<?php
$i = 0;
foreach ($recomment->result() as $comments): $i++;
    echo "<script type='text/javascript'>SetImgResponsiverecomment('.ans-recomment" . $i . "')</script>";
    ?>
    <div id="recomment-<?php echo $comments->id ?>" style=" border: #cccccc solid 1px; padding: 10px; margin-bottom: 5px;">
        <div class="row">
            <div class="col-md-2 col-lg-2" style=" font-size: 12px;">
                <div style=" text-align: center;">
                    <img src="<?php echo base_url() ?>assets/module/asbforum/uploads/<?php echo $comments->photo ?>" class="img img-responsive" style=" width: 100px;"/>
                    ความคิดเห็นที่ <?php echo $i ?>
                </div>

            </div>
            <div class="col-md-10 col-lg-10">
                <div class="well well-sm" style=" background: #ffffff;">
                    <div class="ans-recomment<?php echo $i ?>">
                        <?php echo $comments->comment; ?>
                    </div>
                    <hr/>
                    #<?php echo $comments->id; ?> | โดย  : <?php echo $comments->alias ?> | 
                    วันที่ : <?php echo $model->thaidate($comments->create_date) ?> | 
                    IP : <?php echo $comments->ip ?>
                    <button type="button" class="btn btn-default btn-xs" onclick="activerecomment()"><i class="fa fa-reply"></i> ตอบกลับ</button>
                    <?php if ($this->session->userdata('forum_user_id') == $comments->user_id) { ?>
                        <a href="javascript:deleterecomment('<?php echo $comments->id ?>')" class="pull-right"><i class="fa fa-trash-o"></i></a> 
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
<div id="set<?php echo $detailrecomment ?>"></div>
<script type="text/javascript">
    function activerecomment() {
        var id = "set" + "<?php echo $detailrecomment ?>";
        var etop = $('#' + id).offset().top;
        $('html, body').animate({
            scrollTop: etop
        }, 1000);
    }
</script>



