<tbody>
    <tr>
        <?php $this->renderPartial('_grid_crud', array('title' => $row_title, 'permission' => 'item' )) ?>
        <?php $this->renderPartial('_grid_more'); ?>
    </tr>
</tbody>