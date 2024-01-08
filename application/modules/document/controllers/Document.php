<?php



defined('BASEPATH') or exit('No direct script access allowed');



class Document extends MX_Controller

{



    public function __construct()

    {

        parent::__construct();

        //Do your magic here

        $this->lang->load("english");
        $this->load->model("doc_add_model");
        $this->load->model("doc_get_model");
        $this->load->model("login/login_model");
        $this->load->model("docemail_model");
        date_default_timezone_set("Asia/Bangkok");
    }





    public function index()

    {

        redirect('document/dashboard');
    }





    public function dashboard()

    {

        check_login();

        checkuser_activate();

        get_head();

        get_content("index");

        get_footer();
    }







    public function checkdate()

    {

        $this->doc_add_model->checkdate();
    }





    // public function main_add()

    // {

    //     $this->login_model->call_login();

    //     $data['get_reason'] = $this->doc_get_model->get_reason();



    //     get_head();

    //     get_contents("main_add",$data);

    //     get_footer();

    // }





    public function add_dar()

    {

        check_login();
        checkuser_activate();
        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();
        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();
        $data['get_reason'] = $this->doc_get_model->get_reason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        get_head();
        get_contents('add_dar', $data);
        get_footer();
    }





    public function add_dar2($darcode)
    {
        check_login();
        checkuser_activate();
        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($darcode); //Get Main data
        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($darcode);
        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();
        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();
        $data['get_reason'] = $this->doc_get_model->get_reason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($darcode);
        $data['get_law_use'] = $this->doc_get_model->get_law_use($darcode);
        $data['get_related_use'] = $this->doc_get_model->get_related_use($darcode);

        get_head();
        get_contents('add_dar2', $data);
        get_footer();
    }





    public function list_dar()
    {
        check_login();
        checkuser_activate();
        get_head();
        get_contents("list", $data);
        get_footer();
    }


    public function get_list()
    {
        $this->doc_get_model->get_list();
    }

    public function getDurationJavascript()
    {
        $this->doc_get_model->getDurationJavascript();
    }



    public function list_generel()

    {

        check_login();

        checkuser_activate();

        $data['get_list_gl'] = $this->doc_get_model->get_list_gl();



        get_head();

        get_contents("general_doc/list_gl", $data);

        get_footer();
    }





    public function load_list()

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->get_list();
    }





    public function viewfull($darcode)
    {
        check_login();
        checkuser_activate();
        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($darcode); //Get Main data
        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($darcode);
        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();
        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();
        $data['get_reason'] = $this->doc_get_model->get_reason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($darcode);
        $data['get_law_use'] = $this->doc_get_model->get_law_use($darcode);
        $data['get_related_use'] = $this->doc_get_model->get_related_use($darcode);
        // $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);
        get_head();
        get_contents("viewfull_dar", $data);
        get_footer();
    }





    public function view_deptEdit($darcode)

    {

        check_login();

        checkuser_activate();

        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($darcode); //Get Main data

        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($darcode);

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($darcode);

        $data['get_law_use'] = $this->doc_get_model->get_law_use($darcode);

        $data['get_related_use'] = $this->doc_get_model->get_related_use($darcode);

        // $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);



        get_head();

        get_contents("viewfull_deptedit", $data);

        get_footer();
    }







    public function view_cancel_document($darcode)

    {

        check_login();

        checkuser_activate();

        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($darcode); //Get Main data

        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($darcode);

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($darcode);

        $data['get_law_use'] = $this->doc_get_model->get_law_use($darcode);

        $data['get_related_use'] = $this->doc_get_model->get_related_use($darcode);

        // $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);



        get_head();

        get_contents("viewfull_cancel", $data);

        get_footer();
    }





    public function save_editdar($darcode)

    {

        check_login();

        checkuser_activate();

        // $this->doc_get_model->checkHashtagFormat();

        $this->doc_add_model->save_editdar($darcode);



        // $this->doc_add_model->save_sec1();

        header("refresh:1; url=" . base_url('document/list_dar'));
    }





    public function save_sec1()

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->checkNull_add();

        $this->doc_get_model->checkHashtagFormat();

        $this->doc_add_model->save_sec1();
    }







    public function cancelSec1($darcode, $doccode)

    {

        $this->doc_add_model->cancelSec1_deleteHashtag($doccode);

        $this->doc_add_model->cancelSec1_deleteRelatedDeptUse($darcode);

        $this->doc_add_model->cancelSec1_deleteTypeUse($darcode);

        $this->doc_add_model->cancelSec1_deleteDoccode($darcode);

        header("refresh:0; url=" . base_url('document/list_dar'));
    }





    public function save_sec1_2($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->checkNull_add2();

        $this->doc_add_model->save_sec1_2($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }



    public function save_sec2($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_manager_Zone();

        $this->doc_add_model->save_sec2($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }





    public function save_sec3($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_qmr_Zone();

        $this->doc_add_model->save_sec3($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }




    public function save_sec3smr($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_smr_Zone();

        $this->doc_add_model->save_sec3smr($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }





    public function save_sec4($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_doc_Zone();

        $this->doc_add_model->save_sec4($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }



    public function save_sec4deptedit($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_sec4deptedit($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }





    public function save_sec4cancel($darcode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_sec4cancel($darcode);

        header("refresh:0; url=" . base_url('document/list_dar/'));
    }







    public function create_master($doccode)

    {

        check_login();

        checkuser_activate();

        // $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($doccode);

        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($doccode);

        // $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($doccode);

        $data['get_law_use'] = $this->doc_get_model->get_law_use($doccode);

        $data['get_related_use'] = $this->doc_get_model->get_related_use($doccode);

        $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);



        $this->load->view("template/tp_headcode");

        $this->load->view("create_master", $data);

        // $this->load->view("template/tp_footer");

    }



    public function create_copy($doccode)

    {

        check_login();

        checkuser_activate();

        // $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($doccode);

        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($doccode);

        // $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($doccode);

        $data['get_law_use'] = $this->doc_get_model->get_law_use($doccode);

        $data['get_related_use'] = $this->doc_get_model->get_related_use($doccode);

        $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);



        $this->load->view("template/tp_headcode");

        $this->load->view("create_copy", $data);

        // $this->load->view("template/tp_footer");

    }





    public function up_status1($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->up_status1($doccode);
    }



    public function up_status2($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->up_status2($doccode);
    }



    public function thkpage()

    {

        check_login();

        checkuser_activate();

        $this->load->view("template/tp_headcode");

        $this->load->view("template/thankyou_page");
    }





    public function edit_document($doccode)
    {

        check_login();
        checkuser_activate();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();
        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();
        $data['get_reason'] = $this->doc_get_model->get_reason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['getfulldata_edit'] = $this->doc_get_model->getfulldata_edit($doccode);

        get_head();
        $this->load->view('edit_doc', $data);
        get_footer();
    }



    public function save_sec1_edit($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_null_change();

        $this->doc_add_model->save_sec1_edit($doccode);

        header("refresh:0; url=" . base_url('document/list_dar'));
    }





    public function edit_dept($doccode)

    {

        check_login();

        checkuser_activate();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['getfulldata_edit'] = $this->doc_get_model->getfulldata_edit($doccode);

        $data['get_last_dar'] = $this->doc_get_model->get_last_dar($doccode);



        get_head();

        get_contents("edit_dept", $data);

        get_footer();
    }



    public function save_edit_dept($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_sec1_copy($doccode);

        header("refresh:0; url=" . base_url() . "document/list_dar");
    }







    public function cancel_document($doccode)

    {

        check_login();

        checkuser_activate();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['getfulldata_edit'] = $this->doc_get_model->getfulldata_edit($doccode);

        $data['get_last_dar'] = $this->doc_get_model->get_last_dar($doccode);



        get_head();

        get_contents('cancel_doc', $data);

        get_footer();
    }





    public function save_cancel($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_cancel($doccode);

        header("refresh:0; url=" . base_url('document/list_dar'));
    }







    public function change_document($doccode)

    {

        check_login();

        checkuser_activate();

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['getfulldata_edit'] = $this->doc_get_model->getfulldata_edit($doccode);

        $data['get_last_dar'] = $this->doc_get_model->get_last_dar($doccode);



        get_head();

        get_contents("change_doc", $data);

        get_footer();
    }





    public function edit_dar($darcode)

    {

        check_login();

        checkuser_activate();

        $data['get_fulldata'] = $this->doc_get_model->get_fulldata($darcode); //Get Main data

        $data['get_doctype_use'] = $this->doc_get_model->get_doctype_use($darcode);

        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        $data['get_sds_use'] = $this->doc_get_model->get_sds_use($darcode);

        $data['get_law_use'] = $this->doc_get_model->get_law_use($darcode);

        $data['get_related_use'] = $this->doc_get_model->get_related_use($darcode);

        // $data['get_doc_file'] = $this->doc_get_model->get_doc_file($doccode);



        get_head();

        get_contents("editdata", $data);

        get_footer();
    }





    public function save_sec1change($doccode)

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->check_null_change();

        $this->doc_add_model->save_sec1change($doccode);

        header("refresh:0; url=" . base_url('document/list_dar'));
    }





    public function add_gl_doc()

    {

        check_login();

        checkuser_activate();

        get_head();

        get_content("general_doc/add_gl_doc");

        get_footer();
    }





    public function edit_gl_doc($gl_doc_code)

    {

        check_login();

        checkuser_activate();

        $data['get_view_doc'] = $this->doc_get_model->get_view_doc($gl_doc_code);

        get_head();

        get_contents("general_doc/edit_gl_doc", $data);

        get_footer();
    }



    public function save_edit_gl_doc($gl_doc_code)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_edit_gl_doc($gl_doc_code);

        header("refresh:0; url=" . base_url() . "document/list_generel");
    }







    public function save_gl_doc()

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->checkHashtagFormat_gl();

        $this->doc_add_model->save_gl_doc();
    }



    public function gl_view_doc($gl_doc_code)

    {

        check_login();

        checkuser_activate();

        $data['get_view_doc'] = $this->doc_get_model->get_view_doc($gl_doc_code);

        get_head();

        get_contents("general_doc/view_gl_doc", $data);

        get_footer();
    }





    public function save_gl_doc2($gl_doc_code)

    {

        check_login();

        checkuser_activate();

        $this->doc_add_model->save_gl_doc2($gl_doc_code);
    }







    public function add_dar_manual()

    {

        check_login();

        checkuser_activate();



        $data['get_doc_type'] = $this->doc_get_model->get_doc_type();

        $data['get_doc_sub_type'] = $this->doc_get_model->get_doc_sub_type();

        $data['get_reason'] = $this->doc_get_model->get_reason();

        $data['get_dept'] = $this->doc_get_model->get_dept();

        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();

        $data['get_law'] = $this->doc_get_model->get_law();

        $data['get_sds'] = $this->doc_get_model->get_sds();

        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);





        get_head();

        get_contents('add_dar_manual', $data);

        get_footer();
    }







    public function save_sec1_manual()

    {

        check_login();

        checkuser_activate();

        $this->doc_get_model->checkNull_add();

        $this->doc_get_model->checkHashtagFormat();

        $this->doc_add_model->save_sec1_manual();
    }





    public function checkDoccode()

    {

        $query = '';

        $query = $this->input->post('query');

        $result = $this->db->query("SELECT dc_data_doccode_display FROM dc_datamain WHERE dc_data_doccode_display = '$query' ");

        if ($result->num_rows() >= 1) {

            $count = 1;
        } else {

            $count = 0;
        }

        echo $count;
    }







    public function checkDarcode()

    {

        $query = '';

        $query = $this->input->post('query');

        $result = $this->db->query("SELECT dc_data_darcode FROM dc_datamain WHERE dc_data_darcode = '$query' ");

        if ($result->num_rows() >= 1) {

            $count = 1;
        } else {

            $count = 0;
        }

        echo $count;
    }






/////////////////////////////////////////////////////////////////////////////////
// Function แก้ไขระยะเวลาจัดเก็บ อัพเดตเพิ่มเติม อ้างอิง CSRO เลขที่ CSR6400060
/////////////////////////////////////////////////////////////////////////////////
public function saveEditDataStore()
{
    $this->doc_add_model->saveEditDataStore();
}

/////////////////////////////////////////////////////////////////////////////////
// Function แก้ไขระยะเวลาจัดเก็บ อัพเดตเพิ่มเติม อ้างอิง CSRO เลขที่ CSR6400060
/////////////////////////////////////////////////////////////////////////////////


public function test()
{
    $rs = $this->docemail_model->getManagerEmailAddress('1002');
    print_r($rs->result());
}








    /* End of file Controllername.php */
}
