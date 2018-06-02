
<table class="table table-striped">
    <thead>
        <tr>
            <th>กระทู้</th>
            <th style=" text-align: center;">ตอบล่าสุด</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($postall->result() as $rs): $i++;
        $lastComment = $this->forum->LastComment($rs->id);
            ?>
            <tr>
                <td>
                    <a href="<?php echo site_url('asbforum/users/viewpost/' . $rs->id) ?>"><b><?php echo $rs->title ?></b></a>
                    <font style=" font-size: 12px; color: #999999;">
                    <br/>
                    หมวด <?php echo $rs->cat_name ?> | 
                    เมื่อ <?php echo $rs->create_date ?> | 
                    อ่าน <span class=" badge"><?php echo $rs->readpost ?></span>
                    ตอบ <span class=" badge"><?php echo $this->forum->CountComment($rs->id) ?></span>
                    </font>
                </td>
                <td style=" text-align: right;">
                    <?php if(isset($lastComment->create_date)){
                        echo "<i class='fa fa-calendar'></i> ".$lastComment->create_date;
                        echo "<br/><font style='font-size:12px;color: #999999;'><i class='fa fa-user'></i> ".$lastComment->alias."</font>";
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


