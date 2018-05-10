<?php
	$this->breadcrumbs = array(
	    Yii::t('app', ucfirst('Price Book')) => array('pricebook'),
	    Yii::t('app', 'View'),
	);
?>
<div class="row">
    <div class="col-xs-12 widget-container-col ui-sortable">

        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'Price Book ' . ucfirst('Detail')),
            'headerIcon' => sysMenuItemIcon(),
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
            
            <!-- Flash message layouts.partial._flash_message -->
            <?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
			<?php if($data):?>
				
				<?php foreach($data as $key=>$header):?>
					<div class="row">
						<div class="col-sm-6">
							<h4>Price Book Name: <?=$header['price_book_name']?></h4>
						</div>
						<div class="col-sm-6">
							<h4>Valid From: <?=$header['valid_from']?></h4>
						</div>
						<div class="col-sm-6">
							<h4>Outlet Name: <?=$header['outlet_name']?></h4>
						</div>
						<div class="col-sm-6">
							<h4>Valid To: <?=$header['valid_to']?></h4>
						</div>
						
					</div>
					<hr>
					<div class="row">
						<table class="table">
							<thead>
								<?php foreach($header['item'] as $k=>$item):?>
								<tr>
									<?php foreach($item as $col=>$row):?>
										<th><?=strtoupper($col)?></th>
									<?php endforeach;?>
								</tr>
								<?php break;?>
								<?php endforeach;?>
							</thead>
							<tbody>
								<?php foreach($header['item'] as $k=>$item):?>
									<tr>
										<?php foreach($item as $col=>$row):?>
											<td><?=$row?></td>
										<?php endforeach;?>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				<?php endforeach;?>
			<?php endif;?>
        <?php $this->endWidget(); ?>

        

    </div>
</div>