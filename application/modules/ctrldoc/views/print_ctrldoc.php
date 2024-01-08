<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หน้าปริ้นแบบฟอร์มเอกสารควบคุม</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    $getuser = $this->login_model->getuser();
    $getfulldata = $get_fulldata->row();
    $getHashtag = $this->ctrldoc_model->getDctHashtag($getfulldata->dct_doccode);

	$getchecktype = get_check_type($darcode);
	$getfulldatas = getFullData($darcode)->row();
	// create new PDF document

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('IT Dept');
    $pdf->SetTitle('Document Library');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    // $pdf->SetHeaderData('Document Library');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(10, 5, 10, true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)

    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------
    // set font
    $pdf->SetFont('thsarabun', '', 10);

    // Print a table
    // add a page
    $pdf->AddPage();

    // create some HTML content

$html = '
<table style="border:1px solid #111111;">
    <tr>
        <th></th>
        <th style="font-size:18px;text-align:center;">ใบคำร้องเกี่ยวกับเอกสาร</th>
        <th style="text-align:right;">'.$getfulldata->dct_formcode.'</th>
    </tr>
</table><br>
<div></div>
<table>
    <tr style="font-size:16px;">
        <td>';
        $html .= '<input checked="checked" type="checkbox" name="print_dcttype" id="print_dcttype" value="01" readonly="true">Control Document';
        $html .='
        </td>
        <td></td>
        <td>
        <b>DAR No.</b>&nbsp;'.$darcode.'
        </td>
    </tr>
</table>
<div></div>
<table>
    <tr>
        <th colspan="4" style="text-align:center;font-size:20px;border:1px solid #111111;"><b>Document Type and Description</b></th>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="2" style="font-size:16px;">';
        foreach ($get_doc_sub_type->result_array() as $doc_sub_type){

            $resultCheckDctSub = checkDctSubtype($darcode)->row();
            $checkDctSubtype = "";
            if($resultCheckDctSub->dct_subtype == $doc_sub_type['dct_subtype_code']){
                $checkDctSubtype = 'checked="checked"';
            }
            $subtypeCode = $doc_sub_type['dct_subtype_code'];
            $subtypeName = $doc_sub_type['dct_subtype_name'];
            $html .='
            <label class="checkbox-inline col-sm-12 p-2">
            <input '.$checkDctSubtype.' required type="radio" name="datasubtype-ctrl2" id="datasubtype-ctrl2" value="'.$subtypeCode.'" readonly="true">&nbsp;'.$subtypeName.'</label><br>';
        }
        $html .='
        </td>';

        $html .='
        <td style="font-size:15px;">
            &nbsp;<b>วันที่ร้องขอ :</b>&nbsp;&nbsp;'.con_date($getfulldata->dct_date).'<br>
            &nbsp;<b>แผนก :</b>&nbsp;&nbsp;'.getDeptcodeName($getfulldata->dct_dept).'<br>
            &nbsp;<b>ชื่อเอกสาร :</b>&nbsp;&nbsp;'.$getfulldata->dct_docname.'<br>
            &nbsp;<b>รหัสเอกสาร :</b>&nbsp;'.$getfulldata->dct_doccode.'<br>
            &nbsp;<b>วันที่เริ่มใช้ :</b>&nbsp;&nbsp;'.con_date($getfulldata->dct_datestart).'
        </td>

        <td style="font-size:15px;">
            &nbsp;&nbsp;<b>ผู้ร้องขอ :</b>&nbsp;&nbsp;'.$getfulldata->dct_user.'<br>
            &nbsp;&nbsp;<b>ครั้งที่แก้ไข :</b>&nbsp;&nbsp;'.$getfulldata->dct_editcount.'<br>
            &nbsp;&nbsp;<b>ระยะเวลาจัดเก็บ :</b>&nbsp;&nbsp;'.$getfulldata->dct_store." ".$getfulldata->dct_store_type.'
        </td>
    </tr>

    <tr>
        <td colspan="2" style="font-size:18px;"><b><u>เหตุผลในการร้องขอ</u></b></td>
    </tr>';

    $html .='
    <tr>
        <td style="font-size:16px;" colspan="3">';
        foreach ($get_reason->result_array() as $rs_reason){
            if ($rs_reason['dc_reason_code'] == $getfulldata->dct_reson) {
                $checked = ' checked="checked" ';
            } else {
                $checked = '';
            }

            $resoncode = $rs_reason['dc_reason_code'];
            $resonname = $rs_reason['dc_reason_name'];

            $html .='
            <label class="checkbox-inline"><input '.$checked.' type="radio" name="dataReason-ctrl" id="dataReason-ctrl" value="'.$resoncode.'" readonly="true" />&nbsp;'.$resonname.'</label>
            ';
        }
    $html .=' 
        </td>
    </tr>

    <tr>
        <td colspan="2" style="font-size:16px;"><b><u>รายละเอียด</u></b>&nbsp;&nbsp;&nbsp;'.$getfulldata->dct_reson_detail.'</td>
    </tr><br>

    <tr>
        <td colspan="4" style="text-align:center;color:red;border:1px solid #111111;">กรุณาให้เหตุผลในการร้องขอทุกครั้ง เพื่อบันทึกเป็นหลักฐานในประวัติการแก้ไข</td>
    </tr>
</table>


<table>
<div></div>
    <tr>
        <td colspan="3" style="font-size:18px;"><b><u>หน่วยงานที่เกี่ยวข้อง</u></b></td>
    </tr>';

    $i=1;
    $tr = '
    <tr>';
    $trs = '';
    foreach ($get_related_dept->result_array() as $rs_related_dept){
        $relatedcode = $rs_related_dept['related_code'];
        $relatedDeptname = $rs_related_dept['related_dept_name'];
    $html .=$tr;
        $html .='
        <td style="font-size:16px;">
            <label class="checkbox-inline">
                <input checked="checked" class="related_dept" type="checkbox" name="relatedDeptcode-ctrl[]" id="relatedDeptcode-ctrl" value="'.$relatedcode.'" readonly="true"/>&nbsp;'.$relatedDeptname.'
            </label>
        </td>';

    if($i == 3 || $i == 6 || $i == 9 || $i == 12 || $i == 15 || $i == 17){

        $trs = '
        </tr>';

        $tr = '
        <tr>';
    }else {

        $tr = '';
        $trs = '';  
    }

    $html .=$trs;
    $i++;
}

$html .='
</table>
<div></div>
<div style="text-align:center;color:red;border:1px solid #111111;">กรุณาเลือกติ๊กถูกให้ครบถ้วน เพื่อเจ้าหน้าที่จะได้ดำเนินการได้อย่างทั่วถึง</div>
';

$resonstatus0 = "";
$resonstatus1 = "";

if($getfulldata->dct_result_reson_status == "อนุมัติ"){
    $resonstatus1 = 'checked="checked"';
}else if($getfulldata->dct_result_reson_status == "ไม่อนุมัติ"){
    $resonstatus0 = 'checked="checked"';
}


$html .='
<table style="border-bottom:1px solid #111111;">
    <tr><br>
        <td colspan="2" style="font-size:18px;"><b><u>ผลการอนุมัติจากเจ้าหน้าที่</u></b></td>
        <td style="font-size:16px;"><input readonly="true" type="radio" name="print_dcc1" value="1" '.$resonstatus1.'/>&nbsp;อนุมัติ</td>
        <td style="font-size:16px;"><input readonly="true" type="radio" name="print_dcc0" value="0" '.$resonstatus0.'/>&nbsp;ไม่อนุมัติ</td>
    </tr>
    <tr>
        <td colspan="4" style="font-size:16px;"><b>เนื่องจาก :</b><br>'.$getfulldata->dct_result_reson_detail.'<br></td>
    </tr>
    <tr>
        <td style="font-size:16px;"><b>ผู้อนุมัติ :</b>&nbsp;&nbsp;'.$getfulldata->dct_userapprove.'<br></td>
    </tr>
</table>
';



// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// Print all HTML colors

ob_end_clean();
$filename = $getfulldata->dct_darcode.'.pdf';
//Close and output PDF document
$pdf->Output($filename, 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
</body>
</html>