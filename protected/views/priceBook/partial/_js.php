<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('.input-mask-date').mask('99:99:99');
         $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
          });
        $(".textbox").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if ((e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) && $(this).val().indexOf('.')!=-1) {
                //display error message
                //$("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
        
        
        var itemId=$('.txt-pro-id').val();
        $('.txt-count'+itemId).keypress(function(e){
            if(e.which == 13) {
                priceBook(1,"");
                $('.txt-pro-name').focus();
            }
        })
    });
    function priceBook(opt,idx){
        var url='<?=Yii::app()->createUrl('/PriceBook/AddItem')?>';
        var start_date=$('#PriceBook_start_date').val();
        var end_date=$('#PriceBook_end_date').val();
        var price_book_name=$('#PriceBook_name').val();
        var itemId=$('.txt-pro-id').val();
        var proName=$('.txt-pro-name').val();
        var outlet=$('#db-outlet').val();
        var group_id=$('#db-group').val();
        if(opt==1 && (proName =='')){
            return false;
        }else{
            $.ajax({url:url,
                type : 'post',
                data:{opt,start_date,end_date,price_book_name,outlet,group_id,idx,itemId,proName},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    $('.txt-pro-name').focus();
                }
            });    
        }
        
    }
    var timer=null;
    function updateItem(itemId,val,idx){
        var opt=3;
        var url='<?=Yii::app()->createUrl('/PriceBook/AddItem')?>';
        var markup=$('.txt-markup'+idx).val();
        var markupall=$('.txt-markupall').val();
        var discount=$('.txt-discount'+idx).val();
        var discountall=$('.txt-discountall').val();
        var retail_price=$('.txt-retail-price'+idx).val();
        var min_qty=$('.txt-min-qty'+idx).val();
        var max_qty=$('.txt-max-qty'+idx).val();
        var x = event.which || event.keyCode
        if(x == 13){
            //clearTimeout(timer)
            //timer=setTimeout(function(){
            $.ajax({url:url,
                type : 'post',
                data:{opt,itemId,markup,markupall,discount,discountall,retail_price,min_qty,max_qty,val,idx},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    switch(val){
                        case 'markup':
                        $('#discount'+idx).focus();
                        $('#discount'+idx).select();
                        break;
                        case 'discount':
                        $('#retail_price'+idx).focus();
                        $('#retail_price'+idx).select();
                        break;
                        case 'retail_price':
                        $('#min_qty'+idx).focus();
                        $('#min_qty'+idx).select();
                        break;
                        case 'min_qty':
                        $('#max_qty'+idx).focus();
                        $('#max_qty'+idx).select();
                        break;
                        case 'max_qty':
                        $('.txt-pro-name').focus();
                        //$('#markup'+idx).select();
                        break;
                    }
                }
            });
                //},700   
            //)
        }
        
    }
    function validateBeforeSubmit(){
        var price_book_name=$('#PriceBook_name').val();
        var url = '<?=Yii::app()->createUrl('/PriceBook/SavePriceBook')?>';
        $.ajax({url:url,
            type : 'post',
            data:{price_book_name},
            beforeSend: function() { $('.waiting').slideDown(); },
            complete: function() { $('.waiting').slideUp(); },
            success : function(data) {
                if(data=='exist'){
                    alert('existed')
                }
            }
        });
    }
</script>