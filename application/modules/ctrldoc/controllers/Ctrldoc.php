<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrldoc extends MX_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model("login/login_model");
        $this->load->model("document/doc_get_model");
        $this->load->model("ctrldoc_model");
    }
    

    public function index()
    {
        $data = array(
            "title" => "Control Document"
        );
        get_head();
        get_contents('ctrl_list', $data);
        get_footer();
    }

    public function add_ctrldoc()
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        get_head();
        get_contents('ctrl_add', $data);
        get_footer();
    }

    public function add_ctrldoc_manual()
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_law'] = $this->doc_get_model->get_law();
        $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);

        get_head();
        get_contents('ctrl_add_manual', $data);
        get_footer();
    }

    public function save_ctrldocNew()
    {
        $this->ctrldoc_model->save_ctrldocNew();
    }

    public function save_ctrldocNew_manual()
    {
        $this->ctrldoc_model->save_ctrldocNew_manual();
    }

    public function list_docctrl()
    {
        check_login();
        checkuser_activate();
        get_head();
        get_contents("ctrl_list", $data);
        get_footer();
    }

    public function get_listCtrlDoc(){
        $this->ctrldoc_model->get_listCtrlDoc();
    }

    public function ctrldoc_viewfull($darcode)
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($darcode); //Get Main data
        // $data['get_law'] = $this->doc_get_model->get_law();
        // $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['darcode'] = $darcode;

        get_head();
        get_contents("viewfull_ctrldoc", $data);
        get_footer();
    }


    public function ctrl_add2($darcode)
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($darcode); //Get Main data
        // $data['get_law'] = $this->doc_get_model->get_law();
        // $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['darcode'] = $darcode;

        get_head();
        get_contents('ctrl_add2', $data);
        get_footer();
    }

    public function saveUploadCtrlDoc()
    {
        $this->ctrldoc_model->saveUploadCtrlDoc();
    }

    public function ctrl_editsec1($darcode)
    {
        check_login();
        checkuser_activate();

        $data = array(
            "get_subtype" => $this->ctrldoc_model->get_ctrldocSubtype(),
            "get_reason" => $this->ctrldoc_model->get_ctrldocReason(),
            "get_dept" => $this->doc_get_model->get_dept(),
            "get_related_dept" => $this->doc_get_model->get_related_dept(),
            "username" => $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']),
            "darcode" => $darcode,
            "get_fulldata" => $this->ctrldoc_model->getFulldata($darcode)
        );

        get_head();
        get_contents('ctrl_edit', $data);
        get_footer();
    }


    public function ctrl_saveEditsec1()
    {
        $this->ctrldoc_model->ctrl_saveEditsec1();
    }


    public function cancelCtrlDoc()
    {
        $this->ctrldoc_model->cancelCtrlDoc();
    }

    public function viewfull_ctrldoc_cancel($darcode)
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($darcode); //Get Main data
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['darcode'] = $darcode;

        get_head();
        get_contents("viewfull_ctrldoc_cancel", $data);
        get_footer();
    }

    public function saveDccApprove()
    {
        $this->ctrldoc_model->saveDccApprove();
    }

    public function control_document(){
        check_login();
        checkuser_activate();

        $data = array(
            "dct_subtype" => $this->ctrldoc_model->getDctSubtype()
        );

        get_head();
        get_contents("control_document", $data);
        get_footer();
    }

    public function getCtrlDoclist($ctrldoc_filterDocName , $ctrldoc_filterDocCode , $ctrldoc_filterDateStart , $ctrldoc_filterDateEnd , $ctrldoc_fillterSubtype)
    {
        $this->ctrldoc_model->getCtrlDoclist($ctrldoc_filterDocName , $ctrldoc_filterDocCode , $ctrldoc_filterDateStart , $ctrldoc_filterDateEnd , $ctrldoc_fillterSubtype);
    }

    public function getCtrlDoclist_hashtag($hashtag)
    {
        $this->ctrldoc_model->getCtrlDoclist_hashtag($hashtag);
    }

    public function viewfull_library_ctrldoc($doccode)
    {
        check_login();
        checkuser_activate();

        $data = array(
            "dct_subtype" => $this->ctrldoc_model->getDctSubtype(),
            "getdata_library" => $this->ctrldoc_model->getData_viewfull_library_ctrldoc($doccode),
            "doccode" => $doccode
        );

        get_head();
        get_contents("viewfull_library_ctrldoc", $data);
        get_footer();
    }

    public function requestEditCtrlDoc($activeDarcode)
    {
        check_login();
        checkuser_activate();

        if($activeDarcode != ""){
            $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
            $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
            $data['get_dept'] = $this->doc_get_model->get_dept();
            $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
            $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($activeDarcode); //Get Main data
            // $data['get_law'] = $this->doc_get_model->get_law();
            // $data['get_sds'] = $this->doc_get_model->get_sds();
            $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
            $data['darcode'] = $activeDarcode;
    
            get_head();
            get_contents('ctrl_request_editdoc', $data);
            get_footer();
        }
    }

    public function requestCancelCtrlDoc($activeDarcode)
    {
        check_login();
        checkuser_activate();

        if($activeDarcode != ""){
            $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
            $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
            $data['get_dept'] = $this->doc_get_model->get_dept();
            $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
            $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($activeDarcode); //Get Main data
            // $data['get_law'] = $this->doc_get_model->get_law();
            // $data['get_sds'] = $this->doc_get_model->get_sds();
            $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
            $data['darcode'] = $activeDarcode;
    
            get_head();
            get_contents('ctrl_request_canceldoc', $data);
            get_footer();
        }
    }

    public function save_ctrldoc_rt04()
    {
        $this->ctrldoc_model->save_ctrldoc_rt04();
    }

    public function save_ctrldoc_rt05()
    {
        $this->ctrldoc_model->save_ctrldoc_rt05();
    }


    public function getCtrlDocHashTag()
    {
        $this->ctrldoc_model->getCtrlDocHashTag();
    }

    public function print_ctrldoc($darcode)
    {
        check_login();
        checkuser_activate();

        $data['get_doc_sub_type'] = $this->ctrldoc_model->get_ctrldocSubtype();
        $data['get_reason'] = $this->ctrldoc_model->get_ctrldocReason();
        $data['get_dept'] = $this->doc_get_model->get_dept();
        $data['get_related_dept'] = $this->doc_get_model->get_related_dept();
        $data['get_fulldata'] = $this->ctrldoc_model->getFulldata($darcode); //Get Main data
        // $data['get_law'] = $this->doc_get_model->get_law();
        // $data['get_sds'] = $this->doc_get_model->get_sds();
        $data['username'] = $this->doc_get_model->convertName($_SESSION['Fname'], $_SESSION['Lname']);
        $data['darcode'] = $darcode;

		$this->load->library("TCPDF/tcpdf");
		$this->load->view("print_ctrldoc",$data);
    }

    public function testcode()
    {
        $this->load->model("ctrldocemail_model");
        $this->ctrldocemail_model->test();
    }

    public function saveEditDataStoreCtrl()
    {
        $this->ctrldoc_model->saveEditDataStoreCtrl();
    }

}
/* End of file Controllername.php */




?>