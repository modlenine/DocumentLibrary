<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_lib_model extends CI_Model {

public function __construct()
{
    parent::__construct();
    //Do your magic here
}

public function get_deptlib($newdeptcode)
{
    return $this->db->query("SELECT
    dc_related_dept.related_id,
    dc_related_dept.related_code,
    dc_related_dept.related_dept_code,
    dc_related_dept.related_dept_name
    FROM
    dc_related_dept
    WHERE related_code='$newdeptcode' ");
}

public function getIsoDoclist($filterDocName , $filterDocCode , $filterDateStart , $filterDateEnd , $filterSubtype , $filterHashtag)
{
    $getuser = $this->get_new_user();
    $relatedcode = $getuser->dc_user_new_dept_code;
    $query_filterRelatedDept = "related_dept_code = '$relatedcode'";
    if(getUser()->ecode == "M1809" || getUser()->ecode == "M1447"){
        $query_filterRelatedDept = "related_dept_code = '$relatedcode'";
    }else if(getUser()->ecode == "M0040"){
        $query_filterRelatedDept = "related_dept_code IN ('re13' ,'re14' , 're11')";
    }

    $query_filterDocName = "";
    if($filterDocName != "0"){
        $query_filterDocName = "AND dc_data_docname LIKE '%$filterDocName%'";
    }

    $query_filterDocCode = "";
    if($filterDocCode != "0"){
        $query_filterDocCode = "AND dc_data_doccode LIKE '%$filterDocCode%'";
    }

    $query_filterDate = "";
    if($filterDateStart != "0" && $filterDateEnd != "0"){
        $query_filterDate = "AND dc_data_date BETWEEN '$filterDateStart' AND '$filterDateEnd'";
    }else if($filterDateStart != "0" && $filterDateEnd == "0"){
        $query_filterDate = "AND dc_data_date = '$filterDateStart'";
    }else if($filterDateStart == "0" && $filterDateEnd != "0"){
        $query_filterDate = "AND dc_data_date = '$filterDateEnd'";
    }

    $query_filterSubtype = "";
    if($filterSubtype != "0"){
        $query_filterSubtype = "AND dc_data_sub_type = '$filterSubtype'";
    }

    $query_filterHashtag = "";
    $query_table = "docIso_list";
    if($filterHashtag != "0"){
        $query_filterHashtag = "AND li_hashtag_name LIKE '%$filterHashtag%'";
        $query_table = "docIso_list_hashtag";
    }

    // DB table to use
    $table = $query_table;
    $primaryKey = 'dc_data_id';

    $columns = array(
        array(
            'db' => 'dc_data_doccode', 'dt' => 0,
            'formatter' => function ($d, $row) {
                $result = getdatalinkIsodoc($d)->row();
                return "<a href=".base_url('librarys/viewFull_document/').$result->dc_data_sub_type."/".$result->dc_data_dept."/".$d."><i class='fas fa-file-pdf' style='color:#CC0000;'></i>&nbsp;&nbsp;<b>$d</b></a>";
            }
        ),
        array('db' => 'dc_data_docname', 'dt' => 1),
        array('db' => 'dc_sub_type_name', 'dt' => 2),
        array('db' => 'dc_data_date', 'dt' => 3,
            'formatter' => function($d , $row){
                return con_date($d);
            }
        ),

    );

    // SQL server connection information
    $sql_details = array(
        'user' => getDatabase()->db_username,
        'pass' => getDatabase()->db_password,
        'db'   => getDatabase()->db_databasename,
        'host' => getDatabase()->db_host,
    );

    require('server-side/scripts/ssp.class.php');

    echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"$query_filterRelatedDept $query_filterDocName $query_filterDocCode $query_filterDate $query_filterSubtype $query_filterHashtag")
    );
}

public function getIsoDoclist_hashtag($hashtag)
{
    $getuser = $this->get_new_user();
    $relatedcode = $getuser->dc_user_new_dept_code;
    $query_filterRelatedDept = "related_dept_code = '$relatedcode'";
    if(getUser()->ecode == "M1809" || getUser()->ecode == "M1447"){
        $query_filterRelatedDept = "related_dept_code = '$relatedcode'";
    }else if(getUser()->ecode == "M0040"){
        $query_filterRelatedDept = "related_dept_code IN ('re13' ,'re14' , 're11')";
    }

    $query_icodoc_hashtag = "";
    if($hashtag != "0"){
        $query_icodoc_hashtag = "AND li_hashtag_name LIKE '%$hashtag%'";
    }else{
        $query_icodoc_hashtag = "";
    }



    // DB table to use
    $table = 'docIso_list_hashtag';
    $primaryKey = 'dc_data_id';

    $columns = array(
        array(
            'db' => 'dc_data_doccode', 'dt' => 0,
            'formatter' => function ($d, $row) {
                $result = getdatalinkIsodoc($d)->row();
                return "<a href=".base_url('librarys/viewFull_document/').$result->dc_data_sub_type."/".$result->dc_data_dept."/".$d."><i class='fas fa-file-pdf' style='color:#CC0000;'></i>&nbsp;&nbsp;<b>$d</b></a>";
            }
        ),
        array('db' => 'dc_data_docname', 'dt' => 1),
        array('db' => 'dc_sub_type_name', 'dt' => 2),
        array('db' => 'dc_data_date', 'dt' => 3,
            'formatter' => function($d , $row){
                return con_date($d);
            }
        ),

    );

    // SQL server connection information
    $sql_details = array(
        'user' => getDatabase()->db_username,
        'pass' => getDatabase()->db_password,
        'db'   => getDatabase()->db_databasename,
        'host' => getDatabase()->db_host,
    );

    require('server-side/scripts/ssp.class.php');

    echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null,"$query_filterRelatedDept $query_icodoc_hashtag")
    );
}


public function get_new_user()
{
    $result = $this->db->query("SELECT * FROM dc_user WHERE dc_user_username= '".$_SESSION['username']."' ");
    return $result->row();
}

public function get_doctype()
{
    return $this->db->get("dc_type");
}

public function get_sub_type()
{
    return $this->db->get("dc_sub_type");
}

public function get_file1($subtype,$related_code)
{
    return $this->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_file_location_master,
    library_main.lib_main_file_location_copy,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_sub_type.dc_sub_type_name,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_date,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_edit,
    library_main.lib_main_status,
    library_main.lib_main_modify_status,
    dc_related_dept.related_dept_name,
    dc_related_dept_use.related_dept_code
    FROM
    library_main
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
    WHERE
    dc_datamain.dc_data_sub_type = '$subtype' AND dc_related_dept_use.related_dept_code = '$related_code' AND
    library_main.lib_main_status = 'active'
    GROUP BY
    library_main.lib_main_doccode
    ");
}

//new function
public function new_getdata1($subtype,$related_code)
{
    $sql = $this->db->query("SELECT
    library_main.lib_main_id
    FROM library_main
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_darcode = library_main.lib_main_darcode
    WHERE
    dc_datamain.dc_data_sub_type = '$subtype' AND dc_related_dept_use.related_dept_code = '$related_code' AND
    library_main.lib_main_status = 'active'
    GROUP BY
    library_main.lib_main_doccode
    ");
    return $sql;
}


public function get_file2($subtype,$doccode)
{
    return $this->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    library_main.lib_main_doccode_master,
    library_main.lib_main_doccode_copy,
    library_main.lib_main_file_location_master,
    library_main.lib_main_file_location_copy,
    library_main.lib_main_status,
    library_main.lib_main_modify_status,
    dc_datamain.dc_data_id,
    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_type,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_sub_type_law,
    dc_datamain.dc_data_sub_type_sds,
    dc_datamain.dc_data_date,
    dc_datamain.dc_data_user,
    dc_datamain.dc_data_dept,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_doccode,
    dc_datamain.dc_data_law_doccode,
    dc_datamain.dc_data_sds_doccode,
    dc_datamain.dc_data_edit,
    dc_datamain.dc_data_date_start,
    dc_datamain.dc_data_store,
    dc_datamain.dc_data_store_type,
    dc_datamain.dc_data_reson,
    dc_datamain.dc_data_reson_detail,
    dc_datamain.dc_data_file,
    dc_datamain.dc_data_file_location,
    dc_datamain.dc_data_status,
    dc_datamain.dc_data_result_reson_status,
    dc_datamain.dc_data_result_reson_detail,
    dc_datamain.dc_data_date_approve_mgr,
    dc_datamain.dc_data_approve_mgr,
    dc_datamain.dc_data_result_reson_status2,
    dc_datamain.dc_data_result_reson_detail2,
    dc_datamain.dc_data_date_approve_qmr,
    dc_datamain.dc_data_approve_qmr,
    dc_datamain.dc_data_method,
    dc_datamain.dc_data_operation,
    dc_datamain.dc_data_date_operation,
    dc_sub_type.dc_sub_type_name
    FROM
    library_main
    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type
    WHERE dc_data_sub_type='$subtype' AND dc_data_doccode='$doccode' ORDER BY dc_data_id DESC
    ");
}

//For Loop
public function get_doc_type($subtype,$related_code)
{
    return $this->db->query("SELECT
    library_main.lib_main_id,
    library_main.lib_main_doccode,
    dc_type.dc_type_name,
    dc_type.dc_type_code
    FROM
    library_main
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_doccode = library_main.lib_main_doccode
    INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
    INNER JOIN dc_datamain ON dc_datamain.dc_data_doccode = library_main.lib_main_doccode
    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type
    INNER JOIN dc_type_use ON dc_type_use.dc_type_use_doccode = library_main.lib_main_doccode
    INNER JOIN dc_type ON dc_type.dc_type_code = dc_type_use.dc_type_use_code
    WHERE dc_data_sub_type='$subtype' AND dc_related_dept_use.related_dept_code='$related_code' 
    ");
}
//For Loop


public function get_dept_folder()
{
    return $this->db->get("gl_department");
}


public function count_gl_doc($folder_number,$dept_code)
{
    $query = $this->db->query("SELECT
    gl_document.gl_doc_id
    FROM
    gl_document
    WHERE gl_doc_folder_number='$folder_number' AND gl_doc_deptcode='$dept_code' AND gl_doc_approve_status=1 ");
    $count_sum = $query->num_rows();
    return $count_sum;
}


public function view_gl_document($deptcode,$folder_number)
{
    return $this->db->query("SELECT
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
    gl_document.gl_doc_status
    FROM
    gl_document
    WHERE gl_doc_deptcode='$deptcode' AND gl_doc_folder_number='$folder_number' AND gl_doc_approve_status=1 ORDER BY gl_doc_id DESC");
}


public function get_foldername_deptname($deptcode,$folder_number)
{
    return $this->db->query("SELECT
    gl_folder.gl_folder_id,
    gl_folder.gl_folder_number,
    gl_folder.gl_folder_name,
    gl_folder.gl_folder_dept_id,
    gl_folder.gl_folder_dept_code,
    gl_department.gl_dept_name
    FROM
    gl_folder
    INNER JOIN gl_department ON gl_department.gl_dept_code = gl_folder.gl_folder_dept_code
    WHERE gl_folder_dept_code='$deptcode' AND gl_folder_number='$folder_number' ");
}


public function viewfull_gl_document($deptcode,$folder_number,$gl_doccode)
{
    return $this->db->query("SELECT
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
    gl_document.gl_doc_status
    FROM
    gl_document
    WHERE gl_doc_deptcode='$deptcode' AND gl_doc_folder_number='$folder_number' AND gl_doc_code='$gl_doccode' AND gl_doc_approve_status=1 ");
}


public function gl_card($deptcode,$folder_number,$gl_doccode)
{
    return $this->db->query("SELECT
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
    gl_document.gl_doc_status
    FROM
    gl_document
    WHERE gl_doc_deptcode='$deptcode' AND gl_doc_folder_number='$folder_number' AND gl_doc_code='$gl_doccode' AND gl_doc_approve_status=1 ");
}


public function search_hashtag()
{
    $tag = $this->input->post("gl_doc_hashtag");
    if(isset($_POST['btn_search_hashtag'])){
        $result = $this->db->query("SELECT * FROM gl_document WHERE gl_doc_hashtag LIKE '%$tag%' ");
        return $result;
    }
}



public function getIsoDocHashTag()
{
    $getuser = $this->get_new_user();
    $relatedcode = $getuser->dc_user_new_dept_code;

    $sql = $this->db->query("SELECT
    library_hashtag.li_hashtag_name,
    dc_related_dept_use.related_dept_code
    FROM
    library_hashtag
    INNER JOIN library_main ON library_main.lib_main_doccode = library_hashtag.li_hashtag_doc_code
    INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_doccode = library_hashtag.li_hashtag_doc_code
    WHERE
    library_main.lib_main_status = 'active' 
    AND dc_related_dept_use.related_dept_status = 'active' 
    AND dc_related_dept_use.related_dept_code = '$relatedcode'
    GROUP BY library_hashtag.li_hashtag_name , dc_related_dept_use.related_dept_code 
    ORDER BY library_hashtag.li_hashtag_id DESC
    LIMIT 50
    ");

    $resultData = "";
    foreach($sql->result() as $rs){
        if($resultData == ""){
            $resultData .='<a href="javascript:void(0)" class="attr_isohashtag" data_hashtag="'.$rs->li_hashtag_name.'">'.$rs->li_hashtag_name.'</a>';
        }else{
            $resultData .=' <a href="javascript:void(0)" class="attr_isohashtag" data_hashtag="'.$rs->li_hashtag_name.'">'.$rs->li_hashtag_name.'</a>';
        }
    }

    $output = array(
        "msg" => "ดึงข้อมูล Hash Tag สำเร็จ",
        "status" => "Select Data Success",
        "result" => $resultData
    );

    echo json_encode($output);
}


public function getIsoDocHashTagSearch()
{
    $received_data = json_decode(file_get_contents("php://input"));
    if($received_data->action == "hashtagSearch"){
        $hashtag = $received_data->hashtagSearch;

        $getuser = $this->get_new_user();
        $relatedcode = $getuser->dc_user_new_dept_code;
    
        $sql = $this->db->query("SELECT
        library_hashtag.li_hashtag_name,
        dc_related_dept_use.related_dept_code
        FROM
        library_hashtag
        INNER JOIN library_main ON library_main.lib_main_doccode = library_hashtag.li_hashtag_doc_code
        INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_doccode = library_hashtag.li_hashtag_doc_code
        WHERE
        library_main.lib_main_status = 'active' 
        AND dc_related_dept_use.related_dept_status = 'active' 
        AND dc_related_dept_use.related_dept_code = '$relatedcode' AND library_hashtag.li_hashtag_name LIKE '%$hashtag%'
        GROUP BY library_hashtag.li_hashtag_name , dc_related_dept_use.related_dept_code LIMIT 50");
    
        $output = array(
            "msg" => "ดึงข้อมูล Hash Tag สำเร็จ",
            "status" => "Select Data Success",
            "result" => $sql->result()
        );
    }

    echo json_encode($output);
}

    

}

/* End of file ModelName.php */



?>