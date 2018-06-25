
    <?php
    $this->load->library('takmoph_libraries');
    $lib = new takmoph_libraries();

    $list = array(
            //array('url' => 'newexpress', 'label' => 'ประกาศ'),
            //array('url' => '', 'label' => 'menu2')
    );

    $active = "ประกาศด่วน";
//$list = "";
    echo $lib->breadcrumb($list, $active);
    ?>
            <h3 id="head_submenu"><i class="fa fa-fire text-info"></i> ประกาศด่วน</h3>

    <hr id="hr"/>
    <table class="table table-striped" id="tb_news_express">
        <thead>
            <tr>
                <th style=" display: none;">#</th>
                <th style=" display: none;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($express->result() as $rs):
                $i++;
                ?>
                <tr>
                    <td style=" display: none;"><?php echo $i; ?></td>
                    <td>
                        <font style="color:red;">(<?php echo $rs->create_date ?>) </font>
                        <a href="<?php echo site_url('newexpress/view/' . $this->takmoph_libraries->encode($rs->id)) ?>" style=" text-decoration: none;"><?php echo $rs->title; ?></a> </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#tb_news_express").dataTable();
    });
</script>