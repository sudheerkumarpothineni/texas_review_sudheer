<?php
/**
 * 
 */
class Welcome_model extends CI_Model
{
	public function insert_customer($data){

		// debug($data);exit;
		$insert_multiple = "CALL insert_multiple(?, ?, ?, ?, ?, ?)";
        $result = $this->db->query($insert_multiple, $data);
        if ($result) {
            return $result;
        }
	}

	public function fetch_single_user_data($origin){
		$get_single_customer = "CALL get_single_customer(?)";
		$data = array('id' => $origin);
        $query = $this->db->query($get_single_customer, $data);
        if ($query) {
            return $query->result();
        }
	}

	public function update_customer($data){
		$update_multiple = "CALL update_multiple(?, ?, ?, ?, ?, ?, ?)";
        $result = $this->db->query($update_multiple, $data);
        // debug($result);exit;
        if ($result) {
            return $result;
        }
	}

	public function delete_customer($origin){
		$delete_multiple = "CALL delete_multiple(?)";
        $data = array('id' => $origin);
        $result = $this->db->query($delete_multiple, $data);
		// debug($result);exit;
        if ($result) {
            return $result;
        }
	}

	public function fetch_all(){
		$get_customers = "CALL get_customers()";
        $query = $this->db->query($get_customers);
        // debug($query);exit;
        if ($query) {
            return $query->result();
        }
	}
	
}
?>