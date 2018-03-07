<script>
    jQuery( function($){
        $('div#sale_order_id').on('click','a.btn-order-approve',function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to APPROVE this order?')) {
                return false;
            }
            var url=$(this).attr('href');
            $.ajax({url:url,
                type : 'post',
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    $.fn.yiiGridView.update('sale-suspended-grid');
                    return false;
                }
            });
        });

    });
</script>

<script>
    jQuery( function($){
        $('div#report_header').on('click','.btn-view',function(e) {
            e.preventDefault();
            var data=$("#report-form").serialize();
            $.ajax({url: '<?=  Yii::app()->createUrl($this->route); ?>',
                type : 'GET',
                //dataType : 'json',
                data:data,
                beforeSend: function() { $('.waiting').show(); },
                complete: function() { $('.waiting').hide(); },
                success : function(data) {
                    //$("#report_grid").html(data.div); // Using with Json Data Return
                    $("#report_grid").html(data);
                    return false;
                }
            });
        });
    });
</script>