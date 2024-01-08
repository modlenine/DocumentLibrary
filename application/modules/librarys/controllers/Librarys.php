<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Librarys extends MX_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->lang->load("english");
        $this->load->model("login/login_model");
        $this->load->model("document/doc_get_model");
        $this->load->model('get_lib_model');
    }
    

    public function index()
    {
        check_login();
        checkuser_activate();
        redirect("librarys/view_by_dept");
    }

    public function isoPge()
    {
        check_login();
        checkuser_activate();
        $data = array(
            "title" => "หน้าตู้เอกสาร ISO ใหม่",
            "get_sub_type" => $this->get_lib_model->get_sub_type(),
            "get_doctype" => $this->get_lib_model->get_doctype()
        );
        get_head();
        get_contents("isopage",$data);
        get_footer();
    }

    public function getIsoDoclist($filterDocName , $filterDocCode , $filterDateStart , $filterDateEnd , $filterSubtype , $filterHashtag)
    {
        $this->get_lib_model->getIsoDoclist($filterDocName , $filterDocCode , $filterDateStart , $filterDateEnd , $filterSubtype , $filterHashtag);
    }

    public function getIsoDoclist_hashtag($hashtag)
    {
        $this->get_lib_model->getIsoDoclist_hashtag($hashtag);
    }

    public function view_by_dept()
    {
        check_login();
        checkuser_activate();
        $data['get_doctype'] = $this->get_lib_model->get_doctype();
        $data['get_sub_type'] = $this->get_lib_model->get_sub_type();
        

        get_head();
        get_contents("index",$data);
        get_footer();
    }

    public function view_document($subtype,$related_code)
    {
        check_login();
        checkuser_activate();
        $data['get_file1'] = $this->get_lib_model->get_file1($subtype,$related_code);

        get_head();
        get_contents('view_document',$data);
        get_footer();
    }


    public function viewFull_document($subtype,$related_code,$doccode)
    {
        check_login();
        checkuser_activate();
        check_permission_pinIso($related_code,$doccode);
        $data['get_file1'] = $this->get_lib_model->get_file1($subtype,$related_code);
        $data['get_file2'] = $this->get_lib_model->get_file2($subtype,$doccode);
        
        // $data['get_doc_type'] = $this->get_lib_model->get_doc_type($subtype,$related_code);

        get_head();
        get_contents('viewFull_document',$data);
        get_footer();
    }

    public function document_center()
    {
        check_login();
        checkuser_activate();
        $data['get_dept_folder'] = $this->get_lib_model->get_dept_folder();
        get_head();
        get_contents("document_center",$data);
        get_footer();
    }



    public function view_gl_document($deptcode,$folder_number)
    {
        check_login();
        checkuser_activate();
        $data['view_gl_document'] = $this->get_lib_model->view_gl_document($deptcode,$folder_number);
        $data['get_foldername_deptname'] = $this->get_lib_model->get_foldername_deptname($deptcode,$folder_number);
        get_head();
        get_contents("view_gl_document",$data);
        get_footer();
    }

    public function viewfull_gl_document($deptcode,$folder_number,$gl_doccode)
    {
        check_login();
        checkuser_activate();
        $data['viewfull_gl_document'] = $this->get_lib_model->viewfull_gl_document($deptcode,$folder_number,$gl_doccode);
        get_head();
        get_contents("viewfull_gl_document",$data);
        get_footer();
    }

    public function gl_card($deptcode,$folder_number,$gl_doccode)
    {
        check_login();
        checkuser_activate();
        $data['gl_card'] = $this->get_lib_model->gl_card($deptcode,$folder_number,$gl_doccode);
        get_head();
        get_contents("gl_card",$data);
        get_footer();
    }

    public function testcode()
    {
        get_content("test");
    }

    public function tag($tag)
    {
        check_login();
        checkuser_activate();
        $data['tag'] = $tag;
        get_contents("tag",$data);
    }


    public function search_hashtag()
    {
        check_login();
        checkuser_activate();
        $data['result_hashtag'] = $this->get_lib_model->search_hashtag();
    }



// Live search for gl document
// For ajax live search doccode 
    public function fetch_doccode()
    {
        $output = '';
        $query = '';

        if($this->input->post('query')){
            $query = $this->input->post('query');
        }
        $data['rs'] = gl_search_by_doccode($query);
        $this->load->view('result_data',$data);
    }
// For ajax live search doccode 


// For ajax live search docname
public function fetch_docname()
{
    $output = '';
    $query = '';

    if($this->input->post('query')){
        $query = $this->input->post('query');
    }
    $data['rs'] = gl_search_by_docname($query);
    $this->load->view('result_data',$data);
}
// For ajax live search docname 


// For ajax live search hashtag
public function fetch_hashtag()
{
    $output = '';
    $query = '';

    if($this->input->post('query')){
        $query = $this->input->post('query');
    }
    $data['rs'] = gl_search_by_hashtag($query);
    $this->load->view('result_data',$data);
}
// For ajax live search hashtag 



// For ajax live search date
public function fetch_date()
{
    $start_date = '';
    $end_date = '';


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
    
    $data['rs'] = gl_search_by_date($start_date,$end_date);
    $this->load->view('result_data',$data);
    
}
// For ajax live search date
// Live search for gl document





//Live search for iso document
//For ajax live search doccode
public function fetch_iso_doccode()
{
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
    $rsget = $get_deptlib->row();

    $query = '';



        if($this->input->post('query')){
            $query = $this->input->post('query');
        }
        $data['rs'] = search_by_doccode($rsget->related_code,$query);
        $this->load->view('result_data_iso',$data);
}
//For ajax live search doccode


//For ajax live search docname
public function fetch_iso_docname()
{
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
    $rsget = $get_deptlib->row();
    
    $query = '';



        if($this->input->post('query')){
            $query = $this->input->post('query');
        }
        $data['rs'] = search_by_docname($rsget->related_code,$query);
        $this->load->view('result_data_iso',$data);
}
//For ajax live search docname


//For ajax live search hashtag
public function fetch_iso_hashtag()
{
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
    $rsget = $get_deptlib->row();
    
    $query = '';



        if($this->input->post('query')){
            $query = $this->input->post('query');
        }
        $data['rs'] = search_by_hashtag($rsget->related_code,$query);
        $this->load->view('result_data_iso',$data);
}
//For ajax live search hashtag



//For ajax live search docname
public function fetch_iso_date()
{
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
    $rsget = $get_deptlib->row();
    
    $start_date = '';
    $end_date = '';


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');


        $data['rs'] = search_by_date($rsget->related_code,$start_date,$end_date);
        $this->load->view('result_data_iso',$data);
}
//For ajax live search docname

    

public function getIsoDocHashTag()
{
    $this->get_lib_model->getIsoDocHashTag();
}

public function getIsoDocHashTagSearch()
{
    $this->get_lib_model->getIsoDocHashTagSearch();
}








}

/* End of file Controllername.php */
?>