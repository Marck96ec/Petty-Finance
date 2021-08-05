<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Petty Cash</h6>
   <!--<a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/Cash_general/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Add Cash General</a>  -->
    <!--<a href="<?php echo site_url('admin/Cash_general/new'); ?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-align-justify fa-sm"></i> Add Cash</a>-->
    <!--<a href="<?php echo site_url('admin/Cron_a/new_auto'); ?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-align-justify fa-sm"></i> Add Cash _Automa</a>-->
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>From</th>
            <th>To</th>
            <th>Balance</th>
            <th>Amount Deposited</th>
            <th>Amount Withdraw</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($cash_general)): foreach($cash_general as $cash_g): ?>
            <tr>
              <td><?php echo $cash_g->id ?></td>
              <td><?php echo date("m/d/Y", strtotime($cash_g->from_cash_general)); ?></td> 
              <td><?php echo date("m/d/Y", strtotime($cash_g->to_cash_general)); ?></td>
              <td><?php 
              if (!$cash_g->balance_cash_general) {
                echo '$0';
              } else {
                echo $cash_g->balance_cash_general;
              }   
               ?></td>
              <td><?php
              if (!$cash_g->amount_deposited) {
                echo '$0';
              } else {
                echo $cash_g->amount_deposited;
              }   
              ?></td>
              <td><?php 
              if (!$cash_g->amount_withdrawn) {
                echo '$0';
              } else {
                echo $cash_g->amount_withdrawn;
              } 
               ?></td>
              <td>
              
                <a href="<?php echo site_url('admin/Cash/detalle/'.$cash_g->id); ?>" 

                <?php if ($cash_g === reset($cash_general)) {  
                echo 'class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-lock-open"></i>';
              } else {
                echo 'class="btn btn-sm btn-success shadow-sm"><i class="fas fa-award"></i>';
              }
              ?>
                
                
                Detail</a>
              
              <div <?php if ($cash_g === reset($cash_general)) {  
                echo '';
              } else {
                echo 'style="display:none"';
              }
              ?>>
              
                <!--<a href="<?php echo site_url('admin/Cash_general/new'); ?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-align-justify fa-sm"></i> Add Cash</a>-->
              </div>
              <!-- <a href="<?php echo site_url('admin/Cash_general/edit/'.$cash_g->id); ?>" class="btn btn-sm btn-info shadow-sm"><i class="fas fa-edit fa-sm"></i> Editar</a> -->
              </td>
            </tr>

            
          <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">There are no transactions, register a transaction.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>