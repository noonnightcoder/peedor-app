<?php

$model = Category::model()->findAll();

$arr = Category::model()->buildTree($model);

print_r($arr);

echo Category::model()->buildOptions($arr,null);
