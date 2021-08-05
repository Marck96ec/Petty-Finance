<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Description_cash_m extends MY_Model {

  

  public function insert_new_description($data)
  {   
    $qry = $this->db->insert('description_cash',$data);
    return $qry;      
  }

  public function search_description_cash($id_cash_general)
  {
    $this->db->select("*");
    $this->db->from('description_cash');
    $this->db->where('description', $id_cash_general);
    return $this->db->get()->row(); 
  }
}
