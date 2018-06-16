<div class="row">
    <div class="sidebar-nav" id="payment_cart">

    <?php
        if(!empty($items)){
            echo TbHtml::linkButton(Yii::t('app', 'Preview'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'icon' => 'fa fa-eye white',
                'url' =>Yii::app()->createUrl('Item/PreviewItemBarcode',array('preview'=>'1')),
                'class' => 'pull-right',
                'id' => 'finish_sale_button',
                //'title' => Yii::t('app', 'Complete Sale'),
            ));
        }
    ?>

    </div>
</div>
