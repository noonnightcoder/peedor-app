<?php
Yii::app()->clientScript->registerScript( 'deleteItem', "
        jQuery( function($){
            $('div#grid-cart').on('click','a.delete-item',function(e) {
                e.preventDefault();
                var url=$(this).attr('href');
                $.ajax({url:url,
                        type : 'post',
                        beforeSend: function() { $('.waiting').slideDown(); },
                        complete: function() { $('.waiting').slideUp(); },
                        success : function(data) {
                            $('#register_container').html(data);
                          }
                    });
                });
        });
      ");
?>

<script type="text/javascript">
	var submitting = false;

    $(document).ready(function()
    {
        //Here just in case the loader doesn't go away for some reason
        $('.waiting').slideUp();

        // ajaxForm to ensure is submitting as Ajax even user press enter key
        $('#add_item_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});
        $('.line_item_form,.line_item_form_all').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit});

        $('#cancel_cart').on('click','a.reset-item-to-transfer',function(e) {
            e.preventDefault();
            if (confirm("<?= Yii::t('app','Are you sure you want to clear this sale? All items will cleared.'); ?>")){
                $('#suspend_sale_form').attr('action', '<?php echo Yii::app()->createUrl('receiving/resetItemToTransfer/'); ?>');
                $('#suspend_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
            }
        });

        $('#Receiving_reference_name').blur(function(){
            $('#reference_name_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
        })

        $('.input-grid').change(function(){
            $('.line_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
        })
        
        $('#from_outlet, #to_outlet').change(function(){
           // alert('hello')
            $('#set-outlet-form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
        })

    });

    function salesBeforeSubmit(formData, jqForm, options)
    {
        if (submitting)
        {
            return false;
        }
        submitting = true;
        $('.waiting').slideDown();
    }

    function itemScannedSuccess(responseText, statusText, xhr, $form)
    {
        //$('.waiting').hide();
        setTimeout(function(){$('#SaleItem_item_id').focus();}, 10);
    }
    // really thanks to this http://www.stefanolocati.it/blog/?p=1413
    function qtyScannedSuccess(itemId)
    {
        return function (responseText, statusText, xhr, $form ) {
            setTimeout(function(){$('#quantity_' + itemId).select();}, 10);
        }
    }

</script>