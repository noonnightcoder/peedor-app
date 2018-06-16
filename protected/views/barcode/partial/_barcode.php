<?php 
	/* if multiple barcodes make sure itemId is unique*/
	$optionsArray = array(
		'itemId'=> 'id_'.$item_number, /*id for div or canvas */
		'barocde'=> $item_number, /* value for EAN 13 be careful to set right values for each barcode type */
		'type'=>'code128',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
		'settings'=>array(
		   'output'=>'bmp' /*css, bmp, canvas note- bmp and canvas incompatible wtih IE*/,
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
<?=Item::getItemBarcode($optionsArray)?>

