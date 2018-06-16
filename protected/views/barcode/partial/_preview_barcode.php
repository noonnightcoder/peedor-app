<div class="container">
	<?php if(!empty($items)):?>
		<?php foreach($items as $item):?>
			<h6 style="border-bottom: solid 1px #000000; color: #000000;padding: 5px;"><?=$item['name']?></h6>
			<?php 
			for($i=0;$i<$item['number_of_barcode'];$i++):?>
			<?php
				/* if multiple barcodes make sure itemId is unique*/
				$optionsArray = array(
					'itemId'=> $item['item_number'].'_'.$i, /*id for div or canvas */
					'barocde'=> $item['item_number'], /* value for EAN 13 be careful to set right values for each barcode type */
					'type'=>'code128',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
					'settings'=>array(
					   'output'=>'css' /*css, bmp, canvas note- bmp and canvas incompatible wtih IE*/,
					   /*if the output setting canvas*/
					   'posX' => 0,
					   'posY' => 0,
					   /* */
					   'bgColor'=>'#ffffff', /*background color*/
					   'color' => '#333', /*"1" Bars color*/
					   'barWidth' => 1,
					   'barHeight' => 40,   
					   /*-----------below settings only for datamatrix--------------------*/
					   'moduleSize' => 1,
					   'addQuietZone' => 10, /*Quiet Zone Modules */
					 ),
					'rectangular'=> true /* true or false*/
				);
			?>
			<div style="border: solid 1px #333; width: auto !important; display: inline-block; text-align: center;margin-bottom: 3px;">
				<small><?=substr($item['name'],0,20)?>...</small><br>
				<small>Price: <?=$item['price']?></small><br>
					<?=Item::getItemBarcode($optionsArray)?>
			</div>
			<?php endfor;?>
		<?php endforeach;?>
	<?php endif?>
</div>