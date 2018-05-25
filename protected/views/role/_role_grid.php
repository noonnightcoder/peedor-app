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
            <?php foreach (Authitem::model()->getAuthItemData('item') as $id => $item): ?>
                <td class="permission">
                    <input value="<?= $item["name"]; ?>" type="checkbox" name="Authitem_name_all">
                </td>
            <?php endforeach; ?>

            <td>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="button-group">
                                <button type="button" class="btn btn-primary btn-mini dropdown-toggle" data-toggle="dropdown">
                                    <span class="fa fa-cog"></span> <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="small" data-value="option1" tabIndex="-1">
                                            <input type="checkbox"/>&nbsp;Price Book
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="small" data-value="option2" tabIndex="-1">
                                            <input type="checkbox"/>&nbsp;Composite Item
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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