<?php
class Get_staff_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        date_default_timezone_set("Asia/Bangkok");
    }


    public function get_doc_list()
    {
        return $this->db->query("SELECT * FROM
            (SELECT MAX(dc_data_id) as dc_data_id_max , dc_data_doccode FROM dc_datamain GROUP BY dc_data_doccode)a
            INNER JOIN (SELECT * FROM dc_datamain)b ON a.dc_data_id_max = b.dc_data_id
            INNER JOIN (SELECT * FROM (SELECT MAX(lib_main_id) as lib_main_id_max  FROM library_main GROUP BY lib_main_doccode)c 
            INNER JOIN (SELECT * FROM library_main)d ON c.lib_main_id_max = d.lib_main_id)aa 
            ON a.dc_data_doccode = aa.lib_main_doccode");
    }

    
    public function view_full_data($doccode)
    {
        return $this->db->query("SELECT
            library_main.lib_main_id,
            library_main.lib_main_darcode,
            library_main.lib_main_doccode,
            library_main.lib_main_doccode_master,
            library_main.lib_main_doccode_copy,
            library_main.lib_main_file_location_master,
            library_main.lib_main_file_location_copy,
            library_main.lib_main_status,
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
            dc_datamain.dc_data_old_dar,
            dc_datamain.dc_date_modify,
            dc_reason_request.dc_reason_name,
            dc_sub_type.dc_sub_type_name
            FROM
            library_main
            INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode
            INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson
            INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type
            WHERE lib_main_doccode = '$doccode' ORDER BY dc_data_id DESC ");
    }

    public function save_dept()
    {
        if(isset($_POST['add_dept'])){
            $ar_dept =array(
                "gl_dept_code" => $this->input->post("gl_dept_code"),
                "gl_dept_name" => $this->input->post("gl_dept_name")
            );

            $result = $this->db->insert("gl_department",$ar_dept);
            if(!$result){
                echo "<script>";
                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
                echo "</script>";
            }else{
                echo "<script>";
                echo "alert('บันทึกข้อมูลสำเร็จ')";
                echo "</script>";
                header("refresh:0; url=".base_url('staff/manage_dept'));
            }



        }
    }


    public function get_dept()
    {
        return $this->db->get("gl_department");
    }



    public function select_dept($gl_dept_id)
    {
        return $this->db->query("SELECT * FROM gl_department WHERE gl_dept_id='$gl_dept_id' ");
    }

    public function get_folder($gl_dept_id)
    {
        return $this->db->query("SELECT * FROM gl_folder WHERE gl_folder_dept_id='$gl_dept_id' ");
    }


    public function view_user()
    {
        return $this->db->query("SELECT
        dc_user.dc_user_id,
        dc_user.dc_user_username,
        dc_user.dc_user_password,
        dc_user.dc_user_Fname,
        dc_user.dc_user_Lname,
        dc_user.dc_user_Dept,
        dc_user.dc_user_ecode,
        dc_user.dc_user_DeptCode,
        dc_user.dc_user_memberemail,
        dc_user.dc_user_group,
        dc_user.dc_user_status,
        dc_group_permission.dc_gp_permis_name
        FROM
        dc_user
        INNER JOIN dc_group_permission ON dc_group_permission.dc_gp_permis_code = dc_user.dc_user_group
        ORDER BY dc_user_id DESC");
    }


    public function load_reportDocument($reportdar_filterDateStart , $reportdar_filterDateEnd)
    {

        // DB table to use
        $table = 'report_darlist_new';
        $primaryKey = 'dc_data_id';

        $columns = array(
            array(
                'db' => 'dc_data_darcode', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),
            array('db' => 'dc_sub_type_name', 'dt' => 1),
            array('db' => 'dc_data_doccode', 'dt' => 2),
            array('db' => 'dc_data_docname', 'dt' => 3,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_data_edit', 'dt' => 4,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_reason_name', 'dt' => 5,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_data_storeplus', 'dt' => 6,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_data_date', 'dt' => 7,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dc_data_date_start', 'dt' => 8,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dc_data_date_operation' , 'dt' => 9 ,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dc_data_id' , 'dt' => 10 ,
                'formatter' => function($d , $row){
                    $queryData = getDateForCalcDuration($d);
                    $duration = durationNew($queryData->row()->dc_data_date , $queryData->row()->dc_data_date_operation);
                    return $duration;
                }
            ),
            array('db' => 'dc_data_darcode' , 'dt' => 11 ,
                'formatter' => function($d , $row){
                    $query = get_related_use($d);
                    $output = '';
                    foreach($query->result() as $rs){
                        if($output == ""){
                            $output .= $rs->related_dept_name;
                        }else{
                            $output .= ' , '.$rs->related_dept_name;
                        }
                    }
                    $shortString = substr($output, 0, 50);
                    return $shortString."...";
                }
            ),

        );

        // SQL server connection information
        $sql_details = array(
            'user' => getDatabase()->db_username,
            'pass' => getDatabase()->db_password,
            'db'   => getDatabase()->db_databasename,
            'host' => getDatabase()->db_host
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */

        $queryDateSearch = "";
        if($reportdar_filterDateStart == "0" && $reportdar_filterDateEnd == "0"){
            $queryDateSearch = "";
        }else if($reportdar_filterDateStart != "0" && $reportdar_filterDateEnd == "0"){
            $queryDateSearch = "dc_data_date = '$reportdar_filterDateStart'";
        }else if($reportdar_filterDateStart == "0" && $reportdar_filterDateEnd != "0"){
            $queryDateSearch = "dc_data_date = '$reportdar_filterDateEnd'";
        }else if($reportdar_filterDateStart != "0" && $reportdar_filterDateEnd != "0"){
            $queryDateSearch = "dc_data_date BETWEEN '$reportdar_filterDateStart' AND '$reportdar_filterDateEnd' ";
        }

        require('server-side/scripts/ssp.class.php');

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "$queryDateSearch")
        );
    }


    public function load_reportControlDocument($reportdar_filterDateStart , $reportdar_filterDateEnd)
    {

        // DB table to use
        $table = 'report_ctrldoclist_new';
        $primaryKey = 'dct_id';

        $columns = array(
            array(
                'db' => 'dct_darcode', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $d;
                }
            ),
            array('db' => 'dct_subtype_name', 'dt' => 1),
            array('db' => 'dct_doccode', 'dt' => 2),
            array('db' => 'dct_docname', 'dt' => 3,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dct_editcount', 'dt' => 4,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_reason_name', 'dt' => 5,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dct_data_storeplus', 'dt' => 6,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dct_date', 'dt' => 7,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dct_datestart', 'dt' => 8,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dct_datetimeapprove' , 'dt' => 9 ,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dct_id' , 'dt' => 10 ,
                'formatter' => function($d , $row){
                    $queryData = getDateForCalcDurationDocCtrl($d);
                    $duration = durationNew($queryData->row()->dct_date , $queryData->row()->dct_datetimeapprove);
                    return $duration;
                }
            ),
            array('db' => 'dct_darcode' , 'dt' => 11 ,
                'formatter' => function($d , $row){
                    return "All";
                }
            ),

        );

        // SQL server connection information
        $sql_details = array(
            'user' => getDatabase()->db_username,
            'pass' => getDatabase()->db_password,
            'db'   => getDatabase()->db_databasename,
            'host' => getDatabase()->db_host
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */

        $queryDateSearch = "";
        if($reportdar_filterDateStart == "0" && $reportdar_filterDateEnd == "0"){
            $queryDateSearch = "";
        }else if($reportdar_filterDateStart != "0" && $reportdar_filterDateEnd == "0"){
            $queryDateSearch = "dct_date = '$reportdar_filterDateStart'";
        }else if($reportdar_filterDateStart == "0" && $reportdar_filterDateEnd != "0"){
            $queryDateSearch = "dct_date = '$reportdar_filterDateEnd'";
        }else if($reportdar_filterDateStart != "0" && $reportdar_filterDateEnd != "0"){
            $queryDateSearch = "dct_date BETWEEN '$reportdar_filterDateStart' AND '$reportdar_filterDateEnd' ";
        }

        require('server-side/scripts/ssp.class.php');

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "$queryDateSearch")
        );
    }







    
}


?>