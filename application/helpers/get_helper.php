<?php
class getfn{
    public $ci;

    function __construct()
    {
        $this->ci=& get_instance();
    }

    public function gci()
    {
        return $this->ci;
    }
}

function gfn()
{
    $obj = new getfn();
    return $obj->gci();
}


function conDateFromDb($datetime)
{
    if($datetime != ""){
        $datetimeIn = date_create($datetime);
        return date_format($datetimeIn,"d/m/Y");
    }else{
        return $datetime;
    }
    
}

function getDarFormno()
{
    // check formno ซ้ำในระบบ
    $checkRowdata = gfn()->db->query("SELECT
    dc_data_darcode FROM dc_datamain ORDER BY dc_data_id DESC LIMIT 1 
    ");
    $result = $checkRowdata->num_rows();

    $cutYear = substr(date("Y"), 2, 2);
    $getMonth = substr(date("m"), 0, 2);
    $formno = "";
    if ($result == 0) {
        $formno = "DAR" . $cutYear.$getMonth. "001";
    } else {

        $getFormno = $checkRowdata->row()->dc_data_darcode;
        $cutGetYear = substr($getFormno, 3, 2); //KB2003001
        $cutNo = substr($getFormno, 7, 3); //อันนี้ตัดเอามาแค่ตัวเลขจาก CRF2003001 ตัดเหลือ 001
        $cutNo++;

        if ($cutNo < 10) {
            $cutNo = "00" . $cutNo;
        } else if ($cutNo < 100) {
            $cutNo = "0" . $cutNo;
        }

        if ($cutGetYear != $cutYear) {
            $formno = "DAR" . $cutYear.$getMonth."001";
        } else {
            $formno = "DAR" . $cutGetYear.$getMonth. $cutNo;
        }
    }

    return $formno;
}

function getReqDocFormno()
{
        // check formno ซ้ำในระบบ
        $checkRowdata = gfn()->db->query("SELECT
        dct_darcode FROM dct_datamain ORDER BY dct_id DESC LIMIT 1
        ");
        $result = $checkRowdata->num_rows();
    
        $cutYear = substr(date("Y"), 2, 2);
        $getMonth = substr(date("m"), 0, 2);
        $formno = "";
        if ($result == 0) {
            $formno = "DOC" . $cutYear.$getMonth. "001";
        } else {
    
            $getFormno = $checkRowdata->row()->dct_darcode;
            $cutGetYear = substr($getFormno, 3, 2); //KB2003001
            $cutNo = substr($getFormno, 7, 3); //อันนี้ตัดเอามาแค่ตัวเลขจาก CRF2003001 ตัดเหลือ 001
            $cutNo++;
    
            if ($cutNo < 10) {
                $cutNo = "00" . $cutNo;
            } else if ($cutNo < 100) {
                $cutNo = "0" . $cutNo;
            }
    
            if ($cutGetYear != $cutYear) {
                $formno = "DOC" . $cutYear.$getMonth."001";
            } else {
                $formno = "DOC" . $cutGetYear.$getMonth. $cutNo;
            }
        }
    
        return $formno;
}


function getUserN($ecode)
{
    $sql = gfn()->db->query("SELECT
    dc_user.dc_user_new_dept_code,
    dc_user.dc_user_ecode,
    dc_user.dc_user_Fname,
    dc_user.dc_user_Lname
    FROM
    dc_user
    WHERE dc_user_ecode = '$ecode' ");
    return $sql->row();
}


function duration($start, $end)
{
    if($start != "" && $end != ""){
        $woweekends = 0;
        if($start === $end){
            $woweekends = 1;
        }else{
            $datetime1 = new DateTime($start);
            $datetime2 = new DateTime($end);
            $interval = $datetime1->diff($datetime2);
            $woweekends = 0;
            for ($i = 0; $i <= $interval->d; $i++) {
                $datetime1->modify('+1 day');
                $weekday = $datetime1->format('w');
        
                if ($weekday !== "0" && $weekday !== "6") { // 0 for Sunday and 6 for Saturday
                    $woweekends++;
                }
            }
        }

        return $woweekends." วันทำการ";
    }
}

function durationNew($startDateInput , $endDateInput)
{
    if($startDateInput != "" && $endDateInput != ""){
        $startDate = new DateTime($startDateInput);

        // วันที่สิ้นสุด
        $endDate = new DateTime($endDateInput);
    
        // หาจำนวนวันทั้งหมด
        $interval = $startDate->diff($endDate);
        $totalDays = $interval->days + 1; // ต้องบวก 1 เพื่อรวมวันที่เริ่มต้นด้วย
    
        // หาจำนวนวันเสาร์และอาทิตย์
        $weekendDays = 0;
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            if ($currentDate->format('N') >= 6) {
                $weekendDays++;
            }
            $currentDate->add(new DateInterval('P1D'));
        }
    
        // หาจำนวนวันที่ไม่ใช่วันเสาร์และอาทิตย์
        $workDays = $totalDays - $weekendDays;
    
        return $workDays." วันทำการ";
    }

}

function getDateForCalcDuration($dc_data_id)
{
    if($dc_data_id != ""){
        $sql = gfn()->db->query("SELECT
        dc_data_date,
        dc_data_date_operation
        FROM dar_list_new WHERE dc_data_id = '$dc_data_id'
        ");
        return $sql;
    }
}

function getDateForCalcDurationDocCtrl($dct_id)
{
    if($dct_id != ""){
        $sql = gfn()->db->query("SELECT
        dct_date,
        dct_datetimeapprove
        FROM docCtrl_list WHERE dct_id = '$dct_id'
        ");
        return $sql;
    }
}


function getDataFromDarcode($darcode)
{
    if($darcode != ""){
        $sql = gfn()->db->query("SELECT
        dc_data_status
        FROM dc_datamain WHERE dc_data_darcode = '$darcode'
        ");
        return $sql;
    }
}

function getDataFromDocctrlcode($docctrl)
{
    if($docctrl != ""){
        $sql = gfn()->db->query("SELECT
        dct_status
        FROM dct_datamain WHERE dct_darcode = '$docctrl'
        ");
        return $sql;
    }
}


function getDataStoreEdit()
{
    $sql = gfn()->db->query("SELECT dc_datastore_name FROM dc_datastore_cat ORDER BY dc_datastore_id ASC");
    $output = '<select name="edit_dataStore" id="edit_dataStore" class="form-control">';
    foreach($sql->result() as $rs){
        $output .='
            <option value="'.$rs->dc_datastore_name.'">'.$rs->dc_datastore_name.'</option>
        ';
    }
    $output .='</select>';
    echo $output;
}



function dccSendEmail_new()
{
    $body = '
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

    <span>แจ้งขึ้นทะเบียนเอกสารใหม่</span>';
    $body .= '
        <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
        <span style="padding-left:50px;">ขอแจ้งขึ้นทะเบียนเอกสารใหม่ รายละเอียดดังต่อไปนี้</span><br>
    ';
    $body .='
    <table style="margin-top:20px;">
        <tr>
            <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>ระบบที่เกี่ยวข้อง</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>..........</td>
        </tr>
    </table>
        <div style="margin-top:30px;">
            <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="#">ตรวจสอบเอกสาร</a></span>
        </div>
    ';

    echo $body;
}




function dccSendEmail_change()
{
    $body = '
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

    <span>แจ้งเปลี่ยนแปลงเอกสาร</span>';
    $body .= '
        <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
        <span style="padding-left:50px;">ขอแจ้งเปลี่ยนแปลงเอกสาร (ชื่อเอกสาร) รายละเอียดดังต่อไปนี้</span><br>
    ';
    $body .='
    <table style="margin-top:20px;">
        <tr>
            <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>ครั้งที่แก้ไข</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>..........</td>
        </tr>
    </table>
        <div style="margin-top:30px;">
            <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="#">ตรวจสอบเอกสาร</a></span>
        </div>
    ';

    echo $body;
}



function dccSendEmail_edit()
{
    $body = '
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

    <span>แจ้งแก้ไขเอกสาร</span>';
    $body .= '
        <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
        <span style="padding-left:50px;">ขอแจ้งแก้ไขเอกสาร (ชื่อเอกสาร) รายละเอียดดังต่อไปนี้</span><br>
    ';
    $body .='
    <table style="margin-top:20px;">
        <tr>
            <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>ครั้งที่แก้ไข</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>..........</td>
        </tr>
    </table>
        <div style="margin-top:30px;">
            <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="#">ตรวจสอบเอกสาร</a></span>
        </div>
    ';

    echo $body;
}





function dccSendEmail_cancel()
{
    $body = '
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

    <span>แจ้งยกเลิกเอกสาร</span>';
    $body .= '
        <h3>เรียน ทุกท่านที่เกี่ยวข้อง</h3>
        <span style="padding-left:50px;">ขอแจ้งยกเลิกเอกสาร (ชื่อเอกสาร) รายละเอียดดังต่อไปนี้</span><br>
    ';
    $body .='
    <table style="margin-top:20px;">
        <tr>
            <td style="width:200px;"><b>ชื่อเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>เอกสารของแผนก</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>ประเภทของเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>ระบบที่เกี่ยวข้อง</b></td><td>..........</td>
        </tr>

        <tr>
            <td style="width:200px;"><b>รหัสเอกสาร</b></td><td>..........</td>
            <td style="width:200px;"><b>วันที่เริ่มใช้</b></td><td>..........</td>
        </tr>
        <tr>
            <td style="width:200px;color:red;" colspan="2"><b>วันที่ยกเลิกเอกสาร</b></td><td colspan="2" style="color:red;">..........</td>
        </tr>
    </table>
        <div style="margin-top:30px;">
            <span>ท่านสามารถตรวจสอบเอกสารดังกล่าวได้ที่นี่ > <a href="#">ตรวจสอบเอกสาร</a></span>
        </div>
    ';

    echo $body;
}





function getDeptCodeFromRelated($darcode)
{
    $userdb = gfn()->load->database('saleecolour', TRUE);


    $sql = gfn()->db->query("SELECT
    dc_related_dept_use.related_dept_darcode,
    dc_related_dept_use.related_dept_doccode,
    dc_related_dept.related_dept_code,
    dc_related_dept.related_code,
    dc_related_dept.related_dept_name
    FROM
    dc_related_dept_use
    INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
    WHERE related_dept_darcode = '$darcode'
    ");

    foreach($sql->result() as $rs){
        switch ($rs->related_code){
            case "re01":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re02":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re03":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re04":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re05":
                $rsemail[] = "it@saleecolour.com";
                break;

            case "re06":
                $rsemail[] = "account@saleecolour.com";
                break;

            case "re07":
                $rsemail[] = "purchase@saleecolour.com";
                break;

            case "re08":
                $rsemail[] = "purchase@saleecolour.com";
                break;

            case "re09":
                $rsemail[] = "hr@saleecolour.com";
                break;

            case "re10":
                $rsemail[] = "salesrep@saleecolour.com";
                break;

            case "re11":
                $rsemail[] = "production@saleecolour.com";
                break;

            case "re12":
                $rsemail[] = "engineer@saleecolour.com";
                break;

            case "re13":
                $rsemail[] = "planning@saleecolour.com";
                break;

            case "re14":
                $rsemail[] = "sales@saleecolour.com";
                break;

            case "re15":
                $rsemail[] = "warehouse@saleecolour.com";
                break;

            case "re16":
                $rsemail[] = "lab@saleecolour.com";
                break;

            case "re17":
                $rsemail[] = "sd@saleecolour.com";
                break;                
        }
        
    }

    return $rsemail;


}



function getDeptCodeFromRelated2($darcode)
{
    $userdb = gfn()->load->database('saleecolour', TRUE);


    $sql = gfn()->db->query("SELECT
    dc_related_dept_use.related_dept_darcode,
    dc_related_dept_use.related_dept_doccode,
    dc_related_dept.related_dept_code,
    dc_related_dept.related_code,
    dc_related_dept.related_dept_name
    FROM
    dc_related_dept_use
    INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
    WHERE related_dept_darcode = '$darcode'
    ");

    foreach($sql->result() as $rs){
        
        switch ($rs->related_code){
            case "re01":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re02":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re03":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re04":
                $rsemail[] = "sd@saleecolour.com";
                break;

            case "re05":
                $rsemail[] = "it@saleecolour.com";
                break;

            case "re06":
                $rsemail[] = "account@saleecolour.com";
                break;

            case "re07":
                $rsemail[] = "purchase@saleecolour.com";
                break;

            case "re08":
                $rsemail[] = "purchase@saleecolour.com";
                break;

            case "re09":
                $rsemail[] = "hr@saleecolour.com";
                break;

            case "re10":
                $rsemail[] = "salesrep@saleecolour.com";
                break;

            case "re11":
                $rsemail[] = "production@saleecolour.com";
                break;

            case "re12":
                $rsemail[] = "engineer@saleecolour.com";
                break;

            case "re13":
                $rsemail[] = "planning@saleecolour.com";
                break;

            case "re14":
                $rsemail[] = "sales@saleecolour.com";
                break;

            case "re15":
                $rsemail[] = "warehouse@saleecolour.com";
                break;

            case "re16":
                $rsemail[] = "lab@saleecolour.com";
                break;

            case "re17":
                $rsemail[] = "sd@saleecolour.com";
                break;                
        }
        
    }

    return $rsemail;


}


function checkDctSubtype($darcode)
{
    if($darcode != ""){
        $sql = gfn()->db->query("SELECT
        dct_subtype
        FROM dct_datamain WHERE dct_darcode = '$darcode'
        ");

        return $sql;
    }
}


// function user($deptcode)
// {
//     $userdb = gfn()->load->database('saleecolour', TRUE);
//     $sql = $userdb->query("SELECT * FROM member WHERE DeptCode = '$deptcode' ");
//     foreach($sql->result() as $rs){
//         $rsemail[] = $rs->Fname;
//     }
//     return $rsemail;
// }

function getDatabase()
{
    if($_SERVER['HTTP_HOST'] != "localhost"){
        $whereAutoid = "WHERE db_autoid = '3' ";
    }else{
        $whereAutoid = "WHERE db_autoid = '2' ";
    }

    $sql = gfn()->db->query("SELECT
    db_autoid,
    db_username,
    db_password,
    db_databasename,
    db_host
    FROM db $whereAutoid
    ");

    return $sql->row();
}


function getdatalinkIsodoc($doccode)
{
    if($doccode != ""){
        $sql = gfn()->db->query("SELECT
        dc_data_dept,
        dc_data_sub_type
        FROM docIso_list WHERE dc_data_doccode = '$doccode'
        ");

        return $sql;
    }
}




?>