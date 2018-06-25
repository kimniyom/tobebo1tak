<style>
    * {
        margin: 0;
        padding: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        /*background: #2d2c41;*/
        font-family: 'Open Sans', Arial, Helvetica, Sans-serif, Verdana, Tahoma;
    }

    ul { list-style-type: none; }

    a {
        color: #b63b4d;
        text-decoration: none;
    }

    /** =======================
     * Contenedor Principal
     ===========================*/


    h1 {
        color: #FFF;
        font-size: 24px;
        font-weight: 400;
        text-align: center;
        margin-top: 80px;
    }

    h1 a {
        color: #c12c42;
        font-size: 16px;
    }

    .accordion {
        width: 100%;
        /*max-width: 360px;*/
        margin: 30px auto 20px;
        background: #FFF;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .accordion .link {
        cursor: pointer;
        display: block;
        padding: 15px 15px 15px 42px;
        color: #4D4D4D;
        font-size: 14px;
        font-weight: 700;
        border-bottom: 1px solid #CCC;
        position: relative;
        -webkit-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .accordion li:last-child .link { border-bottom: 0; }

    .accordion li i {
        position: absolute;
        top: 16px;
        left: 12px;
        font-size: 18px;
        color: #595959;
        -webkit-transition: all 0.4s ease;
        -o-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .accordion li i.fa-chevron-down {
        right: 12px;
        left: auto;
        font-size: 16px;
    }

    .accordion li.open .link { color: #b63b4d; }

    .accordion li.open i { color: #b63b4d; }

    .accordion li.open i.fa-chevron-down {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    /**
     * Submenu
     -----------------------------*/


    .submenu {
        display: none;
        background: #444359;
        font-size: 14px;
    }

    .submenu li { border-bottom: 1px solid #4b4a5e; }

    .submenu a {
        display: block;
        text-decoration: none;
        color: #d9d9d9;
        padding: 12px;
        padding-left: 42px;
        -webkit-transition: all 0.25s ease;
        -o-transition: all 0.25s ease;
        transition: all 0.25s ease;
    }

    .submenu a:hover {
        background: #b63b4d;
        color: #FFF;
    }
</style>

<?php
$this->load->library('takmoph_libraries');
?>

<?php
$model = new takmoph_libraries();
/*
  $list = array(
  array('url' => '', 'label' => 'menu1'),
  array('url' => '', 'label' => 'menu2')
  );
 * 
 */
$active = $head;
$list = "";
echo $model->breadcrumb($list, $active);
?>


        <h3 id="head_submenu">
            <i class="fa fa-newspaper-o"></i> <?php echo $head ?>
        </h3>
    
<hr id="hr"/>

<!-- Contenedor -->
<ul id="accordion" class="accordion">
    <?php foreach ($catergory->result() as $rs): ?>
        <li>
            <div class="link"><i class="fa fa-file-text-o"></i><?= $rs->mas_from ?><i class="fa fa-chevron-down"></i></div>
            <ul class="submenu">
                <?php if ($rs->from_status == '0') { ?>
                    <li>
                        <a href="<?= base_url() ?>file_download/<?= $rs->file ?>" target="_blank"><i class="icon-share-alt"></i>
                            <?= $rs->mas_from ?></a>
                    </li>
                <?php } ?>
                <?php
                $sub_from = $this->tak->get_sub_from($rs->id);
                foreach ($sub_from->result() as $data):
                    ?>
                    <li><a href="<?= base_url() ?>file_download/<?= $data->file ?>" target="_blank"><i class="icon-share-alt"></i>
                            <?= $data->sub_name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(function () {
        var Accordion = function (el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            // Variables privadas
            var links = this.el.find('.link');
            // Evento
            links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown);
        }

        Accordion.prototype.dropdown = function (e) {
            var $el = e.data.el;
            $this = $(this),
                    $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
            }
        }

        var accordion = new Accordion($('#accordion'), false);
    });
</script>
