<style type="text/css">
    #btn-category{
        background: #f1f1f1;
        color: #686868;
        border:#f1f1f1  solid 1px;
    }

    #btn-category:hover{
        background: #f8f8f8;
        border: #dfdfdf solid 1px;
    }
</style>
<h3><i class="fa fa-comment"></i> กระดานสนทนา</h3>

<hr id="hr"/>
<h4>หมวด</h4>
<div class="row">
<?php foreach ($category->result() as $rs) { ?>
        <div class="col-md-4 col-lg-3" style=" margin-bottom: 10px;">
            <a href="<?php echo site_url('asbforum/post/category/' . $rs->id) ?>" style=" text-decoration: none;">
                <div class="btn btn-default btn-block" id="btn-category">
                    <p><?php echo $rs->title ?></p>
                    <span class="badge"><?php echo $this->forum->CountPost($rs->id) ?></span>
                </div></a>
        </div>
<?php } ?>
</div>

<hr/>
<h4><i class="fa fa-thumb-tack"></i> กระทู้ปักมุด</h4>
<table class="table table-bordered table-striped" style=" background: #FFFFFF;" id="tb-post">
    <thead>
        <tr>
            <th style=" display: none;"></th>
            <th>หมวด</th>
            <th>หัวข้อ</th>
            <th style=" text-align: center;">โดย</th>
            <th style=" text-align: center;">อ่าน</th>
            <th style=" text-align: center;">ตอบ</th>
            <th style=" text-align: center;">โพสต์เมื่อ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($lastpost->result() as $rs): $i++;
            ?>
            <tr>
                <td style=" display: none;"><?php echo $i ?></td>
                <td><i class="fa fa-thumb-tack"></i> <?php echo $rs->cat_name ?></td>
                <td><a href="<?php echo site_url('asbforum/post/view/' . $rs->id) ?>"><?php echo $rs->title ?></a></td>
                <td style=" text-align: center;"><?php echo $rs->alias ?></td>
                <td style="text-align: center;"><?php echo $rs->readpost ?></td>
                <td style=" text-align: center;">
    <?php echo $this->forum->countcomment($rs->id) ?>
                </td>
                <td style=" text-align: center;"><?php echo $rs->create_date ?></td>
            </tr>
<?php endforeach; ?>
    </tbody>
</table>

<h4><i class="fa fa-comment"></i> กระทู้ล่าสุด</h4>
<table class="table table-bordered table-striped" style=" background: #FFFFFF;" id="tb-post">
    <thead>
        <tr>
            <th style=" display: none;"></th>
            <th>หมวด</th>
            <th>หัวข้อ</th>
            <th style=" text-align: center;">โดย</th>
            <th style=" text-align: center;">อ่าน</th>
            <th style=" text-align: center;">ตอบ</th>
            <th style=" text-align: center;">โพสต์เมื่อ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($lastpost->result() as $rs): $i++;
            ?>
            <tr>
                <td style=" display: none;"><?php echo $i ?></td>
                <td><?php echo $rs->cat_name ?></td>
                <td><a href="<?php echo site_url('asbforum/post/view/' . $rs->id) ?>"><?php echo $rs->title ?></a></td>
                <td style=" text-align: center;"><?php echo $rs->alias ?></td>
                <td style="text-align: center;"><?php echo $rs->readpost ?></td>
                <td style=" text-align: center;">
    <?php echo $this->forum->countcomment($rs->id) ?>
                </td>
                <td style=" text-align: center;"><?php echo $rs->create_date ?></td>
            </tr>
<?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        //$("#tb-post").dataTable(); 
    });
</script>
