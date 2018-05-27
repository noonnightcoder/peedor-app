<div class="row">
    <div class="col-sm-12">
        <div class="widget-box widget-color-blue" id="widget-box-2">

            <?php $this->renderPartial('//role/_permission_header', array(
                'header_title' => $header_title,
                'header_icon' => $header_icon,
            )) ?>

            <?php
/*                $grid_items = array (
                      array('grid_title' => 'Item',  'permission' => 'item', 'control_name' => 'items'),
                      array('grid_title' => 'Price Book', 'permission' => 'pricebook', 'control_name' => 'pricebooks'),
                      array('grid_title' => 'Category', 'permission' => 'category', 'control_name' => 'categories'),
                );
            */?>

            <?php $this->renderPartial('//role/_permission_content', array(
                'user' => $user,
                'grid_items' => $grid_items,
            )) ?>

        </div>
    </div>
</div>



<style>
    .role-table td.permission{
        min-width: 70px;
        text-align: center;
    }
</style>