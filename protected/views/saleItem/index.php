<?php
$this->breadcrumbs=array(
    'Sales' => array('create'),
    'Create',
);
?>

<div id="register_container">

    <?/*= $sale_save_url */?>
    <?php $this->renderPartial('partial/_left_panel',
        array(
            'model' => $model,
            'items' => $items,
            'employee_id' => $employee_id,
            'disable_editprice' => $disable_editprice,
            'disable_discount' => $disable_discount,
            'discount_symbol' => $discount_symbol,
            'sale_header' => $sale_header,
            'sale_header_icon' => $sale_header_icon,
            'color_style' => $color_style
        )); ?>

    <?php $this->renderPartial('partial/_right_panel', array(
        'model' => $model,
        'count_item' => $count_item,
        'customer' => $customer,
        'cust_fullname' => $cust_fullname,
        'customer_id' => $customer_id,
        'acc_balance' => $acc_balance,
        'sale_mode' => $sale_mode,
        'sub_total' => $sub_total,
        'total' => $total,
        'total_khr_round' => $total_khr_round,
        'discount_amount' => $discount_amount,
        'total_gst' => $total_gst,
        'count_payment' => $count_payment,
        'total_due' => $total_due,
        'payments' => $payments,
        'amount_change' => $amount_change,
        'amount_change_whole' => $amount_change_whole,
        'amount_change_fraction_khr' => $amount_change_fraction_khr,
        'amount_change_khr_round' => $amount_change_khr_round,
        'discount_symbol' => $discount_symbol,
        'discount_amt' => $discount_amt,
        'gst_amount' => $gst_amount,
        'sale_header' => $sale_header,
        'sale_save_url' => $sale_save_url,
        'cust_term' => $cust_term,
        'color_style' => $color_style,
        'tran_type' => $tran_type
    )); ?>

    <?php $this->renderPartial('partial/_js'); ?>

</div>
