<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=266256337158296";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function () {
        var width = $(window).width();
        if (width < 768) {
            $(".detail_news img").addClass("img-responsive");
            $(".detail_news img").css({"width": "auto", "height": "auto"});
        }
    });

</script>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
/*
  $list = array(
  //array('url' => 'backend/menubar', 'label' => 'MenuBar'),
  //array('url' => '', 'label' => 'menu2')
  );
 */
$active = $head;
$list = "";
?>
<?php echo $model->breadcrumb($list, $active); ?>

<h3 id="head_submenu"><i class="fa fa-building"></i> <?php echo $head ?></h3>

<hr id="hr"/>
<div class="detail_news">
    <?php echo $page->page ?>
</div>
