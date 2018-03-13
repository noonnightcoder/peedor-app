<div class="row ">

    <div class="col-xs-5">
        <p>
            <?= Yii::t('app','អតិថិជន/Customer') . " : ". TbHtml::encode(ucwords($cust_fullname)); ?> <br>
            <?= Yii::t('app','Address') . " : ". TbHtml::encode(ucwords($cust_address1 . ' ' . $cust_address2)); ?> <br>
            <?= Yii::t('app','Telephone N') . " : ". TbHtml::encode(ucwords($cust_mobile_no)); ?> <br>
        </p>
    </div>
    <div class="col-xs-6 col-xs-offset-1 text-right">
            <?= Yii::t('app','លេខ​វិ​ក័​យ​ប័ត្រ / INVOICE No') . " : "  . $invoice_no_prefix . $sale_id; ?> <br>
            <?= TbHtml::encode(Yii::t('app','DATE') . " : ". $transaction_date); ?> <br>
    </div>

</div>