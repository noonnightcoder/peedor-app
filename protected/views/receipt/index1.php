
<style>
    #sale-return-policy {
        width: 80%;
        margin: 0 auto;
        text-align: center;
    }

    #receipt-wrapper {
        font-family: 'Arial','khmer os';
        width: 92% !important;
        font-size: 11px !important;
        padding: 0 !important;
    }

    #receipt-items td {
        position: relative;
        padding: 3px;
    }

    @media print {
        body {
            position: relative;
        }

        #footer {
            position: fixed;
            bottom: 0;
            width:100%;
        }
    }

    .row-bordered:after {
        content: "";
        display: block;
        border-bottom: 2px solid #000000;
        margin: 0 15px;
    }

    .kh-font{
        font-family: 'khmer os';
    }
</style>
<?php
if (isset($error_message))
{
    echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $error_message);
    exit();
}
?>

<div class="container" id="receipt_wrapper">
    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_header_view,
        array(
            'sale_id' => $sale_id,
			'cust_fullname' => $cust_fullname,
			'cust_address1' => $cust_address1,
			'cust_address2' => $cust_address2,
			'cust_mobile_no' => $cust_mobile_no,
			'cust_contact_fullname' => $cust_contact_fullname,
			'cust_fax' => $cust_fax,
            'transaction_date' => $transaction_date,
            'cust_notes' => $cust_notes,
            'salerep_fullname' => $salerep_fullname,
            'salerep_tel' => $salerep_tel,
            'invoice_no_prefix' => $invoice_no_prefix,
            'receipt_header_title_kh'=>$receipt_header_title_kh,
            'receipt_header_title_en'=>$receipt_header_title_en
        ));
    ?>

    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_header_body_view,
        array(
            'sale_id' => $sale_id,
            'cust_fullname' => $cust_fullname,
            'cust_address1' => $cust_address1,
            'cust_address2' => $cust_address2,
            'cust_mobile_no' => $cust_mobile_no,
            'cust_contact_fullname' => $cust_contact_fullname,
            'cust_fax' => $cust_fax,
            'transaction_date' => $transaction_date,
            'cust_notes' => $cust_notes,
            'salerep_fullname' => $salerep_fullname,
            'salerep_tel' => $salerep_tel,
            'invoice_no_prefix' => $invoice_no_prefix,
        ));
    ?>

    <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/'  . $invoice_body_view,
        array(
            'salerep_fullname' => $salerep_fullname,
            'cust_fullname' => $cust_fullname,
            'sale_id' => $sale_id,
            'transaction_date' => $transaction_date,
            'transaction_time' => $transaction_time,
            'items' => $items,
            'colspan' => $colspan,
            'total_discount' => $total_discount,
            'discount_amount' => $discount_amount,
            'sub_total' => $sub_total,
            'total' => $total,
            'total_khr_round' => $total_khr_round,
            'amount_change' => $amount_change,
            'amount_change_khr_round' => $amount_change_khr_round,
            'cust_address1' => $cust_address1,
            'invoice_no_prefix' => $invoice_no_prefix,
            'invoice_body_footer_view' => $invoice_body_footer_view,
            'gst_amount' => $gst_amount
        ));
    ?>

    <?php if ($invoice_body_footer_view != null) { ?>

        <?php $this->renderPartial('//receipt/partial/' . invFolderPath() . '/' . $invoice_footer_view,
            array(
                'sub_total' => $sub_total,
                'total' => $total,
                'total_discount' => $total_discount,
                'discount_amount' => $discount_amount,
                'cust_fullname' => $cust_fullname,
                'gst_amount' => $gst_amount,
                //'colspan' => $colspan,
            ));
        ?>

    <?php } ?>
    <?php if(isset($_GET['print']) && $_GET['print'] == 'true'):?>
        <?php $this->renderPartial('//receipt/partial/_js'); ?>
    <?php endif;?>

</div>