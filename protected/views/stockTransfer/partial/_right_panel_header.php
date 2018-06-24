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
                    'paper_type' => array('0'=>'Basic Paper'),'model' => $model,'items'=>$items
                ), true),
            ));
        ?>
    
    </div>
</div>