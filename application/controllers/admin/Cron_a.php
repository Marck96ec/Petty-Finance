<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Guayaquil');
class Cron_a extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Cash_general_m');
    $this->load->model('Cash_m');
    $this->load->library('form_validation'); 
    $this->load->library('session');
  }

  public function new_auto()
  {

    $dataud =$this->Cash_general_m->get_cash_general_id();
    //echo "<pre>";var_dump($dataud);die();
    $from_cash_general = $dataud->from_cash_general;
    $to_cash_general = $dataud->to_cash_general;
    $balance_cash_general = $dataud->balance_cash_general;
    $amount_deposited = $dataud->amount_deposited;
    $amount_withdrawn = $dataud->amount_withdrawn;

    $a_from_cash_general= date("Y-m-d",strtotime($to_cash_general."+ 1 days"));
    $a_to_cash_general= date("Y-m-d",strtotime($to_cash_general."+ 8 days"));
    
    $result_insert = $this->Cash_general_m->insert_auto_new_g($a_from_cash_general,$a_to_cash_general);
    // insetar valor dentro de valor general
    
    $ultimo_id = $this->db->insert_id();

    $row_ante_ult = $this->Cash_general_m->get_cash_general_id_search($ultimo_id-1);
    //inserta primer balance
    $resultado =$this->Cash_m->insert_default_open_balance($ultimo_id,$a_from_cash_general,$balance_cash_general);

   // var_dump($resultado);die();
    $data = array(
      'balance_cash_general'=>$balance_cash_general,
      'amount_deposited' => $balance_cash_general
    );

    $this->Cash_general_m->update_cash_general($data, $ultimo_id);
    $data_block = array(
      'status'=>1
    );
    $this->Cash_general_m->update_cash_general($data_block, $ultimo_id-1);
    $this->session->set_flashdata('msg', 'Cash General agregado correctamente');
    
   // var_dump($ultimo_id);die();
    
    echo 'se ejecuto'. PHP_EOL;
    //echo "<pre>";var_dump($ultimoId);die();   
  }

}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */