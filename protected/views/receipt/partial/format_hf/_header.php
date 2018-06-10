<div class="row row-bordered">

    <div class="col-xs-5">
        <p>
            <?= 'ឈ្មោះអ្នកលក់ ' .  " ៖ ". TbHtml::encode($salerep_fullname); ?> <br>
        </p>
    </div>

    <div class="col-xs-6 col-xs-offset-1 text-right">
        <p>
            <?= Yii::t('app','Telephone Number') . " : ". TbHtml::encode(Yii::app()->settings->get('site', 'companyPhone')); ?> <br>
        </p>
    </div>

</div>

<div class="container text-center" style="">
    <div class="col-lg-4 col-lg-offset-4">
        <h2><span class="receipt-title-kh-font"><?=$receipt_header_title_kh?></span> <br>
            <?=$receipt_header_title_en?></h2>
    </div>
</div>
