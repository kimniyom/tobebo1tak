<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        <div class="well">
            <form action="<?php echo site_url('takmoph_admin/save_admin_menu');?>" method="post">
            <label>เมนู</label>
            <input type="text" name="admin_menu_name" style="width:90%;"/>
            <label>ลิงค์</label>
            <input type="text" name="admin_menu_link" style="width:90%;"/>
            <br/><br/>
            <input type="submit" value="บันทึก"/>
            </form>
        </div>
    </body>
</html>