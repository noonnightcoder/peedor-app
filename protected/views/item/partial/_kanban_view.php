<div class="row">
	<?php foreach($data as $key=>$row):?>
		<div class="col-xs-6 col-sm-4 col-md-4">
			<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>">
				<div class="thumbnail search-thumbnail" style="height: 250px;">
					<span class="search-promotion label label-success arrowed-in arrowed-in-right"></span>

					<img class="media-object" src="<?=$baseUrl.'/images/'.($row['image'] ? $row['image'] : 'noimage.gif')?>" style="max-height: 150px !important;" />
					<div class="caption">
						<h5 class="search-title">
							<a href="<?=Yii::app()->createUrl('Item/ItemSearch?result='.$row['id'])?>" class="blue"><?=$row['name']?></a>
						</h5>
						<p><?=substr(strip_tags($row['description']),0,32) . "...";?></p>
					</div>
				</div>
			</a>
		</div>
	<?php endforeach?>
</div>