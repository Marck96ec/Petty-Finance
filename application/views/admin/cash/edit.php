<div class="card shadow mb-4">
  <div class="card-header py-3"><?php echo empty($Cash_m->name) ? 'Nuevo Cash ' : 'Editar Cash '; ?> </div>
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
        <div class="form-group col-md-6">
          <input class="form-control" id="inputUsername" type="hidden" name="id_cash_general" 
          value="<?php echo $id_cash_general=$this->session->userdata('id_general_cash')?>" >
        </div> 
      <div class="form-row">
        
        <div class="form-group col-md-6">
          <label class="small mb-1" for="inputUsername">Date</label>
          <input class="form-control" id="inputUsername" type="date" name="date" value="<?php echo set_value('date', $this->input->post('date') ? $this->input->post('date') : $Cash_m->date); ?>"  
          <?php if ($Cash_m->date) {
            echo 'readonly';
          } else {
            echo '';
          }
          ?>>
        </div> 
        <div class="form-group col-md-6">
          <label class="small mb-1" for="inputUsername">Receipt N°.</label>
          <input class="form-control"  id="inputUsername" type="text" name="receipt_no" value="<?php echo set_value('receipt_no', $this->input->post('receipt_no') ? $this->input->post('receipt_no') : $Cash_m->receipt_no); ?>" placeholder="Ejm: ######">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">        
          <label class="small mb-1" for="exampleFormControlSelect2">Description</label>
            <select class="form-control" id="description" name="description" >
              <?php if ($Cash_m->description == 0): ?>
                <option value = "" selected>Select Description</option>
              <?php endif ?>
              <?php foreach ($description_cash as $ds): ?>
                <option value="<?php echo $ds->id ?>" <?php if ($ds->id == $Cash_m->description) echo "selected" ?>><?php echo $ds->description ?></option>
              <?php endforeach ?>
          </select>
        </div> 
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label class="small mb-1" for="inputUsername">Amount Deposited</label>
          <input class="form-control" id="inputUsername" type="text" name="amount_deposited" value="<?php echo set_value('amount_deposited', $this->input->post('amount_deposited') ? $this->input->post('amount_deposited') : $Cash_m->amount_deposited); ?>" placeholder="Ejm: 200">
        </div> 
        <div class="form-group col-md-4">
          <label class="small mb-1" for="inputUsername">Amount With Drawn</label>
          <input class="form-control"  id="inputUsername" type="text" name="amount_withdrawn" value="<?php echo set_value('amount_withdrawn', $this->input->post('amount_withdrawn') ? $this->input->post('amount_withdrawn') : $Cash_m->amount_withdrawn); ?>" placeholder="Ejm: 0">
        </div>
        <div class="form-group col-md-4">
          <label class="small mb-1" for="exampleFormControlSelect2">Select Charged To</label>
          <select class="form-control" id="charged_to" name="charged_to" >
            <?php if ($Cash_m->charged_to == 0): ?>
              <option value = "" selected>Select Charged To</option>
            <?php endif ?>
            <?php foreach ($charged_to as $ct): ?>
              <option value="<?php echo $ct->id_charged_to ?>" <?php if ($ct->id_charged_to == $Cash_m->charged_to) echo "selected" ?>><?php echo $ct->description ?></option>
            <?php endforeach ?>
          </select>
        </div> 
      </div>

   

      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="small mb-1" for="exampleFormControlSelect2">Select Received By</label>
          <select class="form-control" id="received_by" name="received_by">
            <?php if ($Cash_m->received_by == 0): ?>
              <option value = "" selected>Select Received By</option>
            <?php endif ?>
            <?php foreach ($users as $user): ?>
              <option value="<?php echo $user->id ?>" <?php if ($user->id == $Cash_m->received_by) echo "selected" ?>><?php echo $user->first_name.' '.$user->last_name?></option>
            <?php endforeach ?>
          </select>
        </div> 
        <div class="form-group col-md-6">
        <label class="small mb-1" for="exampleFormControlSelect2">Select Approved By</label>
          <select class="form-control" id="approved_by" name="approved_by"  
          <?php if ($Cash_m->date) {
            echo 'style="pointer-events: none;" readonly';
          } else {
            echo '';
          }
          ?>>
            <?php if ($Cash_m->approved_by == 0): ?>
              <option value = "" selected>Select Approved By</option>
            <?php endif ?>
            <?php foreach ($users as $user): ?>
              <option value="<?php echo $user->id ?>" <?php if ($user->id == $Cash_m->approved_by) echo "selected" ?>><?php echo $user->first_name.' '.$user->last_name?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      

      <button class="btn btn-primary" type="submit">Registrar Cash </button>

      <a href="<?php echo site_url('admin/Cash/detalle/'.$id = $this->session->userdata('id_general_cash')); ?>" class="btn btn-dark">Cancelar</a>
      
      <?php echo form_close() ?>
    </div>
  </div>