<div class="row">
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array( // configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'),
        ),
    )); ?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'employee-form',
        'enableAjaxValidation' => false,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <div class="col-sm-5">

        <h4 class="header blue"><i
                    class="ace-icon fa fa-info-circle blue"></i><?= Yii::t('app', 'Employee Basic Information') ?>
        </h4>
        <p class="help-block"><?= Yii::t('app', 'Fields with'); ?> <span
                    class="required">*</span> <?= Yii::t('app', 'are required'); ?></p>

        <?php //echo $form->errorSummary($model); ?>

        <?= $form->textFieldControlGroup($model, 'first_name', array('class' => 'span10', 'maxlength' => 50, 'data-required' => 'true')); ?>

        <?= $form->textFieldControlGroup($model, 'last_name', array('class' => 'span10', 'maxlength' => 50, 'data-required' => 'true')); ?>

        <?= $form->textFieldControlGroup($model, 'mobile_no', array('class' => 'span10', 'maxlength' => 15)); ?>

        <div class="form-group">

            <label class="col-sm-3 control-label"
                   for="Employee_dob"><?= Yii::t('app', 'Date of Birth') ?></label>

            <div class="col-sm-9">

                <?= CHtml::activeDropDownList($model, 'day', Employee::itemAlias('day'), array('prompt' => yii::t('app', 'Day'))); ?>

                <?= CHtml::activeDropDownList($model, 'month', Employee::itemAlias('month'), array('prompt' => yii::t('app', 'Month'))); ?>

                <?= CHtml::activeDropDownList($model, 'year', Employee::itemAlias('year'), array('prompt' => yii::t('app', 'Year'))); ?>

                <span class="help-block"> <?= $form->error($model, 'dob'); ?> </span>
            </div>

        </div>

        <?= $form->textFieldControlGroup($model, 'adddress1', array('class' => 'span10', 'maxlength' => 60)); ?>

        <?= $form->textFieldControlGroup($model, 'address2', array('class' => 'span10', 'maxlength' => 60)); ?>

        <?php //echo $form->textFieldControlGroup($model,'city_id',array('class'=>'span10')); ?>

        <?= $form->textFieldControlGroup($model, 'country_code', array('class' => 'span10', 'maxlength' => 2)); ?>

        <?= $form->textFieldControlGroup($model, 'email', array('class' => 'span10', 'maxlength' => 30, 'data-type' => 'email')); ?>

        <?= $form->textAreaControlGroup($model, 'notes', array('rows' => 2, 'cols' => 20, 'class' => 'span10')); ?>
    </div>

    <div class="col-sm-7">
        <h4 class="header blue bolder smaller"><i
                    class="ace-icon fa fa-key blue"></i><?= Yii::t('app', 'Employee Login Info') ?></h4>

        <?php $this->renderPartial('//rbacUser/_login_form',array(
            'model' => $model,
            'user' => $user,
            'form' => $form,
            'disabled' => $disabled,
        ));?>


        <h4 class="header blue bolder"><i
                    class="ace-icon fa fa-gavel blue"></i><?= Yii::t('app', 'Employee Permissions and Access'); ?>
        </h4>

        <?php $this->renderPartial('//rbacUser/_role_form', array(
            'form' => $form,
            'user' => $user,
        )); ?>

        <div class="form-actions">
            <?= TbHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            )); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php Yii::app()->clientScript->registerScript('setFocus', '$("#Employee_first_name").focus();'); ?>
