<div class="row">
	<?php foreach($data as $key=>$row):?>
	<div class="col-xs-12">
		<div class="media search-media">
			<div class="media-left">
				<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>">
					<img class="media-object" src="<?=$baseUrl.'/images/noimage.gif'?>" width="120px" />
				</a>
			</div>

			<div class="media-body">
				<div>
					<h5 class="media-heading">
						<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>" class="blue"><?=$row['name']?></a>
					</h5>
				</div>
				<p><?=substr($row['description'],0,80)?></p>
			</div>
		</div>
	</div>
	<?php endforeach?>
</div>