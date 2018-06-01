<tbody>
<tr>
    <td class=""> <?= Yii::t('app',$grid_title); ?> </td>

    <?php /*echo CHtml::activeCheckboxList($user, $control_name,Authitem::model()->getAuthItemDataList($permission),
        array('separator' => '',
            'checkAll' => Yii::t('app','Select All'),
            'template'=>'<td class="permission">{input}</td>'
        )
    );
    */?>

    <input id="ytRbacUser_<?= $control_name ?>" type="hidden" value="" name="RbacUser[<?= $control_name ?>]">

    <td class="permission">
        <input id="RbacUser_<?= $control_name ?>_all" value="1" name="RbacUser_<?= $control_name ?>_all" type="checkbox"  />
    </td>

    <?php foreach(Authitem::model()->getAuthItemData($permission) as $key => $value): ?>
        <?php if ($key < 4 ) { ?>
            <td class="permission">
                <input value="<?= $value['name'] ?>" name="RbacUser[<?= $control_name ?>][]" type="checkbox" />
            </td>
        <?php } elseif ($key==4) { ?>
                <td>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="button-group">
                                <button type="button" class="btn btn-primary btn-mini dropdown-toggle" data-toggle="dropdown">
                                    <span class="fa fa-cog"></span> <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="small" data-value="option1" tabIndex="-1">
                                            <input value="<?= $value['name'] ?>" name="RbacUser[<?= $control_name ?>][]" type="checkbox" />&nbsp;<?= $value['description'] ?>
                                        </a>
                                    </li>

        <?php } else { ?>
            <li>
                <a href="#" class="small" data-value="option1" tabIndex="-1">
                    <input value="<?= $value['name'] ?>" name="RbacUser[<?= $control_name ?>][]" type="checkbox" />&nbsp;<?= $value['description'] ?>
                </a>
            </li>
        <?php  } ?>
    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </td>
    <script>
        jQuery('#RbacUser_<?= $control_name ?>_all').click(function() {
            $("input[name='RbacUser[<?= $control_name ?>][]']").prop('checked', this.checked);
        });
    </script>
</tr>
</tbody>