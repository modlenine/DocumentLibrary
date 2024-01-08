<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrldocemail_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
    }

    private function getdataForemail($darcode)
    {
        if($darcode != ""){
            $sql = $this->db->query("SELECT
            dct_datamain.dct_darcode,
            dct_datamain.dct_id,
            dct_subtype.dct_subtype_name,
            dct_datamain.dct_docname,
            dct_datamain.dct_doccode,
            dct_datamain.dct_editcount,
            dct_datamain.dct_datestart,
            dct_datamain.dct_store,
            dct_datamain.dct_store_type,
            dct_reason_request.dc_reason_name,
            dct_datamain.dct_reson_detail,
            dct_datamain.dct_date,
            dct_datamain.dct_user,
            dct_datamain.dct_result_reson_status,
            dct_datamain.dct_result_reson_detail,
            dct_datamain.dct_userapprove,
            dct_datamain.dct_datetimeapprove
            FROM
            dct_datamain
            INNER JOIN dct_subtype ON dct_subtype.dct_subtype_code = dct_datamain.dct_subtype
            INNER JOIN dct_reason_request ON dct_reason_request.dc_reason_code = dct_datamain.dct_reson            
            WHERE dct_darcode = '$darcode'
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
        $this->db2 = $this->load->database('saleecolour', TRUE);
        if($qmrEcode  != ""){
            $sql = $this->db2->query("SELECT
            memberemail
            FROM member WHERE ecode = '$qmrEcode' AND resigned = 0
            ");

            return $sql;
        }
    }

    public function test()
    {
        $optionTo = $this->getQmrEmailAddress("M1447");
        $output = array(
            "test" => $optionTo->result_array()
        );
        echo json_encode($output);
    }
    

    public function sendemailToDcc($darcode)
    {

        $emaildata = $this->getdataForemail($darcode)->row();

        $subject = "New ใบคำร้องเอกสารควบคุม";
        $body = '
            <h2>พบใบคำร้องเอกสารควบคุม</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dct_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>Control Document</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dct_subtype_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dct_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dct_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dct_editcount.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dct_datestart).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dct_store.' '.$emaildata->dct_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dct_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">All</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dct_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dct_user.'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('ctrldoc/ctrldoc_viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";


        $optionTo = $this->getQmrEmailAddress("M1447");
        //M1447 = Pattamaporn Mudkrathok

        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['memberemail'];
        }


        $optioncc = $this->getUserEmailAddress($emaildata->dct_user);
        $cc = array();
        foreach ($optioncc->result_array() as $resultcc) {
            $cc[] = $resultcc['dc_user_memberemail'];
        }

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }

    public function sendemailBackToUser($darcode)
    {
        $emaildata = $this->getdataForemail($darcode)->row();

        $subject = "ผลการอนุมัติ ใบคำร้องเอกสารควบคุม";
        $body = '
            <h2>ผลการอนุมัติ ใบคำร้องเอกสารควบคุม</h2>
            <table>
            <tr>
                <td class="bghead"><strong>เลขที่คำขอ</strong></td>
                <td>'.$emaildata->dct_darcode.'</td>
                <td class="bghead"><strong>ระบบที่เกี่ยวข้อง</strong></td>
                <td>Control Document</td>
            </tr>


            <tr>
                <td class="bghead"><strong>ประเภทเอกสาร</strong></td>
                <td>'.$emaildata->dct_subtype_name.'</td>
                <td class="bghead"><strong>ชื่อเอกสาร</strong></td>
                <td>'.$emaildata->dct_docname.'</td>
            </tr>


            <tr>
                <td class="bghead"><strong>รหัสเอกสาร</strong></td>
                <td>'.$emaildata->dct_doccode.'</td>
                <td class="bghead"><strong>ครั้งที่แก้ไข</strong></td>
                <td>'.$emaildata->dct_editcount.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่เริ่มใช้</strong></td>
                <td>'.con_date($emaildata->dct_datestart).'</td>
                <td class="bghead"><strong>ระยะเวลาในการจัดเก็บ</strong></td>
                <td>'.$emaildata->dct_store.' '.$emaildata->dct_store_type.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>เหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dc_reason_name.'</td>
                <td class="bghead"><strong>รายละเอียดเหตุผลในการร้องขอ</strong></td>
                <td>'.$emaildata->dct_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>หน่วยงานที่เกี่ยวข้อง</strong></td>
                <td colspan="3">All</td>
            </tr>

            <tr>
                <td class="bghead"><strong>วันที่ร้องขอ</strong></td>
                <td>'.con_date($emaildata->dct_date).'</td>
                <td class="bghead"><strong>ผู้ร้องขอ</strong></td>
                <td>'.$emaildata->dct_user.'</td>
            </tr>

            <tr>
                <td colspan="4" class="bghead"><strong>ผลการอนุมัติจากเจ้าหน้าที่</strong></td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผลการอนุมัติ</strong></td>
                <td>'.$emaildata->dct_result_reson_status.'</td>
                <td class="bghead"><strong>เหตุผลในการอนุมัติ</strong></td>
                <td>'.$emaildata->dct_result_reson_detail.'</td>
            </tr>

            <tr>
                <td class="bghead"><strong>ผู้อนุมัติ</strong></td>
                <td>'.$emaildata->dct_userapprove.'</td>
                <td class="bghead"><strong>วันที่อนุมัติ</strong></td>
                <td>'.con_date($emaildata->dct_datetimeapprove).'</td>
            </tr>

            <tr>
                <td><strong>ตรวจสอบรายการ</strong></td>
                <td colspan="3"><a href="' . base_url('ctrldoc/ctrldoc_viewfull/').$darcode. '">'.$darcode.'</a></td>
            </tr>

            </table>
            ';

        $to = "";
        $cc = "";

        $optionTo = $this->getUserEmailAddress($emaildata->dct_user);
        $to = array();
        foreach ($optionTo->result_array() as $result) {
            $to[] = $result['dc_user_memberemail'];
        }


        // $optioncc = getEmail_onMemberTbl("('$emaildata->wdf_ecode')");
        // $cc = array();
        // foreach ($optioncc->result_array() as $resultcc) {
        //     $cc[] = $resultcc['memberemail'];
        // }
        $cc = array("all_saleecolour@saleecolour.net");

        send_email($subject, $body, $to, $cc);
        //  Email Zone
    }
    

}
/* End of file ModelName.php */
?>