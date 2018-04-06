<script>
    jQuery(function ($) {
        $('div#report_grid').on('click', 'a.btn-order-approve', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to Confirm this order?')) {
                return false;
            }
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                beforeSend: function () {
                    $('.waiting').show();
                },
                complete: function () {
                    $('.waiting').hide();
                },
                success: function (data) {
                    //$("#report_grid").html(data);
                    $.fn.yiiGridView.update('sale-order-grid');
                    return false;
                }
            });
        });

    });

</script>