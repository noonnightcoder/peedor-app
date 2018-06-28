<div class="row">
    <div class="sidebar-nav" id="payment_cart">

    <?php

        if(!empty($items)){

            $trans_type = Yii::app()->receivingCart->getTransferHeader('trans_type');
            $to_outlet = Yii::app()->receivingCart->getTransferHeader('to_outlet');
            $from_outlet = Yii::app()->receivingCart->getTransferHeader('from_outlet');
            $receive_id = isset($_GET['receive_id']) ? $_GET['receive_id'] : Yii::app()->receivingCart->getTransferHeader('receive_id');
            $url = $trans_type == param('sale_complete_status') ? Yii::app()->createUrl('receiving/transferUpdateStatus',array(
                'receive_id' => $receive_id, 
                'outlet_id' => $to_outlet,
                'tran_type' =>param('sale_complete_status'),
                'ajax' => 0
            )) : ($receive_id>0 && $trans_type==2 ? Yii::app()->createUrl('receiving/UpdateItemToTransfer',array(
                'receive_id' => $receive_id,
                'outlet_id' => $from_outlet,
                'trans_type' => $trans_type
            )) : Yii::app()->createUrl('receiving/saveItemToTransfer'));
            echo TbHtml::linkButton(Yii::t('app', $trans_type == param('sale_complete_status') ? 'Confirm' : 'Save'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'icon' => 'glyphicon glyphicon-off white',
                'url' => $url,
                'class' => 'pull-right',
                'id' => 'finish_sale_button',
                //'title' => Yii::t('app', 'Complete Sale'),
            ));
        }
    ?>

    </div>
</div>