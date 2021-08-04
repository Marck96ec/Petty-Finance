<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charged_to_m extends MY_Model {

  

  public function insert_new_charged_to($data)
  {   
    $qry = $this->db->insert('charged_to',$data);
    return $qry;      
  }

  public function search_charged_to($id_charged_to)
  {
    $this->db->select("*");
    $this->db->from('charged_to');
    $this->db->where('description', $id_charged_to);
    return $this->db->get()->row(); 
  }
}
