
    <?php
    $this->load->library('takmoph_libraries');
    $lib = new takmoph_libraries();

    $list = array(
        array('url' => 'newexpress', 'label' => 'ประกาศ'),
            //array('url' => '', 'label' => 'menu2')
    );
    $active = "ด่วน";
//$list = "";
    echo $lib->breadcrumb($list, $active);
    ?>
    
            <h3 id="head_submenu"><i class="fa fa-fire text-info"></i> ประกาศด่วน</h3>
       
    <hr id="hr"/>
    <h4>เรื่อง :: <?php echo $model->title; ?></h4><br/>
    <?php echo $model->detail ?>
    <hr/>
    <div class="pull-right" style=" margin-right: 15px;"><i class="fa fa-calendar"></i> <?php echo $model->create_date; ?></div>
    <br/><br/>