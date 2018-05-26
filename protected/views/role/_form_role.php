    <div class="widget-box widget-color-blue" id="widget-box-2">
        <!-- #section:custom/widget-box.options -->

        <?php $this->renderPartial('_form_role_header', array(
                'title' => 'Item',
                'icon' => sysMenuItemIcon(),
        )) ?>

        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-striped table-bordered table-hover role-table">
                    <thead class="thin-border-bottom">

                    <tr>
                        <td style="min-width:220px;"><?= Yii::t('app', ' '); ?></td>
                        <td class="permission"><?= Yii::t('app', 'Full Access'); ?></td>
                        <td class="permission"><?= Yii::t('app', 'View'); ?></td>
                        <td class="permission"><?= Yii::t('app', 'Create'); ?></td>
                        <td class="permission"><?= Yii::t('app', 'Edit'); ?></td>
                        <td class="permission"><?= Yii::t('app', 'Delete'); ?></td>
                        <td style="width:100%"></td>
                    </tr>

                    </thead>

                    <tbody>
                        <td> Item </td>
                        <td class="permission">
                            <input value="All" type="checkbox" name="Authitem_name_all">
                        </td>
                        <?php foreach (Authitem::model()->getAuthItemData('item') as $id => $item): ?>
                            <td class="permission">
                                <input value="<?= $item["name"]; ?>" type="checkbox" name="Authitem_name_all">
                            </td>
                        <?php endforeach; ?>

                        <?php $this->renderPartial('_grid_more'); ?>

                    </tbody>


                    <tbody>
                    <td> Category </td>
                    <td class="permission">
                        <input value="All" type="checkbox" name="Authitem_name_all">
                    </td>
                    <?php foreach (Authitem::model()->getAuthItemData('item') as $id => $item): ?>
                        <td class="permission">
                            <input value="<?= $item["name"]; ?>" type="checkbox" name="Authitem_name_all">
                        </td>
                    <?php endforeach; ?>

                    <?php $this->renderPartial('_grid_more'); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<style>
    .role-table td.permission{
        min-width: 70px;
        text-align: center;
    }
</style>