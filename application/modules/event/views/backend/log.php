<table style=" width: 100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Log</th>
            <th>user</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach($result->result() as $rs){ $i++;?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $rs->log ?></td>
            <td><?php echo $rs->author ?></td>
            <td><?php echo $rs->d_update ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>