<div class="row">
    <div class="sidebar-nav" id="payment_cart">

    <?php
        if(!empty($items)){
            echo TbHtml::linkButton(Yii::t('app', 'Save'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'icon' => 'glyphicon glyphicon-off white',
                'url' =>Yii::app()->createUrl('stockTransfer/saveItemToTransfer'),
                'class' => 'pull-right',
                'id' => 'finish_sale_button',
                //'title' => Yii::t('app', 'Complete Sale'),
            ));
        }
    ?>

    </div>
</div>