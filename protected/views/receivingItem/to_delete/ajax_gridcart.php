<div class="grid-view" id="grid_cart">  
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'receiving-item-form',
            'enableAjaxValidation'=>false,
            'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>
    <?php
    if (isset($warning))
    {
        echo "<div class='alert alert-warning'><strong>".$warning."</strong><a class='close' data-dismiss='alert'>×</a></div>";
    }
    ?>
    <table class="table table-striped table-hover">
        <thead>
            <tr><th><?php echo Yii::t('model','model.receivingitem.name'); ?></th>
                <th><?php echo Yii::t('model','model.item.cost_price'); ?></th>
                <th><?php echo Yii::t('model','model.item.unit_price'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.quantity'); ?></th>
                <th class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>"><?php echo Yii::t('model','model.receivingitem.discount_amount'); ?></th>
                <th><?php echo Yii::t('model','model.receivingitem.expire_date'); ?></th> 
                <th class='<?php echo $expiredate_class; ?>'><?php echo Yii::t('model','model.receivingitem.total'); ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="cart_contents">
            <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                <?php
                    if (substr($item['discount'],0,1)=='$')
                    {
                        $total_item=($item['cost_price']*$item['quantity']-substr($item['discount'],1));
                    }    
                    else  
                    {  
                        $total_item=($item['cost_price']*$item['quantity']-$item['cost_price']*$item['quantity']*$item['discount']/100);
                    } 
                    $item_id=$item['item_id'];
                    $cur_item_info= Item::model()->findbyPk($item_id);
                    $qty_in_stock=$cur_item_info->quantity;
                    /*
                    $n_expire=0;
                    if (Yii::app()->receivingCart->getMode()<>'receive') {
                        $n_expire=ItemExpire::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item['item_id']));
                    }
                     * 
                    */
                ?>
                    <tr>
                        <td> 
                            <?php echo $item['name']; ?><br/>
                            <span class="text-info"><?php echo $qty_in_stock . ' ' . Yii::t('app','in stock') ?> </span>
                        </td>
                        <td><?php echo $form->textField($model,"[$item_id]cost_price",array('value'=>$item['cost_price'],'class'=>'input-small numeric cost-price','id'=>"cost_price_$item_id",'placeholder'=>'Cost Price','data-id'=>"$item_id",'maxlength'=>10,'onkeypress'=>'return isNumberKey(event)')); ?></td>
                        <td><?php echo $form->textField($model,"[$item_id]unit_price",array('value'=>$item['unit_price'],'class'=>'input-small numeric unit-price','id'=>"unit_price_$item_id",'placeholder'=>'Unit Price','data-id'=>"$item_id",'maxlength'=>50,'onkeydown'=>'return isNumberKey(event)')); ?></td>
                        <td><?php echo $form->textField($model,"[$item_id]quantity",array('value'=>$item['quantity'],'class'=>'input-small numeric quantity','id'=>"quantity_$item_id",'placeholder'=>'Quantity','data-id'=>"$item_id",'maxlength'=>50,'onkeydown'=>'return isNumberKey(event)')); ?>
                        </td>
                        <td class="<?php echo Yii::app()->settings->get('sale', 'discount'); ?>"><?php echo $form->textField($model,"[$item_id]discount",array('value'=>$item['discount'],'class'=>'input-small','id'=>"discount_$item_id",'placeholder'=>'Discount','data-id'=>"$item_id",'maxlength'=>50)); ?></td>
                         <td class='<?php echo $expiredate_class; ?>'>
                            <?php $this->widget('yiiwheels.widgets.maskinput.WhMaskInput',array('name' => 'expire_date','mask' => '11/11/1111','value'=>$item['expire_date'],'htmlOptions' => array('placeholder' => '31/01/2020','id'=>"expiredate_$item_id",'data-id'=>"$item_id",'class' => 'expiredate form-control'))); ?>
                        </td>   
                        <!--
                        <td><?php //$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('name' => 'datepickertest','value'=>$item['expire_date'],'pluginOptions' => array('format' => 'yyyy-mm-dd'),'htmlOptions'=>array('value'=>$item['expire_date'],'id'=>"expiredate_$item_id",'data-id'=>"$item_id",'class'=>'input-small'))); ?>
                            <?php /*
                            if ( $n_expire>0 ) { 
                               echo TbHtml::dropDownList('expire_date','',ItemExpire::model()->getItemExpDate($item['item_id']),array('id'=>"expiredate_$item_id",
                                                'options'=>array($item['expire_date']=>array('selected'=>true)),
                                                'class'=>"expiredate input-sm",'data-id'=>"$item_id"));  
                            } else { 
                                $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array('name' => 'datepickertest','value'=>$item['expire_date'],'pluginOptions' => array('format' => 'yyyy-mm-dd'),'htmlOptions'=>array('value'=>$item['expire_date'],'id'=>"expiredate_$item_id",'data-id'=>"$item_id",'class'=>'input-small'))); 
                            }
                             * 
                             */
                            ?>
                        </td>
                        -->
                        <td><?php echo $total_item; ?>
                        <td><?php echo TbHtml::linkButton('',array(
                                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                'size'=>TbHtml::BUTTON_SIZE_MINI,
                                'icon'=>'glyphicon-trash',
                                'url'=>array('DeleteItem','item_id'=>$item_id),
                                'class'=>'delete-item',
                                'title' => Yii::t( 'app', 'Remove' ),
                            )); ?>
                        </td>
                    </tr> 
            <?php endforeach; ?> <!--/endforeach-->

        </tbody>
    </table>
    <?php $this->endWidget(); ?>  <!--/endformWidget-->     

    <?php
    if (empty($items))
        echo Yii::t('app','There are no items in the cart');

    ?> 

</div> <!--/endgridcartdiv-->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              