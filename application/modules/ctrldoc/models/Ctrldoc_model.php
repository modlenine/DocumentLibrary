<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrldoc_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model("ctrldocemail_model");
    }

    public function get_ctrldocSubtype()
    {
        $sql = $this->db->query("SELECT
        dct_subtype_code,
        dct_subtype_name
        FROM dct_subtype
        ORDER BY dct_subtype_code ASC
        ");
        return $sql;
    }

    public function get_ctrldocReason()
    {
        $sql = $this->db->query("SELECT
        dc_reason_code,
        dc_reason_name
        FROM dct_reason_request ORDER BY dc_reason_id
        ");
        return $sql;
    }

    public function save_ctrldocNew()
    {
        if($this->input->post("formcode-ctrl") != ""){

            $dataDept_ctrl = $this->input->post("dataDept-ctrl");
            $dct_subtype_code = $this->input->post("datasubtype-ctrl");

            $get_darcode = getReqDocFormno();
            $get_doc_code = $this->get_ctrldoccode($dataDept_ctrl , $dct_subtype_code);
            $dc_data_sub_type = $this->input->post('dc_data_sub_type');
            $fullDoccodeDisplay = "";
            if($get_doc_code != ""){
                $fullDoccodeDisplay = $get_doc_code."-00-".date("d-m-Y");
            }

            if($fullDoccodeDisplay != ""){
                $armain = array(
                    "dct_doccode" => $get_doc_code,
                    "dct_doccode_display" => $fullDoccodeDisplay,
                    "dct_darcode" => $get_darcode,
                    "dct_type" => $this->input->post("datatype-ctrl"),
                    "dct_subtype" => $this->input->post("datasubtype-ctrl"),
                    "dct_date" => $this->input->post("dataDate-ctrl"),
                    "dct_user" => $this->input->post("datauser-ctrl"),
                    "dct_dept" => $this->input->post("dataDept-ctrl"),
                    "dct_docname" => $this->input->post("dataDocname-ctrl"),
                    "dct_editcount" => $this->input->post("dataEdit-ctrl"),
                    "dct_datestart" => $this->input->post("dataDateStart-ctrl"),
                    "dct_store" => $this->input->post("dataStore-ctrl"),
                    "dct_store_type" => $this->input->post("dataStoreType-ctrl"),
                    "dct_reson" => $this->input->post("dataReason-ctrl"),
                    "dct_reson_detail" => $this->input->post("dataReasonDetail-ctrl"),
                    "dct_status" => "Create Request Form",
                );
                $this->db->insert("dct_datamain", $armain);
    
                // Loop insert related department
                $related_dept_code = $this->input->post("relatedDeptcode-ctrl");
                foreach ($related_dept_code as $related_dept_codes) {
                    $arrelated = array(
                        "related_dept_doccode" => $get_doc_code,
                        "related_dept_darcode" => $get_darcode,
                        "related_dept_code" => $related_dept_codes,
                        "related_dept_status" => "active"
                    );
                    $this->db->insert("dct_related_dept_use", $arrelated);
                }
                // Loop insert related department
    
    
                // Loop insert System Category
                $sys_cat = $this->input->post("datatype-ctrl");
                $arsys_cat = array(
                    "dc_type_use_doccode" => $get_doc_code,
                    "dc_type_use_darcode" => $get_darcode,
                    "dc_type_use_code" => $sys_cat,
                    "dc_type_use_status" => "active"
                );
                $this->db->insert("dct_type_use", $arsys_cat);
                // Loop insert System Category
    
    
                // check Hashtag
                $li_get_hashtag = $this->input->post("hashtag_ctrldoc");
                        $cutHash = "";
                foreach ($li_get_hashtag as $lgd) {

                    if (strpos($lgd, "#") !== false) {
                        // ถ้ามี "#" ในข้อความ
                        $cutHash = str_replace("#", "", $lgd);
                        $cutHash = str_replace(" ", "", $cutHash);
                        $newText = "#".$cutHash;
                    } else {
                        // ถ้าไม่มี "#" ในข้อความ
                        $newText = "#".$lgd;
                    }

                    $ar_li_hashtag = array(
                        "dct_hashtag_doc_code" => $get_doc_code,
                        "dct_hashtag_name" => $newText,
                        "dct_hashtag_status" => "pending"
                    );
                    $this->db->insert("dct_hashtag", $ar_li_hashtag);
                }

                $output = array(
                    "msg" => "บันทึกข้อมูลสำเร็จ",
                    "status" => "Insert Data Success"
                );
            }else{
                $output = array(
                    "msg" => "บันทึกข้อมูลไม่สำเร็จ ไม่พบเลขที่เอกสาร",
                    "status" => "Insert Data Not Success"
                );
            }

        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }

    public function save_ctrldocNew_manual()
    {
        if($this->input->post("formcode-ctrl-manual") != ""){

            //check doccode Duplicate
            $resultCheckDoccode = $this->checkDoccodeDuplicate($this->input->post("dataDoccode-ctrl-manual"));
            if($resultCheckDoccode->num_rows() == 0){
                
                $dataDept_ctrl = $this->input->post("dataDept-ctrl-manual");
                $dct_subtype_code = $this->input->post("datasubtype-ctrl-manual");
    
                $get_darcode = getReqDocFormno();
                $get_doc_code = $this->input->post("dataDoccode-ctrl-manual");
                $dc_data_sub_type = $this->input->post('dc_data_sub_type-manual');
                $fullDoccodeDisplay = "";
                if($get_doc_code != ""){
                    $fullDoccodeDisplay = $get_doc_code."-00-".con_date2($this->input->post("dataDate-ctrl-manual"));
                }
    
                if($fullDoccodeDisplay != ""){
                    $armain = array(
                        "dct_doccode" => $get_doc_code,
                        "dct_doccode_display" => $fullDoccodeDisplay,
                        "dct_darcode" => $get_darcode,
                        "dct_type" => $this->input->post("datatype-ctrl-manual"),
                        "dct_subtype" => $this->input->post("datasubtype-ctrl-manual"),
                        "dct_date" => $this->input->post("dataDate-ctrl-manual"),
                        "dct_user" => $this->input->post("datauser-ctrl-manual"),
                        "dct_dept" => $this->input->post("dataDept-ctrl-manual"),
                        "dct_docname" => $this->input->post("dataDocname-ctrl-manual"),
                        "dct_editcount" => $this->input->post("dataEdit-ctrl-manual"),
                        "dct_datestart" => $this->input->post("dataDateStart-ctrl-manual"),
                        "dct_store" => $this->input->post("dataStore-ctrl-manual"),
                        "dct_store_type" => $this->input->post("dataStoreType-ctrl-manual"),
                        "dct_reson" => $this->input->post("dataReason-ctrl-manual"),
                        "dct_reson_detail" => $this->input->post("dataReasonDetail-ctrl-manual"),
                        "dct_status" => "Create Request Form",
                    );
                    $this->db->insert("dct_datamain", $armain);
        
                    // Loop insert related department
                    $related_dept_code = $this->input->post("relatedDeptcode-ctrl-manual");
                    foreach ($related_dept_code as $related_dept_codes) {
                        $arrelated = array(
                            "related_dept_doccode" => $get_doc_code,
                            "related_dept_darcode" => $get_darcode,
                            "related_dept_code" => $related_dept_codes,
                            "related_dept_status" => "active"
                        );
                        $this->db->insert("dct_related_dept_use", $arrelated);
                    }
                    // Loop insert related department
        
        
                    // Loop insert System Category
                    $sys_cat = $this->input->post("datatype-ctrl-manual");
                    $arsys_cat = array(
                        "dc_type_use_doccode" => $get_doc_code,
                        "dc_type_use_darcode" => $get_darcode,
                        "dc_type_use_code" => $sys_cat,
                        "dc_type_use_status" => "active"
                    );
                    $this->db->insert("dct_type_use", $arsys_cat);
                    // Loop insert System Category
        
        
                    $li_get_hashtag = $this->input->post("hashtag_ctrldoc-manual");
                    foreach ($li_get_hashtag as $lgd) {

                        if (strpos($lgd, "#") !== false) {
                            // ถ้ามี "#" ในข้อความ
                            $cutHash = str_replace("#", "", $lgd);
                            $cutHash = str_replace(" ", "", $cutHash);
                            $newText = "#".$cutHash;
                        } else {
                            // ถ้าไม่มี "#" ในข้อความ
                            $newText = "#".$lgd;
                        }

                        $ar_li_hashtag = array(
                            "dct_hashtag_doc_code" => $get_doc_code,
                            "dct_hashtag_name" => $newText,
                            "dct_hashtag_status" => "pending"
                        );
                        $this->db->insert("dct_hashtag", $ar_li_hashtag);
                    }
    
                    $output = array(
                        "msg" => "บันทึกข้อมูลสำเร็จ",
                        "status" => "Insert Data Success"
                    );
                }else{
                    $output = array(
                        "msg" => "บันทึกข้อมูลไม่สำเร็จ ไม่พบเลขที่เอกสาร",
                        "status" => "Insert Data Not Success"
                    );
                }
            }else{
                $output = array(
                    "msg" => "ตรวจพบเลขเอกสารซ้ำในระบบ",
                    "status" => "Found Duplicate Doccode"
                );
            }


        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }

    private function checkDoccodeDuplicate($doccodeInput)
    {
        if($doccodeInput != ""){
            $sql = $this->db->query("SELECT
            dct_doccode
            FROM dct_datamain WHERE dct_doccode LIKE '%$doccodeInput%'
            ");
            return $sql;
        }
    }

    private function get_ctrldoccode($dataDept_ctrl , $dct_subtype_code)
    {
        $dcDataDoccodeSearch = "";
        $deptcodeShortName = $this->getShortDeptName($dataDept_ctrl);
        $dcDataDoccodeSearch = $deptcodeShortName."-".$dct_subtype_code; //WH-01

        $sql = $this->db->query("SELECT
        dct_doccode ,
        SUBSTR(dct_doccode,7,3)AS cutdc_data_sub_type
        FROM dct_datamain WHERE dct_doccode LIKE '%$dcDataDoccodeSearch%'
        ORDER BY SUBSTR(dct_doccode,7,3) DESC LIMIT 1
        ");

        // check data
        $docNo = 0;
        $docNoCode = "";
        if($sql->num_rows() != 0){
            $docNo = intval($sql->row()->cutdc_data_sub_type);
            $docNo = $docNo+1;

            if ($docNo < 10) {
                $docNoCode = "00" . $docNo;
            } else if ($docNo >= 10 && $docNo < 100) {
                $docNoCode = "0" . $docNo;
            } else {
                $docNoCode = $docNo;
            }
        }else{
            $docNoCode = "001";
        }

        return $dcDataDoccodeSearch."-".$docNoCode;
    }

    private function getShortDeptName($dataDept_ctrl)
    {
        if($dataDept_ctrl != ""){
            $sql = $this->db->query("SELECT
            dc_dept_short_name
            FROM dc_dept_main WHERE dc_dept_code = '$dataDept_ctrl'
            ");

            return $sql->row()->dc_dept_short_name;
        }
    }

    public function get_listCtrlDoc()
    {
        // DB table to use
        $table = 'docCtrl_list';
        $primaryKey = 'dct_id';

        $columns = array(
            array(
                'db' => 'dct_darcode', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    $sqlQuery = getDataFromDocctrlcode($d);
                    if($sqlQuery->row()->dct_status == "Create Request Form") {
                        $linkpage = "ctrl_add2/";
                    }else if($sqlQuery->row()->dct_status == "User Cancel"){
                        $linkpage = "viewfull_ctrldoc_cancel/";
                    }else{
                        $linkpage = "ctrldoc_viewfull/";
                    }

                    return '<b><a href="'.base_url("ctrldoc/").$linkpage.$d.'">' . $d . '</a></b>'; //or any other format you require
                }
            ),
            array('db' => 'dct_doccode', 'dt' => 1),
            array('db' => 'dct_subtype_name', 'dt' => 2),
            array('db' => 'dct_date', 'dt' => 3,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dct_datetimeapprove', 'dt' => 4,
                'formatter' => function($d , $row){
                    return con_date($d);
                }
            ),
            array('db' => 'dct_user', 'dt' => 5,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dc_reason_name', 'dt' => 6,
                'formatter' => function($d , $row){
                    return $d;
                }
            ),
            array('db' => 'dct_status', 'dt' => 7,
                'formatter' => function($d , $row){
                    if ($d == "Manager Approved" || $d == "Qmr Approved" || $d == "Complete") {
                        $tdcolor = '  style="color:green"  ';
                    } else if ($d == "Manager Not Approve" || $d == "Qmr Not Approve") {
                        $tdcolor = '  style="color:red"  ';
                    } else if ($d == "Open") {
                        $tdcolor = '  style="color:#33CCFF"  ';
                    } else {
                        $tdcolor = '';
                    }
                    return "<span $tdcolor><b>".$d."</b></span>";
                }
            ),
            array('db' => 'dct_id', 'dt' => 8,
                'formatter' => function($d , $row){
                    $queryData = getDateForCalcDurationDocCtrl($d);
                    $duration = durationNew($queryData->row()->dct_date , $queryData->row()->dct_datetimeapprove);
                    return $duration;
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
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, null)
        );
    }
    

    public function getFulldata($darcode)
    {
        if($darcode != ""){
            $sql = $this->db->query("SELECT
            dct_id,
            dct_darcode,
            dct_type,
            dct_subtype,
            dct_date,
            dct_user,
            dct_dept,
            dct_docname,
            dct_doccode_display,
            dct_doccode,
            dct_editcount,
            dct_datestart,
            dct_store,
            dct_store_type,
            dct_reson,
            dct_reson_detail,
            dct_status,
            dct_file_location,
            dct_file,
            dct_result_reson_status,
            dct_result_reson_detail,
            dct_userapprove,
            dct_datetimeapprove,
            dct_olddar
            FROM dct_datamain
            WHERE dct_darcode = '$darcode'
            ");

            return $sql;
        }
    }

    public function getDctHashtag($doccode)
    {
        if($doccode != ""){
            $sql = $this->db->query("SELECT
            dct_hashtag_name
            FROM dct_hashtag WHERE dct_hashtag_doc_code = '$doccode'
            ");
            return $sql;
        }
    }


    public function ctrl_saveEditsec1()
    {
        if($this->input->post("darcode-ctrlEdit") != ""){
            $arSaveEdit = array(
                "dct_subtype" => $this->input->post("datasubtype-ctrlEdit"),
                "dct_date" => $this->input->post("dataDate-ctrlEdit"),
                "dct_user" => $this->input->post("datauser-ctrlEdit"),
                "dct_dept" => $this->input->post("dataDept-ctrlEdit"),
                "dct_docname" => $this->input->post("dataDocname-ctrlEdit"),
                "dct_datestart" => $this->input->post("dataDateStart-ctrlEdit"),
                "dct_store" => $this->input->post("dataStore-ctrlEdit"),
                "dct_store_type" => $this->input->post("dataStoreType-ctrlEdit"),
                "dct_reson_detail" => $this->input->post("dataReasonDetail-ctrlEdit"),
                "dct_status" => "Create Request Form",
            );
            $this->db->where("dct_darcode" , $this->input->post("darcode-ctrlEdit"));
            $this->db->update("dct_datamain" , $arSaveEdit);

            $output = array(
                "msg" => "บันทึกการแก้ไขข้อมูลสำเร็จ",
                "status" => "Update Data Success"
            );
        }else{
            $output = array(
                "msg" => "บันทึกการแก้ไขข้อมูลไม่สำเร็จ",
                "status" => "Update Data Not Success"
            );
        }

        echo json_encode($output);
    }


    public function cancelCtrlDoc()
    {
        $received_data = json_decode(file_get_contents("php://input"));

        if($received_data->action == "cancelCtrlDoc"){
            $darcode = $received_data->darcode;
            $doccode = $received_data->doccode;
            $arCancelCtrldoc = array(
                "dct_status" => "User Cancel",
                "dct_doccode_display" => "user cancel",
                "dct_doccode" => "user cancel"
            );
            $this->db->where("dct_darcode" , $darcode);
            $this->db->update("dct_datamain" , $arCancelCtrldoc);

            $this->cancelSec1_deleteHashtag($doccode);
            $this->cancelSec1_deleteRelatedDeptUse($darcode);
            $this->cancelSec1_deleteTypeUse($darcode);
        }

        $output = array(
            "msg" => "ยกเลิกเอกสารสำเร็จ",
            "status" => "Update Data Success"
        );
        echo json_encode($output);
    }

    private function cancelSec1_deleteHashtag($doccode)
    {
        $this->db->where("dct_hashtag_doc_code", $doccode);
        $this->db->delete("dct_hashtag");
    }

    private function cancelSec1_deleteRelatedDeptUse($darcode)
    {
        $this->db->where("related_dept_darcode", $darcode);
        $this->db->delete("dct_related_dept_use");
    }

    private function cancelSec1_deleteTypeUse($darcode)
    {
        $arInactive = array(
            "dc_type_use_status" => "inactive"
        );
        $this->db->where("dc_type_use_darcode", $darcode);
        $this->db->update("dct_type_use" , $arInactive);
    }

    public function saveUploadCtrlDoc()
    {
        $checkFile = $_FILES["dataFile-ctrl2"]['tmp_name'] !== "";
        if($checkFile === true){

            $fileInput = "dataFile-ctrl2";
            $darcode = $this->input->post("dataDarcode-ctrl2");
            $doccodeDisplay = $this->input->post("dataDoccode-ctrl2");
            uploadCtrlDoc($fileInput , $darcode , $doccodeDisplay);

            //Send Email
            $this->ctrldocemail_model->sendemailToDcc($darcode);
            

            $output = array(
                "msg" => "อัพโหลดไฟล์สำเร็จ",
                "status" => "Update Data Success",
            );
        }else{
            $output = array(
                "msg" => "อัพโหลดไฟล์ไม่สำเร็จ",
                "status" => "Update Data Not Success"
            );
        }

        // $output = array(
        //     "test" => $checkFile
        // );

        echo json_encode($output);
    }


    public function saveDccApprove()
    {
        if($this->input->post("dct_approveType") != ""){

            $status = "";
            if($this->input->post("dct_approveType") == "อนุมัติ"){
                $status = "Complete";
            }else if($this->input->post("dct_approveType") == "ไม่อนุมัติ"){
                $status = "Not Approve";
            }

            $arSaveDccApprove = array(
                "dct_result_reson_status" => $this->input->post("dct_approveType"),
                "dct_result_reson_detail" => $this->input->post("dct_approveReason"),
                "dct_userapprove" => $this->input->post("dct_approveUsername"),
                "dct_datetimeapprove" => date("Y-m-d H:i:s"),
                "dct_status" => $status
            );
            $this->db->where("dct_darcode" , $this->input->post("dct_approveDarcode"));
            $this->db->update("dct_datamain" , $arSaveDccApprove);

            if($this->input->post("dct_approveType") == "อนุมัติ"){
                $lib_status_txt = "";
                if($this->input->post("dct_approve_reson") == "rt-05"){
                    $lib_status_txt = "inactive";
                }else{
                    $lib_status_txt = "active";
                }
                $arSaveDctLibrary = array(
                    "dct_lib_darcode" => $this->input->post("dct_approveDarcode"),
                    "dct_lib_doccode" => $this->input->post("dct_approveDoccode"),
                    "dct_lib_datetime" => date("Y-m-d H:i:s"),
                    "dct_lib_status" => $lib_status_txt
                );
                $this->db->insert("dct_library" , $arSaveDctLibrary);


                //update status hashtag
                $arupdateHashtag = array(
                    "dct_hashtag_status" => "active"
                );
                $this->db->where("dct_hashtag_doc_code" , $this->input->post("dct_approveDoccode"));
                $this->db->update("dct_hashtag" , $arupdateHashtag);


                //check rt04
                if($this->input->post("dct_approve_olddar") != ""){
                    if($this->input->post("dct_approve_reson") == "rt-04" || $this->input->post("dct_approve_reson") == "rt-05"){
                        //change dct_lib_modify_status
                        $archangeModifyStatus = array(
                            "dct_lib_modify_status" => null,
                            "dct_lib_status" => "inactive"
                        );
                        $this->db->where("dct_lib_darcode" , $this->input->post("dct_approve_olddar"));
                        $this->db->update("dct_library" , $archangeModifyStatus);
                    }

                }

            }else if($this->input->post("dct_approveType") == "ไม่อนุมัติ"){

                //update status hashtag
                $arupdateHashtag = array(
                    "dct_hashtag_status" => "inactive"
                );
                $this->db->where("dct_hashtag_doc_code" , $this->input->post("dct_approveDoccode"));
                $this->db->update("dct_hashtag" , $arupdateHashtag);

                //check rt04
                if($this->input->post("dct_approve_olddar") != ""){
                    if($this->input->post("dct_approve_reson") == "rt-04" || $this->input->post("dct_approve_reson") == "rt-05"){
                        //change dct_lib_modify_status
                        $archangeModifyStatus = array(
                            "dct_lib_modify_status" => null,
                            "dct_lib_status" => "active"
                        );
                        $this->db->where("dct_lib_darcode" , $this->input->post("dct_approve_olddar"));
                        $this->db->update("dct_library" , $archangeModifyStatus);
                    }

                }
            }

            $this->ctrldocemail_model->sendemailBackToUser($this->input->post("dct_approveDarcode"));

            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "Update Data Success"
            );
        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Update Data Success"
            );
        }


        echo json_encode($output);
    }

    public function getDctSubtype()
    {
        $sql = $this->db->query("SELECT
        dct_subtype_code ,
        dct_subtype_name
        FROM dct_subtype ORDER BY dct_subtype_code ASC
        ");
        return $sql;
    }

    public function getCtrlDoclist($ctrldoc_filterDocName , $ctrldoc_filterDocCode , $ctrldoc_filterDateStart , $ctrldoc_filterDateEnd , $ctrldoc_fillterSubtype)
    {
        //query zone
        $query_ctrldoc_filterDocName = "";
        if($ctrldoc_filterDocName != "0"){
            $query_ctrldoc_filterDocName = "dct_docname LIKE '%$ctrldoc_filterDocName%'";
        }else{
            $query_ctrldoc_filterDocName = "dct_docname LIKE '%%'";
        }

        $query_ctrldoc_filterDocCode = "";
        if($ctrldoc_filterDocCode != "0"){
            $query_ctrldoc_filterDocCode = "AND dct_doccode LIKE '%$ctrldoc_filterDocCode%'";
        }else{
            $query_ctrldoc_filterDocCode = "";
        }

        $query_ctrldoc_filterDate = "";
        if($ctrldoc_filterDateStart == "0" && $ctrldoc_filterDateEnd == "0"){
            $query_ctrldoc_filterDate = "";
        }else if($ctrldoc_filterDateStart == "0" && $ctrldoc_filterDateEnd != "0"){
            $query_ctrldoc_filterDate = "AND dct_date = '$ctrldoc_filterDateEnd'";
        }else if($ctrldoc_filterDateStart != "0" && $ctrldoc_filterDateEnd == "0"){
            $query_ctrldoc_filterDate = "AND dct_date = '$ctrldoc_filterDateStart'";
        }else if($ctrldoc_filterDateStart != "0" && $ctrldoc_filterDateEnd != "0"){
            $query_ctrldoc_filterDate = "AND dct_date BETWEEN '$ctrldoc_filterDateStart' AND '$ctrldoc_filterDateEnd' ";
        }

        $query_ctrldoc_filterSubtype = "";
        if($ctrldoc_fillterSubtype != "0"){
            $query_ctrldoc_filterSubtype = "AND dct_subtype_code = '$ctrldoc_fillterSubtype'";
        }else{
            $query_ctrldoc_filterSubtype = "";
        }





        // DB table to use
        $table = 'doc_list_new';
        $primaryKey = 'dct_id';

        $columns = array(
            array(
                'db' => 'dct_doccode', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return '<i class="fas fa-file-pdf" style="color:#CC0000;">&nbsp;&nbsp;<b><a href="'.base_url("ctrldoc/viewfull_library_ctrldoc/").$d.'">' . $d . '</a></b></i>'; //or any other format you require
                }
            ),
            array('db' => 'dct_docname', 'dt' => 1),
            array('db' => 'dct_subtype_name', 'dt' => 2),
            array('db' => 'dct_date', 'dt' => 3,
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

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */
        require('server-side/scripts/ssp.class.php');

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "$query_ctrldoc_filterDocName $query_ctrldoc_filterDocCode $query_ctrldoc_filterDate $query_ctrldoc_filterSubtype")
        );
    }

    public function getCtrlDoclist_hashtag($hashtag)
    {
        $query_ctrldoc_hashtag = "";
        if($hashtag != "0"){
            $query_ctrldoc_hashtag = "dct_hashtag_name LIKE '%$hashtag%'";
        }else{
            $query_ctrldoc_hashtag = "";
        }

        // DB table to use
        $table = 'doc_list_new';
        $primaryKey = 'dct_id';

        $columns = array(
            array(
                'db' => 'dct_doccode', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return '<i class="fas fa-file-pdf" style="color:#CC0000;">&nbsp;&nbsp;<b><a href="'.base_url("ctrldoc/viewfull_library_ctrldoc/").$d.'">' . $d . '</a></b></i>'; //or any other format you require
                }
            ),
            array('db' => 'dct_docname', 'dt' => 1),
            array('db' => 'dct_subtype_name', 'dt' => 2),
            array('db' => 'dct_date', 'dt' => 3,
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

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */
        require('server-side/scripts/ssp.class.php');

        echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "$query_ctrldoc_hashtag")
        );
    }


    public function getData_viewfull_library_ctrldoc($doccode)
    {
        if($doccode != ""){
            $sql = $this->db->query("SELECT
            dct_datamain.dct_id,
            dct_datamain.dct_darcode,
            dct_datamain.dct_type,
            dct_datamain.dct_subtype,
            dct_datamain.dct_date,
            dct_datamain.dct_user,
            dct_datamain.dct_dept,
            dct_datamain.dct_docname,
            dct_datamain.dct_doccode_display,
            dct_datamain.dct_doccode,
            dct_datamain.dct_editcount,
            dct_datamain.dct_datestart,
            dct_datamain.dct_store,
            dct_datamain.dct_store_type,
            dct_datamain.dct_reson,
            dct_datamain.dct_reson_detail,
            dct_datamain.dct_file,
            dct_datamain.dct_file_location,
            dct_datamain.dct_status,
            dct_datamain.dct_result_reson_status,
            dct_datamain.dct_result_reson_detail,
            dct_datamain.dct_olddar,
            dct_datamain.dct_datetimemodify,
            dct_datamain.dct_formcode,
            dct_library.dct_lib_status,
            dct_library.dct_lib_modify_status,
            dct_library.dct_lib_datetime,
            dct_subtype.dct_subtype_name,
            dct_reason_request.dc_reason_name
            FROM
            dct_datamain
            INNER JOIN dct_library ON dct_library.dct_lib_doccode = dct_datamain.dct_doccode AND dct_library.dct_lib_darcode = dct_datamain.dct_darcode
            INNER JOIN dct_subtype ON dct_subtype.dct_subtype_code = dct_datamain.dct_subtype
            INNER JOIN dct_reason_request ON dct_reason_request.dc_reason_code = dct_datamain.dct_reson
            WHERE
            dct_datamain.dct_status = 'Complete' AND
            dct_datamain.dct_doccode = '$doccode'
            ORDER BY
            dct_datamain.dct_datestart DESC
            
             ");
    
             return $sql;
        }

    }


    // public function requestEditCtrlDoc($activeDarcode)
    // {
    //     if($activeDarcode !=""){
    //         //insert pending status to dct_library
    //         $arrayInsertPending = array(
    //             "dct_lib_modify_status" => "pending"
    //         );
    //         $this->db->where("dct_lib_darcode" , $activeDarcode);
    //         $this->db->update("dct_library" , $arrayInsertPending);

    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    // public function requestCancelCtrlDoc($activeDarcode)
    // {
    //     if($activeDarcode !=""){
    //         //insert pending status to dct_library
    //         $arrayInsertPending = array(
    //             "dct_lib_modify_status" => "pending"
    //         );
    //         $this->db->where("dct_lib_darcode" , $activeDarcode);
    //         $this->db->update("dct_library" , $arrayInsertPending);

    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    public function save_ctrldoc_rt04()
    {
        $checkFile = $_FILES["dataFile-ctrl2-rt04"]['tmp_name'] !== "";
        if($checkFile === true){
            $dataDept_ctrl = $this->input->post("dataDept-ctrl2-rt04");
            $dct_subtype_code = $this->input->post("datasubtype-ctrl2-rt04");

            $get_darcode = getReqDocFormno();
            $get_doc_code = $this->input->post("dataDoccode-ctrl2-rt04");
            $dc_data_sub_type = $this->input->post('dc_data_sub_type');
            $dataEdit = $this->input->post("dataEdit-ctrl2-rt04");
            $fullDoccodeDisplay = "";
            if($get_doc_code != ""){
                $fullDoccodeDisplay = $get_doc_code."-$dataEdit-".date("d-m-Y");
            }

            if($fullDoccodeDisplay != ""){
                $armain = array(
                    "dct_doccode" => $get_doc_code,
                    "dct_doccode_display" => $fullDoccodeDisplay,
                    "dct_darcode" => $get_darcode,
                    "dct_type" => $this->input->post("datatype-ctrl2-rt04"),
                    "dct_subtype" => $this->input->post("datasubtype-ctrl2-rt04"),
                    "dct_date" => $this->input->post("dataDate-ctrl2-rt04"),
                    "dct_user" => $this->input->post("datauser-ctrl2-rt04"),
                    "dct_dept" => $this->input->post("dataDept-ctrl2-rt04"),
                    "dct_docname" => $this->input->post("dataDocname-ctrl2-rt04"),
                    "dct_editcount" => $this->input->post("dataEdit-ctrl2-rt04"),
                    "dct_datestart" => $this->input->post("dataDateStart-ctrl2-rt04"),
                    "dct_store" => $this->input->post("dataStore-ctrl2-rt04"),
                    "dct_store_type" => $this->input->post("dataStoreType-ctrl2-rt04"),
                    "dct_reson" => $this->input->post("dataReason-ctrl2-rt04"),
                    "dct_reson_detail" => $this->input->post("dataReasonDetail-ctrl2-rt04"),
                    "dct_status" => "Open",
                    "dct_olddar" => $this->input->post("oldDarcode-ctrl2-rt04")
                );
                $this->db->insert("dct_datamain", $armain);
    
                // Loop insert related department
                $related_dept_code = $this->input->post("relatedDeptcode-ctrl2-rt04");
                foreach ($related_dept_code as $related_dept_codes) {
                    $arrelated = array(
                        "related_dept_doccode" => $get_doc_code,
                        "related_dept_darcode" => $get_darcode,
                        "related_dept_code" => $related_dept_codes,
                        "related_dept_status" => "active"
                    );
                    $this->db->insert("dct_related_dept_use", $arrelated);
                }
                // Loop insert related department
    
    
                // Loop insert System Category
                $sys_cat = $this->input->post("datatype-ctrl2-rt04");
                $arsys_cat = array(
                    "dc_type_use_doccode" => $get_doc_code,
                    "dc_type_use_darcode" => $get_darcode,
                    "dc_type_use_code" => $sys_cat,
                    "dc_type_use_status" => "active"
                );
                $this->db->insert("dct_type_use", $arsys_cat);
                // Loop insert System Category
    
    
                // $li_get_hashtag = $this->input->post("hashTag-ctrl2-rt04");
                // $ar_li_hashtag = array(
                //     "dct_hashtag_doc_code" => $get_doc_code,
                //     "dct_hashtag_name" => $li_get_hashtag,
                //     "dct_hashtag_status" => "pending"
                // );
                // $this->db->insert("dct_hashtag", $ar_li_hashtag);

                $arrayInsertPending = array(
                    "dct_lib_modify_status" => "pending"
                );
                $this->db->where("dct_lib_darcode" , $this->input->post("oldDarcode-ctrl2-rt04"));
                $this->db->update("dct_library" , $arrayInsertPending);

                $fileInput = "dataFile-ctrl2-rt04";
                uploadCtrlDoc($fileInput , $get_darcode , $fullDoccodeDisplay);

                $output = array(
                    "msg" => "บันทึกข้อมูลสำเร็จ",
                    "status" => "Insert Data Success"
                );
            }else{
                $output = array(
                    "msg" => "บันทึกข้อมูลไม่สำเร็จ ไม่พบเลขที่เอกสาร",
                    "status" => "Insert Data Not Success"
                );
            }
        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }


    public function save_ctrldoc_rt05()
    {
        $checkFile = $_FILES["dataFile-ctrl2-rt05"]['tmp_name'] !== "";
        if($checkFile === true){
            $dataDept_ctrl = $this->input->post("dataDept-ctrl2-rt05");
            $dct_subtype_code = $this->input->post("datasubtype-ctrl2-rt05");

            $get_darcode = getReqDocFormno();
            $get_doc_code = $this->input->post("dataDoccode-ctrl2-rt05");
            $dc_data_sub_type = $this->input->post('dc_data_sub_type');
            $dataEdit = $this->input->post("dataEdit-ctrl2-rt05");
            $fullDoccodeDisplay = "";
            if($get_doc_code != ""){
                $fullDoccodeDisplay = $get_doc_code."-$dataEdit-".date("d-m-Y");
            }

            if($fullDoccodeDisplay != ""){
                $armain = array(
                    "dct_doccode" => $get_doc_code,
                    "dct_doccode_display" => $fullDoccodeDisplay,
                    "dct_darcode" => $get_darcode,
                    "dct_type" => $this->input->post("datatype-ctrl2-rt05"),
                    "dct_subtype" => $this->input->post("datasubtype-ctrl2-rt05"),
                    "dct_date" => $this->input->post("dataDate-ctrl2-rt05"),
                    "dct_user" => $this->input->post("datauser-ctrl2-rt05"),
                    "dct_dept" => $this->input->post("dataDept-ctrl2-rt05"),
                    "dct_docname" => $this->input->post("dataDocname-ctrl2-rt05"),
                    "dct_editcount" => $this->input->post("dataEdit-ctrl2-rt05"),
                    "dct_datestart" => $this->input->post("dataDateStart-ctrl2-rt05"),
                    "dct_store" => $this->input->post("dataStore-ctrl2-rt05"),
                    "dct_store_type" => $this->input->post("dataStoreType-ctrl2-rt05"),
                    "dct_reson" => $this->input->post("dataReason-ctrl2-rt05"),
                    "dct_reson_detail" => $this->input->post("dataReasonDetail-ctrl2-rt05"),
                    "dct_status" => "Open",
                    "dct_olddar" => $this->input->post("oldDarcode-ctrl2-rt05")
                );
                $this->db->insert("dct_datamain", $armain);
    
                // Loop insert related department
                $related_dept_code = $this->input->post("relatedDeptcode-ctrl2-rt05");
                foreach ($related_dept_code as $related_dept_codes) {
                    $arrelated = array(
                        "related_dept_doccode" => $get_doc_code,
                        "related_dept_darcode" => $get_darcode,
                        "related_dept_code" => $related_dept_codes,
                        "related_dept_status" => "active"
                    );
                    $this->db->insert("dct_related_dept_use", $arrelated);
                }
                // Loop insert related department
    
    
                // Loop insert System Category
                $sys_cat = $this->input->post("datatype-ctrl2-rt05");
                $arsys_cat = array(
                    "dc_type_use_doccode" => $get_doc_code,
                    "dc_type_use_darcode" => $get_darcode,
                    "dc_type_use_code" => $sys_cat,
                    "dc_type_use_status" => "active"
                );
                $this->db->insert("dct_type_use", $arsys_cat);
                // Loop insert System Category
    
    
                // $li_get_hashtag = $this->input->post("hashTag-ctrl2-rt04");
                // $ar_li_hashtag = array(
                //     "dct_hashtag_doc_code" => $get_doc_code,
                //     "dct_hashtag_name" => $li_get_hashtag,
                //     "dct_hashtag_status" => "pending"
                // );
                // $this->db->insert("dct_hashtag", $ar_li_hashtag);

                //insert pending status to dct_library
                $arrayInsertPending = array(
                    "dct_lib_modify_status" => "pending"
                );
                $this->db->where("dct_lib_darcode" , $this->input->post("oldDarcode-ctrl2-rt05"));
                $this->db->update("dct_library" , $arrayInsertPending);

                $fileInput = "dataFile-ctrl2-rt05";
                uploadCtrlDoc($fileInput , $get_darcode , $fullDoccodeDisplay);

                $output = array(
                    "msg" => "บันทึกข้อมูลสำเร็จ",
                    "status" => "Insert Data Success"
                );
            }else{
                $output = array(
                    "msg" => "บันทึกข้อมูลไม่สำเร็จ ไม่พบเลขที่เอกสาร",
                    "status" => "Insert Data Not Success"
                );
            }
        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }


    public function getCtrlDocHashTag()
    {
        $sql = $this->db->query("SELECT 
        dct_hashtag_name 
        FROM dct_hashtag 
        WHERE dct_hashtag_status = 'active' 
        GROUP BY dct_hashtag_name LIMIT 50
        ");

        $resultData = "";
        foreach($sql->result() as $rs){
            if($resultData == ""){
                $resultData .='<a href="javascript:void(0)" class="attr_ctrhashtag" data_hashtag="'.$rs->dct_hashtag_name.'">'.$rs->dct_hashtag_name.'</a>';
            }else{
                $resultData .=' <a href="javascript:void(0)" class="attr_ctrhashtag" data_hashtag="'.$rs->dct_hashtag_name.'">'.$rs->dct_hashtag_name.'</a>';
            }
        }

        $output = array(
            "msg" => "ดึงข้อมูล Hash Tag สำเร็จ",
            "status" => "Select Data Success",
            "result" => $resultData
        );
        
        echo json_encode($output);
    }

    public function saveEditDataStoreCtrl()
    {
        $received_data = json_decode(file_get_contents("php://input"));
        if($received_data->action == "saveEditDataStoreCtrl"){
            $datastore = $received_data->datastore;
            $datastoretype = $received_data->datastoretype;
            $darcode = $received_data->darcode;

            $arupdate = array(
                "dct_store" => $datastore,
                "dct_store_type" => $datastoretype
            );
            $this->db->where("dct_darcode" , $darcode);
            $this->db->update("dct_datamain" , $arupdate);

            $output = array(
                "msg" => "แก้ไขข้อมูลสำเร็จ",
                "status" => "Update Data Success"
            );
        }else{
            $output = array(
                "msg" => "แก้ไขข้อมูลไม่สำเร็จ",
                "status" => "Update Data Not Success"
            );
        }

        echo json_encode($output);

        
    }
    

}
/* End of file ModelName.php */
?>