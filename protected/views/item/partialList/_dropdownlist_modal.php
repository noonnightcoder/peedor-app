<select class="form-control" id="db-brand" name="Item[brand_id]" onchange="showDialog(event.target.value)">
    <option value=""></option>
    <?php foreach($data as $key=>$value):?>

        <option value="<?=$value['id']?>" <?php echo $id==$value['id'] ? 'selected' : ''?>><?=$value['name']?></option>
    <?php endforeach;?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup >
</select>

<!-- Modal -->
<div class="modal fade" id="<?=$modal?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('<?=$list?>').value=''" aria-label="Close">
          &times;
        </button>
        <h5 class="modal-title" id="exampleModalLabel"><?=$title?></h5>
      </div>
      <div class="modal-body">
        <?php echo CHtml::label('Name', 1, array('class' => 'control-label')); ?>
        <?php echo CHtml::TextField('Name','',array('class'=>'form-control','id'=>$name));?>
        <span id="error" class="errorMsg"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('<?=$list?>').value=''" data-dismiss="modal">Close</button>
        <button type="button" id='<?=$btnSave?>' class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

