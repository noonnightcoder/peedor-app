<div class="col-sm-6">
	<div class="widget-box widget-color-green2">
		<div class="widget-header">
			<h4 class="widget-title lighter smaller">
				Browse Files
				<span class="smaller-80">(with selectable folders)</span>
			</h4>
		</div>

		<div class="widget-body">
			<div class="widget-main padding-8">
				<ul id="tree2"></ul>
			</div>
		</div>
	</div>
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
	
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($){
		var sampleData = initiateDemoData();//see below
		
		$('#tree2').ace_tree({
			dataSource: sampleData['dataSource2'] ,
			loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
			'open-icon' : 'ace-icon fa fa-folder-open',
			'close-icon' : 'ace-icon fa fa-folder',
			'itemSelect' : true,
			'folderSelect': true,
			'multiSelect': true,
			'selected-icon' : null,
			'unselected-icon' : null,
			'folder-open-icon' : 'ace-icon tree-plus',
			'folder-close-icon' : 'ace-icon tree-minus'
		});
		
		
		/**
		//Use something like this to reload data	
		$('#tree1').find("li:not([data-template])").remove();
		$('#tree1').tree('render');
		*/
		
		
		/**
		//please refer to docs for more info
		$('#tree1')
		.on('loaded.fu.tree', function(e) {
		})
		.on('updated.fu.tree', function(e, result) {
		})
		.on('selected.fu.tree', function(e) {
		})
		.on('deselected.fu.tree', function(e) {
		})
		.on('opened.fu.tree', function(e) {
		})
		.on('closed.fu.tree', function(e) {
		});
		*/
		
		var category_tree={};
		function initiateDemoData(){
			
			axios.get('CategoryTree').then(res=>{
				category_tree=res.data;
				// return category_tree
				console.log(category_tree);
			}).catch(function(e){
				console.log(e);
			})
			var tree_data_2 = {
				
				'music' : {text: 'Music', type: 'folder', 'icon-class':'orange'}	,
				
			}
			console.log(category_tree);
			// tree_data_2['music']['additionalParameters'] = {
			// 	'children' : [
			// 		{text: '<i class="ace-icon fa fa-music blue"></i> song1.ogg', type: 'item'},
			// 		{text: '<i class="ace-icon fa fa-music blue"></i> song2.ogg', type: 'item'},
			// 		{text: '<i class="ace-icon fa fa-music blue"></i> song3.ogg', type: 'item'},
			// 		{text: '<i class="ace-icon fa fa-music blue"></i> song4.ogg', type: 'item'},
			// 		{text: '<i class="ace-icon fa fa-music blue"></i> song5.ogg', type: 'item'}
			// 	]
			// }
			console.log(tree_data_2);



			var dataSource2 = function(options, callback){
				var $data = null
				if(!("text" in options) && !("type" in options)){
					$data = tree_data_2;//the root tree
					callback({ data: $data });
					return;
				}
				else if("type" in options && options.type == "folder") {
					if("additionalParameters" in options && "children" in options.additionalParameters)
						$data = options.additionalParameters.children || {};
					else $data = {}//no data
				}
				
				if($data != null)//this setTimeout is only for mimicking some random delay
					setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

				//we have used static data here
				//but you can retrieve your data dynamically from a server using ajax call
				//checkout examples/treeview.html and examples/treeview.js for more info
			}

			
			return {'dataSource2' : dataSource2}
		}

	});
</script>