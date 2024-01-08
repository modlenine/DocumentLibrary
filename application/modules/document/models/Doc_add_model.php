<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Doc_add_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model("doc_get_model");
        $this->load->model("docemail_model");
        require("PHPMailer_5.2.0/class.phpmailer.php");
        date_default_timezone_set("Asia/Bangkok");
    }


    public function checkdate()
    {
        echo date("d-m-Y-H-i-s");
    }


//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการ Save การแก้ไชใบ Dar
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

    public function save_editdar($darcode)
    {
        $get_doc_code = $this->input->post('check_edit_doccode');
        $dc_data_sub_type = $this->input->post('dc_data_sub_type');
        $get_dar_code = $this->input->post('check_edit_darcode');

        if (isset($_POST['btnEditDar'])) { //Check button submit

            if ($_FILES['dc_data_file2']['tmp_name'] !== "") {
                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน
                $file_name = $_FILES['dc_data_file2']['name'];
                $file_name_cut = str_replace(" ", "", $file_name);
                $file_name_date = substr_replace(".", $get_doc_code . "-" . $date . ".pdf", 0);
                $file_size = $_FILES['dc_data_file2']['size'];
                $file_tmp = $_FILES['dc_data_file2']['tmp_name'];
                $file_type = $_FILES['dc_data_file2']['type'];

                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";

                print_r($file_name);
                echo "<br>" . "Copy/Upload Complete" . "<br>";
            } else {
                $file_name_date = $this->input->post('check_edit_data_file');
            }




            $armain = array(
                "dc_data_date" => $this->input->post("dc_data_date"),
                "dc_data_dept" => $this->input->post("dc_data_dept"),
                "dc_data_docname" => $this->input->post("dc_data_docname"),
                "dc_data_date_start" => $this->input->post("dc_data_date_start"),
                "dc_data_store" => $this->input->post("dc_data_store"),
                "dc_data_store_type" => $this->input->post("dc_data_store_type"),
                "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),
                "dc_data_file" => $file_name_date
            );


            $this->db->where("related_dept_darcode", $get_dar_code);
            $this->db->delete("dc_related_dept_use");

            // Loop insert related department

            $related_dept_code = $this->input->post("related_dept_code");
            foreach ($related_dept_code as $related_dept_codes) {
                $arrelated = array(
                    "related_dept_doccode" => $get_doc_code,
                    "related_dept_darcode" => $get_dar_code,
                    "related_dept_code" => $related_dept_codes,
                    "related_dept_status" => "active"
                );
                $this->db->insert("dc_related_dept_use", $arrelated);
            }

            // Loop insert related department



            $this->db->where("dc_type_use_darcode", $get_dar_code);
            $this->db->delete("dc_type_use");
            // Loop insert System Category
            $sys_cat = $this->input->post("dc_data_type");
            foreach ($sys_cat as $sys_cats) {
                $arsys_cat = array(
                    "dc_type_use_doccode" => $get_doc_code,
                    "dc_type_use_darcode" => $get_dar_code,
                    "dc_type_use_code" => $sys_cats,
                    "dc_type_use_status" => "active"
                );
                $this->db->insert("dc_type_use", $arsys_cat);

            }
            // Loop insert System Category





            if ($this->input->post('li_hashtag') == "") {
                echo "ไม่มีการแก้ไข Hashtag";
            } else {
                $this->db->where("li_hashtag_doc_code", $get_doc_code);
                $this->db->delete("library_hashtag");
                //Hash tag

                $li_get_hashtag = $this->input->post("li_hashtag");
                foreach ($li_get_hashtag as $lgd) {
                    $ar_li_hashtag = array(
                        "li_hashtag_doc_code" => $get_doc_code,
                        "li_hashtag_name" => $lgd
                    );
                    $this->db->insert("library_hashtag", $ar_li_hashtag);
                }

            }

            $result = $this->db->where("dc_data_darcode", $darcode);
            $result = $this->db->update("dc_datamain", $armain);
            if (!$result) {
                echo "<script>";
                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
                echo "window.history.back(-1)";
                echo "</script>";

            } else {
                echo "บันทึกข้อมูลสำเร็จ";
            }

        } //Check button submit


    }

//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการ Save การแก้ไชใบ Dar
//////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////////////////////////////////
//////////////////Section การบันทึกใบ Dar 
//////////////////////////////////////////////////////////////////////////
    public function save_sec1()
    {
        $get_darcode = getDarFormno();
        $get_doc_code = $this->doc_get_model->get_doc_code();
        $dc_data_sub_type = $this->input->post('dc_data_sub_type');

        if (isset($_POST['saveSec1_1'])) { //Check button submit
            if ($dc_data_sub_type == "sds") {
                $conDoccode = cut_doccode3($get_doc_code);
            } else if ($dc_data_sub_type == "l") {
                $conDoccode = cut_doccode2($get_doc_code);
            } else {
                $conDoccode = cut_doccode1($get_doc_code);
            }

            $armain = array(
                "dc_data_doccode" => $conDoccode,
                "dc_data_doccode_display" => $get_doc_code,
                "dc_data_darcode" => $get_darcode,
                "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),
                "dc_data_sub_type_law" => $this->input->post("get_law"),
                "dc_data_sub_type_sds" => $this->input->post("get_sds"),
                "dc_data_date" => $this->input->post("dc_data_date"),
                "dc_data_user" => $this->input->post("dc_data_user"),
                "dc_data_dept" => $this->input->post("dc_data_dept"),
                "dc_data_docname" => $this->input->post("dc_data_docname"),
                "dc_data_edit" => $this->input->post("dc_data_edit"),
                "dc_data_date_start" => $this->input->post("dc_data_date_start"),
                "dc_data_store" => $this->input->post("dc_data_store"),
                "dc_data_store_type" => $this->input->post("dc_data_store_type"),
                "dc_data_reson" => $this->input->post("dc_data_reson"),
                "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),
                "dc_data_status" => "Creating DAR",
                "dc_data_formcode" => $this->input->post("formcode")

            );
            // Loop insert related department
            $related_dept_code = $this->input->post("related_dept_code");
            foreach ($related_dept_code as $related_dept_codes) {

                $arrelated = array(
                    "related_dept_doccode" => $conDoccode,
                    "related_dept_darcode" => $get_darcode,
                    "related_dept_code" => $related_dept_codes,
                    "related_dept_status" => "active"
                );
                $this->db->insert("dc_related_dept_use", $arrelated);
            }
            // Loop insert related department

            // Loop insert System Category
            $sys_cat = $this->input->post("dc_data_type");
            foreach ($sys_cat as $sys_cats) {
                $arsys_cat = array(
                    "dc_type_use_doccode" => $conDoccode,
                    "dc_type_use_darcode" => $get_darcode,
                    "dc_type_use_code" => $sys_cats,
                    "dc_type_use_status" => "active"
                );
                $this->db->insert("dc_type_use", $arsys_cat);
            }
            // Loop insert System Category

            $li_get_hashtag = $this->input->post("li_hashtag");
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
                    "li_hashtag_doc_code" => $conDoccode,
                    "li_hashtag_name" => $newText,
                    "li_hashtag_status" => "pending"
                );
                $this->db->insert("library_hashtag", $ar_li_hashtag);
            }

        } //Check button submit

        $result = $this->db->insert("dc_datamain", $armain);

        if (!$result) {
            echo "<script>";
            echo "alert('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')";
            echo "window.history.back(-1)";
            echo "</script>";
        } else {
            echo "บันทึกข้อมูลสำเร็จ";
            header("refresh:0; url=" . base_url('document/add_dar2/') . $get_darcode);
        }

    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section การบันทึกใบ Dar 
//////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////
//////////////////Section การบันทึกใบ Dar Sectin ที่2
//////////////////////////////////////////////////////////////////////////
    public function save_sec1_2($darcode)
    {

        $get_darcode = $darcode;
        $get_doc_code = $this->input->post("doccode");
        // $dc_data_sub_type = $this->input->post('dc_data_sub_type');

        if (isset($_POST['btnUser_submit'])) { //Check button submit

            $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน
            $file_name = $_FILES['dc_data_file']['name'];
            $file_name_cut = str_replace(" ", "", $file_name);
            $file_name_date = substr_replace(".", $get_doc_code . "-" . $date . ".pdf", 0);
            $file_size = $_FILES['dc_data_file']['size'];
            $file_tmp = $_FILES['dc_data_file']['tmp_name'];
            $file_type = $_FILES['dc_data_file']['type'];

            move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

            $filelocation = "asset/document_files/";

            print_r($file_name);
            echo "<br>" . "Copy/Upload Complete" . "<br>";


            $armain = array(
                "dc_data_file" => $file_name_date,
                "dc_data_file_location" => $filelocation,
                "dc_data_status" => "Open"

            );


        } //Check button submit

        $this->db->where("dc_data_darcode", $get_darcode);
        $result = $this->db->update("dc_datamain", $armain);

        $this->docemail_model->sendto_manager($get_darcode);

        if (!$result) {

            echo "<script>";
            echo "alert('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')";
            echo "window.history.back(-1)";
            echo "</script>";
        } else {
            echo "บันทึกข้อมูลสำเร็จ";
        }

    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section การบันทึกใบ Dar Sectin ที่2
//////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการยกเลิกเอกสาร
//////////////////////////////////////////////////////////////////////////

    public function cancelSec1_deleteHashtag($doccode)
    {
        $this->db->where("li_hashtag_doc_code", $doccode);
        $this->db->delete("library_hashtag");
    }

//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการยกเลิกเอกสาร
//////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบแผนกที่เกี่ยวข้อง
//////////////////////////////////////////////////////////////////////////
    public function cancelSec1_deleteRelatedDeptUse($darcode)
    {
        $this->db->where("related_dept_darcode", $darcode);
        $this->db->delete("dc_related_dept_use");
    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบแผนกที่เกี่ยวข้อง
//////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบ Document type
//////////////////////////////////////////////////////////////////////////
    public function cancelSec1_deleteTypeUse($darcode)
    {
        $this->db->where("dc_type_use_darcode", $darcode);
        $this->db->delete("dc_type_use");
    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบ Document type
//////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบ Doccode
//////////////////////////////////////////////////////////////////////////
    public function cancelSec1_deleteDoccode($darcode)
    {
        $ar_cancelSec1 = array(
            "dc_data_doccode" => "user cancel",
            "dc_data_doccode_display" => "user cancel",
            "dc_data_status" => "User Cancel"
        );

        $this->db->where("dc_data_darcode", $darcode);
        $this->db->update("dc_datamain", $ar_cancelSec1);
    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section ของการลบ Doccode
//////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจากผู้จัดการ
//////////////////////////////////////////////////////////////////////////
    public function save_sec2($darcode)
    {
        if (isset($_POST['btnSave_sec2'])) {

            if ($this->input->post("dc_data_result_reson_status") == 1) {

                $ar_save_sec2 = array(

                    "dc_data_result_reson_status" => $this->input->post('dc_data_result_reson_status'),
                    "dc_data_result_reson_detail" => $this->input->post('dc_data_result_reson_detail'),
                    "dc_data_approve_mgr" => $this->input->post('dc_data_approve_mgr'),
                    "dc_data_date_approve_mgr" => date("Y-m-d"),
                    "dc_data_status" => "Manager Approved"

                );

                $this->db->where("dc_data_darcode", $darcode);
                $result_sec2 = $this->db->update("dc_datamain", $ar_save_sec2);

                if ($result_sec2) {
                    echo "บันทึกข้อมูลสำเร็จ";
                } else {
                    echo "<script>";
                    echo "alert('บันทึกข้อมูลไม่สำเร็จสำเร็จ')";
                    echo "</script>";
                    exit();

                }

                $this->docemail_model->sendto_qmr($darcode);

            } else {

                if (get_data_reson($darcode)->dc_data_reson != 'r-02' && get_data_reson($darcode)->dc_data_reson != 'r-04' && get_data_reson($darcode)->dc_data_reson != 'r-03' && get_data_reson($darcode)->dc_data_reson != 'r-05') {

                    echo "ไม่เท่ากับ r-02";

                    $del_hashtag = $this->db->where('li_hashtag_doc_code', convert_darcode_to_doccode($darcode));
                    $del_hashtag = $this->db->delete('library_hashtag');

                    if ($del_hashtag) {
                        echo "ลบแฮชแท็กสำเร็จ";
                    } else {
                        echo "ลบแฮชแท็กไม่สำเร็จ";
                    }

                } else {
                    echo get_data_reson($darcode)->dc_data_reson . "<br>";
                }


                $checkolddar = $this->db->query("SELECT dc_data_old_dar FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");
                $checknumrow = $checkolddar->num_rows();
                if ($checknumrow > 0) {
                    $getolddar = $checkolddar->row();
                    $clear_padding = array(
                        "lib_main_modify_status" => ""
                    );
                    $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);
                    $this->db->update("library_main", $clear_padding);
                }


                $ar_mgr_notapprove = array(

                    "dc_data_result_reson_status" => $this->input->post('dc_data_result_reson_status'),
                    "dc_data_result_reson_detail" => $this->input->post('dc_data_result_reson_detail'),
                    "dc_data_approve_mgr" => $this->input->post('dc_data_approve_mgr'),
                    "dc_data_date_approve_mgr" => date("Y-m-d"),
                    "dc_data_status" => "Manager Not Approve",
                    "dc_data_edit" => 0
                );

                $this->db->where("dc_data_darcode", $darcode);
                $rs_notapp = $this->db->update("dc_datamain", $ar_mgr_notapprove);
                if ($rs_notapp) {
                    echo "อัพเดตข้อมูลสำเร็จ<br>";
                } else {
                    echo "อัพเดตข้อมูลไม่สำเร็จ";
                }



                $query_related_dept = $this->db->query("SELECT * FROM dc_related_dept_use WHERE related_dept_darcode='$darcode' ");
                if ($query_related_dept) {
                    foreach ($query_related_dept->result_array() as $rs) {
                        $ar_related = array(
                            "related_dept_status" => 'inactive'
                        );
                        $update_releted_dept = $this->db->where('related_dept_darcode', $darcode);
                        $update_releted_dept = $this->db->update('dc_related_dept_use', $ar_related);
                    }

                    if ($update_releted_dept) {
                        echo "ปรับสถานะสำเร็จ<br>";
                    } else {
                        echo "ปรับสถานะไม่สำเร็จ";
                    }

                }



                $query_type_use = $this->db->query("SELECT * FROM dc_type_use WHERE dc_type_use_darcode='$darcode' ");
                if ($query_type_use) {
                    foreach ($query_type_use->result_array() as $rstu) {
                        $ar_type_use = array(
                            "dc_type_use_status" => "inactive"
                        );

                        $update_type_use = $this->db->where('dc_type_use_darcode', $darcode);
                        $update_type_use = $this->db->update('dc_type_use', $ar_type_use);
                    }

                    if ($update_type_use) {
                        echo "ปรับสถานะหมวดหมู่สำเร็จ<br>";
                    } else {
                        echo "ปรับสถานะหมวดหมู่ไม่สำเร็จ";
                    }

                }

                $this->docemail_model->sendBackToUser_ManagerNotApprove($darcode);

            }

        }

    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจากผู้จัดการ
//////////////////////////////////////////////////////////////////////////





//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจาก SMR
//////////////////////////////////////////////////////////////////////////
    public function save_sec3smr($darcode)
    {
        if (isset($_POST['btnSave_sec3smr'])) {

            $get_doc_code = $this->doc_get_model->get_doc_code();
            if ($this->input->post("dc_data_result_reson_status3") == 1) {
                $ar_save_sec3 = array(

                    "dc_data_result_reson_status3" => $this->input->post('dc_data_result_reson_status3'),
                    "dc_data_result_reson_detail3" => $this->input->post('dc_data_result_reson_detail3'),
                    "dc_data_approve_smr" => $this->input->post('dc_data_approve_smr'),
                    "dc_data_date_approve_smr" => date("Y-m-d"),
                    "dc_data_status" => "Smr Approved"

                );

                $this->db->where("dc_data_darcode", $darcode);
                $result_sec3 = $this->db->update("dc_datamain", $ar_save_sec3);

                if ($result_sec3) {
                    echo "บันทึกข้อมูลสำเร็จ";
                } else {

                    echo "<script>";
                    echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
                    echo "</script>";
                    exit();

                }

            } else {

                if (get_data_reson($darcode)->dc_data_reson != 'r-02' && get_data_reson($darcode)->dc_data_reson != 'r-04' && get_data_reson($darcode)->dc_data_reson != 'r-03' && get_data_reson($darcode)->dc_data_reson != 'r-05') {

                    echo "ไม่เท่ากับ r-02";
                    $del_hashtag = $this->db->where('li_hashtag_doc_code', convert_darcode_to_doccode($darcode));
                    $del_hashtag = $this->db->delete('library_hashtag');
                    if ($del_hashtag) {
                        echo "ลบแฮชแท็กสำเร็จ";
                    } else {
                        echo "ลบแฮชแท็กไม่สำเร็จ";
                    }

                } else {

                    echo get_data_reson($darcode)->dc_data_reson . "<br>";

                }





                $checkolddar = $this->db->query("SELECT dc_data_old_dar FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");
                $checknumrow = $checkolddar->num_rows();

                if ($checknumrow > 0) {
                    $getolddar = $checkolddar->row();
                    $clear_padding = array(
                        "lib_main_modify_status" => ""
                    );

                    $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);
                    $this->db->update("library_main", $clear_padding);

                }







                $ar_smr_notapprove = array(

                    "dc_data_result_reson_status3" => $this->input->post('dc_data_result_reson_status3'),
                    "dc_data_result_reson_detail3" => $this->input->post('dc_data_result_reson_detail3'),
                    "dc_data_approve_smr" => $this->input->post('dc_data_approve_smr'),
                    "dc_data_date_approve_smr" => date("Y-m-d"),
                    "dc_data_status" => "Smr Not Approve",
                    "dc_data_edit" => 0

                );

                $this->db->where("dc_data_darcode", $darcode);
                $rs_notapp = $this->db->update("dc_datamain", $ar_smr_notapprove);

                if ($rs_notapp) {
                    echo "อัพเดตข้อมูลสำเร็จ<br>";
                } else {
                    echo "อัพเดตข้อมูลไม่สำเร็จ";
                }



                $query_related_dept = $this->db->query("SELECT * FROM dc_related_dept_use WHERE related_dept_darcode='$darcode' ");

                if ($query_related_dept) {
                    foreach ($query_related_dept->result_array() as $rs) {
                        $ar_related = array(
                            "related_dept_status" => 'inactive'
                        );

                        $update_releted_dept = $this->db->where('related_dept_darcode', $darcode);
                        $update_releted_dept = $this->db->update('dc_related_dept_use', $ar_related);

                    }

                    if ($update_releted_dept) {
                        echo "ปรับสถานะสำเร็จ<br>";

                    } else {
                        echo "ปรับสถานะไม่สำเร็จ";

                    }

                }


                $query_type_use = $this->db->query("SELECT * FROM dc_type_use WHERE dc_type_use_darcode='$darcode' ");
                if ($query_type_use) {
                    foreach ($query_type_use->result_array() as $rstu) {
                        $ar_type_use = array(
                            "dc_type_use_status" => "inactive"
                        );

                        $update_type_use = $this->db->where('dc_type_use_darcode', $darcode);
                        $update_type_use = $this->db->update('dc_type_use', $ar_type_use);

                    }

                    if ($update_type_use) {
                        echo "ปรับสถานะหมวดหมู่สำเร็จ<br>";

                    } else {
                        echo "ปรับสถานะหมวดหมู่ไม่สำเร็จ";

                    }

                }

            }



            //Email Zone

            $calldata_email = $this->doc_get_model->get_fulldata($darcode);
            $calldata_emails = $calldata_email->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องเกี่ยวกับเอกสาร (DAR) Status: ผลการอนุมัติจาก SMR";



            $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

            $body .= "<h4>Status: ผลการอนุมัติจาก SMR</h4>";



            $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

            $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



            $ra_typeuse = $this->doc_get_model->get_doctype_use($darcode);

            foreach ($ra_typeuse->result_array() as $rst) {

                $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";

            }



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

            $ra_related_dept = $this->doc_get_model->get_related_use($darcode);

            foreach ($ra_related_dept->result_array() as $rrd) {

                $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

            }

            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br><br>";



            if ($calldata_emails->dc_data_result_reson_status == 1) {

                $reson1_status = "อนุมัติ";

            } else {

                $reson1_status = "ไม่อนุมัติ";

            }

            $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก ผู้จัดการ :&nbsp;&nbsp;</strong></span>" . $reson1_status . "<br>";

            $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail . "<br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_mgr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_mgr . "</span><br><br>";







            if ($calldata_emails->dc_data_result_reson_status3 == 1) {

                $reson3_status = "อนุมัติ";

            } else {

                $reson3_status = "ไม่อนุมัติ";

            }

            $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก SMR :&nbsp;&nbsp;</strong></span>" . $reson3_status . "<br>";

            $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail3 . "<br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_smr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_smr . "</span><br><br>";







            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
            $mail->Host = "mail.saleecolour.net";  // specify main and backup server
            //        $mail->Host = "smtp.gmail.com";
            $mail->Port = 25; // พอร์ท
            //        $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";
            $mail->FromName = "Document System";



            $get_user_email = get_email_user("dc_user_group in (1,2)");
            foreach ($get_user_email->result_array() as $gue) {
                $mail->AddAddress($gue['dc_user_memberemail']);
            }

            // $mail->AddAddress("chainarong_k@saleecolour.com");

            foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {
                $mail->AddCC($cc['memberemail']);
            }


            $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
            $gue_cc = $get_usercc_email->row();
            $mail->AddCC($gue_cc->dc_user_memberemail);
            $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional
            $mail->WordWrap = 50;                                 // set word wrap to 50 characters
            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
            $mail->IsHTML(true);                                  // set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();

            //************************************ZONE***SEND****EMAIL*************************************//

        }

    }
//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจาก SMR
//////////////////////////////////////////////////////////////////////////








//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจาก QMR
//////////////////////////////////////////////////////////////////////////
    public function save_sec3($darcode)
    {

        if (isset($_POST['btnSave_sec3'])) {

            $get_doc_code = $this->doc_get_model->get_doc_code();
            if ($this->input->post("dc_data_result_reson_status2") == 1) {

                $ar_save_sec3 = array(

                    "dc_data_result_reson_status2" => $this->input->post('dc_data_result_reson_status2'),
                    "dc_data_result_reson_detail2" => $this->input->post('dc_data_result_reson_detail2'),
                    "dc_data_approve_qmr" => $this->input->post('dc_data_approve_qmr'),
                    "dc_data_date_approve_qmr" => date("Y-m-d"),
                    "dc_data_status" => "Qmr Approved"

                );


                $this->db->where("dc_data_darcode", $darcode);
                $result_sec3 = $this->db->update("dc_datamain", $ar_save_sec3);

                if ($result_sec3) {
                    echo "บันทึกข้อมูลสำเร็จ";

                } else {
                    echo "<script>";
                    echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
                    echo "</script>";
                    exit();

                }

                $this->docemail_model->sendto_Dcc($darcode);

            } else {

                if (get_data_reson($darcode)->dc_data_reson != 'r-02' && get_data_reson($darcode)->dc_data_reson != 'r-04' && get_data_reson($darcode)->dc_data_reson != 'r-03' && get_data_reson($darcode)->dc_data_reson != 'r-05') {

                    echo "ไม่เท่ากับ r-02";

                    $del_hashtag = $this->db->where('li_hashtag_doc_code', convert_darcode_to_doccode($darcode));
                    $del_hashtag = $this->db->delete('library_hashtag');

                    if ($del_hashtag) {
                        echo "ลบแฮชแท็กสำเร็จ";
                    } else {
                        echo "ลบแฮชแท็กไม่สำเร็จ";
                    }

                } else {
                    echo get_data_reson($darcode)->dc_data_reson . "<br>";
                }

                $checkolddar = $this->db->query("SELECT dc_data_old_dar FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");
                $checknumrow = $checkolddar->num_rows();

                if ($checknumrow > 0) {

                    $getolddar = $checkolddar->row();
                    $clear_padding = array(
                        "lib_main_modify_status" => ""
                    );

                    $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);
                    $this->db->update("library_main", $clear_padding);

                }


                $ar_qmr_notapprove = array(

                    "dc_data_result_reson_status2" => $this->input->post('dc_data_result_reson_status2'),
                    "dc_data_result_reson_detail2" => $this->input->post('dc_data_result_reson_detail2'),
                    "dc_data_approve_qmr" => $this->input->post('dc_data_approve_qmr'),
                    "dc_data_date_approve_qmr" => date("Y-m-d"),
                    "dc_data_status" => "Qmr Not Approve",
                    "dc_data_edit" => 0

                );

                $this->db->where("dc_data_darcode", $darcode);
                $rs_notapp = $this->db->update("dc_datamain", $ar_qmr_notapprove);

                if ($rs_notapp) {
                    echo "อัพเดตข้อมูลสำเร็จ<br>";

                } else {
                    echo "อัพเดตข้อมูลไม่สำเร็จ";

                }


                $query_related_dept = $this->db->query("SELECT * FROM dc_related_dept_use WHERE related_dept_darcode='$darcode' ");

                if ($query_related_dept) {

                    foreach ($query_related_dept->result_array() as $rs) {

                        $ar_related = array(
                            "related_dept_status" => 'inactive'
                        );

                        $update_releted_dept = $this->db->where('related_dept_darcode', $darcode);
                        $update_releted_dept = $this->db->update('dc_related_dept_use', $ar_related);

                    }

                    if ($update_releted_dept) {
                        echo "ปรับสถานะสำเร็จ<br>";

                    } else {
                        echo "ปรับสถานะไม่สำเร็จ";

                    }

                }


                $query_type_use = $this->db->query("SELECT * FROM dc_type_use WHERE dc_type_use_darcode='$darcode' ");

                if ($query_type_use) {
                    foreach ($query_type_use->result_array() as $rstu) {
                        $ar_type_use = array(
                            "dc_type_use_status" => "inactive"
                        );

                        $update_type_use = $this->db->where('dc_type_use_darcode', $darcode);
                        $update_type_use = $this->db->update('dc_type_use', $ar_type_use);
                    }

                    if ($update_type_use) {
                        echo "ปรับสถานะหมวดหมู่สำเร็จ<br>";

                    } else {
                        echo "ปรับสถานะหมวดหมู่ไม่สำเร็จ";

                    }

                }

                $this->docemail_model->sendBackToUser_QmrNotApprove($darcode);

            }

        }

    }

//////////////////////////////////////////////////////////////////////////
//////////////////Section ผลการอนุมัติจาก QMR
//////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////
///////////// Section ขั้นตอนของการแจกจ่ายเอกสารของ Dcc 
//////////////////////////////////////////////////////////////////////
    public function save_sec4($darcode)
    {

        if (isset($_POST['btnOpsave'])) {

            // Get document code

            $get_doccode = $this->db->query("SELECT dc_data_doccode , dc_data_file FROM dc_datamain WHERE dc_data_darcode='$darcode' ");

            $get_doccodes = $get_doccode->row();
            $get_doc_code = substr($get_doccodes->dc_data_file, 0, -4);

            // For Master file

            $file_name = $_FILES['document_master']['name'];
            $file_name_cut = str_replace(" ", "", $file_name);
            $file_name_master = substr_replace(".", $get_doc_code . "-master" . ".pdf", 0);
            $file_size = $_FILES['document_master']['size'];
            $file_tmp = $_FILES['document_master']['tmp_name'];
            $file_type = $_FILES['document_master']['type'];

            move_uploaded_file($file_tmp, "asset/master/" . $file_name_master);

            $filelocation_master = "asset/master/";

            print_r($file_name);
            echo "<br>" . "Copy/Upload Complete" . "<br>";


            $file_name = $_FILES['document_copy']['name'];
            $file_name_cut = str_replace(" ", "", $file_name);
            $file_name_copy = substr_replace(".", $get_doc_code . "-copy" . ".pdf", 0);
            $file_size = $_FILES['document_copy']['size'];
            $file_tmp = $_FILES['document_copy']['tmp_name'];
            $file_type = $_FILES['document_copy']['type'];

            move_uploaded_file($file_tmp, "asset/copy/" . $file_name_copy);
            $filelocation_copy = "asset/copy/";


            print_r($file_name);
            echo "<br>" . "Copy/Upload Complete" . "<br>";

            $status = "Complete";
            $ar_save_sec4 = array(

                "dc_data_method" => $this->input->post('dc_data_method'),
                "dc_data_operation" => $this->input->post('dc_data_operation'),
                "dc_data_date_operation" => date("Y-m-d"),
                "dc_data_status" => $status

            );



            $this->db->where("dc_data_darcode", $darcode);
            $result_sec4 = $this->db->update("dc_datamain", $ar_save_sec4);


            $checkolddar = $this->db->query("SELECT dc_data_old_dar FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");
            $checknumrow = $checkolddar->num_rows();
            if ($checknumrow > 0) {

                $getolddar = $checkolddar->row();
                $inactive = array(
                    "lib_main_status" => "inactive",
                    "lib_main_modify_status" => "",
                    "lib_main_pin_status" => 0,
                    "lib_main_pin_order" => 0
                );

                $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);
                $this->db->update("library_main", $inactive);
            }


            foreach ($checkolddar->result_array() as $get_od) {
                $inactive_related_dept_use = array(
                    "related_dept_status" => "inactive"
                );

                $this->db->where("related_dept_darcode", $get_od['dc_data_old_dar']);
                $this->db->update("dc_related_dept_use", $inactive_related_dept_use);
            }



            foreach ($checkolddar->result_array() as $get_ods) {
                $inactive_type_use = array(
                    "dc_type_use_status" => "inactive"
                );

                $this->db->where("dc_type_use_darcode", $get_ods['dc_data_old_dar']);
                $this->db->update("dc_type_use", $inactive_type_use);
            }



            //query for update hashtag

            $query_hashtag = $this->db->query("SELECT li_hashtag_doc_code FROM library_hashtag WHERE li_hashtag_doc_code='$get_doccodes->dc_data_doccode' ");

            foreach ($query_hashtag->result_array() as $get_hashtag_doccode) {
                $ar_update_hashtag_status = array(
                    "li_hashtag_status" => "active"
                );

                $this->db->where("li_hashtag_doc_code", $get_hashtag_doccode['li_hashtag_doc_code']);
                $this->db->update("library_hashtag", $ar_update_hashtag_status);

            }



            $ar_lib_save = array(
                "lib_main_doccode" => $get_doccodes->dc_data_doccode,
                "lib_main_darcode" => $darcode,
                "lib_main_doccode_master" => $file_name_master,
                "lib_main_doccode_copy" => $file_name_copy,
                "lib_main_file_location_master" => $filelocation_master,
                "lib_main_file_location_copy" => $filelocation_copy,
                "lib_main_status" => "active"
            );

            $result = $this->db->insert("library_main", $ar_lib_save);

            if ($result) {
                echo "บันทึกข้อมูลสำเร็จ";
            } else {
                echo "<script>";
                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
                echo "</script>";
                exit();
            }


            //Email Zone

            $calldata_email = $this->doc_get_model->get_fulldata($darcode);
            $calldata_emails = $calldata_email->row();

            //************************************ZONE***SEND****EMAIL*************************************//

            $subject = "New ใบคำร้องเกี่ยวกับเอกสาร(DAR) Status: ผลการดำเนินการของ DCC";



            $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

            $body .= "<h4>Status: ผลการดำเนินการของ DCC</h4>";



            $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

            $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



            $ra_typeuse = $this->doc_get_model->get_doctype_use($darcode);

            foreach ($ra_typeuse->result_array() as $rst) {
                $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";
            }

            $body .= "<br>";

            $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";


            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

            $ra_related_dept = $this->doc_get_model->get_related_use($darcode);

            foreach ($ra_related_dept->result_array() as $rrd) {

                $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

            }

            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br><br>";



            if ($calldata_emails->dc_data_result_reson_status == 1) {

                $reson1_status = "อนุมัติ";

            } else {

                $reson1_status = "ไม่อนุมัติ";

            }

            $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก ผู้จัดการ :&nbsp;&nbsp;</strong></span>" . $reson1_status . "<br>";

            $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail . "<br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_mgr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_mgr . "</span><br><br>";






            // check sds
            if($calldata_emails->dc_data_result_reson_status2 !== ""){
                if ($calldata_emails->dc_data_result_reson_status2 == 1) {

                    $reson2_status = "อนุมัติ";
    
                } else {
    
                    $reson2_status = "ไม่อนุมัติ";
    
                }
    
                $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก QMR :&nbsp;&nbsp;</strong></span>" . $reson2_status . "<br>";
    
                $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail2 . "<br>";
    
                $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_qmr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_qmr . "</span><br><br>";
            }else if($calldata_emails->dc_data_result_reson_status3 !== ""){
                if ($calldata_emails->dc_data_result_reson_status3 == 1) {

                    $reson3_status = "อนุมัติ";
    
                } else {
    
                    $reson3_status = "ไม่อนุมัติ";
    
                }
    
                $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก SMR :&nbsp;&nbsp;</strong></span>" . $reson3_status . "<br>";
    
                $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail3 . "<br>";
    
                $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_smr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_smr . "</span><br><br>";
            }

            





            $body .= "<span style='font-size:20px;'><strong>สำหรับผู้ควบคุมเอกสาร : &nbsp;</strong></span><span>" . $calldata_emails->dc_data_method . "</span><br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่ดำเนินการ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_operation) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้ดำเนินการ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_operation . "</span><br><br>";





            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            




            //////////////////////////////////////////////////////
            ////////////////// New send Email
            //////////////////////////////////////////////////////
            if($calldata_emails->dc_reason_name == "เอกสารใหม่ (New Release)"){
                $textSubject = "แจ้งขึ้นทะเบียนเอกสารใหม่";
            }else if($calldata_emails->dc_reason_name == "เปลี่ยนแปลงเอกสาร (Change)"){
                $textSubject = "แจ้งเปลี่ยนแปลงเอกสาร";
            }else if($calldata_emails->dc_reason_name == "ขอแก้ไขเอกสาร (Revision)"){
                $textSubject = "แจ้งแก้ไขเอกสาร";
            }

            $subject2 = $textSubject;
            $body2 = '
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Sarabun&display=swap");

                    h3{
                        font-family: Tahoma, sans-serif;
                        font-size:14px;
                    }

                    table {
                        font-family: Tahoma, sans-serif;
                        font-size:14px;
                        border-collapse: collapse;
                        width: 70%;
                    }
                    
                    td, th {
                        border: 1px solid #ccc;
                        text-align: left;
                        padding: 8px;
                    }
                    
                    tr:nth-child(even) {
                        background-color: #F5F5F5;
                    }

                    .bghead{
                        text-align:center;
                        background-color:#D3D3D3;
                    }
                </style>
                ';
            $body2 .= '
                <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
                <span style="padding-left:50px;">ขอ'.$textSubject.' รายละเอียดดังต่อไปนี้</span><br>
            ';
            $body2 .='
                <table style="margin-top:20px;">
                    <tr>
                        <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>'.$calldata_emails->dc_data_docname.'</td>
                        <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>'.$calldata_emails->dc_dept_main_name.'</td>
                    </tr>

                    <tr>
                        <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>'.$calldata_emails->dc_sub_type_name.'</td>
                        <td style="width:200px;"><b>ครั้งที่แก้ไข</b></td><td>'.$calldata_emails->dc_data_edit.'</td>
                    </tr>

                    <tr>
                        <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>'.$calldata_emails->dc_data_doccode.'</td>
                        <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>'.con_date($calldata_emails->dc_data_date_start).'</td>
                    </tr>
                </table>
                <div style="margin-top:30px;">
                    <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="'.base_url('librarys/view_by_dept').'">ตรวจสอบเอกสาร</a></span>
                </div>
            ';

            $mail2 = new PHPMailer();
            $mail2->IsSMTP();
            $mail2->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
            $mail2->SMTPDebug = 1;                                      // set mailer to use SMTP
            $mail2->Host = "mail.saleecolour.net";  // specify main and backup server
            //        $mail->Host = "smtp.gmail.com";
            $mail2->Port = 25; // พอร์ท
            //        $mail->SMTPSecure = 'tls';
            $mail2->SMTPAuth = true;     // turn on SMTP authentication
            $mail2->Username = getEmailAccount()->email_user;  // SMTP username
            //websystem@saleecolour.com
            //        $mail->Username = "chainarong039@gmail.com";
            $mail2->Password = getEmailAccount()->email_password; // SMTP password
            //Ae8686#
            //        $mail->Password = "ShctBkk1";
            $mail2->From = "documentsystem@saleecolour.net";
            $mail2->FromName = "Document System";
            $get_user_email2 = get_email_user("dc_user_group in (1,2,6)");

            foreach ($get_user_email2->result_array() as $gue) {
                $mail2->AddAddress($gue['dc_user_memberemail']);
            }

            // $mail->AddAddress("chainarong_k@saleecolour.com");
            foreach (getDeptCodeFromRelated($calldata_emails->dc_data_darcode) as $cc) {
                $mail2->AddCC($cc);
            }


            // $get_usercc_email2 = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
            // $gue_cc2 = $get_usercc_email2->row();
            // $mail2->AddCC($gue_cc2->dc_user_memberemail);
            $mail2->AddCC("chainarong_k@saleecolour.com");                  // name is optional
            $mail2->WordWrap = 50;                                 // set word wrap to 50 characters
            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
            $mail2->IsHTML(true);                                  // set email format to HTML
            $mail2->Subject = $subject2;
            $mail2->Body = $body2;
            $mail2->send();

            //************************************ZONE***SEND****EMAIL*************************************//

        }

    }


    public function testemail()
    {
        $mail2 = new PHPMailer();
        $mail2->IsSMTP();
        $mail2->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
        $mail2->SMTPDebug = 1;                                      // set mailer to use SMTP
        $mail2->Host = "mail.saleecolour.net";  // specify main and backup server
        //        $mail->Host = "smtp.gmail.com";
        $mail2->Port = 25; // พอร์ท
        //        $mail->SMTPSecure = 'tls';
        $mail2->SMTPAuth = true;     // turn on SMTP authentication
        $mail2->Username = getEmailAccount()->email_user;  // SMTP username
        //websystem@saleecolour.com
        //        $mail->Username = "chainarong039@gmail.com";
        $mail2->Password = getEmailAccount()->email_password; // SMTP password
        //Ae8686#
        //        $mail->Password = "ShctBkk1";
        $mail2->From = "documentsystem@saleecolour.net";
        $mail2->FromName = "Document System";
        // $get_user_email2 = get_email_user("dc_user_group in (1,2,6)");

        // foreach ($get_user_email2->result_array() as $gue) {
        //     $mail2->AddAddress($gue['dc_user_memberemail']);
        // }

        // $mail->AddAddress("chainarong_k@saleecolour.com");
        // foreach (getDeptCodeFromRelated($calldata_emails->dc_data_darcode) as $cc) {
        //     $mail2->AddCC($cc);
        // }


        // $get_usercc_email2 = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
        // $gue_cc2 = $get_usercc_email2->row();
        // $mail2->AddCC($gue_cc2->dc_user_memberemail);
        $mail2->AddCC("chainarong_k@saleecolour.com");
        // $mail2->AddCC("anon@saleecolour.com");                  // name is optional
        $mail2->WordWrap = 50;                                 // set word wrap to 50 characters
        // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $mail2->IsHTML(true);                                  // set email format to HTML
        $mail2->Subject = "ทดสอบ";
        $mail2->Body = "ทดสอบการส่ง Email จากระบบ";
        $mail2->send();
    }

////////////////////////////////////////////////////////////
/////// Section ขั้นตอนของการแจกจ่ายเอกสารของ Dcc 
///////////////////////////////////////////////////////////




    public function save_sec4deptedit($darcode)
    {
        if (isset($_POST['btnOpsave'])) {

            // Get document code

            $get_doccode = $this->db->query("SELECT dc_data_doccode , dc_data_file FROM dc_datamain WHERE dc_data_darcode='$darcode' ");

            $get_doccodes = $get_doccode->row();

            $get_doc_code = substr($get_doccodes->dc_data_file, 0, -4);



            $status = "Complete";



            $ar_save_sec4 = array(



                "dc_data_method" => $this->input->post('dc_data_method'),

                "dc_data_operation" => $this->input->post('dc_data_operation'),

                "dc_data_date_operation" => date("Y-m-d"),

                "dc_data_status" => $status

            );

            $this->db->where("dc_data_darcode", $darcode);

            $result_sec4 = $this->db->update("dc_datamain", $ar_save_sec4);





            $checkolddar = $this->db->query("SELECT dc_data_old_dar FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");

            $checknumrow = $checkolddar->num_rows();

            if ($checknumrow > 0) {

                $getolddar = $checkolddar->row();

                $inactive = array(

                    "lib_main_status" => "inactive",

                    "lib_main_modify_status" => "",

                    "lib_main_pin_status" => 0,

                    "lib_main_pin_order" => 0

                );

                $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);

                $this->db->update("library_main", $inactive);

            }



            foreach ($checkolddar->result_array() as $get_od) {

                $inactive_related_dept_use = array(

                    "related_dept_status" => "inactive"

                );

                $this->db->where("related_dept_darcode", $get_od['dc_data_old_dar']);

                $this->db->update("dc_related_dept_use", $inactive_related_dept_use);

            }



            foreach ($checkolddar->result_array() as $get_ods) {

                $inactive_type_use = array(

                    "dc_type_use_status" => "inactive"

                );

                $this->db->where("dc_type_use_darcode", $get_ods['dc_data_old_dar']);

                $this->db->update("dc_type_use", $inactive_type_use);

            }



            //Get old data for add to new data

            $query = $this->db->query("SELECT * FROM library_main WHERE lib_main_darcode='$getolddar->dc_data_old_dar' ");

            $get_data_old = $query->row();

            $ar_lib_save = array(

                "lib_main_doccode" => $get_doccodes->dc_data_doccode,

                "lib_main_darcode" => $darcode,

                "lib_main_doccode_master" => $get_data_old->lib_main_doccode_master,

                "lib_main_doccode_copy" => $get_data_old->lib_main_doccode_copy,

                "lib_main_file_location_master" => $get_data_old->lib_main_file_location_master,

                "lib_main_file_location_copy" => $get_data_old->lib_main_file_location_copy,

                "lib_main_status" => "active"

            );

            $this->db->insert("library_main", $ar_lib_save);





            //Email Zone

            $calldata_email = $this->doc_get_model->get_fulldata($darcode);

            $calldata_emails = $calldata_email->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องเกี่ยวกับเอกสาร(DAR) Status: ผลการดำเนินการของ DCC";



            $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

            $body .= "<h4>Status: ผลการดำเนินการของ DCC</h4>";



            $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

            $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



            $ra_typeuse = $this->doc_get_model->get_doctype_use($darcode);

            foreach ($ra_typeuse->result_array() as $rst) {

                $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";

            }



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

            $ra_related_dept = $this->doc_get_model->get_related_use($darcode);

            foreach ($ra_related_dept->result_array() as $rrd) {

                $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

            }

            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br><br>";



            if ($calldata_emails->dc_data_result_reson_status == 1) {

                $reson1_status = "อนุมัติ";

            } else {

                $reson1_status = "ไม่อนุมัติ";

            }

            $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก ผู้จัดการ :&nbsp;&nbsp;</strong></span>" . $reson1_status . "<br>";

            $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail . "<br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_mgr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_mgr . "</span><br><br>";







            if ($calldata_emails->dc_data_result_reson_status2 == 1) {

                $reson2_status = "อนุมัติ";

            } else {

                $reson2_status = "ไม่อนุมัติ";

            }

            $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก QMR :&nbsp;&nbsp;</strong></span>" . $reson2_status . "<br>";

            $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail2 . "<br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_qmr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_qmr . "</span><br><br>";





            $body .= "<span style='font-size:20px;'><strong>สำหรับผู้ควบคุมเอกสาร : &nbsp;</strong></span><span>" . $calldata_emails->dc_data_method . "</span><br>";

            $body .= "<span style='font-size:20px;'><strong>วันที่ดำเนินการ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_operation) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้ดำเนินการ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_operation . "</span><br><br>";





            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

            $mail->Host = "mail.saleecolour.net";  // specify main and backup server

            //        $mail->Host = "smtp.gmail.com";

            $mail->Port = 25; // พอร์ท

            //        $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;     // turn on SMTP authentication

            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";

            $mail->FromName = "Document System";



            $get_user_email = get_email_user("dc_user_group in (1,2,6)");

            foreach ($get_user_email->result_array() as $gue) {

                $mail->AddAddress($gue['dc_user_memberemail']);

            }





            // $mail->AddAddress("chainarong_k@saleecolour.com");

            foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {

                $mail->AddCC($cc['memberemail']);

            }





            $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");

            $gue_cc = $get_usercc_email->row();

            $mail->AddCC($gue_cc->dc_user_memberemail);



            $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters

            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();







//////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// New send Email
////////////////////////////////////////////////////////////////////////////////////////////

            $subject2 = 'แจ้งอัพเดตหน่วยงานที่เกี่ยวข้อง';
            $body2 = '
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Sarabun&display=swap");

                    h3{
                        font-family: Tahoma, sans-serif;
                        font-size:14px;
                    }

                    table {
                        font-family: Tahoma, sans-serif;
                        font-size:14px;
                        border-collapse: collapse;
                        width: 70%;
                    }
                    
                    td, th {
                        border: 1px solid #ccc;
                        text-align: left;
                        padding: 8px;
                    }
                    
                    tr:nth-child(even) {
                        background-color: #F5F5F5;
                    }

                    .bghead{
                        text-align:center;
                        background-color:#D3D3D3;
                    }
                </style>

                ';
            $body2 .= '
                <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
                <span style="padding-left:50px;">ขอแจ้งอัพเดตหน่วยงานที่เกี่ยวข้องรายละเอียดดังต่อไปนี้</span><br>
            ';
            $body2 .='
                <table style="margin-top:20px;">
                    <tr>
                        <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>'.$calldata_emails->dc_data_docname.'</td>
                        <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>'.$calldata_emails->dc_dept_main_name.'</td>
                    </tr>

                    <tr>
                        <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>'.$calldata_emails->dc_sub_type_name.'</td>
                        <td style="width:200px;"><b>ครั้งที่แก้ไข</b></td><td>'.$calldata_emails->dc_data_edit.'</td>
                    </tr>

                    <tr>
                        <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>'.$calldata_emails->dc_data_doccode.'</td>
                        <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>'.con_date($calldata_emails->dc_data_date_start).'</td>
                    </tr>
                </table>
                <div style="margin-top:30px;">
                    <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="'.base_url('librarys/view_by_dept').'">ตรวจสอบเอกสาร</a></span>
                </div>
            ';

            $mail2 = new PHPMailer();
            $mail2->IsSMTP();
            $mail2->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
            $mail2->SMTPDebug = 1;                                      // set mailer to use SMTP
            $mail2->Host = "mail.saleecolour.net";  // specify main and backup server
            //        $mail->Host = "smtp.gmail.com";
            $mail2->Port = 25; // พอร์ท
            //        $mail->SMTPSecure = 'tls';
            $mail2->SMTPAuth = true;     // turn on SMTP authentication
            $mail2->Username = getEmailAccount()->email_user;  // SMTP username
            //websystem@saleecolour.com
            //        $mail->Username = "chainarong039@gmail.com";
            $mail2->Password = getEmailAccount()->email_password; // SMTP password
            //Ae8686#
            //        $mail->Password = "ShctBkk1";
            $mail2->From = "documentsystem@saleecolour.net";
            $mail2->FromName = "Document System";
            $get_user_email2 = get_email_user("dc_user_group in (1,2,6)");

            foreach ($get_user_email2->result_array() as $gue) {
                $mail2->AddAddress($gue['dc_user_memberemail']);
            }

            // $mail->AddAddress("chainarong_k@saleecolour.com");
            foreach (getDeptCodeFromRelated($calldata_emails->dc_data_darcode) as $cc) {
                $mail2->AddCC($cc);
            }
            


            // $get_usercc_email2 = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
            // $gue_cc2 = $get_usercc_email2->row();
            // $mail2->AddCC($gue_cc2->dc_user_memberemail);
            $mail2->AddCC("chainarong_k@saleecolour.com");                  // name is optional
            $mail2->WordWrap = 50;                                 // set word wrap to 50 characters
            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
            $mail2->IsHTML(true);                                  // set email format to HTML
            $mail2->Subject = $subject2;
            $mail2->Body = $body2;
            $mail2->send();

            //************************************ZONE***SEND****EMAIL*************************************//

//////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// New send Email
////////////////////////////////////////////////////////////////////////////////////////////





        }

    }











    public function up_status1($doccode)

    {

        $ar = array(

            "lib_main_status" => "lib02"

        );

        $this->db->where('lib_main_doccode', $doccode);

        $this->db->update('library_main', $ar);

        redirect('document/thkpage/');

    }



    public function up_status2($doccode)

    {

        $ar = array(

            "lib_main_status" => "lib03"

        );

        $this->db->where('lib_main_doccode', $doccode);

        $this->db->update('library_main', $ar);

        redirect('document/thkpage/');

    }













    public function save_sec1_edit($doccode)

    {

        $get_darcode = $this->doc_get_model->get_dar_code();

        $dc_data_edit = $this->input->post('dc_data_edit');

        $dc_data_doccode = $this->input->post('dc_data_doccode');

        $dc_data_sub_type = $this->input->post('dc_data_sub_type');

        $darcode_h = $this->input->post("darcode_h");





        $rev = "-rev";



        if (isset($_POST['btnUser_submit'])) {



            if ($dc_data_sub_type == "s" || $dc_data_sub_type == "f" || $dc_data_sub_type == "x") {

                $cut1 = substr($dc_data_doccode, 0, 9);

                $cut2 = substr($dc_data_doccode, 9, 2);

                $cut3 = substr($dc_data_doccode, 11);



                $dc_data_doccode = $cut1 . $rev . $dc_data_edit . $cut3;



                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $dc_data_doccode . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            } else {

                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $dc_data_doccode . $rev . $dc_data_edit . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            }





            if ($dc_data_sub_type == "sds") {

                $conDoccode = cut_doccode3($dc_data_doccode);

            } else if ($dc_data_sub_type == "l") {

                $conDoccode = cut_doccode2($dc_data_doccode);

            } else {

                $conDoccode = cut_doccode1($dc_data_doccode);

            }









            $armain = array(

                "dc_data_doccode" => $conDoccode,

                "dc_data_doccode_display" => $dc_data_doccode,

                "dc_data_darcode" => $get_darcode,

                "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),

                "dc_data_sub_type_law" => $this->input->post("get_law"),

                "dc_data_sub_type_sds" => $this->input->post("get_sds"),

                "dc_data_date" => $this->input->post("dc_data_date"),

                "dc_data_user" => $this->input->post("dc_data_user"),

                "dc_data_dept" => $this->input->post("dc_data_dept"),

                "dc_data_docname" => $this->input->post("dc_data_docname"),

                "dc_data_edit" => $dc_data_edit,

                "dc_data_date_start" => $this->input->post("dc_data_date_start"),

                "dc_data_store" => $this->input->post("dc_data_store"),

                "dc_data_store_type" => $this->input->post("dc_data_store_type"),

                "dc_data_reson" => $this->input->post("dc_data_reson"),

                "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),

                "dc_data_file" => $file_name_date,

                "dc_data_file_location" => $filelocation,

                "dc_data_status" => "Open",

                "dc_data_old_dar" => $darcode_h,

                "dc_data_formcode" => $this->input->post("formcode")

            );





            // Delete old Related department

            // $this->db->where("related_dept_doccode", $conDoccode);

            // $this->db->delete("dc_related_dept_use");

            // Delete old Related department





            // Loop insert related department

            $related_dept_code = $this->input->post("related_dept_code");

            foreach ($related_dept_code as $related_dept_codes) {

                $arrelated = array(

                    "related_dept_doccode" => $conDoccode,

                    "related_dept_darcode" => $get_darcode,

                    "related_dept_code" => $related_dept_codes,

                    "related_dept_status" => "active"

                );

                $this->db->insert("dc_related_dept_use", $arrelated);

            }

            // Loop insert related department





            // Delete old Category 

            // $this->db->where("dc_type_use_doccode", $conDoccode);

            // $this->db->delete("dc_type_use");

            // Delete old Category 





            // Loop insert System Category

            $sys_cat = $this->input->post("dc_data_type");

            foreach ($sys_cat as $sys_cats) {

                $arsys_cat = array(

                    "dc_type_use_doccode" => $conDoccode,

                    "dc_type_use_darcode" => $get_darcode,

                    "dc_type_use_code" => $sys_cats,

                    "dc_type_use_status" => "active"

                );

                $this->db->insert("dc_type_use", $arsys_cat);

            }

            // Loop insert System Category







            //Change status on library main table

            $ar_update_library = array(

                "lib_main_modify_status" => "pending"

            );

            $this->db->where("lib_main_darcode", $darcode_h);

            $this->db->update("library_main", $ar_update_library);

            // Change status on library main table





            $result = $this->db->insert("dc_datamain", $armain);

            if (!$result) {

                echo "<script>";

                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

                echo "window.history.back(-1)";

                echo "</script>";

            } else {

                echo "บันทึกข้อมูลสำเร็จ";

            }





            $calldata_email = $this->doc_get_model->get_fulldata($get_darcode);

            $calldata_emails = $calldata_email->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR )";



            $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

            $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

            $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



            $ra_typeuse = $this->doc_get_model->get_doctype_use($get_darcode);

            foreach ($ra_typeuse->result_array() as $rst) {

                $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";

            }



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

            $ra_related_dept = $this->doc_get_model->get_related_use($get_darcode);

            foreach ($ra_related_dept->result_array() as $rrd) {

                $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

            }

            $body .= "<br><br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br>";



            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

            $mail->Host = "mail.saleecolour.net";  // specify main and backup server

            //        $mail->Host = "smtp.gmail.com";

            $mail->Port = 25; // พอร์ท

            //        $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;     // turn on SMTP authentication

            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";

            $mail->FromName = "Document System";



            $get_user_email = get_email_user("dc_user_group in (1,2,6)");

            foreach ($get_user_email->result_array() as $gue) {

                $mail->AddAddress($gue['dc_user_memberemail']);

            }





            // $mail->AddAddress("chainarong_k@saleecolour.com");

            foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {

                $mail->AddCC($cc['memberemail']);

            }





            $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");

            $gue_cc = $get_usercc_email->row();

            $mail->AddCC($gue_cc->dc_user_memberemail);



            $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters

            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();

            //************************************ZONE***SEND****EMAIL*************************************//







        }

    }













    public function save_sec1_copy($darcode)

    {



        $get_darcode = $this->doc_get_model->get_dar_code();



        $armain = array(

            "dc_data_doccode" => $this->input->post("dc_data_doccode"),

            "dc_data_doccode_display" => $this->input->post("dc_data_doccode_display"),

            "dc_data_darcode" => $get_darcode,

            "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),

            "dc_data_sub_type_law" => $this->input->post("get_law"),

            "dc_data_sub_type_sds" => $this->input->post("get_sds"),

            "dc_data_date" => $this->input->post("dc_data_date"),

            "dc_data_user" => $this->input->post("dc_data_user"),

            "dc_data_dept" => $this->input->post("dc_data_depts"),

            "dc_data_docname" => $this->input->post("dc_data_docname"),

            "dc_data_edit" => $this->input->post("dc_data_edit"),

            "dc_data_date_start" => $this->input->post("dc_data_date_start"),

            "dc_data_store" => $this->input->post("dc_data_store"),

            "dc_data_store_type" => $this->input->post("dc_data_store_type"),

            "dc_data_reson" => $this->input->post("dc_data_reson"),

            "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),

            "dc_data_file" => $this->input->post("dc_data_file"),

            "dc_data_file_location" => $this->input->post("dc_data_file_location"),

            "dc_data_status" => "Open",

            "dc_data_old_dar" => $this->input->post("dc_data_old_dar"),

            "dc_data_formcode" => $this->input->post("formcode")

        );





        // Delete old Related department

        // $this->db->where("related_dept_doccode", $darcode);

        // $this->db->delete("dc_related_dept_use");

        // Delete old Related department





        // Loop insert related department

        $related_dept_code = $this->input->post("related_dept_code");

        foreach ($related_dept_code as $related_dept_codes) {

            $arrelated = array(

                "related_dept_doccode" => $this->input->post("dc_data_doccode"),

                "related_dept_darcode" => $get_darcode,

                "related_dept_code" => $related_dept_codes,

                "related_dept_status" => "active"

            );

            $this->db->insert("dc_related_dept_use", $arrelated);

        }

        // Loop insert related department





        // Loop insert System Category

        $sys_cat = $this->input->post("dc_data_type");

        foreach ($sys_cat as $sys_cats) {

            $arsys_cat = array(

                "dc_type_use_doccode" => $this->input->post("dc_data_doccode"),

                "dc_type_use_darcode" => $get_darcode,

                "dc_type_use_code" => $sys_cats,

                "dc_type_use_status" => "active"

            );

            $this->db->insert("dc_type_use", $arsys_cat);

        }

        // Loop insert System Category





        //Change status on library main table

        $ar_update_library = array(

            "lib_main_modify_status" => "pending"

        );

        $this->db->where("lib_main_darcode", $this->input->post("dc_data_old_dar"));

        $this->db->update("library_main", $ar_update_library);

        // Change status on library main table







        $result = $this->db->insert("dc_datamain", $armain);

        if (!$result) {

            echo "<script>";

            echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

            echo "window.history.back(-1)";

            echo "</script>";

        } else {

            echo "บันทึกข้อมูลสำเร็จ";

        }







        $calldata_email = $this->doc_get_model->get_fulldata($get_darcode);

        $calldata_emails = $calldata_email->row();



        //************************************ZONE***SEND****EMAIL*************************************//



        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR )";



        $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

        $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

        $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



        $ra_typeuse = $this->doc_get_model->get_doctype_use($get_darcode);

        foreach ($ra_typeuse->result_array() as $rst) {

            $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";

        }



        $body .= "<br>";



        $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



        $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



        $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



        $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



        $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



        $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



        $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



        $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

        $ra_related_dept = $this->doc_get_model->get_related_use($get_darcode);

        foreach ($ra_related_dept->result_array() as $rrd) {

            $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

        }

        $body .= "<br><br>";



        $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br>";



        $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

        $body .= "</html>\n";



        $mail = new PHPMailer();

        $mail->IsSMTP();

        $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

        $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

        $mail->Host = "mail.saleecolour.net";  // specify main and backup server

        //        $mail->Host = "smtp.gmail.com";

        $mail->Port = 25; // พอร์ท

        //        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;     // turn on SMTP authentication

        $mail->Username = getEmailAccount()->email_user;  // SMTP username

        //websystem@saleecolour.com

        //        $mail->Username = "chainarong039@gmail.com";

        $mail->Password = getEmailAccount()->email_password; // SMTP password

        //Ae8686#

        //        $mail->Password = "ShctBkk1";



        $mail->From = "documentsystem@saleecolour.net";

        $mail->FromName = "Document System";



        $get_user_email = get_email_user("dc_user_group in (1,2,5)");

        foreach ($get_user_email->result_array() as $gue) {

            $mail->AddAddress($gue['dc_user_memberemail']);

        }





        // $mail->AddAddress("chainarong_k@saleecolour.com");

        foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {

            $mail->AddCC($cc['memberemail']);

        }





        $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");

        $gue_cc = $get_usercc_email->row();

        $mail->AddCC($gue_cc->dc_user_memberemail);



        $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional

        $mail->WordWrap = 50;                                 // set word wrap to 50 characters

        // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

        $mail->IsHTML(true);                                  // set email format to HTML

        $mail->Subject = $subject;

        $mail->Body = $body;

        $mail->send();

        //************************************ZONE***SEND****EMAIL*************************************//
    }






















////////////////////////////////////////////////////////////////////
//////////////////////////Section save cancel
//////////////////////////////////////////////////////////////////

    public function save_cancel($darcode)
    {
        $get_darcode = $this->doc_get_model->get_dar_code();

        $armain = array(
            "dc_data_doccode" => $this->input->post("dc_data_doccode"),
            "dc_data_doccode_display" => $this->input->post("dc_data_doccode_display"),
            "dc_data_darcode" => $get_darcode,
            "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),
            "dc_data_sub_type_law" => $this->input->post("get_law"),
            "dc_data_sub_type_sds" => $this->input->post("get_sds"),
            "dc_data_date" => $this->input->post("dc_data_date"),
            "dc_data_user" => $this->input->post("dc_data_user"),
            "dc_data_dept" => $this->input->post("dc_data_depts"),
            "dc_data_docname" => $this->input->post("dc_data_docname"),
            "dc_data_edit" => $this->input->post("dc_data_edit"),
            "dc_data_date_start" => $this->input->post("dc_data_date_start"),
            "dc_data_store" => $this->input->post("dc_data_store"),
            "dc_data_store_type" => $this->input->post("dc_data_store_type"),
            "dc_data_reson" => $this->input->post("dc_data_reson"),
            "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),
            "dc_data_file" => $this->input->post("dc_data_file"),
            "dc_data_file_location" => $this->input->post("dc_data_file_location"),
            "dc_data_status" => "Open",
            "dc_data_old_dar" => $this->input->post("dc_data_old_dar"),
            "dc_data_formcode" => $this->input->post("formcode")

        );



        // Loop insert related department

        $related_dept_code = $this->input->post("related_dept_code");
        foreach ($related_dept_code as $related_dept_codes) {
            $arrelated = array(

                "related_dept_doccode" => $this->input->post("dc_data_doccode"),
                "related_dept_darcode" => $get_darcode,
                "related_dept_code" => $related_dept_codes,
                "related_dept_status" => "active"
            );
            $this->db->insert("dc_related_dept_use", $arrelated);
        }

        // Loop insert related department





        // Loop insert System Category

        $sys_cat = $this->input->post("dc_data_type");

        foreach ($sys_cat as $sys_cats) {
            $arsys_cat = array(
                "dc_type_use_doccode" => $this->input->post("dc_data_doccode"),
                "dc_type_use_darcode" => $get_darcode,
                "dc_type_use_code" => $sys_cats,
                "dc_type_use_status" => "active"
            );
            $this->db->insert("dc_type_use", $arsys_cat);
        }

        // Loop insert System Category





        //Change status on library main table

        $ar_update_library = array(
            "lib_main_modify_status" => "pending"
        );

        $this->db->where("lib_main_darcode", $this->input->post("dc_data_old_dar"));
        $this->db->update("library_main", $ar_update_library);

        // Change status on library main table



        $result = $this->db->insert("dc_datamain", $armain);

        if (!$result) {
            echo "<script>";
            echo "alert('บันทึกข้อมูลไม่สำเร็จ')";
            echo "window.history.back(-1)";
            echo "</script>";

        } else {
            echo "บันทึกข้อมูลสำเร็จ";

        }





        $calldata_email = $this->doc_get_model->get_fulldata($get_darcode);
        $calldata_emails = $calldata_email->row();



        //************************************ZONE***SEND****EMAIL*************************************//



        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR )";



        $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

        $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

        $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



        $ra_typeuse = $this->doc_get_model->get_doctype_use($get_darcode);

        foreach ($ra_typeuse->result_array() as $rst) {
            $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";
        }



        $body .= "<br>";



        $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



        $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



        $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



        $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



        $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



        $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



        $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



        $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

        $ra_related_dept = $this->doc_get_model->get_related_use($get_darcode);

        foreach ($ra_related_dept->result_array() as $rrd) {

            $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

        }

        $body .= "<br><br>";



        $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br>";



        $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

        $body .= "</html>\n";



        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
        $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
        $mail->Host = "mail.saleecolour.net";  // specify main and backup server
        //        $mail->Host = "smtp.gmail.com";
        $mail->Port = 25; // พอร์ท
        //        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = getEmailAccount()->email_user;  // SMTP username
        //websystem@saleecolour.com
        //        $mail->Username = "chainarong039@gmail.com";
        $mail->Password = getEmailAccount()->email_password; // SMTP password
        //Ae8686#
        //        $mail->Password = "ShctBkk1";

        $mail->From = "documentsystem@saleecolour.net";
        $mail->FromName = "Document System";

        $get_user_email = get_email_user("dc_user_group in (1,2,5)");
        foreach ($get_user_email->result_array() as $gue) {
            $mail->AddAddress($gue['dc_user_memberemail']);
        }


        // $mail->AddAddress("chainarong_k@saleecolour.com");

        foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {
            $mail->AddCC($cc['memberemail']);
        }





        $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
        $gue_cc = $get_usercc_email->row();
        $mail->AddCC($gue_cc->dc_user_memberemail);

        $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters

        // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();

        //************************************ZONE***SEND****EMAIL*************************************//

    }
////////////////////////////////////////////////////////////////////
//////////////Section save cancel
//////////////////////////////////////////////////////////////////
























///////////////////////////////////////////////////////////////////////////////
//////////////////////////Section ของการ ยกเลิกเอกสาร
//////////////////////////////////////////////////////////////////////////////
    public function save_sec4cancel($darcode)
    {

        if (isset($_POST['btnOpsave'])) {
            // Get document code

            $get_doccode = $this->db->query("SELECT dc_data_doccode , dc_data_file FROM dc_datamain WHERE dc_data_darcode='$darcode' ");
            $get_doccodes = $get_doccode->row();
            $get_doc_code = substr($get_doccodes->dc_data_file, 0, -4);

            // For Master file

            $file_name = $_FILES['document_master_cancel']['name'];
            $file_name_cut = str_replace(" ", "", $file_name);
            $file_name_master = substr_replace(".", $get_doc_code . "-master-cancel" . ".pdf", 0);
            $file_size = $_FILES['document_master_cancel']['size'];
            $file_tmp = $_FILES['document_master_cancel']['tmp_name'];
            $file_type = $_FILES['document_master_cancel']['type'];

            move_uploaded_file($file_tmp, "asset/master/" . $file_name_master);
            $filelocation_master = "asset/master/";

            print_r($file_name);
            echo "<br>" . "Copy/Upload Complete" . "<br>";


            $status = "Complete";
            $ar_save_sec4 = array(

                "dc_data_method" => $this->input->post('dc_data_method'),
                "dc_data_operation" => $this->input->post('dc_data_operation'),
                "dc_data_date_operation" => date("Y-m-d"),
                "dc_data_status" => $status
            );

            $this->db->where("dc_data_darcode", $darcode);
            $result_sec4 = $this->db->update("dc_datamain", $ar_save_sec4);



            $checkolddar = $this->db->query("SELECT dc_data_old_dar , dc_data_darcode FROM dc_datamain WHERE dc_data_darcode = '$darcode' ");
            $checknumrow = $checkolddar->num_rows();
            if ($checknumrow > 0) {

                $getolddar = $checkolddar->row();

                $inactive = array(

                    "lib_main_status" => "inactive",
                    "lib_main_modify_status" => "",
                    "lib_main_pin_status" => 0,
                    "lib_main_pin_order" => 0

                );

                $this->db->where("lib_main_darcode", $getolddar->dc_data_old_dar);
                $this->db->update("library_main", $inactive);

            }


            foreach ($checkolddar->result_array() as $get_od) {
                $inactive_related_dept_use = array(
                    "related_dept_status" => "inactive"
                );

                $this->db->where("related_dept_darcode", $get_od['dc_data_old_dar']);
                $this->db->update("dc_related_dept_use", $inactive_related_dept_use);
            }


            foreach ($checkolddar->result_array() as $get_d) {

                $inactive_related_dept = array(
                    "related_dept_status" => "inactive"
                );
                $this->db->where("related_dept_darcode", $get_d['dc_data_darcode']);
                $this->db->update("dc_related_dept_use", $inactive_related_dept);

            }



            foreach ($checkolddar->result_array() as $get_ods) {
                $inactive_type_use = array(
                    "dc_type_use_status" => "inactive"
                );

                $this->db->where("dc_type_use_darcode", $get_ods['dc_data_old_dar']);
                $this->db->update("dc_type_use", $inactive_type_use);

            }



            foreach ($checkolddar->result_array() as $get_ds) {
                $inactive_type_use = array(
                    "dc_type_use_status" => "inactive"
                );

                $this->db->where("dc_type_use_darcode", $get_ds['dc_data_darcode']);
                $this->db->update("dc_type_use", $inactive_type_use);

            }



            $ar_lib_save = array(

                "lib_main_doccode" => $get_doccodes->dc_data_doccode,
                "lib_main_darcode" => $darcode,
                "lib_main_doccode_master" => $file_name_master,
                "lib_main_doccode_copy" => "",
                "lib_main_file_location_master" => $filelocation_master,
                "lib_main_file_location_copy" => "",
                "lib_main_status" => "inactive"

            );
            $this->db->insert("library_main", $ar_lib_save);



            $result = $this->db->where("li_hashtag_doc_code", $get_doccodes->dc_data_doccode);
            $result = $this->db->delete("library_hashtag");

        }





        //Email Zone

        $calldata_email = $this->doc_get_model->get_fulldata($darcode);
        $calldata_emails = $calldata_email->row();


        //************************************ZONE***SEND****EMAIL*************************************//



        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร(DAR) Status: ผลการดำเนินการของ DCC";


        $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

        $body .= "<h4>Status: ผลการดำเนินการของ DCC</h4>";


        $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

        $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";


        $ra_typeuse = $this->doc_get_model->get_doctype_use($darcode);

        foreach ($ra_typeuse->result_array() as $rst) {
            $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";
        }


        $body .= "<br>";

        $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";


        $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";


        $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";


        $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";


        $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";


        $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";


        $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";


        $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

        $ra_related_dept = $this->doc_get_model->get_related_use($darcode);

        foreach ($ra_related_dept->result_array() as $rrd) {
            $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";
        }

        $body .= "<br>";

        $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br><br>";

        if ($calldata_emails->dc_data_result_reson_status == 1) {
            $reson1_status = "อนุมัติ";
        } else {
            $reson1_status = "ไม่อนุมัติ";
        }

        $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก ผู้จัดการ :&nbsp;&nbsp;</strong></span>" . $reson1_status . "<br>";

        $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail . "<br>";

        $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_mgr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_mgr . "</span><br><br>";


        if ($calldata_emails->dc_data_result_reson_status2 == 1) {

            $reson2_status = "อนุมัติ";

        } else {

            $reson2_status = "ไม่อนุมัติ";

        }

        $body .= "<span style='font-size:20px;'><strong>ผลการร้องขอ จาก QMR :&nbsp;&nbsp;</strong></span>" . $reson2_status . "<br>";

        $body .= "<span style='font-size:20px;'><strong>รายละเอียดการอนุมัติ : &nbsp;</strong></span>" . $calldata_emails->dc_data_result_reson_detail2 . "<br>";

        $body .= "<span style='font-size:20px;'><strong>วันที่อนุมัติ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_approve_qmr) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้อนุมัติ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_approve_qmr . "</span><br><br>";


        $body .= "<span style='font-size:20px;'><strong>สำหรับผู้ควบคุมเอกสาร : &nbsp;</strong></span><span>" . $calldata_emails->dc_data_method . "</span><br>";

        $body .= "<span style='font-size:20px;'><strong>วันที่ดำเนินการ : &nbsp;&nbsp;</strong></span><span>" . con_date($calldata_emails->dc_data_date_operation) . "&nbsp;&nbsp;</span><span style='font-size:20px;'><strong>ชื่อผู้ดำเนินการ :&nbsp;&nbsp;</strong></span><span>" . $calldata_emails->dc_data_operation . "</span><br><br>";


        $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

        $body .= "</html>\n";



        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
        $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
        $mail->Host = "mail.saleecolour.net";  // specify main and backup server
        //        $mail->Host = "smtp.gmail.com";
        $mail->Port = 25; // พอร์ท
        //        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = getEmailAccount()->email_user;  // SMTP username
        //websystem@saleecolour.com
        //        $mail->Username = "chainarong039@gmail.com";
        $mail->Password = getEmailAccount()->email_password; // SMTP password
        //Ae8686#
        //        $mail->Password = "ShctBkk1"

        $mail->From = "documentsystem@saleecolour.net";
        $mail->FromName = "Document System";

        $get_user_email = get_email_user("dc_user_group in (1,2,6)");
        foreach ($get_user_email->result_array() as $gue) {
            $mail->AddAddress($gue['dc_user_memberemail']);
        }

        // $mail->AddAddress("chainarong_k@saleecolour.com");
        foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {
            $mail->AddCC($cc['memberemail']);
        }

        $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
        $gue_cc = $get_usercc_email->row();
        $mail->AddCC($gue_cc->dc_user_memberemail);
        $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();

        //************************************ZONE***SEND****EMAIL*************************************//




        
//////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// New send Email
////////////////////////////////////////////////////////////////////////////////////////////

$subject2 = 'แจ้งยกเลิกเอกสาร';
$body2 = '
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Sarabun&display=swap");

        h3{
            font-family: Tahoma, sans-serif;
            font-size:14px;
        }

        table {
            font-family: Tahoma, sans-serif;
            font-size:14px;
            border-collapse: collapse;
            width: 70%;
        }
        
        td, th {
            border: 1px solid #ccc;
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #F5F5F5;
        }

        .bghead{
            text-align:center;
            background-color:#D3D3D3;
        }
    </style>';


$body2 .= '
    <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
    <span style="padding-left:50px;">ขอแจ้งยกเลิกเอกสาร รายละเอียดดังต่อไปนี้</span><br>
';
$body2 .='
    <table style="margin-top:20px;">
        <tr>
            <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>'.$calldata_emails->dc_data_docname.'</td>
            <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>'.$calldata_emails->dc_dept_main_name.'</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>'.$calldata_emails->dc_sub_type_name.'</td>
            <td style="width:200px;"><b>ครั้งที่แก้ไข</b></td><td>'.$calldata_emails->dc_data_edit.'</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>'.$calldata_emails->dc_data_doccode.'</td>
            <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>'.con_date($calldata_emails->dc_data_date_start).'</td>
        </tr>

    </table>
    <div style="margin-top:30px;">
        <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="'.base_url('librarys/view_by_dept').'">ตรวจสอบเอกสาร</a></span>
    </div>
';

$mail2 = new PHPMailer();
$mail2->IsSMTP();
$mail2->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
$mail2->SMTPDebug = 1;                                      // set mailer to use SMTP
$mail2->Host = "mail.saleecolour.net";  // specify main and backup server
//        $mail->Host = "smtp.gmail.com";
$mail2->Port = 25; // พอร์ท
//        $mail->SMTPSecure = 'tls';
$mail2->SMTPAuth = true;     // turn on SMTP authentication
$mail2->Username = getEmailAccount()->email_user;  // SMTP username
//websystem@saleecolour.com
//        $mail->Username = "chainarong039@gmail.com";
$mail2->Password = getEmailAccount()->email_password; // SMTP password
//Ae8686#
//        $mail->Password = "ShctBkk1";
$mail2->From = "documentsystem@saleecolour.net";
$mail2->FromName = "Document System";
$get_user_email2 = get_email_user("dc_user_group in (1,2,6)");

foreach ($get_user_email2->result_array() as $gue) {
    $mail2->AddAddress($gue['dc_user_memberemail']);
}

// $mail->AddAddress("chainarong_k@saleecolour.com");
foreach (getDeptCodeFromRelated($calldata_emails->dc_data_darcode) as $cc) {
    $mail2->AddCC($cc);
}


// $get_usercc_email2 = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");
// $gue_cc2 = $get_usercc_email2->row();
// $mail2->AddCC($gue_cc2->dc_user_memberemail);
$mail2->AddCC("chainarong_k@saleecolour.com");                  // name is optional
$mail2->WordWrap = 50;                                 // set word wrap to 50 characters
// $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
// $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail2->IsHTML(true);                                  // set email format to HTML
$mail2->Subject = $subject2;
$mail2->Body = $body2;
$mail2->send();

//************************************ZONE***SEND****EMAIL*************************************//

//////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// New send Email
////////////////////////////////////////////////////////////////////////////////////////////

        

    }

    
///////////////////////////////////////////////////////////////////////////////
//////////////////////////Section ของการ ยกเลิกเอกสาร
//////////////////////////////////////////////////////////////////////////////









    public function save_sec1change($doccode)

    {

        $get_darcode = $this->doc_get_model->get_dar_code();

        $dc_data_edit = $this->input->post('dc_data_edit');

        $dc_data_doccode = $this->input->post('dc_data_doccode');

        $dc_data_sub_type = $this->input->post('dc_data_sub_type');

        $darcode_h = $this->input->post("darcode_h");





        $rev = "-rev";



        if (isset($_POST['btnUser_submit'])) {



            if ($dc_data_sub_type == "s" || $dc_data_sub_type == "f" || $dc_data_sub_type == "x") {

                $cut1 = substr($dc_data_doccode, 0, 9);

                $cut2 = substr($dc_data_doccode, 9, 2);

                $cut3 = substr($dc_data_doccode, 11);



                $dc_data_doccode = $cut1 . $rev . $dc_data_edit . $cut3;



                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $dc_data_doccode . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            } else {

                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $dc_data_doccode . $rev . $dc_data_edit . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            }





            if ($dc_data_sub_type == "sds") {

                $conDoccode = cut_doccode3($dc_data_doccode);

            } else if ($dc_data_sub_type == "l") {

                $conDoccode = cut_doccode2($dc_data_doccode);

            } else {

                $conDoccode = cut_doccode1($dc_data_doccode);

            }









            $armain = array(

                "dc_data_doccode" => $conDoccode,

                "dc_data_doccode_display" => $dc_data_doccode,

                "dc_data_darcode" => $get_darcode,

                "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),

                "dc_data_sub_type_law" => $this->input->post("get_law"),

                "dc_data_sub_type_sds" => $this->input->post("get_sds"),

                "dc_data_date" => $this->input->post("dc_data_date"),

                "dc_data_user" => $this->input->post("dc_data_user"),

                "dc_data_dept" => $this->input->post("dc_data_dept"),

                "dc_data_docname" => $this->input->post("dc_data_docname"),

                "dc_data_edit" => $dc_data_edit,

                "dc_data_date_start" => $this->input->post("dc_data_date_start"),

                "dc_data_store" => $this->input->post("dc_data_store"),

                "dc_data_store_type" => $this->input->post("dc_data_store_type"),

                "dc_data_reson" => $this->input->post("dc_data_reson"),

                "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),

                "dc_data_file" => $file_name_date,

                "dc_data_file_location" => $filelocation,

                "dc_data_status" => "Open",

                "dc_data_old_dar" => $darcode_h,

                "dc_data_formcode" => $this->input->post("formcode")

            );





            // Delete old Related department

            // $this->db->where("related_dept_doccode", $conDoccode);

            // $this->db->delete("dc_related_dept_use");

            // Delete old Related department





            // Loop insert related department

            $related_dept_code = $this->input->post("related_dept_code");

            foreach ($related_dept_code as $related_dept_codes) {

                $arrelated = array(

                    "related_dept_doccode" => $conDoccode,

                    "related_dept_darcode" => $get_darcode,

                    "related_dept_code" => $related_dept_codes,

                    "related_dept_status" => "active"

                );

                $this->db->insert("dc_related_dept_use", $arrelated);

            }

            // Loop insert related department





            // Delete old Category 

            // $this->db->where("dc_type_use_doccode", $conDoccode);

            // $this->db->delete("dc_type_use");

            // Delete old Category 





            // Loop insert System Category

            $sys_cat = $this->input->post("dc_data_type");

            foreach ($sys_cat as $sys_cats) {

                $arsys_cat = array(

                    "dc_type_use_doccode" => $conDoccode,

                    "dc_type_use_darcode" => $get_darcode,

                    "dc_type_use_code" => $sys_cats,

                    "dc_type_use_status" => "active"

                );

                $this->db->insert("dc_type_use", $arsys_cat);

            }

            // Loop insert System Category







            //Change status on library main table



            $ar_update_library = array(

                "lib_main_modify_status" => "pending"

            );

            $this->db->where("lib_main_darcode", $darcode_h);

            $this->db->update("library_main", $ar_update_library);



            // Change status on library main table



            $result = $this->db->insert("dc_datamain", $armain);

            if (!$result) {

                echo "<script>";

                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

                echo "window.history.back(-1)";

                echo "</script>";

            } else {

                echo "บันทึกข้อมูลสำเร็จ";

                // header("refresh:10; url=".base_url()."document");



            }







            $calldata_email = $this->doc_get_model->get_fulldata($get_darcode);

            $calldata_emails = $calldata_email->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR )";



            $body = "<h3 style='font-size:26px;'>พบใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ใหม่ !</h3>";

            $body .= "<strong style='font-size:20px;'>เลขที่ใบ DAR :</strong>&nbsp;" . $calldata_emails->dc_data_darcode . "&nbsp;&nbsp;&nbsp;";

            $body .= "<strong style='font-size:20px;'>ระบบที่เกี่ยวข้อง :</strong>&nbsp;";



            $ra_typeuse = $this->doc_get_model->get_doctype_use($get_darcode);

            foreach ($ra_typeuse->result_array() as $rst) {

                $body .= $rst['dc_type_name'] . "&nbsp;,&nbsp;";

            }



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ประเภทเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_sub_type_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_user . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $calldata_emails->dc_dept_main_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_docname . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รหัสเอกสาร :</strong></span>&nbsp;" . $calldata_emails->dc_data_doccode . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ครั้งที่แก้ไข :</strong></span>&nbsp;" . $calldata_emails->dc_data_edit . "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่เริ่มใช้ :</strong></span>&nbsp;" . con_date($calldata_emails->dc_data_date_start) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ระยะเวลาในการจัดเก็บ :</strong></span>&nbsp;" . $calldata_emails->dc_data_store . "&nbsp;" . $calldata_emails->dc_data_store_type . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_reason_name . "<br>";



            $body .= "<span style='font-size:20px;'><strong>รายละเอียด เหตุผลในการร้องขอ :</strong></span>&nbsp;" . $calldata_emails->dc_data_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>หน่วยงานที่เกี่ยวข้อง :</strong></span>&nbsp;";

            $ra_related_dept = $this->doc_get_model->get_related_use($get_darcode);

            foreach ($ra_related_dept->result_array() as $rrd) {

                $body .= $rrd['related_dept_name'] . "&nbsp;,&nbsp;";

            }

            $body .= "<br><br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $calldata_emails->dc_data_file_location . $calldata_emails->dc_data_file . "'>" . $calldata_emails->dc_data_file . "</a><br>";



            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/viewfull/') . $calldata_emails->dc_data_darcode . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

            $mail->Host = "mail.saleecolour.net";  // specify main and backup server

            //        $mail->Host = "smtp.gmail.com";

            $mail->Port = 25; // พอร์ท

            //        $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;     // turn on SMTP authentication

            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";

            $mail->FromName = "Document System";



            $get_user_email = get_email_user("dc_user_group in (1,2,5)");

            foreach ($get_user_email->result_array() as $gue) {

                $mail->AddAddress($gue['dc_user_memberemail']);

            }





            // $mail->AddAddress("chainarong_k@saleecolour.com");

            foreach (getManagerEmail($calldata_emails->dc_dept_main_code)->result_array() as $cc) {

                $mail->AddCC($cc['memberemail']);

            }





            $get_usercc_email = get_email_user("dc_user_data_user='$calldata_emails->dc_data_user' ");

            $gue_cc = $get_usercc_email->row();

            $mail->AddCC($gue_cc->dc_user_memberemail);



            $mail->AddCC("chainarong_k@saleecolour.com");                  // name is optional

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters

            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();

            //************************************ZONE***SEND****EMAIL*************************************//











        }

    }







    public function save_edit_gl_doc($gl_doc_code)

    {



        if ($_FILES['gl_doc_file']['tmp_name'] == "") {

            $file_name_cuts = $this->input->post("check_gl_file");

        } else {

            $file_name = $_FILES['gl_doc_file']['name'];

            $file_name_cut = str_replace(" ", "", $file_name);

            $file_name_cuts = substr_replace(".", $gl_doc_code . ".pdf", 0);

            $file_size = $_FILES['gl_doc_file']['size'];

            $file_tmp = $_FILES['gl_doc_file']['tmp_name'];

            $file_type = $_FILES['gl_doc_file']['type'];



            move_uploaded_file($file_tmp, "asset/general_document/" . $file_name_cuts);

            $filelocation = "asset/general_document/";





            print_r($file_name);

            echo "<br>" . "Copy/Upload Complete" . "<br>";

        }







        if (isset($_POST['btnEdit_gldoc'])) {







            $add_doc = array(



                "gl_doc_name" => $this->input->post("gl_doc_name"),

                "gl_doc_folder_number" => $this->input->post("gl_doc_folder_number"),

                "gl_doc_detail" => $this->input->post("gl_doc_detail"),

                "gl_doc_file" => $file_name_cuts

            );





            // $hashtags = $this->input->post("gl_doc_hashtag");

            // foreach ($hashtags as $hashtags_btn) {

            //     $ar_hashtag = array(

            //         "gl_ht_doc_code" => $get_doccode,

            //         "gl_ht_name" => $hashtags_btn

            //     );



            //     $this->db->insert("gl_hashtag", $ar_hashtag);

            // }



            $result = $this->db->where("gl_doc_code", $gl_doc_code);

            $result = $this->db->update("gl_document", $add_doc);

            if (!$result) {

                echo "<script>";

                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

                echo "window.history.back(-1)";

                echo "</script>";

            } else {

                echo "บันทึกข้อมูลสำเร็จ";

            }

        }

    }









    public function save_gl_doc()

    {

        $get_doccode = get_gl_doccode();



        $file_name = $_FILES['gl_doc_file']['name'];

        $file_name_cut = str_replace(" ", "", $file_name);

        $file_name_cuts = substr_replace(".", $get_doccode . ".pdf", 0);

        $file_size = $_FILES['gl_doc_file']['size'];

        $file_tmp = $_FILES['gl_doc_file']['tmp_name'];

        $file_type = $_FILES['gl_doc_file']['type'];



        move_uploaded_file($file_tmp, "asset/general_document/" . $file_name_cuts);

        $filelocation = "asset/general_document/";





        print_r($file_name);

        echo "<br>" . "Copy/Upload Complete" . "<br>";



        if (isset($_POST['btnAdd_gldoc'])) {







            $add_doc = array(

                "gl_doc_date_request" => $this->input->post("gl_doc_date_request"),

                "gl_doc_username" => $this->input->post("gl_doc_username"),

                "gl_doc_ecode" => $this->input->post("gl_doc_ecode"),

                "gl_doc_deptcode" => $this->input->post("gl_doc_deptcode"),

                "gl_doc_deptname" => $this->input->post("gl_doc_deptname"),

                "gl_doc_name" => $this->input->post("gl_doc_name"),

                "gl_doc_code" => $get_doccode,

                "gl_doc_folder_number" => $this->input->post("gl_doc_folder_number"),

                "gl_doc_detail" => $this->input->post("gl_doc_detail"),

                "gl_doc_file" => $file_name_cuts,

                "gl_doc_file_location" => $filelocation,

                "gl_doc_approve_status" => $this->input->post("gl_doc_status"),

                "gl_doc_reson_detail" => $this->input->post("gl_doc_reson_detail"),

                "gl_doc_approve_by" => $this->input->post("gl_doc_approve"),

                "gl_doc_status" => "Open"

            );





            $hashtags = $this->input->post("gl_doc_hashtag");

            foreach ($hashtags as $hashtags_btn) {

                $ar_hashtag = array(

                    "gl_ht_doc_code" => $get_doccode,

                    "gl_ht_name" => $hashtags_btn

                );



                $this->db->insert("gl_hashtag", $ar_hashtag);

            }





            $result = $this->db->insert("gl_document", $add_doc);

            if (!$result) {

                echo "<script>";

                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

                echo "window.history.back(-1)";

                echo "</script>";

            } else {

                echo "บันทึกข้อมูลสำเร็จ";

                header("refresh:0; url=" . base_url() . "document/list_generel");

            }







            $getGldata = getgldataforemail($get_doccode);

            $rsgldata = $getGldata->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องขอใช้งานเอกสารภายใน";



            $body = "<h3 style='font-size:26px;'>ใบคำร้องขอใช้งานเอกสารภายใน ใหม่ !</h3>";

            $body .= "<strong style='font-size:20px;'>รหัสเอกสาร :</strong>&nbsp;" . $rsgldata->gl_doc_code . "&nbsp;&nbsp;&nbsp;";



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($rsgldata->gl_doc_date_request) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $rsgldata->gl_doc_username . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $rsgldata->gl_dept_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $rsgldata->gl_doc_name . "<br>";





            $body .= "<span style='font-size:20px;'><strong>รายละเอียดของเอกสาร :</strong></span>&nbsp;" . $rsgldata->gl_doc_detail . "<br>";



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $rsgldata->gl_doc_file_location . $rsgldata->gl_doc_file . "'>" . $rsgldata->gl_doc_name . "</a><br>";









            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/gl_view_doc/') . $rsgldata->gl_doc_code . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

            $mail->Host = "mail.saleecolour.net";  // specify main and backup server

            //        $mail->Host = "smtp.gmail.com";

            $mail->Port = 25; // พอร์ท

            //        $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;     // turn on SMTP authentication

            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";

            $mail->FromName = "Document System";



            // $get_user_email = get_email_user("dc_user_group in (1,2,5)");

            foreach (get_email_sendtoMgr($rsgldata->gl_doc_deptcode)->result_array() as $gue) {

                $mail->AddAddress($gue['dc_user_memberemail']);

            }



            // $mail->AddAddress("chainarong_k@saleecolour.com");
            foreach(get_email_sendccDept($rsgldata->gl_doc_deptcode)->result_array() as $rss){
                $mail->AddCC($rss['dc_user_memberemail']);
            }

            foreach(get_email_sendtoDcc()->result_array() as $dccE){
                $mail->AddCC($dccE['dc_user_memberemail']);
            }

            $mail->AddCC("chainarong_k@saleecolour.com");





            $get_usercc_email = get_email_user("dc_user_data_user='$rsgldata->gl_doc_username' ");

            $gue_cc = $get_usercc_email->row();

            // $mail->AddCC($gue_cc->dc_user_memberemail);







            // $mail->AddCC("chainarong039@gmail.com");                  // name is optional

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters

            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();

            //************************************ZONE***SEND****EMAIL*************************************//



        }

    }





    public function save_gl_doc2($gl_doc_code)

    {

        if (isset($_POST['btn_save2'])) {

            if ($this->input->post("gl_doc_status") == 1) {



                $ar_approve = array(

                    "gl_doc_approve_status" => $this->input->post("gl_doc_status"),

                    "gl_doc_reson_detail" => $this->input->post("gl_doc_reson_detail"),

                    "gl_doc_approve_by" => $this->input->post("gl_doc_approve_by"),

                    "gl_doc_status" => "Approved"

                );



                $result = $this->db->where("gl_doc_code", $gl_doc_code);

                $result = $this->db->update("gl_document", $ar_approve);

            } else {



                $this->db->where('gl_ht_doc_code', $gl_doc_code);

                $this->db->delete('gl_hashtag');





                $ar_approve = array(

                    "gl_doc_approve_status" => $this->input->post("gl_doc_status"),

                    "gl_doc_reson_detail" => $this->input->post("gl_doc_reson_detail"),

                    "gl_doc_approve_by" => $this->input->post("gl_doc_approve_by"),

                    "gl_doc_status" => "Not Approve"

                );



                $result = $this->db->where("gl_doc_code", $gl_doc_code);

                $result = $this->db->update("gl_document", $ar_approve);

            }



            if (!$result) {

                echo "<script>";

                echo "alert('บันทึกข้อมูลไม่สำเร็จ')";

                echo "window.history.back(-1)";

                echo "</script>";

            } else {

                echo "บันทึกข้อมูลสำเร็จ";

                header("refresh:0; url=" . base_url() . "document/list_generel");

            }









            $getGldata = getgldataforemail($gl_doc_code);

            $rsgldata = $getGldata->row();



            //************************************ZONE***SEND****EMAIL*************************************//



            $subject = "New ใบคำร้องขอใช้งานเอกสารภายใน";



            $body = "<h3 style='font-size:26px;'>ใบคำร้องขอใช้งานเอกสารภายใน ใหม่ !</h3>";

            $body .= "<strong style='font-size:20px;'>รหัสเอกสาร :</strong>&nbsp;" . $rsgldata->gl_doc_code . "&nbsp;&nbsp;&nbsp;";



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>วันที่ร้องขอ :</strong></span>&nbsp;" . con_date($rsgldata->gl_doc_date_request) . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ผู้ร้องขอ :</strong></span>&nbsp;" . $rsgldata->gl_doc_username . "<br>";



            $body .= "<span style='font-size:20px;'><strong>แผนก :</strong></span>&nbsp;" . $rsgldata->gl_dept_name . "&nbsp;&nbsp;&nbsp;<span style='font-size:20px;'><strong>ชื่อเอกสาร :</strong></span>&nbsp;" . $rsgldata->gl_doc_name . "<br>";





            $body .= "<span style='font-size:20px;'><strong>รายละเอียดของเอกสาร :</strong></span>&nbsp;" . $rsgldata->gl_doc_detail . "<br>";



            $body .= "<br>";



            $body .= "<span style='font-size:20px;'><strong>ผลการอนุมัติ :</strong></span>&nbsp;" . $rsgldata->gl_doc_status . "<br>";



            $body .= "<span style='font-size:20px;'><strong>เหตุผลในการอนุมัติ :</strong></span>&nbsp;" . $rsgldata->gl_doc_reson_detail . "<br>";



            $body .= "<span style='font-size:20px;'><strong>ผู้อนุมัติ :</strong></span>&nbsp;" . $rsgldata->gl_doc_approve_by . "<br>";



            $body .= "<span style='font-size:20px;'><strong>ไฟล์เอกสาร :</strong></span>&nbsp;" . "<a href='" . base_url() . $rsgldata->gl_doc_file_location . $rsgldata->gl_doc_file . "'>" . $rsgldata->gl_doc_name . "</a><br>";









            $body .= "<strong>Link Program :</strong>&nbsp;" . "<a href='" . base_url('document/gl_view_doc/') . $rsgldata->gl_doc_code . "'>ตรวจสอบเอกสารได้ที่นี่</a>";

            $body .= "</html>\n";



            $mail = new PHPMailer();

            $mail->IsSMTP();

            $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้

            $mail->SMTPDebug = 1;                                      // set mailer to use SMTP

            $mail->Host = "mail.saleecolour.net";  // specify main and backup server

            //        $mail->Host = "smtp.gmail.com";

            $mail->Port = 25; // พอร์ท

            //        $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;     // turn on SMTP authentication

            $mail->Username = getEmailAccount()->email_user;  // SMTP username

            //websystem@saleecolour.com

            //        $mail->Username = "chainarong039@gmail.com";

            $mail->Password = getEmailAccount()->email_password; // SMTP password

            //Ae8686#

            //        $mail->Password = "ShctBkk1";



            $mail->From = "documentsystem@saleecolour.net";

            $mail->FromName = "Document System";



            foreach (get_email_sendtoMgr($rsgldata->gl_doc_deptcode)->result_array() as $gue) {

                $mail->AddAddress($gue['dc_user_memberemail']);

            }



            // $mail->AddAddress("chainarong_k@saleecolour.com");
            foreach(get_email_sendccDept($rsgldata->gl_doc_deptcode)->result_array() as $rss){
                $mail->AddCC($rss['dc_user_memberemail']);
            }

            foreach(get_email_sendtoDcc()->result_array() as $dccE){
                $mail->AddCC($dccE['dc_user_memberemail']);
            }

            $mail->AddCC("chainarong_k@saleecolour.com");





            $get_usercc_email = get_email_user("dc_user_data_user='$rsgldata->gl_doc_username' ");

            $gue_cc = $get_usercc_email->row();

            $mail->AddCC($gue_cc->dc_user_memberemail);







            // $mail->AddAddress("chainarong039@gmail.com");                  // name is optional

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters

            // $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments

            // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();

            //************************************ZONE***SEND****EMAIL*************************************//







        }

    }







    public function save_sec1_manual()

    {

        $get_darcode = $this->input->post("dc_data_darcode_manual");

        $get_doc_code = $this->input->post("dc_data_doccode_manual");

        $dc_data_sub_type = $this->input->post('dc_data_sub_type');

        $dc_data_edit = $this->input->post('dc_data_edit');



        if ($dc_data_edit < 10) {

            $rev = "-rev0";

        } else {

            $rev = "-rev";

        }



        if (isset($_POST['saveSec1_1'])) { //Check button submit

            if ($dc_data_sub_type == "sds") {

                $conDoccode = cut_doccode3($get_doc_code);

            } else if ($dc_data_sub_type == "l") {

                $conDoccode = cut_doccode2($get_doc_code);

            } else {

                $conDoccode = cut_doccode1($get_doc_code);

            }





            if ($this->input->post("dc_data_reson") == "r-02" || $this->input->post("dc_data_reson") == "r-04") {

                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $get_doc_code . $rev . $dc_data_edit . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            } else {

                $date = date("H-i-s"); //ดึงวันที่และเวลามาก่อน

                $file_name = $_FILES['dc_data_file']['name'];

                $file_name_cut = str_replace(" ", "", $file_name);

                $file_name_date = substr_replace(".", $get_doc_code . "-" . $date . ".pdf", 0);

                $file_size = $_FILES['dc_data_file']['size'];

                $file_tmp = $_FILES['dc_data_file']['tmp_name'];

                $file_type = $_FILES['dc_data_file']['type'];



                move_uploaded_file($file_tmp, "asset/document_files/" . $file_name_date);

                $filelocation = "asset/document_files/";





                print_r($file_name);

                echo "<br>" . "Copy/Upload Complete" . "<br>";

            }









            $armain = array(

                "dc_data_doccode" => $conDoccode,

                "dc_data_doccode_display" => $get_doc_code,

                "dc_data_darcode" => $get_darcode,

                "dc_data_sub_type" => $this->input->post("dc_data_sub_type"),

                "dc_data_sub_type_law" => $this->input->post("get_law"),

                "dc_data_sub_type_sds" => $this->input->post("get_sds"),

                "dc_data_date" => $this->input->post("dc_data_date"),

                "dc_data_user" => $this->input->post("dc_data_user"),

                "dc_data_dept" => $this->input->post("dc_data_dept"),

                "dc_data_docname" => $this->input->post("dc_data_docname"),

                "dc_data_edit" => $this->input->post("dc_data_edit"),

                "dc_data_date_start" => $this->input->post("dc_data_date_start"),

                "dc_data_store" => $this->input->post("dc_data_store"),

                "dc_data_store_type" => $this->input->post("dc_data_store_type"),

                "dc_data_reson" => $this->input->post("dc_data_reson"),

                "dc_data_reson_detail" => $this->input->post("dc_data_reson_detail"),

                "dc_data_file" => $file_name_date,

                "dc_data_file_location" => $filelocation,

                "dc_data_status" => "Open",

                "dc_data_formcode" => $this->input->post("formcode")

            );





            // Loop insert related department

            $related_dept_code = $this->input->post("related_dept_code");

            foreach ($related_dept_code as $related_dept_codes) {

                $arrelated = array(

                    "related_dept_doccode" => $conDoccode,

                    "related_dept_darcode" => $get_darcode,

                    "related_dept_code" => $related_dept_codes,

                    "related_dept_status" => "active"

                );

                $this->db->insert("dc_related_dept_use", $arrelated);

            }

            // Loop insert related department



            // Loop insert System Category

            $sys_cat = $this->input->post("dc_data_type");

            foreach ($sys_cat as $sys_cats) {

                $arsys_cat = array(

                    "dc_type_use_doccode" => $conDoccode,

                    "dc_type_use_darcode" => $get_darcode,

                    "dc_type_use_code" => $sys_cats,

                    "dc_type_use_status" => "active"

                );

                $this->db->insert("dc_type_use", $arsys_cat);

            }

            // Loop insert System Category





            $li_get_hashtag = $this->input->post("li_hashtag");

            foreach ($li_get_hashtag as $lgd) {

                $ar_li_hashtag = array(

                    "li_hashtag_doc_code" => $conDoccode,

                    "li_hashtag_name" => $lgd,

                    "li_hashtag_status" => "pending"

                );

                $this->db->insert("library_hashtag", $ar_li_hashtag);

            }

        } //Check button submit



        $result = $this->db->insert("dc_datamain", $armain);

        if (!$result) {

            echo "<script>";

            echo "alert('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')";

            echo "window.history.back(-1)";

            echo "</script>";

        } else {

            echo "บันทึกข้อมูลสำเร็จ";

            header("refresh:0; url=" . base_url('document/list_dar/'));

        }

    }






/////////////////////////////////////////////////////////////////////////////////
// Function แก้ไขระยะเวลาจัดเก็บ อัพเดตเพิ่มเติม อ้างอิง CSRO เลขที่ CSR6400060
/////////////////////////////////////////////////////////////////////////////////
public function saveEditDataStore()
{
    if($this->input->post("editDataStore_darcode") != ""){
        $arEditDataStore = array(
            "dc_data_store" => $this->input->post("edit_dataStore"),
            "dc_data_store_type" => $this->input->post("edit_dataStoreType"),
        );
        $this->db->where("dc_data_darcode" , $this->input->post("editDataStore_darcode"));
        if($this->db->update("dc_datamain" , $arEditDataStore)){
            $output = array(
                "msg" => "แก้ไขข้อมูลระยะเวลาการจัดเก็บเรียบร้อยแล้วค่ะ",
                "status" => "Update success"
            );
        }else{
            $output = array(
                "msg" => "แก้ไขข้อมูลไม่สำเร็จ",
                "status" => "Update Not success"
            );
        }
    }
    echo json_encode($output);
}










}/* End of file ModelName.php */

