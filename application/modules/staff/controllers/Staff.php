<?php

class Staff extends MX_Controller{

    

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->lang->load("english");
        $this->load->model("login/login_model");
        $this->load->model("document/doc_get_model");
        $this->load->model("staff/get_staff_model");
        $this->load->model("staff/add_staff_model");
        $this->load->model('librarys/get_lib_model');
    }


    public function index()
    {
        redirect('staff/admin_iso_list');
    }

    public function admin_iso_list()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['get_doc_list'] = $this->get_staff_model->get_doc_list();
        get_head();
        get_contents("index",$data);
        get_footer();
    }

    public function gl()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['get_doc_list'] = $this->get_staff_model->get_doc_list();
        get_head();
        get_contents("gl",$data);
        get_footer();
    }

    public function view_full_data($doccode)
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['view_full_data'] = $this->get_staff_model->view_full_data($doccode);
        get_head();
        get_contents("view_full_data",$data);
        get_footer();

    }


    public function manage_dept()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['get_dept'] = $this->get_staff_model->get_dept();
        get_head();
        get_contents("manage_dept",$data);
        get_footer();
    }


    public function save_dept()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $this->get_staff_model->save_dept();
    }


    public function del_dept($gl_dept_id)
    {
        check_login();
        checkuser_activate();
        check_permis();
        $result = get_del("gl_dept_id",$gl_dept_id,"gl_department");
        if(!$result)
        {
            echo "<script>";
            echo "alert('ลบข้อมูลไม่สำเร็จ')";
            echo "window.history.back(-1)";
            echo "</script>";
        }else{
            echo "<script>";
            echo "alert('ลบข้อมูลสำเร็จ')";
            echo "</script>";
            header("refresh:0; url=".base_url('staff/manage_dept'));
        }
    }


    public function select_dept($gl_dept_id)
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['select_dept'] = $this->get_staff_model->select_dept($gl_dept_id);
        $data['get_folder'] = $this->get_staff_model->get_folder($gl_dept_id);
        get_head();
        get_contents("select_dept",$data);
        get_footer();
    }


    public function save_folder()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $this->add_staff_model->save_folder();
    }


    public function del_folder($folder_id,$dept_id)
    {
        check_login();
        checkuser_activate();
        check_permis();
        $result = get_del("gl_folder_id",$folder_id,"gl_folder");
        if(!$result)
        {
            echo "<script>";
            echo "alert('ลบข้อมูลไม่สำเร็จ')";
            echo "window.history.back(-1)";
            echo "</script>";
        }else{
            echo "<script>";
            echo "alert('ลบข้อมูลสำเร็จ')";
            echo "</script>";
            header("refresh:0; url=".base_url('staff/select_dept/').$dept_id);
        }
    }


    public function dept_update()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $this->add_staff_model->dept_update();
    }


    public function view_user()
    {
        check_login();
        checkuser_activate();
        check_permis();
        $data['view_user'] = $this->get_staff_model->view_user();
        get_head();
        get_contents("user_list",$data);
        get_footer();
    }


    public function save_edit_group()
    {
        check_login();
        checkuser_activate();
        $this->add_staff_model->save_edit_group();
    }


    public function save_edit_user()
    {
        check_login();
        checkuser_activate();
        $this->add_staff_model->save_edit_user();
    }


    public function delete_user($userid)
    {
        check_login();
        checkuser_activate();
        $this->add_staff_model->delete_user($userid);
    }





    public function manage_dashboard()

    {

        check_login();

        checkuser_activate();

        get_head();

        get_content("dashboard/index");

        get_footer();

    }





    public function manage_dashboard_gl()

{

    get_head();

    get_content("dashboard/indexgl");

    get_footer();

}





    public function pin_isodoc($lib_main_id)

    {

        check_login();

        checkuser_activate();

        pinIsoDoc($lib_main_id);

        header("refresh:0; url=".base_url('staff/manage_dashboard/'));

    }



    public function unpin_isodoc($lib_main_id)

    {

        check_login();

        checkuser_activate();

        unpinIsoDoc($lib_main_id);

        header("refresh:0; url=".base_url('staff/manage_dashboard/'));

    }











    //gl

public function pin_gldoc($gldoccode)

{

    pinGlDoc($gldoccode);

    header("refresh:0; url=".base_url('staff/manage_dashboard_gl/'));

}



public function unpin_gldoc($gldoccode)

{

    unPinGlDoc($gldoccode);

    header("refresh:0; url=".base_url('staff/manage_dashboard_gl/'));

}









//Live search for iso document

//For ajax live search doccode

public function fetch_iso_doccode_admin()

{

    // $getuser = $this->get_lib_model->get_new_user();

    // $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);

    // $rsget = $get_deptlib->row();



    $query = '';



        if($this->input->post('query')){

            $query = $this->input->post('query');

        }

        $data['rs'] = searchby_docode_admin($query);

        $this->load->view('result_iso_admin',$data);

}

//For ajax live search doccode









//For ajax live search docname

public function fetch_iso_docname_admin()

{

    // $getuser = $this->get_lib_model->get_new_user();

    // $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);

    // $rsget = $get_deptlib->row();

    

    $query = '';







        if($this->input->post('query')){

            $query = $this->input->post('query');

        }

        $data['rs'] = searchby_docname_admin($query);

        $this->load->view('result_iso_admin',$data);

}

//For ajax live search docname









//For ajax live search docname

public function fetch_iso_hashtag_admin()

{

    // $getuser = $this->get_lib_model->get_new_user();

    // $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);

    // $rsget = $get_deptlib->row();

    

    $query = '';







        if($this->input->post('query')){

            $query = $this->input->post('query');

        }

        $data['rs'] = searchby_hashtag_admin($query);

        $this->load->view('result_iso_admin',$data);

}

//For ajax live search docname











//For ajax live search docname

public function fetch_iso_date_admin()

{

    // $getuser = $this->get_lib_model->get_new_user();

    // $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);

    // $rsget = $get_deptlib->row();

    

    $start_date = '';

    $end_date = '';





        $start_date = $this->input->post('start_date');

        $end_date = $this->input->post('end_date');





        $data['rs'] = searchby_date_admin($start_date,$end_date);

        $this->load->view('result_iso_admin',$data);

}

//For ajax live search docname





    public function fetch_darlog()

    {

        $data['get_list'] = getlist_darlog();

        $this->load->view('result_darlog', $data);

    }

    



    public function fetch_filter_data()

    {

        $status = '';

        if($this->input->post('status')){

            $status = $this->input->post('status');

        }



        $data['get_list'] = getlist_darlog_status($status);

        $this->load->view('result_darlog', $data);

    }





    public function fetch_date_darlog()

    {

        $start_date = '';

        $end_date = '';

        $filter_withdate = '';





        $start_date = $this->input->post('start_date');

        $end_date = $this->input->post('end_date');

        $filter_withdate = $this->input->post('filter_withdate');



        $data['get_list'] = searchby_date_darlog($start_date,$end_date,$filter_withdate);

        $this->load->view('result_darlog', $data);

    }





    public function fetch_date_darlogs()

    {

        $start_date = '';

        $end_date = '';





        $start_date = $this->input->post('start_date');

        $end_date = $this->input->post('end_date');



        $data['get_list'] = searchby_date_darlogs($start_date,$end_date);

        $this->load->view('result_darlog', $data);

    }







    //Report

    //Dar Log Sheet

    // public function darLogSheet()

    // {



    //     check_login();

    //     checkuser_activate();

    //     $data['get_list'] = $this->doc_get_model->get_list();



    //     get_head();

    //     get_contents('darlog',$data);

    //     get_footer();

    // }









    //ทะเบียนเอกสาร

    public function documentList()
    {
        check_login();
        checkuser_activate();

        $data = array(
            "title" => "test"
        );

        get_head();
        get_contents('documentList', $data);
        get_footer();
    }

    public function load_reportDocument($datestart , $dateend)
    {
        $this->get_staff_model->load_reportDocument($datestart , $dateend);
    }



    public function controlDocumentList()
    {
        check_login();
        checkuser_activate();

        $data = array(
            "title" => "test"
        );

        get_head();
        get_contents('controlDocumentList', $data);
        get_footer();
    }

    public function load_reportControlDocument($datestart , $dateend)
    {
        $this->get_staff_model->load_reportControlDocument($datestart , $dateend);
    }





    public function fetch_docList()

    {

        $data['get_list'] = getlist_docList();

        $this->load->view('result_documentList', $data);

    }



    

    public function filterDocList_data()

    {

        $docType = '';

        if($this->input->post('docType')){

            $docType = $this->input->post('docType');

        }



        $data['get_list'] = getlist_docList_filter($docType);

        $this->load->view('result_documentList', $data);

    }







    public function fetch_doclist_date()

    {

        $start_date = '';

        $end_date = '';

        $filter_withdate = '';





        $start_date = $this->input->post('start_date');

        $end_date = $this->input->post('end_date');

        $filter_withdate = $this->input->post('filter_withdate');



        $data['get_list'] = getlist_docList_date($start_date, $end_date, $filter_withdate);

        $this->load->view('result_documentList', $data);

    }





    public function fetch_doclist_dates()

    {

        $start_date = '';

        $end_date = '';



        $start_date = $this->input->post('start_date');

        $end_date = $this->input->post('end_date');



        $data['get_list'] = getlist_docList_dates($start_date, $end_date);

        $this->load->view('result_documentList', $data);

    }





















    

}

// End Class

?>