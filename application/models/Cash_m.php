<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_m extends MY_Model {

  protected $_table_name = 'cash';

  public $coin_rules = array(
    
    array(
      'field' => 'date',
      'label' => 'Date',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'description',
      'label' => 'Description',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'charged_to',
      'label' => 'charged_to',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'received_by',
      'label' => 'received_by',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'approved_by',
      'label' => 'approved_by',
      'rules' => 'trim|required'
    )

    
  );

  public function get_new()
  { 
    $Cash_m = new stdClass(); //clase vacia
    $Cash_m->id_cash_general = '';
    $Cash_m->date = '';
    $Cash_m->receipt_no = '';
    $Cash_m->description = '';
    $Cash_m->amount_deposited = '';
    $Cash_m->amount_withdrawn = '';
    $Cash_m->charged_to = '';
    $Cash_m->received_by = '';
    $Cash_m->approved_by = '';

    return $Cash_m;
  }

  public function get_cash()
  {
    $this->db->select("
    l.id,
    date,
    receipt_no,
    l.description,
    amount_deposited,
    amount_withdrawn,
    c.description as charged_to,
    CONCAT(u.first_name,' ',u.last_name) as received_by,
    CONCAT(u.first_name,' ',u.last_name) as approved_by
    
    ");
    $this->db->from('cash l');
    $this->db->join('users u', 'u.id = l.received_by', 'left');
    $this->db->join('users us', 'us.id = l.approved_by', 'left');
    $this->db->join('charged_to c', 'c.id_charged_to = l.charged_to', 'left');

    return $this->db->get()->result(); 
  }

  public function get_cash_id($id_cash_general)
  {
    $this->db->select("
    l.id,
    date,
    receipt_no,
    dc.description,
    amount_deposited,
    amount_withdrawn,
    c.description as charged_to,
    CONCAT(u.first_name,' ',u.last_name) as received_by,
    CONCAT(us.first_name,' ',us.last_name) as approved_by
    
    ");
    $this->db->from('cash l');
    $this->db->where('l.id_cash_general', $id_cash_general);
    $this->db->join('users u', 'u.id = l.received_by', 'left');
    $this->db->join('users us', 'us.id = l.approved_by', 'left');
    $this->db->join('charged_to c', 'c.id_charged_to = l.charged_to', 'left');
    $this->db->join('description_cash dc', 'dc.id = l.description', 'left');

    return $this->db->get()->result(); 
  }

  public function get_cash_general_info($id_cash_general)
  {
    $this->db->select("*");
    $this->db->from('cash_general');
    $this->db->where('id', $id_cash_general);

    return $this->db->get()->row(); 
  }

  
  public function get_charged_to()
  {
    return $this->db->get('charged_to')->result();
  }

  public function get_users()
  {
    return $this->db->get('users')->result();
  }

  public function get_description()
  {
    $this->db->select("*");
    $this->db->from('description_cash');
    $this->db->where('id !=1');

    return $this->db->get()->result(); 
  }

  public function insert_default_open_balance($ulti_id,$date_from,$amount_balance)
  {   
    $null = NULL;
    $data = array(
      'id_cash_general'=> $ulti_id,
      'date'=>$date_from,
      'receipt_no'=>$null,
      'description'=>'1', //Open Balance
      'amount_deposited'=>$amount_balance,
      'amount_withdrawn'=>$null,
      'charged_to'=>'1',
      'received_by'=>$null,
      'approved_by'=>$null
    );
    $qry = $this->db->insert('cash',$data);

    return $qry;      
  }

}

/* End of file User_m.php */
/* Location: ./application/models/User_m.php */