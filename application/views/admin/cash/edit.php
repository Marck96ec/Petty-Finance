<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>  	<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="card shadow mb-4">
  <div class="card-header py-3"><?php echo empty($Cash_m->name) ? 'New Transactions ' : 'Edit Transactions '; ?> </div>
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
          <input class="form-control" id="inputUsername" type="date" name="date" value="<?php echo set_value('date', $this->input->post('date') ? $this->input->post('date') : $Cash_m->date );  ?>"  
          <?php if ($Cash_m->date) { 
            echo 'readonly';
          } else {
            echo '';
          }
          ?> 
          min="<?php  if(isset($from_cash_general)){echo $from_cash_general;}else{ echo '';}?>" 
          max="<?php if(isset($to_cash_general)){echo $to_cash_general;}else{ echo '';} ?>"
          placeholder="mm-dd-yyyy">
        </div> 
        <div class="form-group col-md-6">
          <label class="small mb-1" for="inputUsername">Receipt N°.</label>
          <input class="form-control"  id="inputUsername" type="text" name="receipt_no" value="<?php echo set_value('receipt_no', $this->input->post('receipt_no') ? $this->input->post('receipt_no') : $Cash_m->receipt_no); ?>" placeholder="Ejm: ######">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">        
          <label class="small mb-1" for="exampleFormControlSelect2">Description</label>
            <select  id="description" name="description" class="form-control form-control-lg select2 selectdescription">
              <?php if ($Cash_m->description == 0): ?>
                <option value = "" selected></option>
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
          <input class="form-control decimales" id="inputUsername" type="text" name="amount_deposited" value="<?php echo set_value('amount_deposited', $this->input->post('amount_deposited') ? $this->input->post('amount_deposited') : $Cash_m->amount_deposited); ?>" placeholder="Ejm: 200">
        </div> 
        <div class="form-group col-md-4">
          <label class="small mb-1" for="inputUsername">Amount Withdrawn</label>
          <input class="form-control decimales"  id="inputUsername" type="text" name="amount_withdrawn" value="<?php echo set_value('amount_withdrawn', $this->input->post('amount_withdrawn') ? $this->input->post('amount_withdrawn') : $Cash_m->amount_withdrawn); ?>" placeholder="Ejm: 0">
        </div>
        <div class="form-group col-md-4">
          <label class="small mb-1" for="exampleFormControlSelect2">Charged To</label>
          <select class="form-control select2" id="charged_to" name="charged_to" >
            <?php if ($Cash_m->charged_to == 0): ?>
              <option value = "" selected></option>
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
          <select class="form-control " id="received_by" name="received_by">
            <?php if ($Cash_m->received_by == 0): ?>
              <option value = "" selected>Select Received By</option>
            <?php endif ?>
            <?php foreach ($users as $user): ?>
              <?php if ($user->f_reveived_by == 1): ?>
                <option value="<?php echo $user->id ?>" <?php if ($user->id == $Cash_m->received_by) echo "selected" ?>><?php echo $user->first_name.' '.$user->last_name?></option>
              <?php endif ?>
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
              <?php if ($user->f_approved_by == 1): ?>
                <option value="<?php echo $user->id ?>" <?php if ($user->id == $Cash_m->approved_by) echo "selected" ?>><?php echo $user->first_name.' '.$user->last_name?></option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <button class="btn btn-primary" type="submit">Register </button>

      <a href="<?php echo site_url('admin/Cash/detalle/'.$id = $this->session->userdata('id_general_cash')); ?>" class="btn btn-dark">Cancel</a>
      
      <?php echo form_close() ?>
    </div>
  </div>

 
  <script>
$('#description').select2({
    placeholder:'Description',
    tags:true,
  }).on('select2:close', function(){
    var element = $(this);
    var new_description = $('#description option:selected').text();
    //console.log(new_description);
    if(new_description != '')
    {

      $.ajax({
        type: 'POST',
        dataType: 'json', 
        url: '<?php echo site_url() ?>admin/Cash/add_description_cash',  
        data: { 'description_name': new_description },
        success:function(res)
        {
          console.log(res);
          //element.val(null).trigger('change');
          if(res.resp == 'yes')
          {
            //alert(res);
            element.append('<option value="'+res.ultimoId+'" selected>'+new_description+'</option>').prop('selected',true);
            
          }
        }
      })
    }

  });


  $('#charged_to').select2({
    placeholder:'Charged To',
    tags:true,
  }).on('select2:close', function(){
    var element = $(this);
    var new_add_charged_to = $('#charged_to option:selected').text();
    console.log(new_add_charged_to);
    if(new_add_charged_to != '')
    {
     //alert(new_add_charged_to);
      $.ajax({
        type: 'POST',
        dataType: 'json', 
        url: '<?php echo site_url() ?>admin/Cash/add_charged_to',  
        data: { 'charged_to_name': new_add_charged_to },
        success:function(res)
        {
          console.log(res);
          //element.val(null).trigger('change');
          if(res.resp == 'yes')
          {
            //alert(res);
            element.append('<option value="'+res.ultimoId+'" selected>'+new_add_charged_to+'</option>').prop('selected',true);
            
          }
        }
      })
    }

  });

  $('.decimales').on('input', function () {
  this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});
</script>