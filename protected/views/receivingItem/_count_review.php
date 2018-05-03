<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('inventory count')) => array('InventoryCountCreate'),
	    Yii::t('app', 'Review'),
	);
?>
<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Count Inventory'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array('label' => Yii::t('app','Save'),'url' => Yii::app()->createUrl('receivingItem/SaveCount'),'icon'=>'fa fa-floppy-o white'),
            ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        ),
    ),
)); ?>
	<table class="table">
		<thead>
			<tr>
				<th>Item Name</th>
				<th>Expected</th>
				<th>Counted</th>
				<th title="Unit=Expected-Counted">Unit</th>
				<th>Cost</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$totalExpected=0;
				$totalCounted=0;
				$totalUnit=0;
				$totalCost=0;
				foreach($items as $key=>$value):?>
				<tr>
					<td>
						<?=$value['proName']?>
					</td>
					<td>
						<?=$value['expected']?>
					</td>
					<td>
						<?=$value['countNum']?>
					</td>
					<td>
						<?php
							$unit=0;
							if($value['expected']<0){
								$unit=-1*($value['expected'])-$value['countNum'];
								$unit=-1*$unit;
							}else{
								$unit=$value['expected']-$value['countNum'];
							}
							echo $unit;
						?>
					</td>
					<td>
						<?=$unit*$value['cost']?>
					</td>
				</tr>
				<?php
					$totalExpected+=$value['expected'];
					$totalCounted+=$value['countNum'];
					$totalUnit+=$unit;
					$totalCost+=($unit*$value['cost']);
				?>
			<?php endforeach;?>
		</tbody>
		<tfoot>
			<tr>
				<td>Total:</td>
				<td><?=$totalExpected?></td>
				<td><?=$totalCounted?></td>
				<td><?=$totalUnit?></td>
				<td><?=$totalCost?></td>
			</tr>
		</tfoot>
	</table>
	
<?php $this->endWidget(); ?>
