<style type="text/css">
	.row{
		margin-bottom: 10px;
	}
</style>
<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$list = array(
    //array('url' => 'toberegis/toberegis', 'label' => 'Dashboard')
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

<?php echo $this->session->userdata('user_register'); ?>