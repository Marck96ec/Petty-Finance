<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Guayaquil');
class Cash_general extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Cash_general_m');
    $this->load->model('Cash_m');
    $this->load->library('form_validation'); 
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['cash_general'] = $this->Cash_general_m->get();
    $data['subview'] = 'admin/cash_general/index';

    $this->load->view('admin/_main_layout', $data);
  }

  public function edit($id = NULL)
  {
    if ($id) {
      $data['cash_general'] = $this->Cash_general_m->get($id);
    } else {
      $data['cash_general'] = $this->Cash_general_m->get_new();
    }

    $rules = $this->Cash_general_m->coin_rules;
   
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == TRUE) {

      $Cash_general_data = $this->Cash_general_m->array_from_post(['from_cash_general','to_cash_general', 'balance_cash_general', 'amount_deposited', 'amount_withdrawn']);
      
      $this->Cash_general_m->save($Cash_general_data, $id);

      if ($id) {
        $this->session->set_flashdata('msg', 'Cash General editado correctamente');
      } else {
        $this->session->set_flashdata('msg', 'Cash General agregado correctamente');
      }
      
      redirect('admin/Cash_general');

    }

    $data['subview'] = 'admin/cash_general/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  public function new()
  {
 
      $data['cash_general'] = $this->Cash_general_m->get_new();

    $rules = $this->Cash_general_m->coin_rules;
   
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == TRUE) {

      $Cash_general_data = $this->Cash_general_m->array_from_post(['from_cash_general','to_cash_general', 'balance_cash_general', 'amount_deposited', 'amount_withdrawn']);
      
      $object = (object)$Cash_general_data;

      $ultimo_id = $this->Cash_general_m->save($Cash_general_data);

      
      $row_ante_ult = $this->Cash_general_m->get_cash_general_id_search($ultimo_id-1);
      //inserta primer balance
      $this->Cash_m->insert_default_open_balance($ultimo_id,$object->from_cash_general,$row_ante_ult->balance_cash_general);

      $data = array(
				'balance_cash_general'=>$row_ante_ult->balance_cash_general,
				'amount_deposited' => $row_ante_ult->balance_cash_general
			);
      $this->Cash_general_m->update_cash_general($data, $ultimo_id);
      $data_block = array(
				'status'=>1
			);
      $this->Cash_general_m->update_cash_general($data_block, $ultimo_id-1);
      $this->session->set_flashdata('msg', 'Cash General agregado correctamente');
      
     // var_dump($ultimo_id);die();
      
      redirect('admin/Cash_general');

    }
    $dataud =$this->Cash_general_m->get_cash_general_id();
    $data['dataud']= $dataud;
    $data['datauno']= strtotime($dataud->to_cash_general."+ 1 days");
    $data['dataocho'] = strtotime($dataud->to_cash_general."+ 8 days");
    $data['subview'] = 'admin/cash_general/edit';
    $this->load->view('admin/_main_layout', $data);
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
    
    redirect('admin/Cash_general');
    //echo "<pre>";var_dump($ultimoId);die();



    
  }
 

}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */