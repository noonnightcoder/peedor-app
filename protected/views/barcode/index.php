<?php if(isset($_GET['preview'])):?>
	<?php $this->renderPartial('//barcode/partial/_header_view_barcode')?>
<?php endif;?>
<div id="register_container">
	<?php $this->renderPartial('//barcode/'.$view,$data)?>
</div>