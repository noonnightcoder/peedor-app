<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/Create'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
        'beforeValidate'=>"js:beforeValidate()",
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

<?php $this->renderPartial('_header', array('model' => $model)) ?>


<div class="col-sm-12">
    <div class="errorMessage" id="formResult"></div>
    <h4 class="header blue">
        <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Basic Information') ?>
    </h4>

    <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
        <?= Yii::t('app', 'are required'); ?></p>
        <div class="row">
            
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_brand"><?= Yii::t('app','Brand') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-brand" name="Item[brand_id]" onchange="showBrandDialog(event.target.value)">
                            <option value="0">--Choose Brand--</option>
                            <?php foreach($brand as $key=>$value):?>

                                <option value="<?=$value['id']?>" <?php echo $model['brand_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label>Description</label>
                <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                    'model'=>$model,
                    'attribute'=>'description',
                    'language'=>'en',
                    'editorTemplate'=>'full',
                    'htmlOptions'=>array('placeholder'=>'Description')
                )); ?>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="col-sm-1">
                <label>Tags </label>
            </div>
            <div class="col-sm-11">
                <div class="tag-container" title="Type any text then press Tap or Comma(,) or Enter key">
                    <div class="tag-item-box"></div>
                    <!-- <div class="col-sm-12"> -->
                        <input type="text" class="span3 tag-box" value="" style="margin-top: 10px;float: left;">
                        <?php echo $form->hiddenField($model, 'tags', array('class' => 'span3','id'=>'item-tags','value'=>Yii::app()->session['tags'])); ?>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Inventory') ?>
        </h4>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'sku',array('class'=>'span3 txt-barcode','maxlength'=>32)); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'item_number',array('class'=>'span3 form-control','maxlength'=>255,'placeholder'=>'ISBN,UPC,GTIN,etc.')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_supplier"><?= Yii::t('app','Supplier') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-supplier" name="Item[supplier_id]" onchange="showSupplierDialog(event.target.value)">
                            <option value="0">--Choose Supplier--</option>
                            <?php foreach($supplier as $key=>$value):?>

                                <option value="<?=$value['id']?>" <?php echo $model['supplier_id']==$value['id'] ? 'selected' : ''?>><?=$value['company_name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldControlGroup($model, 'quantity', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_category"><?= Yii::t('app','Category') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-category" name="Item[category_id]" onchange="showCategoryDialog(event.target.value)">
                            <option value="0">--Choose Category--</option>
                            <?php foreach($categories as $key=>$value):?>

                                <option value="<?=$value['id']?>" <?php echo $model['category_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_unit_measurable"><?= Yii::t('app','Unit Of Measurable') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-measurable" name="Item[unit_measurable_id]" onchange="showMeasurableDialog(event.target.value)">
                            <option value="0">--Choose Measurable--</option>
                            <?php foreach($measurable as $key=>$value):?>

                                <option value="<?=$value['id']?>" <?php echo $model['unit_measurable_id']==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
                            <?php endforeach;?>
                            <optgroup >
                                <option value="addnew">
                                    Create New
                                </option>
                            </optgroup >
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3 txt-reorder-level pull-right',)); ?>
            </div>
            
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Pricing') ?>
        </h4>
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'cost_price', array('class' => 'span3')); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'markup', array('class' => 'span3','value'=>0)); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldControlGroup($model, 'unit_price', array('class' => 'span3')); ?>
            </div>
        </div>
    
<?php $this->renderPartial('partialList/_measurable_modal',array('measurable'=>$measurable)); ?>
<?php $this->renderPartial('partialList/_supplier_modal',array('measurable'=>$measurable)); ?>
<?php $this->renderPartial('partialList/_brand_modal',array('brand'=>$brand)); ?>
</div>
<?php $this->endWidget(); ?>
<script>
    function beforeValidate() {
    var form = $(this);
    if(form.find('.has-error').length) {
            return false;
    }else{
        return true;
    }
}
</script>
<div id="modal-container"></div>
<?php $this->renderPartial('partialList/_action',array('categories'=>$categories)) ?>

<style type="text/css">
    .margin-top-15{
        margin-left: 15px;
        margin-top: 15px;
    }
    .tag-container{
        display: inline-block;
        height: auto;
        min-height: 35px;
        border-radius: 3px;
        width: 100%;
        border:solid 1px #ccc;
    }
    .tag-box{
        border:none !important;
        float: left;
        width: 200px;
    }
    .tag-item-box{
        float: left;
        height: auto;
    }
    .tag-item{
        padding: 5px;
        background-color: #ccc;
        position: relative;
        float: left;
        top: 0px;
        bottom: 10px;
        margin: 10px 5px 10px 5px !important;
        border-radius: 3px;
    }
</style>