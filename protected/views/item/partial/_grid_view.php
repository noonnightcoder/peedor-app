<div class="row">
	<?php foreach($data as $key=>$row):?>
	<div class="col-xs-12">
		<div class="media search-media">
			<div class="media-left">
				<a href="#">
					<img class="media-object" src="<?=$baseUrl.'/images/noimage.gif'?>" width="120px" />
				</a>
			</div>

			<div class="media-body">
				<div>
					<h5 class="media-heading">
						<a href="#" class="blue"><?=$row['name']?></a>
					</h5>
				</div>
				<p><?=$row['description']?></p>
			</div>
		</div>
	</div>
	<?php endforeach?>
</div>