<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('teachers');
	}


    public function processTeachers()
    {
        $name=$this->input->post('firstname',true);
        $gender=$this->input->post('gender',true);
        $lang_speak=$this->input->post('speak',true);
        $lang_read=$this->input->post('read',true);
        $lang_write=$this->input->post('write',true);
        $res_addr=$this->input->post('res_addr',true);
        /** Qualification part */
        $highschool=$this->input->post('highschool',true);

        $highschool_arr=array(
          'main_subjects'=>$highschool[0],
          'school'=>$highschool[1],
          'board'=>$highschool[2],
          'year_of_passing'=>$highschool[3],
          'per_of_marks'=>$highschool[4],
          'division'=>$highschool[5]
        );

        $lang_speak_arr=array(
          $lang_speak[0],
          $lang_speak[1],
          $lang_speak[2]
        );

        $lang_read_arr=array(
          $lang_read[0],
          $lang_read[1],
          $lang_read[2]
        );

        $lang_write_arr=array(
          $lang_write[0],
          $lang_write[1],
          $lang_write[2]
        );

        $res_addr_arr=array(
            'doorno'=>$res_addr[0],
            'street'=>$res_addr[1],
            'district'=>$res_addr[2],
            'city'=>$res_addr[3],
            'state'=>$res_addr[4],
            'pin'=>$res_addr[5],
            'tel_no'=>$res_addr[6]
        );

        $this->load->model('user_model');
        $insert_array=array(
            'first_name'=>$name,
            'gender'=>$gender,
            'details_highschool'=>json_encode($highschool_arr),
            'lang_speak'=>json_encode($lang_speak_arr),
            'lang_read'=>json_encode($lang_read_arr),
            'lang_write'=>json_encode($lang_write_arr),
            'resident_address'=>json_encode($res_addr_arr)
        );

        $iid=$this->user_model->insertCommon('teacher_admission',$insert_array);
        if($iid>0){
            $result['status']="success";
            $result['message']="form submitted";
        }else{
            $result['status']="failed";
            $result['message']="form not submitted";
        }
        die(json_encode($result));
	}

    public function selectTeachers()
    {
        $this->load->model('user_model');
        $id=$this->input->get('id',true);
        $result=$this->user_model->selectCommon('teacher_admission',array('details_highschool'),array('staff_id'=>$id));
        print_r($result->result('array'));
	}

}
