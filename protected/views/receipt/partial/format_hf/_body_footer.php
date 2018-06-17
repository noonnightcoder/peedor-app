<tbody>
    <tr class="gift-receipt-element">
        <td colspan="3" style='text-align:left;border-top:2px solid #000000; font-size: 11px;'></td>
        <td colspan="" class="font-10-px" style='text-align:right;border-top:2px solid #000000;'>
            សរុប <br>
            <?= Yii::t('app','Sub Total'); ?>
        </td>
        <td colspan="2" class="font-10-px" style='text-align:right;border-top:2px solid #000000;'> <?= curcurrencySympbol() . number_format($sub_total,Common::getDecimalPlace(), '.', ','); ?></td>
    </tr>

    <tr class="gift-receipt-element">
        <td colspan="3" class="font-10-px" style='text-align:left;'></td>
        <td colspan="<?php //echo $colspan; */ ?>" class="font-10-px" style='text-align:right;'>
            <?= $total_discount . '%' . Yii::t('app', 'Discount');  ?>
        </td>
        <td colspan="2" class="font-10-px" style='text-align:right;'>
            <?= curcurrencySympbol() . number_format($discount_amount,Common::getDecimalPlace(), '.', ','); ?>
        </td>
    </tr>

    <tr class="gift-receipt-element">
        <td colspan="3" class="font-10-px" style='text-align:left;'></td>
        <td class="kh-font font-10-px" colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'>
            អាករតំលៃបន្ថៃម ១០% <br>
            <?= Yii::t('app', 'VAT (10%)');  ?>
        </td>
        <td colspan="2" class="font-10-px" style='text-align:right;'>
            <?= curcurrencySympbol() . number_format($gst_amount,Common::getDecimalPlace(), '.', ','); ?>
        </td>
    </tr>

    <tr class="gift-receipt-element">
        <td colspan="3" style='text-align:left;'></td>
        <td class="kh-font font-10-px" colspan="<?php //echo $colspan; */ ?>" style='text-align:right;'>
            សរុបរួម <br>
            <?= TbHtml::b(Yii::t('app','Grand Total'));  ?>
        </td>
        <td colspan="2" style='text-align:right;'>
            <span style="font-size:12px;font-weight:bold">
                <?= curcurrencySympbol() . number_format($total,Common::getDecimalPlace(), '.', ','); ?>
            </span>
        </td>
    </tr>
</tbody>