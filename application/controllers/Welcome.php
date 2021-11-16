<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->helper('security');
        $this->load->library('form_validation');
    }
    public function index() {
        $this->load->view('welcome_message');
    }
    public function action() {
        if ($this->input->post('data_action')) {
            $data_action = $this->input->post('data_action');

            if ($data_action == 'fetch_all') {
                // echo "string";exit;
                $result = $this->welcome_model->fetch_all();
                // debug($result);exit;
                
                $output = '';
                if (count($result) > 0) {
                    $i=1;
                    foreach ($result as $row) {
                        $output.='
                                <tr>
                                    <td>'.$i.'</td>
                                    <td>'.$row->customer_name.'</td>
                                    <td>'.$row->address.'</td>
                                    <td>'.$row->postalcode.'</td>
                                    <td>'.$row->order_quantity.'</td>
                                    <td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id.'">Edit</button>
                                    <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id.'">Delete</button></td></td>
                                </tr>
                        ';
                        $i++;
                    }
                }
                else{
                    $output.= '
                        <tr>
                            <td colspan="6" align="center">No data found</td>
                        </tr>
                    ';
                }
                echo $output;
            }

            // Insert & Update
            if ($data_action == 'Insert' || $data_action == 'Update') {
                // debug($this->input->post());exit;
                $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
                $this->form_validation->set_rules('postalcode', 'Postal Code', 'trim|required|xss_clean');
                
                if ($this->form_validation->run()) {
                    
                    $origin = $this->input->post('id');
                    // debug($origin);exit;
                    if ($origin) {
                        $data = array('id' => $origin, 'customer_name' => $this->input->post('customer_name'), 'address' => $this->input->post('address'), 'postalcode' => $this->input->post('postalcode'), 'city' => $this->input->post('city'), 'order_quantity' => $this->input->post('order_quantity'), 'trade_mark' => $this->input->post('trade_mark'));
                        $this->welcome_model->update_customer($data);
                    	$array = array('success' => true, 'msg' => 'Data Updated');
                    } else {   
                        $data = array('customer_name' => $this->input->post('customer_name'), 'address' => $this->input->post('address'), 'postalcode' => $this->input->post('postalcode'), 'city' => $this->input->post('city'), 'order_quantity' => $this->input->post('order_quantity'), 'trade_mark' => $this->input->post('trade_mark'));
                        $this->welcome_model->insert_customer($data);
                        $array = array('success' => true, 'msg' => 'Data Inserted');
                    }
                } else {
                    $array = array('error' => true, 'customer_name_error' => form_error('customer_name'), 'address_error' => form_error('address'), 'postalcode_error' => form_error('postalcode'), 'order_quantity_error' => form_error('order_quantity'));
                }
                echo json_encode($array);
            }

            // Fetch Single User Data
            if ($data_action == 'fetch_single_user_data') {
                $origin = $this->input->post('origin');
                $result = $this->welcome_model->fetch_single_user_data($origin);
                // debug($result);exit;
                echo json_encode($result[0]);
            }

            // Delete
			if ($data_action == 'Delete') {
				$origin = $this->input->post('origin');
				$result = $this->welcome_model->delete_customer($origin);
				if ($result) {
					$array=array('success'=>true,'msg'=>'Deleted');
				}
				else{
					$array=array('error'=>true);
				}
				echo json_encode($array);
					}
        }
    }
}
