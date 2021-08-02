<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_general_m extends MY_Model {

  protected $_table_name = 'cash_general';

  public $coin_rules = array(
    array(
      'field' => 'from_cash_general',
      'label' => 'From',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'to_cash_general',
      'label' => 'To',
      'rules' => 'trim|required'
    )
  );

  public function get_new()
  {
    $cash_general = new stdClass(); //clase vacia
    $cash_general->from_cash_general = '';
    $cash_general->to_cash_general = '';
    $cash_general->balance_cash_general = '';
    $cash_general->amount_deposited = '';
    $cash_general->amount_withdrawn = '';

    return $cash_general;
  }
   
   public function update_cash_general($data, $id_cash_general){
      $query = $this->db
      ->where('id',$id_cash_general)
      ->update('cash_general',$data);
    return $query;
   }

   public function get_cash_general_id()
  {
    $this->db->select("*");
    $this->db->from('cash_general');
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->row(); 
  }

  public function get_cash_general_id_search($id)
  {
    $this->db->select("*");
    $this->db->from('cash_general');
    $this->db->where('id', $id);
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->row(); 
  }

}

/* End of file User_m.php */
/* Location: ./application/models/User_m.php */