<?php
//$model = Category::model()->findAll();

$arr = Category::model()->buildTree($model);

//print_r($arr);

// print_r(Category::model()->buildOptions($arr,null));
?>
<option value="">--Choose Parent--</option>
<!-- <?php foreach($model as $key=>$value):?>
    <?php if($cid==$value['id']):?>
        <option value="<?=$value['id']?>" selected><?=$value['name']?></option>
    <?php else:?>
        <option value="<?=$value['id']?>"><?=$value['name']?></option>    
    <?php endif;?>
<?php endforeach;?> -->
    <?=Category::model()->buildOptions($arr,$cid)?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup>