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
                <?= $form->textFieldControlGroup($model,'item_number',array('class'=>'span3 form-control','maxlength'=>255)); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
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
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Pricing') ?>
        </h4>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldControlGroup($model, 'cost_price', array('class' => 'span3')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldControlGroup($model, 'unit_price', array('class' => 'span3')); ?>
            </div>
        </div>
        <h4 class="header blue">
            <i class="fa fa-info-circle blue"></i><?= Yii::t('app', 'Detail') ?>
        </h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_category"><?= Yii::t('app','Category') ?></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="db-category" name="Item[category_id]" onchange="showDialog(event.target.value)">
                            <option value="0">--Choose Parent--</option>
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
                        <?php
                        $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'asDropDownList' => false,
                            'model'=> $model,
                            'attribute'=>'unit_measurable_id',
                            'pluginOptions' => array(
                                'placeholder' => Yii::t('app','Unit Of Measurable'),
                                'multiple'=>false,
                                'width' => '50%',
                                //'tokenSeparators' => array(',', ' '),
                                'allowClear'=>true,
                                //'minimumInputLength'=>1,
                                'ajax' => array(
                                    'url' => Yii::app()->createUrl('unitMeasurable/GetUnitMeasurable2/'),
                                    'dataType' => 'json',
                                    'cache'=>true,
                                    'data' => 'js:function(term,page) {
                                                            return {
                                                                term: term,
                                                                page_limit: 10,
                                                                quietMillis: 100,
                                                                apikey: "e5mnmyr86jzb9dhae3ksgd73"
                                                            };
                                                        }',
                                    'results' => 'js:function(data,page){
                                                    return { results: data.results };
                                                 }',
                                ),
                                'initSelection' => "js:function (element, callback) {
                                                    var id=$(element).val();
                                                    if (id!=='') {
                                                        $.ajax('".$this->createUrl('/unitMeasurable/InitUnitMeasurable')."', {
                                                            dataType: 'json',
                                                            data: { id: id }
                                                        }).done(function(data) {callback(data);});
                                                    }
                                            }",
                                'createSearchChoice' => 'js:function(term, data) {
                                                if ($(data).filter(function() {
                                                    return this.text.localeCompare(term) === 0;
                                                }).length === 0) {
                                                    return {id:term, text: term, isNew: true};
                                                }
                                            }',
                                'formatResult' => 'js:function(term) {
                                                if (term.isNew) {
                                                    return "<span class=\"label label-important\">New</span> " + term.text;
                                                }
                                                else {
                                                    return term.text;
                                                }
                                            }',
                            )));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'reorder_level',array('class'=>'span3 txt-reorder-level pull-right',)); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldControlGroup($model,'location',array('class'=>'span3 txt-location','maxlength'=>20)); ?>
            </div>
        </div>
    

    

    

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