<div class="card shadow mb-4">
  <div class="card-header py-3"><?php echo empty($cash_general->name) ? 'Nuevo Cash General' : 'Editar Cash General'; ?> </div>
  <div class="card-body">
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo validation_errors('<li>', '</li>'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php } ?> 
      
      <?php echo form_open(); ?>
      
      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="small mb-1" for="inputUsername">From</label>
          <input class="form-control" id="inputUsername" type="text" name="from_cash_general" value="<?php echo set_value('from_cash_general', date('Y-m-d',$datauno) ? date('Y-m-d',$datauno) : $cash_general->from_cash_general); ?>" placeholder="Ejm: mm/dd/aaaa">
        </div> 
        <div class="form-group col-md-6">
          <label class="small mb-1" for="inputUsername">To</label>
          <input class="form-control"  id="inputUsername" type="text" name="to_cash_general" value="<?php echo set_value('to_cash_general', date('Y-m-d',$dataocho) ? date('Y-m-d',$dataocho) : $cash_general->to_cash_general); ?>" placeholder="Ejm: mm/dd/aaaa">
        </div>
      </div>

      

      <button class="btn btn-primary" type="submit">Registrar Cash General</button>
      <a href="<?php echo site_url('admin/Cash_general/'); ?>" class="btn btn-dark">Cancelar</a>
      
      <?php echo form_close() ?>
    </div>
  </div>