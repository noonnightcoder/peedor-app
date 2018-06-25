<div class="row">
    
</div>
<div class="row">
    <div class="sidebar-nav" id="client_cart">
     
        <?php
            $this->widget('yiiwheels.widgets.box.WhBox', array(
                'title' => Yii::t('app', 'Information'),
                'headerIcon' => 'ace-icon fa fa-info-circle ',
                'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                'content' => $this->renderPartial('partial/_form', array(
                    'model' => $model,
                    'items'=>$items,
                    'from_outlet' => $from_outlet,
                    'to_outlet' => $to_outlet
                ), true),
            ));
        ?>
    
    </div>
</div>