<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          &times;
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Create Supplier</h5>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <?php echo CHtml::label('Company Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control','id'=>'Supplier_Name'));?>
              <span id="error" class="errorMsg"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <?php echo CHtml::label('First Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control','id'=>'Supplier_First_Name'));?>
              <span id="error" class="errorMsg"></span>
            </div>
            <div class="col-sm-6">
              <?php echo CHtml::label('Last Name', 1, array('class' => 'control-label')); ?>
              <?php echo CHtml::TextField('Supplier','',array('class'=>'form-control','id'=>'Supplier_Last_Name'));?>
              <span id="error" class="errorMsg"></span>
            </div>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="saveSupplier()" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>