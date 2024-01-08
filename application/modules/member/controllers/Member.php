<?php 
class Member extends MX_Controller{

public function __construct()
{
    parent::__construct();
    //Do your magic here
    $this->load->model("getmember_model","getmember");
}

public function index()
{

}

public function get_member()
{
    check_login();
    $data['get_member'] = $this->getmember->get_member();
    get_head();
    get_contents("list_member",$data);
    get_footer();
}





}
?>