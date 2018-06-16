<div class="grid-view" id="grid-cart">
    <?php 
    //echo json_encode(Yii::app()->session['pre']);
    // echo json_encode(Yii::app()->session['deleted_item']);
    ?>
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th><?php echo Yii::t('app', 'Item Name'); ?></th>
            <th><?php echo Yii::t('app', 'Barcode'); ?></th>
            <th><?php echo Yii::t('app', 'Number Of Barcode'); ?></th>
            <th><?php echo Yii::t('app', 'Action'); ?></th>
        </tr>
        </thead>
        <tbody id="cart_contents">
            <?php if(!empty($items)):?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            
                            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                'method'=>'post',
                                'action' => Yii::app()->createUrl('item/editItemBarcode/',array('item_id'=>'all')),
                                'htmlOptions'=>array('class'=>'line_item_form'),
                            ));
                            ?>
                                <?php echo $form->textField($model, "number_of_barcode", array( 'class' => 'input-small input-grid', 'id' => "number_of_barcode_all", 'maxlength' => 10)); ?>
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
                            <?php $this->renderPartial('//barcode/partial/_barcode',array('item_number'=>$item['item_number'])); ?><br/>
                        </td>
                        <td>
                             <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                'method'=>'post',
                                'action' => Yii::app()->createUrl('item/editItemBarcode/',array('item_id'=>$item['item_id'])),
                                'htmlOptions'=>array('class'=>'line_item_form'),
                            ));
                            ?>
                                <?php echo $form->textField($model, "number_of_barcode", array('value' => $item['number_of_barcode'], 'class' => 'input-small input-grid', 'id' => "number_of_barcode_".$item['item_id'], 'placeholder' => 'Number Of Barcode','maxlength' => 10)); ?>
                            <?php $this->endWidget(); ?>
                        </td>
                        <td><?php
                            echo TbHtml::linkButton('', array(
                                'color'=>TbHtml::BUTTON_COLOR_DANGER,
                                'size' => TbHtml::BUTTON_SIZE_MINI,
                                'icon' => 'glyphicon glyphicon-trash ',
                                'url' => array('DeleteItemBarcode', 'item_id' => $item['item_id'],'number_of_barcode'=>$item['number_of_barcode']),
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