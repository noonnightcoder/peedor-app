<script>

    var id=1;
    var price_range=[{arrID:'',from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''}];
    function addPriceRange(iid=0){
        if(id==1){
            id=iid+1;
        }
        $('#price-range').append('\
			<div class="range-'+id+'">\
            <div class="row">\
    			<hr style="width:90%; margin-left:0px;">\
    			<div class="col-sm-2">\
                    <div class="form-group col-sm-12">\
    				    <input type="number" name="priceQuantity[price_qty'+id+'][from_quantity]" id="ItemPriceQuantity_from_quantity" class="txt-from-qty'+id+' form-control" placeholder="From" onkeyUp="getValue('+id+')">\
    				</div>\
    			</div>\
    			<div class="col-sm-2">\
                    <div class="form-group col-sm-12">\
    				    <input type="number" name="priceQuantity[price_qty'+id+'][to_quantity]" id="ItemPriceQuantity_to_quantity" class="txt-to-qty'+id+' form-control" placeholder="To" onBlur="getValue('+id+')">\
    				</div>\
    			</div>\
    			<div class="col-sm-2">\
                    <div class="form-group col-sm-12">\
    				    <input type="number" step="0.01" name="priceQuantity[price_qty'+id+'][unit_price]" id="ItemPriceQuantity_unit_price" class="txt-price'+id+' form-control" placeholder="Price" onkeyUp="getValue('+id+')">\
    				</div>\
    			</div>\
    			<!--<div class="col-sm-2">\
                    <div class="form-group col-sm-12">\
    				    <input type="text" name="priceQuantity[price_qty'+id+'][start_date]" id="ItemPriceQuantity_start_date" class="input-grid input-mask-date dt-start-date'+id+' form-control" placeholder="dd/mm/yyyy" title="Satrt Date" onChange="getValue('+id+')">\
    				</div>\
    			</div>\
    			<div class="col-sm-2">\
                    <div class="form-group col-sm-12">\
    				    <input type="text" name="priceQuantity[price_qty'+id+'][end_date]" id="ItemPriceQuantity_end_date" class="input-grid input-mask-date dt-end-date'+id+' form-control" placeholder="dd/mm/yyyy" title="End Date" onChange="getValue('+id+')">\
    				</div>\
    			</div>-->\
    			<div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removePriceRange('+id+')"></div>\
                </div>\
                <p class="msg-'+id+'" style="color:#ff0000;"></p>\
		    </div>\
			');
        price_range.push({arrID:id,from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''});
        console.log(price_range);
        id=id+1;
        $('.btn-save,.btn-add').prop('disabled',true);
    }

    function removePriceRange(rid){
        $('.range-'+rid).html('');
        $('.btn-add').prop('disabled',false);
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range.splice(i,1);
            }
        })
    }

    function getValue(rid=''){
        var toQty=$('.txt-to-qty'+rid).val();
        var c='';
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range[i].from_quantity=$('.txt-from-qty'+rid).val();
                price_range[i].to_quantity=$('.txt-to-qty'+rid).val();
                price_range[i].price=$('.txt-price'+rid).val();
                price_range[i].start_date=$('.dt-start-date'+rid).val();
                price_range[i].end_date=$('.dt-end-date'+rid).val();
            }else{
                if(price_range[i].to_quantity==toQty && toQty!==""){
                    $('.msg-'+rid).text('Range already exist.')
                    $('.btn-save,.btn-add').prop('disabled',true);
                    c='d';
                }else{
                    $('.msg-'+rid).text('')
                    $('.btn-save,.btn-add').prop('disabled',false);
                    c='';
                }
            }
        });
        if($('.txt-price'+rid).val() !=="" && c==''){
            $('.btn-add').prop('disabled',false);
        }
    }
    //$('#priceQuantity'-form').submit(function(e){
    //     e.preventDefault();
    //     $.ajax({
    //         type:'post',
    //         url:'<?php //echo Yii::app()->createUrl('priceQuantity'/Create')?>//',
    //        data:{
    //            priceQuantity':
    //                {
    //                    item_number:$('.txt-priceQuantity'-number').val(),
    //                    name:$('.txt-priceQuantity'-name').val(),
    //                    reorder_level:$('.txt-reorder-level').val(),
    //                    location:$('.txt-location').val(),
    //                    description:$('.txt-description').val(),
    //                    category_id:$('#s2id_autogen2_search').val()
    //                },
    //            data:price_range
    //        },
    //        beforeSend:function(data){
    //            $('.waiting').slideDown();
    //        },
    //        success:function(data){
    //            $('.waiting').slideUp();
    //        }
    //    })
    //});
    $(document).ready(function()
    {
        $('.input-mask-date').mask('99/99/9999');
        $('.btn-add').prop('disabled',true);
    });
</script>