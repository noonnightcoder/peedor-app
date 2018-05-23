<div class="row">
	<?php foreach($data as $key=>$row):?>
		<div class="col-xs-6 col-sm-4 col-md-3">
			<a href="#">
			<div class="thumbnail search-thumbnail" style="height: 190px;">
				<span class="search-promotion label label-success arrowed-in arrowed-in-right"></span>

				<img class="media-object" src="<?=$baseUrl.'/images/noimage.gif'?>" />
				<div class="caption">
					<h5 class="search-title">
						<a href="#" class="blue"><?=$row['name']?></a>
					</h5>
					<p><?=$row['description']?></p>
				</div>
			</div>
		</a>
		</div>
	<?php endforeach?>
</div>