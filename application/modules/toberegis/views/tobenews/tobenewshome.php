<div style="font-size:24px; font-weight: bold;">
                                        <i class="fa fa-trophy"></i> 10 ลำดับล่าสุด
                                    </div>
                                    <div class="list-group" style="margin:0px; padding: 0px;">
                                    <?php 
                                        foreach($news->result() as $newstobe):
                                    ?>
                                        <a href="" class="list-group-item" style=" padding: 0px; margin:0px;">
                                            <i class="fa fa-calendar"></i> <?php echo $newstobe->date ?>
                                            <b><?php echo $newstobe->title ?></b>
                                        </a>
                                    <?php endforeach; ?>
                                    </div>
                                    <button type="button" class="btn btn-warning btn-xs hvr-curl-top-right pull-right">ทั้งหมด ...</button>
                                </div>