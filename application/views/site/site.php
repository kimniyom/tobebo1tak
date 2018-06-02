<?php
$this->load->library('takmoph_libraries');
$model = new takmoph_libraries();
$barmodel = new menubar_model();
$navbar = $barmodel->get_navbarmenu_all();
$style = $barmodel->get_style();
$homepage = new homepage_model();
$sub_homepage = new sub_homepage_model();
$mas_homepage = $homepage->get_menu();
$list = array(
        //array('url' => 'takmoph_admin', 'label' => 'เมนูหลัก'),
        //array('url' => '', 'label' => 'menu2')
);

$active = $head;
?>

<?php echo $model->breadcrumb($list, $active); ?>

     <h3 id="head_submenu"><i class="fa fa-sitemap"></i> <?php echo $head ?></h3>

    <hr id="hr"/>
    <h4>เมนูเว็บไซต์</h4>
    <ul>
        <li>
            <a href="<?php echo site_url() ?>" style="color:<?php echo $style->color_head ?>;"><i class="fa fa-home"></i> หน้าแรก</a>
        </li>
        <?php
        foreach ($navbar->result() as $nb):
            ?>
            <?php if ($nb->type == '0') { ?>
                <li>
                    <a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($nb->id)) ?>" 
                       style="color:<?php echo $style->color_head ?>;">
                        <b><?php echo $nb->title ?></b></a>
                </li>
            <?php } else { ?>
                <li>
                    <b><font style="color:<?php echo $style->color_head ?>;"><?php echo $nb->title ?></font></b>
                </li>
                <!--########## Subnavbar ###########-->
                <ul>
                    <?php
                    $subnav = $barmodel->get_sub_navbarmenu($nb->id);
                    foreach ($subnav->result() as $snSub):
                        ?>
                        <li><a href="<?php echo site_url('site/page/' . $this->takmoph_libraries->encode($snSub->id)) ?>"
                               style="color:<?php echo $style->color_head ?>;">
                                - <?php echo $snSub->title ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul> 
            <?php } ?>
        <?php endforeach; ?>
        <!-- EndMenuNavbar -->
    </ul>

    <h4>เมนูหลัก</h4>

    <ul>
        <?php
        $menu = $this->tak->get_mas_menu();
        foreach ($menu->result() as $rs):
            $menu_model = new menu_model();
            //$color = $menu_model->get_color($rs->menu_color);
            ?>

            <?php
            if ($rs->mas_status == '0') {
                ?>
                <li>
                    <a href="<?= site_url($rs->link . '/' . $this->takmoph_libraries->encode($rs->admin_menu_id) . '/' . $rs->mas_menu) ?>" style="text-decoration: none;color:<?php echo $style->color_head ?>;">
                        <?= $rs->mas_menu ?>     </a>
                </li>
                <!-- ลิงค์ ข้างนอก -->
            <?php } else if ($rs->mas_status == '2') {
                ?>
                <li>
                    <a href="<?php echo $rs->link_out; ?>" target="_blank" style=" text-decoration: none;color:<?php echo $style->color_head ?>;">
                        <?= $rs->mas_menu ?>
                    </a>
                </li>
                <!-- Droupdown -->
                <?php
            } else {
                ?>
                <li>
                    <a href="<?php echo site_url('menu/submenu/' . $this->takmoph_libraries->encode($rs->id)); ?>" 		style=" text-decoration: none;color:<?php echo $style->color_head ?>;">
                        <?= $rs->mas_menu ?>
                    </a>
                </li>
            <?php } ?>
        <?php endforeach; ?>

        <!-- 
        #######################################
        ## Menu Down Load
        ########################################
        -->
        <li>
            <a href="<?php echo site_url('formdownload'); ?>" style="text-decoration:none;color:<?php echo $style->color_head ?>;">
                แบบฟอร์มต่าง ๆ 
            </a>
        </li>
    </ul>

    <h4>ข้อมูลหน้าเว็บ</h4>
    <ul>
        <?php foreach ($mas_homepage->result() as $rs): ?>
            <li><?php echo $rs->title_name ?></li>
            <ul>
                <?php
                $subhomepage = $sub_homepage->get_subhomepage($rs->id, $rs->limit);
                $i = 0;
                foreach ($subhomepage->result() as $sm):
                    $i++;

                    if ($sm->final == 0) {
                        $linkMenu = site_url('homepage/viewupper/' . $this->takmoph_libraries->encode($sm->id) . '/' . $sm->id);
                        $count = '<span class="badge">' . $sub_homepage->CountHomePage($sm->id) . '</span>';
                    } else {
                        $linkMenu = site_url('homepage/view/' . $this->takmoph_libraries->encode($sm->id));
                        $count = "";
                    }
                    ?>

                    <li><a href="<?php echo $linkMenu ?>"><?php echo $sm->title ?> </a></li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </ul>

