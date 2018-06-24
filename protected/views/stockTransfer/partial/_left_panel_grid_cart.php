<div class="grid-view" id="grid-cart">
    <?php 
    //echo json_encode(Yii::app()->session['pre']);
    // echo json_encode(Yii::app()->session['deleted_item']);
    ?>
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Item Name'); ?></th>
            <th><?php echo Yii::t('app', 'Quantity'); ?></th>
            <th><?php echo Yii::t('app', 'Action'); ?></th>
        </tr>
        </thead>
        <tbody id="cart_contents">
            <?php if(!empty($items)):?>
                    <tr>
                        <td></td>
                        <td>
                            
                            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                'method'=>'post',
                                'action' => Yii::app()->createUrl('stockTransfer/editItemToTransfer/',array('item_id'=>'all')),
                                'htmlOptions'=>array('class'=>'line_item_form'),
                            ));
                            ?>
                                <?php echo $form->textField($model, "quantity", array( 'class' => 'input-small input-grid', 'id' => "quantity_all_item", 'maxlength' => 10)); ?>
                            <?php $this->endWidget(); ?>

                        </td>
                        <td></td>
                    </tr>
                <?php foreach (array_reverse($items, true) as $id => $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['name']; ?><br/>
                        </td>
                        <td>
                             <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                'method'=>'post',
                                'action' => Yii::app()->createUrl('stockTransfer/editItemToTransfer/',array('item_id'=>$item['item_id'])),
                                'htmlOptions'=>array('class'=>'line_item_form'),
                            ));
                            ?>
                                <?php echo $form->textField($model, "quantity", array('value' => $item['quantity'], 'class' => 'input-small input-grid', 'id' => "quantity_".$item['item_id'], 'placeholder' => 'Quantity','maxlength' => 10)); ?>
                            <?php $this->endWidget(); ?>
                        </td>
                        <td><?php
                            echo TbHtml::linkButton('', array(
                                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                'size' => TbHtml::BUTTON_SIZE_MINI,
                                'icon' => 'glyphicon glyphicon-trash ',
                                'url' => array('DeleteItemToTransfer', 'item_id' => $item['item_id'],'quantity'=>$item['quantity']),
                                'class' => 'delete-item',
                                'title' => Yii::t('app', 'Remove'),
                            ));
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>

    <?php
        // if (empty($items)) {
        //     echo Yii::t('app', 'There are no items in the cart');
        // }
    ?>
</div> <!-- #section:grid.cart.layout -->