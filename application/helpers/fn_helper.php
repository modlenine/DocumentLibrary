<?php
class myfn {
    public $ci;
    function __construct(){
        $this->ci=& get_instance();
    }

    public function get_ci()
    {
        return $this->ci;
    }
}

function getEmailAccount()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT * FROM email_information");
    return $query->row();
}

function getEmailAccount_2()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT * FROM email_information WHERE email_id = '2'");
    return $query->row();
}

// Load Zone
function load_login_model()
{
    $obj = new myfn();
    $obj->get_ci()->load->model("login/login_model");
}

function load_doc_get_model()
{
    $obj = new myfn();
    $obj->get_ci()->load->model("document/doc_get_model");
}
// Load Zone

function get_head()
{
    $obj = new myfn();
    $obj->get_ci()->load->view("template/tp_head");
}

function get_footer()
{
    $obj = new myfn();
    $obj->get_ci()->load->view("template/tp_footer");
}


function get_content($page)
{
    $obj = new myfn();
    $obj->get_ci()->load->view($page);
}


function get_contents($page,$data)
{
    $obj = new myfn();
    $obj->get_ci()->load->view($page,$data);
}


function check_login()//Check session login
{
    $obj = new myfn();
    load_login_model();
    $obj->get_ci()->login_model->call_login();
}


function check_permis()
{
    $obj = new myfn();
    load_login_model();
    $obj->get_ci()->login_model->check_permis();
}


function cut_doccode1($doccode)
{
    return substr($doccode,0,8);
}


function cut_doccode2($doccode)
{
    return substr($doccode,0,13);
}


function cut_doccode3($doccode)
{
    return substr($doccode,0,10);
}


function get_del($nameid,$id,$tbname)
// delete function request 3 parameter = nameid , id , table name
{
    $obj = new myfn();
    $result = $obj->get_ci()->db->where($nameid , $id);
    $result = $obj->get_ci()->db->delete($tbname);
    return $result;
}


function get_modal()
{
    $obj = new myfn();
    $result = $obj->get_ci()->load->view("template/modal");
}


function get_folder($dept_id)
{
    $obj = new myfn();
    $result = $obj->get_ci()->db->query("SELECT * FROM gl_folder WHERE gl_folder_dept_id='$dept_id' ");
    return $result;
}
// Convert Zone  Convert Zone   Convert Zone   Convert Zone


function convert_name($getuser_Fname, $getuser_Lname)
{
    $obj = new myfn();
    load_doc_get_model();
    $result = $obj->get_ci()->doc_get_model->convertName($getuser_Fname, $getuser_Lname);
    return $result;
}


function convert_darcode_to_doccode($darcode)
{
    $obj = new myfn();
    $rs_doccode = $obj->get_ci()->db->query("SELECT dc_data_darcode , dc_data_doccode FROM dc_datamain WHERE dc_data_darcode='$darcode' ");
    $result = $rs_doccode->row();
    return $result->dc_data_doccode;
}
// Convert Zone  Convert Zone   Convert Zone   Convert Zone


function get_gl_folder_number($dept_id)
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT gl_folder_number FROM gl_folder WHERE gl_folder_dept_id='$dept_id' ");
    $numrow = $query->num_rows();
    
    if($numrow == 0)
    {
        return $gl_folder_num = "01";
    }else{
        $call_num = $obj->get_ci()->db->query("SELECT gl_folder_number FROM gl_folder WHERE gl_folder_dept_id= '$dept_id' ORDER BY gl_folder_number DESC LIMIT 1 ");

        foreach($call_num->result_array() as $call_nums){
            $get_num = $call_nums['gl_folder_number'];
            $get_num++;
        }

        if($get_num < 10){
            $get_num = "0".$get_num;
        }
        $gl_folder_num = $get_num;
        return $gl_folder_num;
    }

}


function get_folder_code($dept_code)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT * FROM gl_folder WHERE gl_folder_dept_code='$dept_code' ");
}


function get_gl_doccode()
{
    $obj = new myfn();
    $dept_code = $obj->get_ci()->input->post("gl_doc_deptcode");
    $folder_code = $obj->get_ci()->input->post("gl_doc_folder_number");

    $sql = $obj->get_ci()->db->query("SELECT gl_doc_code FROM gl_document WHERE gl_doc_deptcode='$dept_code' AND gl_doc_folder_number='$folder_code' ORDER BY gl_doc_code DESC LIMIT 1 ");

    $numrow = $sql->num_rows();

    if($numrow == 0){
        $gl_doccode = $dept_code."-".$folder_code."-"."001";
        return $gl_doccode;
    }else{

        foreach($sql->result_array() as $rs){
         $cut_doc_code = substr($rs['gl_doc_code'],8); ;
            //1001-01-001 => 001
         $cut_doc_code++;
        }

        if($cut_doc_code < 10){
            $cut_doc_code = "00".$cut_doc_code;
        }else if ($cut_doc_code >= 10 && $cut_doc_code < 100){
            $cut_doc_code = "0".$cut_doc_code;
        }
        $get_gl_doccode = $dept_code."-".$folder_code."-".$cut_doc_code;
        return $get_gl_doccode;
    }
}

function convertHashtoLink($string)
{
    $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
    $string = preg_replace($expression,'<a href="'.base_url("librarys/document_center?tag=$1").'">$0</a>',$string);
    return $string;
}

function convertHashtoLink2($string)
{
    $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
    $string = preg_replace($expression,'<a href="'.base_url("librarys/view_by_dept?tag=$1").'">$0</a>',$string);
    return $string;
}


function get_group($session_username)
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT
    dc_user.dc_user_id,
    dc_user.dc_user_username,
    dc_user.dc_user_Dept,
    dc_user.dc_user_ecode,
    dc_user.dc_user_DeptCode,
    dc_user.dc_user_group,
    dc_user.dc_user_status,
    dc_group_permission.dc_gp_permis_name
    FROM
    dc_user
    INNER JOIN dc_group_permission ON dc_group_permission.dc_gp_permis_code = dc_user.dc_user_group
    WHERE dc_user_username = '$session_username' ");

    return $query;
}


function get_group_all()
{
    $obj = new myfn();
    return $obj->get_ci()->db->get("dc_group_permission");
}


function get_hashtag_doclist($doccode)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT * FROM gl_hashtag WHERE gl_ht_doc_code='$doccode' ");
}

function get_hashtag_iso($doccode)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT * FROM library_hashtag WHERE li_hashtag_doc_code='$doccode' ");
}

function get_graph1()
{
    $obj = new myfn();
    return $obj->get_ci()->load->view("dashboard/graph1");
}


function get_graph2()
{
    $obj = new myfn();
    return $obj->get_ci()->load->view("dashboard/graph2");
}


function con_date($date)
{
    if($date == ""){
        $rscondate = "";
    }else{
        $condate = date_create($date);

    $rscondate = date_format($condate,"d/m/Y");
    }
    return  $rscondate;
}


function con_date2($date)
{
    if($date == ""){
        $rscondate = "";
    }else{
        $condate = date_create($date);

    $rscondate = date_format($condate,"d-m-Y");
    }
    return  $rscondate;
}

// Search Document ISO Zone
function search_by_date($related_code,$date_start,$data_end)
{
    $obj = new myfn();

    $obj->get_ci()->load->model("librarys/get_lib_model");
    $getUser = $obj->get_ci()->get_lib_model->get_new_user();
    $newDeptCode = $getUser->dc_user_new_dept_code;
    $ecode = $getUser->dc_user_ecode;

    $querySpecial = "";
    if($ecode == "M0112"){
        $querySpecial = "OR dc_related_dept_use.related_dept_code = 're16'";
    }else{
        $querySpecial = "";
    }

    return $obj->get_ci()->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_status,
    dc_related_dept_use.related_dept_code,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_date,
    dc_dept_main.dc_dept_main_name
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

        WHERE

        library_main.lib_main_status = 'active' AND dc_related_dept_use.related_dept_code ='$related_code' $querySpecial AND dc_data_date BETWEEN '$date_start' AND '$data_end'

        GROUP BY

        library_main.lib_main_doccode ORDER BY dc_datamain.dc_data_date DESC");
}

function search_by_docname($related_code,$docname)
{
    $obj = new myfn();

    $obj->get_ci()->load->model("librarys/get_lib_model");
    $getUser = $obj->get_ci()->get_lib_model->get_new_user();
    $newDeptCode = $getUser->dc_user_new_dept_code;
    $ecode = $getUser->dc_user_ecode;

    $querySpecial = "";
    if($ecode == "M0112"){
        $querySpecial = "OR dc_related_dept_use.related_dept_code = 're16'";
    }else{
        $querySpecial = "";
    }

    return $obj->get_ci()->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_status,
    dc_related_dept_use.related_dept_code,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_date,
    dc_dept_main.dc_dept_main_name
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

        WHERE

        library_main.lib_main_status = 'active' AND dc_related_dept_use.related_dept_code ='$related_code' $querySpecial AND dc_datamain.dc_data_docname LIKE '%$docname%'

        GROUP BY

        library_main.lib_main_doccode ORDER BY dc_datamain.dc_data_date DESC");

}

function search_by_doccode($related_code,$doccode)
{
    $obj = new myfn();

    $obj->get_ci()->load->model("librarys/get_lib_model");
    $getUser = $obj->get_ci()->get_lib_model->get_new_user();
    $newDeptCode = $getUser->dc_user_new_dept_code;
    $ecode = $getUser->dc_user_ecode;

    $querySpecial = "";
    if($ecode == "M0112"){
        $querySpecial = "OR dc_related_dept_use.related_dept_code = 're16'";
    }else{
        $querySpecial = "";
    }

    $query = $obj->get_ci()->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_status,
    dc_related_dept_use.related_dept_code,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_date,
    dc_dept_main.dc_dept_main_name
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

        WHERE

        library_main.lib_main_status = 'active' AND dc_related_dept_use.related_dept_code ='$related_code' $querySpecial AND dc_datamain.dc_data_doccode LIKE '%$doccode%'

        GROUP BY

        library_main.lib_main_doccode ORDER BY dc_datamain.dc_data_date DESC");

    return $query;
}

function search_by_darcode($related_code,$darcode)
{
    $obj = new myfn();

    $obj->get_ci()->load->model("librarys/get_lib_model");
    $getUser = $obj->get_ci()->get_lib_model->get_new_user();
    $newDeptCode = $getUser->dc_user_new_dept_code;
    $ecode = $getUser->dc_user_ecode;

    $querySpecial = "";
    if($ecode == "M0112"){
        $querySpecial = "OR dc_related_dept_use.related_dept_code = 're16'";
    }else{
        $querySpecial = "";
    }

    return $obj->get_ci()->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_status,
    dc_related_dept_use.related_dept_code,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_date,
    dc_dept_main.dc_dept_main_name
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

        WHERE

        library_main.lib_main_status = 'active' AND dc_related_dept_use.related_dept_code ='$related_code' $querySpecial AND dc_datamain.dc_data_darcode LIKE '%$darcode%'

        GROUP BY

        library_main.lib_main_doccode ORDER BY dc_datamain.dc_data_date DESC");
}

function search_by_hashtag($related_code,$tag)
{
    $obj = new myfn();

    $obj->get_ci()->load->model("librarys/get_lib_model");
    $getUser = $obj->get_ci()->get_lib_model->get_new_user();
    $newDeptCode = $getUser->dc_user_new_dept_code;
    $ecode = $getUser->dc_user_ecode;

    $querySpecial = "";
    if($ecode == "M0112"){
        $querySpecial = "OR dc_related_dept_use.related_dept_code = 're16'";
    }else{
        $querySpecial = "";
    }

    return $obj->get_ci()->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_status,
    dc_related_dept_use.related_dept_code,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_date,
    dc_dept_main.dc_dept_main_name,
    library_hashtag.li_hashtag_name
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept
    INNER JOIN library_hashtag ON library_hashtag.li_hashtag_doc_code = dc_datamain.dc_data_doccode

        WHERE

        library_main.lib_main_status = 'active' AND dc_related_dept_use.related_dept_code ='$related_code' $querySpecial AND library_hashtag.li_hashtag_name LIKE '%$tag%'

        GROUP BY

        library_main.lib_main_doccode ORDER BY dc_datamain.dc_data_date DESC");
}
// Search Document ISO Zone


// Search General Document Zone
function gl_search_by_date($start_date,$end_date)
{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT

        gl_document.gl_doc_id,

        gl_document.gl_doc_date_request,

        gl_document.gl_doc_username,

        gl_document.gl_doc_ecode,

        gl_document.gl_doc_deptcode,

        gl_document.gl_doc_deptname,

        gl_document.gl_doc_name,

        gl_document.gl_doc_code,

        gl_document.gl_doc_folder_number,

        gl_document.gl_doc_detail,

        gl_document.gl_doc_file,

        gl_document.gl_doc_file_location,

        gl_document.gl_doc_approve_status,

        gl_document.gl_doc_reson_detail,

        gl_document.gl_doc_approve_by,

        gl_document.gl_doc_status,

        gl_document.gl_doc_hashtag,

        gl_hashtag.gl_ht_name,

        gl_hashtag.gl_ht_doc_code

        FROM

        gl_document

        INNER JOIN gl_hashtag ON gl_hashtag.gl_ht_doc_code = gl_document.gl_doc_code 

        WHERE gl_document.gl_doc_status = 'Approved' AND gl_document.gl_doc_date_request BETWEEN '$start_date' AND '$end_date'

        GROUP BY gl_doc_code DESC  ");

}


function gl_search_by_docname($docname)
{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT

        gl_document.gl_doc_id,

        gl_document.gl_doc_date_request,

        gl_document.gl_doc_username,

        gl_document.gl_doc_ecode,

        gl_document.gl_doc_deptcode,

        gl_document.gl_doc_deptname,

        gl_document.gl_doc_name,

        gl_document.gl_doc_code,

        gl_document.gl_doc_folder_number,

        gl_document.gl_doc_detail,

        gl_document.gl_doc_file,

        gl_document.gl_doc_file_location,

        gl_document.gl_doc_approve_status,

        gl_document.gl_doc_reson_detail,

        gl_document.gl_doc_approve_by,

        gl_document.gl_doc_status,

        gl_document.gl_doc_hashtag,

        gl_hashtag.gl_ht_name,

        gl_hashtag.gl_ht_doc_code

        FROM

        gl_document

        INNER JOIN gl_hashtag ON gl_hashtag.gl_ht_doc_code = gl_document.gl_doc_code 

        WHERE gl_document.gl_doc_status = 'Approved' AND gl_document.gl_doc_name LIKE '%$docname%'

        GROUP BY gl_doc_code DESC  ");

}



function gl_search_by_doccode($doccode)

{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT

        gl_document.gl_doc_id,

        gl_document.gl_doc_date_request,

        gl_document.gl_doc_username,

        gl_document.gl_doc_ecode,

        gl_document.gl_doc_deptcode,

        gl_document.gl_doc_deptname,

        gl_document.gl_doc_name,

        gl_document.gl_doc_code,

        gl_document.gl_doc_folder_number,

        gl_document.gl_doc_detail,

        gl_document.gl_doc_file,

        gl_document.gl_doc_file_location,

        gl_document.gl_doc_approve_status,

        gl_document.gl_doc_reson_detail,

        gl_document.gl_doc_approve_by,

        gl_document.gl_doc_status,

        gl_document.gl_doc_hashtag,

        gl_hashtag.gl_ht_name,

        gl_hashtag.gl_ht_doc_code

        FROM

        gl_document

        INNER JOIN gl_hashtag ON gl_hashtag.gl_ht_doc_code = gl_document.gl_doc_code 

        WHERE gl_document.gl_doc_status = 'Approved' AND gl_document.gl_doc_code LIKE '%$doccode%'

        GROUP BY gl_doc_code DESC  ");

}



function gl_search_by_hashtag($tag)

{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT

        gl_document.gl_doc_id,

        gl_document.gl_doc_date_request,

        gl_document.gl_doc_username,

        gl_document.gl_doc_ecode,

        gl_document.gl_doc_deptcode,

        gl_document.gl_doc_deptname,

        gl_document.gl_doc_name,

        gl_document.gl_doc_code,

        gl_document.gl_doc_folder_number,

        gl_document.gl_doc_detail,

        gl_document.gl_doc_file,

        gl_document.gl_doc_file_location,

        gl_document.gl_doc_approve_status,

        gl_document.gl_doc_reson_detail,

        gl_document.gl_doc_approve_by,

        gl_document.gl_doc_status,

        gl_document.gl_doc_hashtag,

        gl_hashtag.gl_ht_name,

        gl_hashtag.gl_ht_doc_code

        FROM

        gl_document

        INNER JOIN gl_hashtag ON gl_hashtag.gl_ht_doc_code = gl_document.gl_doc_code 

        WHERE gl_ht_name LIKE '%$tag%' AND gl_doc_status = 'Approved' GROUP BY gl_doc_code DESC  ");

}



// Search General Document Zone











//staff list document

function get_all_file()

{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT

        library_main.lib_main_id,

        library_main.lib_main_doccode,

        library_main.lib_main_doccode_master,

        library_main.lib_main_doccode_copy,

        library_main.lib_main_file_location_master,

        library_main.lib_main_file_location_copy,

        dc_related_dept_use.related_dept_code,

        dc_related_dept.related_dept_name,

        dc_datamain.dc_data_sub_type,

        dc_datamain.dc_data_sub_type_law,

        dc_datamain.dc_data_sub_type_sds,

        dc_sub_type.dc_sub_type_name,

        dc_datamain.dc_data_docname,

        dc_datamain.dc_data_doccode,

        dc_datamain.dc_data_darcode,

        dc_datamain.dc_data_doccode_display,

        dc_datamain.dc_data_edit,

        library_main.lib_main_status,

        library_hashtag.li_hashtag_name,

        library_hashtag.li_hashtag_doc_code,

        dc_datamain.dc_data_dept,

        dc_dept_main.dc_dept_main_name,

        dc_datamain.dc_data_date

        FROM

        library_main

        INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_doccode = library_main.lib_main_doccode

        INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code

        INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode

        INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

        INNER JOIN library_hashtag ON library_hashtag.li_hashtag_doc_code = library_main.lib_main_doccode

        INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

        WHERE

        library_main.lib_main_status = 'active'

        GROUP BY

        library_main.lib_main_doccode ORDER BY lib_main_id ASC");

}





function get_reason($reasonid){

    $obj = new myfn();

    $result = $obj->get_ci()->db->query("SELECT * FROM dc_reason_request WHERE dc_reason_code='$reasonid' ");

    $resonname = $result->row();

    return $resonname->dc_reason_name;

}





function get_deptcode_new($username)

{

    $obj = new myfn();

    $result = $obj->get_ci()->db->query("SELECT * FROM dc_user WHERE dc_user_username='$username' ");

    return $result->row();

}





// Get data reson from datamain table for check status un delete hastag on dcc add model

function get_data_reson($darcode)

{

    $obj = new myfn();

    $result = $obj->get_ci()->db->query("SELECT dc_data_reson FROM dc_datamain WHERE dc_data_darcode='$darcode' ");

    return $result->row();

}





function get_related_use($darcode)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT
        dc_related_dept.related_id,
        dc_related_dept.related_dept_name,
        dc_related_dept_use.related_dept_doccode,
        dc_related_dept_use.related_dept_darcode,
        dc_related_dept_use.related_dept_id,
        dc_related_dept_use.related_dept_code,
        dc_related_dept_use.related_dept_status
        FROM
        dc_related_dept
        INNER JOIN dc_related_dept_use ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
        WHERE related_dept_darcode='$darcode' ");
}



function count_darfile()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT dc_data_status FROM dc_datamain WHERE dc_data_status='Open' ");
    $count = $query->num_rows();
    return $count;
}


function count_ctrlDocfile()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT dct_status FROM dct_datamain WHERE dct_status = 'Open' ");
    $count = $query->num_rows();
    return $count;
}


function count_glfile()
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT gl_doc_status FROM gl_document WHERE gl_doc_status='Open' ");
    $count = $query->num_rows();
    return $count;
}


function count_dctFile($dctsubtype)
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT
    dct_library.dct_lib_status,
    dct_library.dct_lib_doccode,
    dct_datamain.dct_subtype,
    dct_datamain.dct_id
    FROM
    dct_library
    INNER JOIN dct_datamain ON dct_datamain.dct_doccode = dct_library.dct_lib_doccode AND dct_library.dct_lib_darcode = dct_datamain.dct_darcode
    WHERE
    dct_datamain.dct_subtype = '$dctsubtype' AND dct_lib_status = 'active'");
    $count = $query->num_rows();
    return $count;
}







function checkHashtag($hashtags)

{

    return preg_match('/^#{1}+([ก-เa-zA-Z0-9_]+)$/',$hashtags);

}









//Email function 

function get_email_user($query_where)

{

    $obj=new myfn();

    return $obj->get_ci()->db->query("SELECT dc_user_memberemail FROM dc_user WHERE $query_where ");

}


// Update send email for owner dept
function get_email_userOnlydept($query_where)

{

    $obj=new myfn();

    return $obj->get_ci()->db->query("SELECT dc_user_memberemail FROM dc_user WHERE $query_where ");

}

// สำหรับส่ง Email ให้ Manager Approve
function get_email_sendtoMgr($deptcode)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT dc_user_memberemail FROM dc_user WHERE dc_user_DeptCode = '$deptcode' and dc_user_group in (1,5) ");
}

function get_email_sendtoDcc()
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT dc_user_memberemail FROM dc_user WHERE dc_user_DeptCode = '1001' and dc_user_group = 1 ");
}

function get_email_sendccDept($deptcode)
{
    $obj = new myfn();
    return $obj->get_ci()->db->query("SELECT dc_user_memberemail FROM dc_user WHERE dc_user_DeptCode = '$deptcode' ");
}











// Get dc datastore

function get_dcdatastore()

{

    $obj=new myfn();

    $result = $obj->get_ci()->db->query("SELECT * FROM dc_datastore_cat ORDER BY dc_datastore_id ASC");

    return $result->result_array();

}









//Get Manager Email

function getManagerEmail($deptCode)

{

    $obj = new myfn();

    $result = $obj->get_ci()->login_model->getManagerEmail($deptCode);

    return $result;

}







//Check doccode

function checkDoccode($checkDoccode)

{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT dc_data_doccode_display FROM dc_datamain WHERE dc_data_doccode_display = '$checkDoccode' ");



}







function getgldataforemail($gldoccode)

{

    $obj = new myfn();

    return $obj->get_ci()->db->query("SELECT 

        gl_doc_id,

        gl_doc_date_request,

        gl_doc_username,

        gl_doc_ecode,

        gl_doc_deptcode,

        gl_doc_deptname,

        gl_doc_name,

        gl_doc_code,

        gl_doc_folder_number,

        gl_doc_detail,

        gl_doc_file,

        gl_doc_file_location,

        gl_doc_approve_status,

        gl_doc_reson_detail,

        gl_doc_approve_by,

        gl_doc_status,

        gl_dept_name

        FROM gl_document

        INNER JOIN gl_department on gl_department.gl_dept_code = gl_document.gl_doc_deptcode

        WHERE gl_doc_code = '$gldoccode'

        ");

}







function getDataFile($doccode)
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT * from library_main where lib_main_doccode = '$doccode'
        order by lib_main_id desc limit 1");
    return $query->row();
}

function getDataFileCtrlDoc($doccode)
{
    if($doccode != ""){
        $obj = new myfn();
        $sql = $obj->get_ci()->db->query("SELECT
        dct_library.dct_lib_doccode,
        dct_library.dct_lib_darcode,
        dct_library.dct_lib_status,
        dct_library.dct_lib_modify_status,
        dct_datamain.dct_file,
        dct_datamain.dct_file_location,
        dct_datamain.dct_dept,
        dc_dept_main.dc_dept_main_code
        FROM
        dct_library
        INNER JOIN dct_datamain ON dct_datamain.dct_doccode = dct_library.dct_lib_doccode AND dct_library.dct_lib_darcode = dct_datamain.dct_darcode
        INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dct_datamain.dct_dept
        WHERE
        dct_library.dct_lib_doccode = '$doccode' AND
        dct_library.dct_lib_status = 'active'
        
        ");
        return $sql;
    }
}







function getFormcode()

{

    $obj =new myfn();

    $query = $obj->get_ci()->db->query("SELECT * FROM dc_formcode ORDER BY dc_formcode_order DESC LIMIT 1");

    return $query->row()->dc_formcode_name;

}



function selectFormcode($darcode)

{

    $obj = new myfn();

    $query = $obj->get_ci()->db->query("SELECT dc_data_formcode FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");

    return $query->row()->dc_data_formcode;

}



// get dept code
function getnewdeptcode($ecodelogin)
{
    $obj = new myfn();
    $query = $obj->get_ci()->db->query("SELECT dc_user_new_dept_code FROM dc_user WHERE dc_user_ecode = '$ecodelogin' ");
    return $query->row();
}


function getDeptcodeName($deptcodeNew)
{
    if($deptcodeNew != ""){
        $obj = new myfn();
        $query = $obj->get_ci()->db->query("SELECT dc_dept_main_name FROM dc_dept_main WHERE dc_dept_code = '$deptcodeNew'");
        return $query->row()->dc_dept_main_name;
    }
}