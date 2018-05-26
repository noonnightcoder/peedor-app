<?php
$arr = Category::model()->buildTree($model);
?>
<?=Category::model()->buildOptions($arr,$cid)?>
<optgroup >
    <option value="addnew">
        Create New
    </option>
</optgroup>