<table class="table table-striped" id="tb_homepage">
    <thead>
        <tr>
            <th style="text-align:center; width:2%;">ลำดับ</th>
            <th style="text-align:center;">รหัส</th>
            <th>เรื่อง</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($homepage->result() as $rs):
            $users = $this->user->view($rs->owner);
            $i++;
            ?>
            <tr>
                <td style="text-align:center;"><?php echo $i; ?></td>
                <td style="text-align:center;"><?php echo $rs->id; ?></td>
                <td><?php echo $rs->title_name; ?><em style=" color: #999999;">(โดย : <?php echo $users->name . ' ' . $users->lname ?>)</em></td>
                <td style="width: 20%; text-align:right;">
                  <button type="button" class="btn btn-default btn-sm up"><i class="fa fa-chevron-up text-success"></i>ขึ้น</button>
                  <button type="button" class="btn btn-default btn-sm down"><i class="fa fa-chevron-down text-warning"></i>ลง</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="log"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".up,.down").click(function(){
            var row = $(this).parents("tr:first");
            if ($(this).is(".up")) {
                row.insertBefore(row.prev());
            } else {
                row.insertAfter(row.next());
            }
        });
    });

        function save_sort_order(){
        var table = document.getElementById('tb_homepage');

          var rowLength = table.rows.length;
          var a = 0;
          for(var i=1; i<rowLength; i+=1){
            var rows = table.rows[i];
            var level = i;
            var id = parseInt(rows.cells[1].innerText);
            //alert(level + "=>" + title);
            var url = "<?php echo site_url('backend/homepage/set_level')?>";
            var data = {
              id: id,level: level
            };

            $.post(url,data,function(success){
              a = (a+=1);
              //$("#log").append(success + "<br/>");
              if(a >= (rowLength-1)){
                window.location.reload();
              }
            });

            //your code goes here, looping over every row.
            //cells are accessed as easy
            /*
            var cellLength = row.cells.length;
            for(var y=0; y<cellLength; y+=1){
              var cell = row.cells[y];

              //do something with every cell here
            }
            */
        }
    }
</script>
