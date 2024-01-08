<?php
class mylogin {
    public $ci;
    function __construct(){
        $this->ci=& get_instance();
        
    }

    public function get_ci()
    {
        return $this->ci;
    }
}



function lfn(){
    $obj = new mylogin();
    return $obj->get_ci();
}

function check_new_user($username)
{
    $obj = new mylogin();

    $query_check = $obj->get_ci()->db->query("SELECT * FROM dc_user WHERE dc_user_username= '$username' ");
    $checknum = $query_check->num_rows();
    return $checknum;
}


function verify_user()
{
    $obj = new mylogin();
    $obj->get_ci()->load->view("login/verify_user");
}

function get_newuser($username)
{
    $obj = new mylogin();
    $result = $obj->get_ci()->db->query("SELECT * FROM dc_user WHERE dc_user_username='$username' ");
    return $result->row();
}

function get_dept_byuser($user_deptcode)
{
    $obj = new mylogin();
    $result = $obj->get_ci()->db->query("SELECT * FROM dc_dept_main WHERE dc_dept_code='$user_deptcode' ");
    return $result->row();
}


function checkuser_activate()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT dc_user_status FROM dc_user WHERE dc_user_username='".$_SESSION["username"]."' ");
    $result = $query->num_rows();
    if($result < 1){
        $_SESSION['RedirectKe'] = $_SERVER['REQUEST_URI'];

          echo "<h1 style='text-align:center;margin-top:50px;'>กรุณายืนยันการใช้งานโปรแกรม</h1>";
          header("refresh:1; url=".base_url()."login/verify_user");
          die();
    }
}


function check_permission_pinIso($related_code,$doccode)
{
    $obj = new mylogin();
    load_login_model();
    $obj->get_ci()->login_model->check_pin($related_code,$doccode);
}



function loginlog($username)
{
    $obj = new mylogin();
    // insert login log
    $logindata = array(
        "dcuser_loginusername" => $username,
        "dcuser_logindatetime" => date("Y-m-d H:i:s"),
        "dcuser_loginstatus" => "login",
        "dcuser_browser" => $obj->get_ci()->agent->browser(),
        "dcuser_browser_version" => $obj->get_ci()->agent->version(),
        "dcuser_ip" => $obj->get_ci()->input->ip_address(),
        "dcuser_os" => $obj->get_ci()->agent->platform()
      );
      $obj->get_ci()->db->insert("dc_userloginlog" , $logindata);
}

function getUser()
{
    lfn()->load->model("login/login_model" , "login");
    return lfn()->login->getuser();
}




?>