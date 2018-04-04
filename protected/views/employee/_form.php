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

        <h4 class="header blue">
            <i class="ace-icon fa fa-info-circle blue"></i><?= Yii::t('app', 'Employee Basic Information') ?>
        </h4>
        <p class="help-block"><?= Yii::t('app', 'Fields with'); ?> <span
                    class="required">*</span> <?= Yii::t('app', 'are required'); ?></p>

        <?php $this->renderPartial('_basic', array(
                'model' => $model,
                'form' => $form,
            )
        )
        ?>

        <?php $this->renderPartial('_address', array(
                'model' => $model,
                'form' => $form,
            )
        )
        ?>


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
            //'auth_items' => $auth_items,
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
