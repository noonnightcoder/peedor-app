<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('Price Book')) => array('/pricebook'),
	    Yii::t('app', 'List'),
	);
?>
<div class="row" id="<?= $main_div_id ?>">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'List of ' . ucfirst(get_class($model))),
            'headerIcon' => sysMenuItemIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
            
        	<!-- Admin Header layouts.admin._header -->
            <div class="page-header">
                <?php echo TbHtml::linkButton(Yii::t('app', 'Add New'), array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => 'ace-icon fa fa-plus white',
                    'url' => $this->createUrl('create'),
                )); ?>
            </div>
            <!-- Flash message layouts.partial._flash_message -->
            <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

            <!-- Grid Table Filterable layouts.admin._grid_filter -->
            <?php $this->renderPartial('//layouts/admin/_grid', array(
                'model' => $model,
                'data_provider' => $data_provider ,
                'grid_id' => $grid_id,
                'page_size' => $page_size,
                'grid_columns' => $grid_columns,
            )); ?>
        <?php $this->endWidget(); ?>

        <!-- Grid Table layouts.admin._footer -->
        <?php $this->renderPartial('//layouts/admin/_footer',array(
            'main_div_id' => $main_div_id,
            'grid_id' => $grid_id,
        ));?>

    </div>
</div>