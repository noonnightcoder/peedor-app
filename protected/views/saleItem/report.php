<?php
$this->breadcrumbs = array(
    Yii::t('app', 'View Sale Order') => array('saleItem/list'),
    Yii::t('app', 'List'),
);
?>


<?php /*$this->renderPartial('//layouts/report/' . $header_view, array(
    'report' => $report,
    'advance_search' => $advance_search,
    'header_tab' => $header_tab, // Using for tab style
)); */?>

<?php $this->renderPartial('partialList/_header') ?>

<br /> <br />

<!-- Flash message layouts.partial._flash_message -->
<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<div id="report_grid" class="tabbable">

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above',
        'id' => 'tabs',
        'tabs' => array(
            array('label' => '<i class="pink ace-icon fa fa-home bigger-120"></i>' . t('All ','app'),
                'id' => 'tab_1',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                        'report' => $report,
                        'data_provider' => $data_provider,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id,
                        'title' => $title),true),
                'active' => true,
            ),
            array('label' => '<i class="purple ace-icon fa fa-pencil bigger-120"></i>' . t('Waiting for Approval ','app') . '<span class="badge badge-danger">' . $sale_submit_n . '</span>',
                'id' => 'tab_2',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view ,array(
                        'report' => $report,
                        'data_provider' => $data_provider2,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id2,
                        'title' => $title),true,false),
                'visible' => ckacc('sale.review')
            ),
            array('label' => '<i class="green ace-icon fa fa-smile-o bigger-120"></i>' . t( 'Review & Complete ','app') . '<span class="badge badge-info">' . $sale_approve_n .'</span>',
                'id' => 'tab_3',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                        'report' => $report,
                        'data_provider' => $data_provider3,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id3,
                        'title' => $title),true),
                'visible' => ckacc('sale.approve')
            ),
            array('label' => '<i class="green ace-icon fa fa-truck bigger-120"></i>'  . t('Ready to Deliver ','app') . '<span class="badge badge-info">' . $sale_complete_n .'</span>',
                'id' => 'tab_4',
                'content' => $this->renderPartial('//layouts/report/' . $grid_view,array(
                        'report' => $report,
                        'data_provider' => $data_provider1,
                        'grid_columns' => $grid_columns,
                        'grid_id' => $grid_id1,
                        'title' => $title),true),
                'visible' => ckacc('report.stock')
            ),
        ),
        //'events' => array('shown'=>'js:test')
    ));
    ?>

</div>

<?php $this->renderPartial('partialList/_js',array()); ?>

<?php $this->widget( 'ext.modaldlg.EModalDlg' ); ?>
