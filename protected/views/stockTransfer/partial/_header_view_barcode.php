<style type="text/css">
    .barcode-container{
        width: 2480px;
        height: 3508px;
    }
</style>
<nav class="navbar navbar-fixed-top">
	<a class="btn btn-primary" onclick="window.history.back()">
		<i class="ace-icon fa fa-arrow-left bigger-120 white"></i>Back
	</a>
    <a class="btn btn-primary" href="<?=Yii::app()->createUrl('item/admin')?>">
        <i class="ace-icon fa fa-list bigger-120 white"></i>Item List
    </a>
	<a class="btn btn-primary pull-right" id="btn-print">
		<i class="ace-icon fa fa-print bigger-120 white"></i>Print
	</a>
</nav>
<div style="margin-top: 60px !important;"></div>
<script type="text/javascript">
    $('#btn-print').on('click',function(){
        $("#container").show();
        window.print();
    })
</script>