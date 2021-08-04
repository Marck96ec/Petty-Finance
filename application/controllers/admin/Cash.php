<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Description_cash_m');
    $this->load->model('Charged_to_m');
    $this->load->model('Cash_m');
    $this->load->model('Cash_general_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['cash'] = $this->Cash_m->get_cash(); 
    $data['subview'] = 'admin/cash/index';
    $this->load->view('admin/_main_layout', $data); 
  }

  public function add_description_cash()
  {
    if(isset($_POST["description_name"]))
    {
      $category_name = $_POST["description_name"];
      $result_exist = $this->Description_cash_m->search_description_cash($category_name);
      //echo json_encode($result_exist);
      if (!$result_exist) {
        $data = array(
          'description'	=>	$category_name
        );
        $this->Description_cash_m->insert_new_description($data);
        $ultimoId = $this->db->insert_id();
        $data=array(
          'ultimoId'=>$ultimoId,
          'resp'=>'yes'    
        );
        echo json_encode($data);
      } else {
        $data=array(
          'resp'=>'no'
        );
        echo json_encode($data);
      }    
    }
  }

  public function add_charged_to()
  {
    if(isset($_POST["charged_to_name"]))
    {
      $charged_to = $_POST["charged_to_name"];
      $result_exist = $this->Charged_to_m->search_charged_to($charged_to);
      //echo json_encode($result_exist);
      if (!$result_exist) {
        $data = array(
          'description'	=>	$charged_to
        );
        $this->Charged_to_m->insert_new_charged_to($data);
        $ultimoId = $this->db->insert_id();
        $data=array(
          'ultimoId'=>$ultimoId,
          'resp'=>'yes'    
        );
        echo json_encode($data);
      } else {
        $data=array(
          'resp'=>'no'
        );
        echo json_encode($data);
      }  
    }
  }


  public function detalle($id)
  {
    $this->session->set_userdata('id_general_cash',$id); 
    $data['id_cash'] = $id;
    $data['cash_general_info'] = $this->Cash_m->get_cash_general_info($id);
    $data['cash'] = $this->Cash_m->get_cash_id($id);
    $data['subview'] = 'admin/cash/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit($id = NULL)
  {
    if ($id) {

      $data['Cash_m'] = $this->Cash_m->get($id);
    } else {
      $data['Cash_m'] = $this->Cash_m->get_new();
    }

    $data['charged_to'] = $this->Cash_m->get_charged_to();
    $data['users'] = $this->Cash_m->get_users();
    $data['description_cash'] = $this->Cash_m->get_description();

    $rules = $this->Cash_m->coin_rules;
   
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == TRUE) {

      $Cash_m_data = $this->Cash_m->array_from_post(['id_cash_general','date','receipt_no', 'description', 'amount_deposited', 'amount_withdrawn','charged_to','received_by','approved_by']);
      $object = (object)$Cash_m_data;

      $id_cash_general = $this->session->userdata('id_general_cash');
      $cash_g_info= $this->Cash_m->get_cash_general_info($id_cash_general);
      //+++++++++++++++++++++++++++
      $a_amount_deposited = $data['Cash_m']->amount_deposited;//250
      $a_amount_withdrawn = $data['Cash_m']->amount_withdrawn;//10
      
      $new_amount_deposited = floatval($object->amount_deposited);//250
      $new_amount_withdrawn = floatval($object->amount_withdrawn);//100
      
      //update de general cash ++++++++++++++++++++++++
      $amount_deposited = $cash_g_info->amount_deposited; //250
      $amount_withdraw = $cash_g_info->amount_withdrawn; //30

      $balance =  ( $amount_deposited -  $amount_withdraw);

      if ($a_amount_withdrawn == $new_amount_withdrawn) {
        $amount_withdraw = $amount_withdraw; //30
      } else {
        $amount_withdraw = ($amount_withdraw-$a_amount_withdrawn) + $new_amount_withdrawn ;
        $balance =  ( $amount_deposited -  $amount_withdraw);
      }

      if ($a_amount_deposited == $new_amount_deposited) {
        $amount_deposited = $amount_deposited; //250
      } else {
        $amount_deposited = ($amount_deposited-$a_amount_deposited) + $new_amount_deposited ;
        $balance =  ( $amount_deposited -  $amount_withdraw);
      }
      
     
      //$balance = $cash_g_info->balance_cash_general;

      

			$data = array(
				'balance_cash_general'=>$balance,
				'amount_deposited' => $amount_deposited,
				'amount_withdrawn' => $amount_withdraw
			);
 
      $result = $this->Cash_general_m->update_cash_general($data, $id_cash_general);
      //var_dump($id_cash_general);die();
      //**************************** */
      $this->Cash_m->save($Cash_m_data, $id);

      if ($id) {
        $this->session->set_flashdata('msg', 'Cash General editado correctamente');
      } else {
        $this->session->set_flashdata('msg', 'Cash General agregado correctamente');
      }
      

      redirect('admin/cash/detalle/'.$id_cash_general);

    }

    $data['subview'] = 'admin/cash/edit';
    $this->load->view('admin/_main_layout', $data);
  } 

  public function new($id_cash_general)
  { 
    $id_cash_general = $this->session->userdata('id_general_cash');
    $data['id_cash_general'] = $id_cash_general;
    $cash_g_info= $this->Cash_m->get_cash_general_info($id_cash_general);
    $data['from_cash_general'] = $cash_g_info->from_cash_general;
    $data['to_cash_general'] = $cash_g_info->to_cash_general;

    $data['Cash_m'] = $this->Cash_m->get_new();

    $data['charged_to'] = $this->Cash_m->get_charged_to();
    $data['users'] = $this->Cash_m->get_users();
    $data['description_cash'] = $this->Cash_m->get_description();
    

    $rules = $this->Cash_m->coin_rules;
   
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == TRUE) {

      $Cash_m_data = $this->Cash_m->array_from_post(['id_cash_general','date','receipt_no', 'description', 'amount_deposited', 'amount_withdrawn','charged_to','received_by','approved_by']);
      $object = (object)$Cash_m_data;

      //var_dump($Cash_m_data);die();
      //update de general cash ++++++++++++++++++++++++
     
      $cash_g_info= $this->Cash_m->get_cash_general_info($id_cash_general);
  
			$amount_deposited = floatval($cash_g_info->amount_deposited);
      $amount_withdraw = $cash_g_info->amount_withdrawn;
      $balance = $cash_g_info->balance_cash_general;

      $amount_deposited =$amount_deposited + floatval($object->amount_deposited);
      $amount_withdraw = $amount_withdraw + floatval($object->amount_withdrawn);
      $balance = $balance + (floatval($object->amount_deposited) - floatval($object->amount_withdrawn));

			$data = array(
				'balance_cash_general'=>$balance,
				'amount_deposited' => $amount_deposited,
				'amount_withdrawn' => $amount_withdraw
			);
      

      //var_dump($data);die();
      $this->Cash_general_m->update_cash_general($data, $id_cash_general);
      $this->Cash_m->save($Cash_m_data);
      $this->session->set_flashdata('msg', 'Cash agregado correctamente');

      redirect('admin/cash/detalle/'.$id_cash_general);

    }

    $data['subview'] = 'admin/cash/edit';
    $this->load->view('admin/_main_layout', $data); 
  }

}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */