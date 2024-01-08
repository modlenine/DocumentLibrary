<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>



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

<th style="font-size:18px;text-align:center;">ใบคำร้องเกี่ยวกับเอกสาร<br>Document Action Request (DAR.)</th>

<th style="text-align:right;">'.$getfulldatas->dc_data_formcode.'</th>

</tr>

</table><br>

<div style="font-size:16px;">';



foreach(get_iso_type()->result_array() as $gettype){

	$checked = '';

	foreach($getchecktype->result_array() as $gct){

		if ($gettype['dc_type_code'] == $gct['dc_type_use_code']) {

			$checked = ' checked="checked" ';

			continue;

		}

	}



$html .= '<input readonly="true" type="checkbox" name="dctype[]" value="'.$gettype['dc_type_code'].'" '.$checked.'>'.$gettype['dc_type_name'].'&nbsp;&nbsp;&nbsp;';



}



$html .='

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DAR No.</b>&nbsp;'.$darcode.'

</div><br>

<table>

<tr>

<th colspan="4" style="text-align:center;font-size:20px;border:1px solid #111111;"><b>Document Type and Description</b></th>

</tr>

<tr>

<td style="font-size:16px;">';



if($getfulldatas->dc_data_sub_type == "m")

{

	$m_check = ' checked="checked" ';

}else{

	$m_check = '';

}



if($getfulldatas->dc_data_sub_type == "f")

{

	$f_check = ' checked="checked" ';

}else{

	$f_check = '';

}



if($getfulldatas->dc_data_sub_type == "p")

{

	$p_check = ' checked="checked" ';

}else{

	$p_check = '';

}



if($getfulldatas->dc_data_sub_type == "s")

{

	$s_check = ' checked="checked" ';

}else{

	$s_check = '';

}



if($getfulldatas->dc_data_sub_type == "w")

{

	$w_check = ' checked="checked" ';

}else{

	$w_check = '';

}



if($getfulldatas->dc_data_sub_type == "x")

{

	$x_check = ' checked="checked" ';

}else{

	$x_check = '';

}



if($getfulldatas->dc_data_sub_type == "l")

{

	$l_check = ' checked="checked" ';

}else{

	$l_check = '';

}



if($getfulldatas->dc_data_sub_type == "sds")

{

	$sds_check = ' checked="checked" ';

}else{

	$sds_check = '';

}



$html .='<input readonly="true" type="radio" name="dcsubtype" value="m" '.$m_check.' >&nbsp;Integration Manual (M)<br>

<input readonly="true" type="radio" name="dcsubtype" value="p" '.$p_check.' >&nbsp;Procedure (P)<br>

<input readonly="true" type="radio" name="dcsubtype" value="w" '.$w_check.' >&nbsp;Work Instruction (W)<br>

<input readonly="true" type="radio" name="dcsubtype" value="l" '.$l_check.' >&nbsp;Law (L)

</td>



<td style="border-right:1px solid #111111;font-size:16px;">

<input readonly="true" type="radio" name="dcsubtype" value="f" '.$f_check.' >&nbsp;Form (F)<br>

<input readonly="true" type="radio" name="dcsubtype" value="s" '.$s_check.' >&nbsp;Support Document (S)<br>

<input readonly="true" type="radio" name="dcsubtype" value="s" '.$x_check.' >&nbsp;External Document (X)<br>

<input readonly="true" type="radio" name="dcsubtype" value="sds" '.$sds_check.' >&nbsp;Safety Data Sheet (SDS)

</td>';







$html .='



<td style="font-size:15px;">

&nbsp;<b>วันที่ร้องขอ :</b>&nbsp;&nbsp;'.con_date($getfulldatas->dc_data_date).'<br>

&nbsp;<b>แผนก :</b>&nbsp;&nbsp;'.$getfulldatas->dc_dept_main_name.'<br>

&nbsp;<b>ชื่อเอกสาร :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_docname.'<br>

&nbsp;<b>รหัสเอกสาร :</b>&nbsp;'.$getfulldatas->dc_data_doccode_display.'<br>

&nbsp;<b>วันที่เริ่มใช้ :</b>&nbsp;&nbsp;'.con_date($getfulldatas->dc_data_date_start).'

</td>

<td style="font-size:15px;">

&nbsp;&nbsp;<b>ผู้ร้องขอ :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_user.'<br>

&nbsp;&nbsp;<b>ครั้งที่แก้ไข :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_edit.'<br>

&nbsp;&nbsp;<b>ระยะเวลาจัดเก็บ :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_store.$getfulldatas->dc_data_store_type.'

</td>

</tr>

<tr>

<td colspan="2" style="border-bottom:1px solid #111111;border-right:1px solid #111111;font-size:16px;"><b>Sub Type :</b>'.getdocsubtype_name($getfulldatas->dc_data_sub_type_sds)->dc_sds_name.'<br></td>

<td colspan="2" style="border-bottom:1px solid #111111;"></td>

</tr>









<tr>

<td colspan="2" style="font-size:18px;"><b><u>เหตุผลในการร้องขอ</u></b></td>

</tr>';



if($getfulldatas->dc_data_reson == "r-01")

{

    $r01 = ' checked="checked" ';

}else{

    $r01 ='';

}



if($getfulldatas->dc_data_reson == "r-02")

{

    $r02 = ' checked="checked" ';

}else{

    $r02 ='';

}



if($getfulldatas->dc_data_reson == "r-03")

{

    $r03 = ' checked="checked" ';

}else{

    $r03 ='';

}



if($getfulldatas->dc_data_reson == "r-04")

{

    $r04 = ' checked="checked" ';

}else{

    $r04 ='';

}



if($getfulldatas->dc_data_reson == "r-05")

{

    $r05 = ' checked="checked" ';

}else{

    $r05 ='';

}



$html .='

<tr>

<td style="font-size:16px;">

<input readonly="true" type="radio" name="reson_request" value="r-01" '.$r01.' >&nbsp;เอกสารใหม่ (New Release)<br>

<input readonly="true" type="radio" name="reson_request" value="r-02" '.$r02.' >&nbsp;เปลี่ยนแปลงเอกสาร (Change)



</td>

<td style="font-size:16px;">

<input readonly="true" type="radio" name="reson_request" value="r-03" '.$r03.' >&nbsp;ขอสำเนาเพิ่ม (Additional Copy)<br>

<input readonly="true" type="radio" name="reson_request" value="r-04" '.$r04.' >&nbsp;ขอแก้ไขเอกสาร (Revision)



</td>



<td style="font-size:16px;">

<input readonly="true" type="radio" name="reson_request" value="r-05" '.$r05.' >&nbsp;ขอยกเลิกเอกสาร (Obsolete)

</td>



</tr>

<tr>

<td colspan="2" style="font-size:16px;"><b><u>รายละเอียด</u></b>&nbsp;&nbsp;&nbsp;'.$getfulldatas->dc_data_reson_detail.'</td>

</tr><br>



<tr>

<td colspan="4" style="text-align:center;color:red;border:1px solid #111111;">กรุณาให้เหตุผลในการร้องขอทุกครั้ง เพื่อบันทึกเป็นหลักฐานในประวัติการแก้ไข</td>

</tr>

</table>





<table>

<tr>

<td colspan="3" style="font-size:18px;"><b><u>หน่วยงานที่เกี่ยวข้อง</u></b></td>

</tr>

<tr>



';

$i=1;

$tr = '<tr>';

$trs = '';

foreach(getdept()->result_array() as $gd){





    $deptchecked = '';

    foreach (getdept_use($darcode)->result_array() as $get_related_use) {

        if ($get_related_use['related_dept_code'] == $gd['related_code']) {

            $deptchecked = ' checked="checked" ';

            continue;

        }

    }

$html .=$tr;

$html .='

<td style="font-size:16px;">



<input readonly="true" type="checkbox" name="dept[]" value="'.$gd['related_code'].'" '.$deptchecked.' >&nbsp;'.$gd['related_dept_name'].'



</td>';

if($i == 3 || $i == 6 || $i == 9 || $i == 12 || $i == 15 || $i == 17){

    $trs = '</tr>';

    $tr = '<tr>';

    

}else {

    $tr = '';

    $trs = '';

    

}

$html .=$trs;

$i++;

}



$html .='

</table>

<div style="text-align:center;color:red;border:1px solid #111111;">กรุณาเลือกติ๊กถูกให้ครบถ้วน เพื่อเจ้าหน้าที่จะได้ดำเนินการได้อย่างทั่วถึง</div>

';



if($getfulldatas->dc_data_result_reson_status == 1)

{

    $resonstatus1 = ' checked="checked" ';

}else if($getfulldatas->dc_data_result_reson_status == 0){

    $resonstatus0 = ' checked="checked" ';

}else{

    $resonstatus1 ='';

    $resonstatus0 = '';

}



$html .='

<table style="border-bottom:1px solid #111111;">

<tr><br>

<td colspan="2" style="font-size:18px;"><b><u>ผลการร้องขอ (Manager Approve)</u></b></td>

<td style="font-size:16px;"><input readonly="true" type="radio" name="mgr_approve" value="1" '.$resonstatus1.'/>&nbsp;อนุมัติ</td>

<td style="font-size:16px;"><input readonly="true" type="radio" name="mgr_approve" value="0" '.$resonstatus0.'/>&nbsp;ไม่อนุมัติ</td>

</tr>

<tr>

<td colspan="4" style="font-size:16px;"><b>เนื่องจาก :</b><br>'.$getfulldatas->dc_data_result_reson_detail.'<br></td>

</tr>

<tr>

<td style="font-size:16px;"><b>ผู้อนุมัติ :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_approve_mgr.'<br></td>

</tr>

</table>

';



if($getfulldatas->dc_data_result_reson_status2 == 1)

{

    $resonstatus21 = ' checked="checked" ';

}else if($getfulldatas->dc_data_result_reson_status2 == 0){

    $resonstatus20 = ' checked="checked" ';

}else{

    $resonstatus21 = '';

    $resonstatus20 = '';

}



$html .='

<table>

<tr><br>

<td colspan="2" style="font-size:18px;"><b><u>ผลการร้องขอ (Qmr Approve)</u></b></td>

<td style="font-size:16px;"><input readonly="true" type="radio" name="mgr_approve" value="1" '.$resonstatus21.'/>&nbsp;อนุมัติ</td>

<td style="font-size:16px;"><input readonly="true" type="radio" name="mgr_approve" value="0" '.$resonstatus20.'/>&nbsp;ไม่อนุมัติ</td>

</tr>

<tr>

<td colspan="4" style="font-size:16px;"><b>เนื่องจาก :</b><br>'.$getfulldatas->dc_data_result_reson_detail2.'<br></td>

</tr>

<tr>

<td style="font-size:16px;"><b>ผู้อนุมัติ :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_approve_qmr.'<br></td>

</tr>

<tr>

<td colspan="4" style="border:1px solid #111111;text-align:center;"><span style="color:red;"><b>หมายเหตุ</b></span>&nbsp;&nbsp;อำนาจในการอนุมัติ ดูได้ในระเบียบปฏิบัติ เรื่องข้อมูลเอกสารสาระสนเทศ หน้าที่ 4 ข้อที่ 5.1.2 การกำหนดผู้มีอำนาจในการทบทวนและอนุมัติเอกสาร</td>

</tr>

<tr>

<td style="font-size:18px;"><b><u>สำหรับผู้ควบคุมเอกสาร</u></b></td>

</tr>

<tr>

<td colspan="4" style="font-size:16px;"><b>การดำเนินการ :</b><br>'.$getfulldatas->dc_data_method.'</td>

</tr>

<tr>

<td style="font-size:16px;"><b>ผู้ดำเนินการ :</b>&nbsp;&nbsp;'.$getfulldatas->dc_data_operation.'</td>

</tr>

</table>

';



// output the HTML content

$pdf->writeHTML($html, true, false, true, false, '');



// reset pointer to the last page

$pdf->lastPage();





// Print all HTML colors





ob_end_clean();

$filename = $getfulldatas->dc_data_darcode.'.pdf';

//Close and output PDF document

$pdf->Output($filename, 'I');



//============================================================+

// END OF FILE

//============================================================+





?>





</body>

</html>