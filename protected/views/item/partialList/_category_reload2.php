<option value="0">--Choose Parent--</option>
<?php foreach($model as $key=>$value):?>
    <?php if($cid==$value['id']):?>
        <option value="<?=$value['id']?>" selected><?=$value['name']?></option>
    <?php else:?>
        <option value="<?=$value['id']?>"><?=$value['name']?></option>    
    <?php endif;?>
<?php endforeach;?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup>