<tbody>
<tr>
    <td class=""> <?= Yii::t('app',$grid_title); ?> </td>
    <?= CHtml::activeCheckboxList($user, $control_name,Authitem::model()->getAuthItemDataList($permission),
        array('separator' => '',
            'checkAll' => Yii::t('app','Select All'),
            'template'=>'<td class="permission">{input}</td>'
        )
    );
    ?>
</tr>
</tbody>