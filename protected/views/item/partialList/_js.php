<script>

    var id=1;
    var price_range=[{arrID:'',from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''}];
    function addPriceRange(){
        $('#price-range').append('\
			<div class="range-'+id+'">\
			<hr style="width:90%; margin-left:0px;">\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="number" name="price_quantity[price_qty'+id+'][from_quantity]" id="ItemPriceQuantity_from_quantity" class="txt-from-qty'+id+' form-control" placeholder="From" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="number" name="price_quantity[price_qty'+id+'][to_quantity]" id="ItemPriceQuantity_to_quantity" class="txt-to-qty'+id+' form-control" placeholder="To" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="number" step="0.01" name="price_quantity[price_qty'+id+'][unit_price]" id="ItemPriceQuantity_unit_price" class="txt-price'+id+' form-control" placeholder="Price" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="text" name="price_quantity[price_qty'+id+'][start_date]" id="ItemPriceQuantity_start_date" class="input-grid input-mask-date dt-start-date'+id+' form-control" placeholder="dd/mm/yyyy" title="Satrt Date" onChange="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="text" name="price_quantity[price_qty'+id+'][end_date]" id="ItemPriceQuantity_end_date" class="input-grid input-mask-date dt-end-date'+id+' form-control" placeholder="dd/mm/yyyy" title="End Date" onChange="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removePriceRange('+id+')"></div>\
		</div>\
			');
        price_range.push({arrID:id,from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''});
        console.log(price_range);
        id=id+1;

    }

    function removePriceRange(rid){
        $('.range-'+rid).html('');
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range.splice(i,1);
            }
        })
    }

    function getValue(rid=''){
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range[i].from_quantity=$('.txt-from-qty'+rid).val();
                price_range[i].to_quantity=$('.txt-to-qty'+rid).val();
                price_range[i].price=$('.txt-price'+rid).val();
                price_range[i].start_date=$('.dt-start-date'+rid).val();
                price_range[i].end_date=$('.dt-end-date'+rid).val();
            }
        });
        console.log(price_range)
    }

    //$('#price_quantity'-form').submit(function(e){
    //     e.preventDefault();
    //     $.ajax({
    //         type:'post',
    //         url:'<?php //echo Yii::app()->createUrl('price_quantity'/Create')?>//',
    //        data:{
    //            price_quantity':
    //                {
    //                    item_number:$('.txt-price_quantity'-number').val(),
    //                    name:$('.txt-price_quantity'-name').val(),
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
        $('.datepicker').datepicker({
            format: {
                /*
                 * Say our UI should display a week ahead,
                 * but textbox should store the actual date.
                 * This is useful if we need UI to select local dates,
                 * but store in UTC
                 */
                toDisplay: function (date, format, language) {
                    var d = new Date(date);
                    d.setDate(d.getDate() - 7);
                    return d.toISOString();
                },
                toValue: function (date, format, language) {
                    var d = new Date(date);
                    d.setDate(d.getDate() + 7);
                    return new Date(d);
                }
            }
        });
        $('.ui-corner-all').css('height','20px');
    });
</script>