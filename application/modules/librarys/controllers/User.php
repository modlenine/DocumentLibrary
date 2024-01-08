<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->lang->load("english");
        $this->load->model("login/login_model");
        $this->load->model("document/doc_get_model");
    }
    

    public function index()
    {
        check_login();
        $this->load->view('template/tp_head');
        $this->load->view("user/view_user");
        $this->load->view('template/tp_footer');
    }

}

/* End of file Controllername.php */


?>