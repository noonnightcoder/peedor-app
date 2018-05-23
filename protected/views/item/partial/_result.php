<?php $baseUrl = Yii::app()->theme->baseUrl?>
<?php if($data):?>
	<?php if($view=='k'):?>
		<?php $this->renderPartial('partial/_kanban_view',array('data'=>$data,'baseUrl'=>$baseUrl));?>
		<?php elseif($view=='g'):?>
		<?php $this->renderPartial('partial/_grid_view',array('data'=>$data,'baseUrl'=>$baseUrl));?>
	<?php endif;?>
<?php else:?>
	<h5>No Result</h5>
<?php endif;?>
