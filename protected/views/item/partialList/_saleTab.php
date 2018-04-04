 <?php $this->widget('bootstrap.widgets.TbTabs', array(
     'id' => 'tabs-price',
     'type' => 'tabs',
    'tabs' => array(
        array('id'=>'price-tier','label' => 'Price Tier',
            'content' => 'Price Tier',
            'active' => true),
        array('id'=>'price-qty','label' => 'Price Quantity',
            'content' => $this->renderPartial('_form_pricing' ,array(
                'model' => $model,
                'price_tiers' => $price_tiers,
                'price_quantity_range' => $price_quantity_range,
                'form' => $form,
                'title' => 'Basic'),true)
        ),
    )
)); ?>