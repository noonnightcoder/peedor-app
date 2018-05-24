<table class="table table-hover table-bordered role-table">
    <thead>
        <tr>
            <td style="min-width:220px;"><?= Yii::t('app', ' '); ?></td>
            <td class="permission"><?= Yii::t('app', 'Full Access'); ?></td>
            <td class="permission"><?= Yii::t('app', 'View'); ?></td>
            <td class="permission"><?= Yii::t('app', 'Create'); ?></td>
            <td class="permission"><?= Yii::t('app', 'Edit'); ?></td>
            <td class="permission"><?= Yii::t('app', 'Delete'); ?></td>
            <td style="width: 100%;"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Item</td>
            <td class="permission"><input id="Authitem_name_all" value="1" checked="checked" type="checkbox"
                                          name="Authitem_name_all"></td>
            <td class="permission"><input id="Authitem_name_all" value="item.view" checked="checked" type="checkbox"
                                          name="Authitem_name_all"></td>
            <td class="permission"><input id="Authitem_name_all" value="item.create" checked="checked" type="checkbox"
                                          name="Authitem_name_all"></td>
            <td class="permission"><input id="Authitem_name_all" value="item.edit" checked="checked" type="checkbox"
                                          name="Authitem_name_all"></td>
            <td class="permission"><input id="Authitem_name_all" value="item.delete" checked="checked" type="checkbox"
                                          name="Authitem_name_all"></td>
            <td>
                <form>
                    <div id='filters-container' style='display: none;'>
                        <div id="div_id_filters" class="form-group">
                            <div class="controls">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="filter" id="id_filter_1" class="filter filters_1" value="Filter1" />Filter1</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="filter" id="id_filter_2" class="filter filters_2" value="Filter2" />Filter2</label></div>
                                <div class="checkbox"><label><input type="checkbox" name="filter" id="id_filter_3" class="filter filters_3" value="Filter3" />Filter3</label></div>
                                <!-- etc etc more filters -->
                            </div>
                        </div>
                    </div>
                    <button id='filter-btn' data-contentwrapper='#filters-container' class='btn' rel="popover" type="button">Filter</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<style>
    .role-table td.permission {
        min-width: 70px;
        text-align: center;
    }
</style>

<script>
    $('[rel=popover]').popover({
        html:true,
        placement:'bottom',
        content:function(){
            return $($(this).data('contentwrapper')).html();
        }
    });
</script>