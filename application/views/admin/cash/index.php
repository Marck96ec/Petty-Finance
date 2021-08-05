<?php if ($this->session->flashdata('msg')): ?>
  <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
    <?= $this->session->flashdata('msg') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif ?>

<div class="card shadow mb-4">
  <div  class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
    
      <div <?php if ($cash_general_info->status == 1) {
        echo 'style="display:none"';
      } else {
        echo '';
      }
      ?> >
        <a  class="d-sm-inline-block btn btn-sm btn-success shadow-sm"  href="<?php echo site_url('admin/Cash/new/'.$id_cash); ?>" ><i class="fas fa-plus-circle fa-sm"></i> Add Transaction</a>
      </div>
  </div>
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <div class="form-row">
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">From</label>
        <input class="form-control" id="credit_amount" type="text" disabled="" value="<?php echo date("m/d/Y", strtotime($cash_general_info->from_cash_general));?>">
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">To</label>
        <input class="form-control" id="payment_m" type="text" disabled="" value="<?php echo date("m/d/Y", strtotime($cash_general_info->to_cash_general));?>">
      </div>
    </div>
  </div>
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <div class="form-row">
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Balance</label>
        <input class="form-control" id="coin" name="coin" type="text" readonly="" value="<?php echo $cash_general_info->balance_cash_general?>">
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Amount Deposited</label>
        <input class="form-control" id="coin" name="coin" type="text" readonly="" value="<?php echo $cash_general_info->amount_deposited?>">
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Amount Withdrawn</label>
        <input class="form-control" id="coin" name="coin" type="text" readonly="" value="<?php echo $cash_general_info->amount_withdrawn?>">
      </div>
    </div>
  </div>
  <div class="card-body">
    <input type="hidden" value="<?php echo $id_cash?>">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Receipt N°.</th>
            <th>Description</th>
            <th>Amount Deposited</th>
            <th>Amount Withdrawn</th>
            <th>Charged To</th>
            <th>Received By</th>
            <th>Approved By</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=count($cash)+1; if(count($cash)): foreach($cash as $cash_u): ?>
            <tr>
            <td><?php $i--; echo $i; ?></td>
              <td><?php echo date("m/d/Y", strtotime($cash_u->date)) ?></td>
              <td><?php 
              if (!$cash_u->receipt_no) { 
                echo 'N/A';
              } else {
                echo $cash_u->receipt_no;
              }           
               ?></td>
              <td><?php echo $cash_u->description ?></td>
              <td><?php
              if (!$cash_u->amount_deposited) {
                echo ' ';
              } else {
                echo '$ '.$cash_u->amount_deposited;
              }
                ?></td>
              <td><?php
              if (!$cash_u->amount_withdrawn) {
                echo ' ';
              } else {
                echo '$ '. $cash_u->amount_withdrawn;
              }
               ?></td>
              <td><?php echo $cash_u->charged_to ?></td>
              <td>
              <?php 
              if (!$cash_u->received_by) { 
                echo 'N/A';
              } else {
                echo $cash_u->received_by;
              }           
               ?>  
              </td>
              <td>
              <?php 
              if (!$cash_u->approved_by) { 
                echo 'N/A';
              } else {
                echo $cash_u->approved_by;
              }           
               ?>  
              </td>
              <td>
              <div <?php if ($cash_u === end($cash) || $cash_general_info->status == 1) {  
                echo 'style="display:none"';
              } else {
                echo '';
              }
              ?>>
                <a href="<?php echo site_url('admin/Cash/edit/'.$cash_u->id); ?>" class="btn btn-sm btn-info shadow-sm"><i class="fas fa-edit fa-sm"></i> Edit</a>
              </div>
              </td>
            </tr>

            
          <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">There are no transactions, register a new transaction.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>