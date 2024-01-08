<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Docemail_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
    }

    private function getdataforEmail($darcode)
    {
        if($darcode != ""){
            $sql = $this->db->query("SELECT
            dc_datamain.dc_data_id,
            dc_datamain.dc_data_darcode,
            dc_datamain.dc_data_sub_type,
            dc_sub_type.dc_sub_type_name,
            dc_datamain.dc_data_date,
            dc_datamain.dc_data_user,
            dc_datamain.dc_data_dept,
            dc_dept_main.dc_dept_main_code,
            dc_dept_main.dc_dept_main_name,
            dc_datamain.dc_data_docname,
            dc_datamain.dc_data_doccode_display,
            dc_datamain.dc_data_doccode,
            dc_datamain.dc_data_edit,
            dc_datamain.dc_data_date_start,
            dc_datamain.dc_data_store,
            dc_datamain.dc_data_store_type,
            dc_datamain.dc_data_reson,
            dc_reason_request.dc_reason_name,
            dc_datamain.dc_data_reson_detail,
            dc_datamain.dc_data_status,
            dc_datamain.dc_data_result_reson_status,
            dc_datamain.dc_data_result_reson_detail,
            dc_datamain.dc_data_date_approve_mgr,
            dc_datamain.dc_data_approve_mgr,
            dc_datamain.dc_data_result_reson_status2,
            dc_datamain.dc_data_result_reson_detail2,
            dc_datamain.dc_data_date_approve_qmr,
            dc_datamain.dc_data_approve_qmr,
            dc_datamain.dc_data_result_reson_status3,
            dc_datamain.dc_data_result_reson_detail3,
            dc_datamain.dc_data_date_approve_smr,
            dc_datamain.dc_data_approve_smr,
            dc_datamain.dc_data_method,
            dc_datamain.dc_data_operation,
            dc_datamain.dc_data_date_operation,
            dc_datamain.dc_data_formcode
            FROM
            dc_datamain
            INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type
            INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept
            INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson
            WHERE dc_datamain.dc_data_darcode = '$darcode'
            ");

            return $sql;
        }
    }

    private function getnametypeuse($darcode)
    {
        if($darcode != ""){
            $sql = $this->db->query("SELECT
            dc_type_use.dc_type_use_code,
            dc_type.dc_type_name,
            dc_type_use.dc_type_use_darcode
            FROM
            dc_type_use
            INNER JOIN dc_type ON dc_type.dc_type_code = dc_type_use.dc_type_use_code
            WHERE dc_type_use.dc_type_use_darcode = '$darcode'
            ");

            $nameType = "";
            foreach($sql->result() as $rs){
                if($nameType == ""){
                    $nameType.= $rs->dc_type_name;
                }else{
                    $nameType.= " , ".$rs->dc_type_name;
                }
            }

            return $nameType;
        }else{
            return null;
        }
    }

    private function getRelatedDeptuse($darcode)
    {
        if($darcode != ""){
            $sql = $this->db->query("SELECT
            dc_related_dept_use.related_dept_darcode,
            dc_related_dept_use.related_dept_code,
            dc_related_dept.related_dept_name
            FROM
            dc_related_dept_use
            INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
            WHERE dc_related_dept_use.related_dept_darcode = '$darcode'
            ");

            $output = "";
            foreach($sql->result() as $rs){
                if($output == ""){
                    $output .= $rs->related_dept_name;
                }else{
                    $output .=" , ".$rs->related_dept_name;
                }
            }

            return $output;
        }
    }

    public function getManagerEmailAddress($deptcode)
    {
        $this->db2 = $this->load->database('saleecolour', TRUE);
        if($deptcode !=""){
            $sql = $this->db2->query("SELECT
            memberemail
            FROM
            member 
            WHERE
            resigned != 1 
            AND deptcode = '$deptcode' 
            AND posi >= 75
            ");

            return $sql;
        }
    }

    private function getUserEmailAddress($dc_data_user)
    {
        if($dc_data_user != ""){
            $sql = $this->db->query("SELECT
            dc_user_memberemail
            FROM dc_user WHERE dc_user_data_user  = '$dc_data_user'
            ");
            return $sql;
        }
    }

    private function getQmrEmailAddress($qmrEcode)
    {
        if($qmrEcode  != ""){
            $this->db2 = $this->load->database('saleecolour', TRUE);
            $sql = $this->db2->query("SELECT
            memberemail
            FROM member WHERE ecode = '$qmrEcode' AND resigned = 0
            ");

            return $sql;
        }
    }

    public function sendto_manager($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR )";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR)</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        //  Email Zone get Manager Email
        $optionTo = $this->getManagerEmailAddress($emaildata->dc_dept_main_code);

        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['memberemail'];
        }


        $optioncc = $this->getUserEmailAddress($emaildata->dc_data_user);
        $cc = array();
        foreach ($optioncc->result_array() as $resultcc) {
            $cc[] = $resultcc['dc_user_memberemail'];
        }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendto_qmr($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR ) รอ QMR อนุมัติ";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $resultManagerApproveStatus = "";
        if($emaildata->dc_data_result_reson_status == "0"){
            $resultManagerApproveStatus = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status == "1"){
            $resultManagerApproveStatus = "อนุมัติ";
        }

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR) รอ QMR อนุมัติ</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากผู้จัดการแผนก</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_mgr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_mgr).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";


        $optionTo = $this->docemail_model->getQmrEmailAddress("M1830");
        //M1830 = Sukanya Boonsak

        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['memberemail'];
        }


        $optioncc = $this->getUserEmailAddress($emaildata->dc_data_user);
        $cc = array();
        foreach ($optioncc->result_array() as $resultcc) {
            $cc[] = $resultcc['dc_user_memberemail'];
        }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendBackToUser_ManagerNotApprove($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR ) ผู้จัดการแผนกไม่อนุมัติ";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $resultManagerApproveStatus = "";
        if($emaildata->dc_data_result_reson_status == "0"){
            $resultManagerApproveStatus = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status == "1"){
            $resultManagerApproveStatus = "อนุมัติ";
        }

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR) ผู้จัดการแผนกไม่อนุมัติ</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากผู้จัดการแผนก</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_mgr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_mgr).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        //  Email Zone get Manager Email
        // $optionTo = $this->getManagerEmailAddress($emaildata->dc_dept_main_code);

        // $to = array();
        // foreach ($optionTo->result_array() as $result) {
        //     $to[] = $result['memberemail'];
        // }


        $optionTo = $this->getUserEmailAddress($emaildata->dc_data_user);
        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['dc_user_memberemail'];
        }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendto_Dcc($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR ) รอ DCC แจกจ่าย";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $resultManagerApproveStatus = "";
        if($emaildata->dc_data_result_reson_status == "0"){
            $resultManagerApproveStatus = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status == "1"){
            $resultManagerApproveStatus = "อนุมัติ";
        }

        $resultManagerApproveStatus2 = "";
        if($emaildata->dc_data_result_reson_status2 == "0"){
            $resultManagerApproveStatus2 = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status2 == "1"){
            $resultManagerApproveStatus2 = "อนุมัติ";
        }

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR) รอ DCC แจกจ่าย</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากผู้จัดการแผนก</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_mgr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_mgr).'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจาก QMR</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus2.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail2.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_qmr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_qmr).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        $optionTo = $this->docemail_model->getQmrEmailAddress("M1447");
        //M1447 = Pattamaporn Mudkrathok

        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['memberemail'];
        }


        $optioncc = $this->getUserEmailAddress($emaildata->dc_data_user);
        $cc = array();
        foreach ($optioncc->result_array() as $resultcc) {
            $cc[] = $resultcc['dc_user_memberemail'];
        }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendBackToUser_QmrNotApprove($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR ) QMR ไม่อนุมัติ";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $resultManagerApproveStatus = "";
        if($emaildata->dc_data_result_reson_status == "0"){
            $resultManagerApproveStatus = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status == "1"){
            $resultManagerApproveStatus = "อนุมัติ";
        }

        $resultManagerApproveStatus2 = "";
        if($emaildata->dc_data_result_reson_status2 == "0"){
            $resultManagerApproveStatus2 = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status2 == "1"){
            $resultManagerApproveStatus2 = "อนุมัติ";
        }

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR) QMR ไม่อนุมัติ</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากผู้จัดการแผนก</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_mgr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_mgr).'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจาก QMR</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus2.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail2.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_qmr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_qmr).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        $optionTo = $this->getUserEmailAddress($emaildata->dc_data_user);
        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['dc_user_memberemail'];
        }


        // $optioncc = getEmail_onMemberTbl("('$emaildata->wdf_ecode')");
        // $cc = array();
        // foreach ($optioncc->result_array() as $resultcc) {
        //     $cc[] = $resultcc['memberemail'];
        // }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendto_RelatedUser($darcode)
    {
        $subject = "New ใบคำร้องเกี่ยวกับเอกสาร ( DAR ) รอ DCC แจกจ่าย";

        $emaildata = $this->getdataforEmail($darcode)->row();
        $nameTypeuse = $this->getnametypeuse($darcode);
        $relatedDeptUse = $this->getRelatedDeptuse($darcode);

        $resultManagerApproveStatus = "";
        if($emaildata->dc_data_result_reson_status == "0"){
            $resultManagerApproveStatus = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status == "1"){
            $resultManagerApproveStatus = "อนุมัติ";
        }

        $resultManagerApproveStatus2 = "";
        if($emaildata->dc_data_result_reson_status2 == "0"){
            $resultManagerApproveStatus2 = "ไม่อนุมัติ";
        }else if($emaildata->dc_data_result_reson_status2 == "1"){
            $resultManagerApproveStatus2 = "อนุมัติ";
        }

        $body = '
            <h2>พบใบคำร้องเกี่ยวกับเอกสารใหม่ (DAR) รอ DCC แจกจ่าย</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dc_data_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>'.$nameTypeuse.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dc_sub_type_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dc_data_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dc_data_edit.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dc_data_date_start).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dc_data_store.' '.$emaildata->dc_data_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">'.$relatedDeptUse.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dc_data_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dc_data_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากผู้จัดการแผนก</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_mgr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_mgr).'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจาก QMR</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$resultManagerApproveStatus2.'</td>
                <td class="bghead"><strong>เหตุผล</strong></td>
                <td>'.$emaildata->dc_data_result_reson_detail2.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้ดำเนินการ</strong></td>
                <td>'.$emaildata->dc_data_approve_qmr.'</td>
                <td class="bghead"><strong>วันที่</strong></td>
                <td>'.con_date($emaildata->dc_data_date_approve_qmr).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('document/viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        //  Email Zone get Manager Email
        // $optionTo = $this->getManagerEmailAddress($emaildata->dc_dept_main_code);

        // $to = array();
        // foreach ($optionTo->result_array() as $result) {
        //     $to[] = $result['memberemail'];
        // }


        // $optioncc = getEmail_onMemberTbl("('$emaildata->wdf_ecode')");
        // $cc = array();
        // foreach ($optioncc->result_array() as $resultcc) {
        //     $cc[] = $resultcc['memberemail'];
        // }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }
    
    

}

/* End of file ModelName.php */





?>