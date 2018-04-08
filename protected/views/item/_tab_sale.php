<?php 
    $_form=''; 
    if(isset($_GET['id']) && $_GET['id'] >0){
        $_form='_form_price_qty_update';
    }
    else
    {
        $_form='_form_price_qty';
    }
?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'id' => 'tabs-price',
    'type' => 'tabs',
    'tabs' => array(
        array('id' => 'price-tier', 'label' => 'Price Tier',
            'content' => $this->renderPartial('_form_price_tier', array(
                'model' => $model,
                'price_tiers' => $price_tiers,
                ), true),
            'active' => true),
        array('id' => 'price-qty', 'label' => 'Price Quantity',
                'content' => $this->renderPartial($_form, array(
                'model' => $model,
                'item_price_quantity' => $item_price_quantity,
                'form' => $form,
                'title' => 'Sale'), true)
        ),
    )
));