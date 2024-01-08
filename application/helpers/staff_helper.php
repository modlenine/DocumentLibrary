<?php

class staff_fn{

    public $ci;

    function __construct()

    {

        $this->ci=& get_instance();

    }

    public function getci()

    {

        return $this->ci;

    }

}







function getIsoDoc()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    library_main.lib_main_id,

    library_main.lib_main_doccode,

    library_main.lib_main_doccode_master,

    library_main.lib_main_doccode_copy,

    library_main.lib_main_file_location_master,

    library_main.lib_main_file_location_copy,

    library_main.lib_main_pin_status,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_sub_type_law,

    dc_datamain.dc_data_sub_type_sds,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_darcode,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_dept,

    dc_datamain.dc_data_date

    FROM

    library_main

    INNER JOIN dc_datamain ON dc_datamain.dc_data_darcode = library_main.lib_main_darcode

    WHERE

    library_main.lib_main_status = 'active' AND library_main.lib_main_pin_status != 'pin' 

    GROUP BY

    library_main.lib_main_doccode ORDER BY lib_main_id ASC ");

}



function getIsoDocPin()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT
    dc_datamain.dc_data_doccode_display,
    dc_datamain.dc_data_docname,
    dc_datamain.dc_data_sub_type,
    dc_datamain.dc_data_date,
    dc_datamain.dc_data_dept,
    dc_dept_main.dc_dept_main_name,
    library_main.lib_main_status,
    library_main.lib_main_pin_status,
    library_main.lib_main_pin_order,
    library_main.lib_main_doccode,
    library_main.lib_main_id
    FROM
    dc_datamain
    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept
    INNER JOIN library_main ON library_main.lib_main_darcode = dc_datamain.dc_data_darcode
    where library_main.lib_main_status = 'active' and library_main.lib_main_pin_status='pin'
    ORDER BY lib_main_pin_order DESC ");

}





function countPin()

{

    $obj = new staff_fn();

    $query = $obj->getci()->db->query("SELECT lib_main_pin_status FROM library_main WHERE lib_main_pin_status='pin' ");

    return $query->num_rows();

}







function pinIsoDoc($lib_main_id)

{

    $obj = new staff_fn();

    //check order pin

    $checkorderpin = $obj->getci()->db->query("SELECT lib_main_pin_order FROM library_main ORDER BY lib_main_pin_order DESC LIMIT 1 ");

    foreach($checkorderpin->result_array() as $rs){

        if($rs['lib_main_pin_order'] == 0){

            $orderpin = 1;

        }else if($rs['lib_main_pin_order'] > 0){

            $orderpin = $rs['lib_main_pin_order'];

            $orderpin++;

        }

    }

    

    $ar = array(

        "lib_main_pin_status" => "pin",

        "lib_main_pin_order" => $orderpin

    );



    $result = $obj->getci()->db->where("lib_main_id",$lib_main_id);

    $result = $obj->getci()->db->update("library_main",$ar);

    if(!$result)

    {

        echo "<script>";

        echo "alert('ปักหมุดไม่สำเร็จ')";

        echo "</script>";

        exit();

        

    }else{

        echo "<script>";

        echo "alert('ปักหมุดเรียบร้อยแล้ว')";

        echo "</sctipt>";

    }

}





function unpinIsoDoc($lib_main_id)

{

    $obj = new staff_fn();

    $ar = array(

        "lib_main_pin_status" => 0 ,

        "lib_main_pin_order" => 0

    );



    $result = $obj->getci()->db->where("lib_main_id",$lib_main_id);

    $result = $obj->getci()->db->update("library_main",$ar);

    if(!$result)

    {

        echo "<script>";

        echo "alert('ปักหมุดไม่สำเร็จ')";

        echo "</script>";

        exit();

        

    }else{

        echo "<script>";

        echo "alert('ปักหมุดเรียบร้อยแล้ว')";

        echo "</sctipt>";

    }

}







//Zone เอกสารทั่วไป

function getGlDoc()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

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

    gl_document.gl_doc_pin_status,

    gl_document.gl_doc_pin_order

    FROM

    gl_document

    WHERE gl_document.gl_doc_pin_status != 'pin'

    ");

}





function glDocPin()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

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

    gl_document.gl_doc_pin_status,

    gl_document.gl_doc_pin_order

    FROM

    gl_document

    WHERE gl_document.gl_doc_pin_status = 'pin'

    ORDER BY gl_doc_pin_order DESC ");

}





function pinGlDoc($gldoccode)

{

    $obj = new staff_fn();

    $checkOrderPin = $obj->getci()->db->query("SELECT gl_doc_pin_order FROM gl_document ORDER BY gl_doc_pin_order DESC LIMIT 1 ");

    foreach($checkOrderPin->result_array() as $chkGl){

        if($chkGl['gl_doc_pin_order'] == 0){

            $pinroder = 1;

        }else if ($chkGl['gl_doc_pin_order'] > 0){

            $pinroder = $chkGl['gl_doc_pin_order'];

            $pinroder++;

        }

    }





    $arglpin = array(

        "gl_doc_pin_status" => "pin",

        "gl_doc_pin_order" => $pinroder

    );



    $obj->getci()->db->where("gl_doc_code",$gldoccode);

    $result = $obj->getci()->db->update("gl_document",$arglpin);





    if(!$result)

    {

        echo "<script>";

        echo "alert('ปักหมุดไม่สำเร็จ')";

        echo "</script>";

        exit();

        

    }else{

        echo "<script>";

        echo "alert('ปักหมุดเรียบร้อยแล้ว')";

        echo "</sctipt>";

    }

}





function unPinGlDoc($gldoccode)

{

    $obj = new staff_fn();

    $ar_unpin = array(

        "gl_doc_pin_status" => 0,

        "gl_doc_pin_order" => 0

    );

    $obj->getci()->db->where("gl_doc_code",$gldoccode);

    $result = $obj->getci()->db->update("gl_document",$ar_unpin);



    if(!$result)

    {

        echo "<script>";

        echo "alert('ยกเลิกการปักหมุดไม่สำเร็จ')";

        echo "</script>";

        exit();

        

    }else{

        echo "<script>";

        echo "alert('ยกเลิกการปักหมุดเรียบร้อยแล้ว')";

        echo "</sctipt>";

    }

}







function countGlPin()

{

    $obj = new staff_fn();

    $query = $obj->getci()->db->query("SELECT gl_doc_pin_status FROM gl_document WHERE gl_doc_pin_status ='pin' ");

    return $query->num_rows();

}





function searchby_docode_admin($doccode)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT * FROM

    (SELECT MAX(dc_data_id) as dc_data_id_max , dc_data_doccode FROM dc_datamain GROUP BY dc_data_doccode)a

    INNER JOIN

    (SELECT * FROM dc_datamain)b ON a.dc_data_id_max = b.dc_data_id

    INNER JOIN

    (SELECT * FROM (SELECT MAX(lib_main_id) as lib_main_id_max  FROM library_main GROUP BY lib_main_doccode)c 

    INNER JOIN (SELECT * FROM library_main)d ON c.lib_main_id_max = d.lib_main_id)aa 

    ON a.dc_data_doccode = aa.lib_main_doccode WHERE a.dc_data_doccode LIKE '%$doccode%' ");

}







function searchby_docname_admin($docname)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT * FROM

    (SELECT MAX(dc_data_id) as dc_data_id_max , dc_data_doccode FROM dc_datamain GROUP BY dc_data_doccode)a

    INNER JOIN

    (SELECT * FROM dc_datamain)b ON a.dc_data_id_max = b.dc_data_id

    INNER JOIN

    (SELECT * FROM (SELECT MAX(lib_main_id) as lib_main_id_max  FROM library_main GROUP BY lib_main_doccode)c 

    INNER JOIN (SELECT * FROM library_main)d ON c.lib_main_id_max = d.lib_main_id)aa 

    ON a.dc_data_doccode = aa.lib_main_doccode WHERE b.dc_data_docname LIKE '%$docname%' ");

}





function searchby_hashtag_admin($hashtag)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT * FROM

    (SELECT MAX(dc_data_id) as dc_data_id_max , dc_data_doccode FROM dc_datamain GROUP BY dc_data_doccode)a

    INNER JOIN

    (SELECT * FROM dc_datamain)b ON a.dc_data_id_max = b.dc_data_id

    INNER JOIN

    (SELECT * FROM (SELECT MAX(lib_main_id) as lib_main_id_max  FROM library_main GROUP BY lib_main_doccode)c 

    INNER JOIN (SELECT * FROM library_main)d ON c.lib_main_id_max = d.lib_main_id)aa 

    ON a.dc_data_doccode = aa.lib_main_doccode 

    INNER JOIN library_hashtag ON library_hashtag.li_hashtag_doc_code = aa.lib_main_doccode

    WHERE library_hashtag.li_hashtag_name LIKE '%$hashtag%' ");

}







function searchby_date_admin($start_date,$end_date)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT * FROM

    (SELECT MAX(dc_data_id) as dc_data_id_max , dc_data_doccode FROM dc_datamain GROUP BY dc_data_doccode)a

    INNER JOIN

    (SELECT * FROM dc_datamain)b ON a.dc_data_id_max = b.dc_data_id

    INNER JOIN

    (SELECT * FROM (SELECT MAX(lib_main_id) as lib_main_id_max  FROM library_main GROUP BY lib_main_doccode)c 

    INNER JOIN (SELECT * FROM library_main)d ON c.lib_main_id_max = d.lib_main_id)aa 

    ON a.dc_data_doccode = aa.lib_main_doccode 

    WHERE b.dc_data_date BETWEEN '$start_date' AND '$end_date' ");

}









//DAR LOG SHEET

function getlist_darlog()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_datamain.dc_data_date_operation,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson

    order by dc_datamain.dc_data_id desc");

}





function getlist_darlog_status($status)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_datamain.dc_data_date_operation,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson

    WHERE dc_datamain.dc_data_status = '$status'

    order by dc_datamain.dc_data_id desc");

}







function searchby_date_darlog($start_date,$end_date,$filter_withdate)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_datamain.dc_data_date_operation,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 

    WHERE dc_datamain.dc_data_date BETWEEN '$start_date' AND '$end_date' AND dc_datamain.dc_data_status = '$filter_withdate'

    order by dc_datamain.dc_data_id desc");

}







function searchby_date_darlogs($start_date,$end_date)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_datamain.dc_data_date_operation,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 

    WHERE dc_datamain.dc_data_date BETWEEN '$start_date' AND '$end_date'

    order by dc_datamain.dc_data_id desc");

}

//DAR LOG SHEET







//ทะเบียนเอกสาร

//Get Document type for loop

function docType()

{

    $obj = new staff_fn();

    return $obj->getci()->db->get("dc_sub_type");

}





function getlist_docList()

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_date_start,

    dc_datamain.dc_data_store,

    dc_datamain.dc_data_store_type,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_date_operation

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 
    WHERE dc_data_id in ( select max(dc_data_id)as id from dc_datamain GROUP BY dc_datamain.dc_data_doccode ORDER BY dc_datamain.dc_data_id DESC)

    order by dc_datamain.dc_data_id desc");

}





function getlist_docList_filter($docType)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_date_start,

    dc_datamain.dc_data_store,

    dc_datamain.dc_data_store_type,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_date_operation

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 

    WHERE dc_datamain.dc_data_sub_type = '$docType' AND
    dc_data_id in ( select max(dc_data_id)as id from dc_datamain GROUP BY dc_datamain.dc_data_doccode ORDER BY dc_datamain.dc_data_id DESC)

    order by dc_datamain.dc_data_id desc");

}







function getlist_docList_date($start_date,$end_date,$filter_withdate)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_date_start,

    dc_datamain.dc_data_store,

    dc_datamain.dc_data_store_type,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_date_operation

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 

    WHERE dc_datamain.dc_data_date BETWEEN '$start_date' AND '$end_date' AND dc_datamain.dc_data_sub_type = '$filter_withdate' AND
    dc_data_id in ( select max(dc_data_id)as id from dc_datamain GROUP BY dc_datamain.dc_data_doccode ORDER BY dc_datamain.dc_data_id DESC)

    order by dc_datamain.dc_data_id desc");

}







function getlist_docList_dates($start_date,$end_date)

{

    $obj = new staff_fn();

    return $obj->getci()->db->query("SELECT

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_docname,

    dc_datamain.dc_data_edit,

    dc_datamain.dc_data_doccode_display,

    dc_datamain.dc_data_id,

    dc_datamain.dc_data_law_doccode,

    dc_datamain.dc_data_sds_doccode,

    dc_datamain.dc_data_sub_type,

    dc_datamain.dc_data_date,

    dc_datamain.dc_data_date_start,

    dc_datamain.dc_data_store,

    dc_datamain.dc_data_store_type,

    dc_datamain.dc_data_user,

    dc_datamain.dc_data_reson,

    dc_datamain.dc_data_status,

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_datamain.dc_data_darcode,
    dc_datamain.dc_data_date_operation

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson 

    WHERE dc_datamain.dc_data_date BETWEEN '$start_date' AND '$end_date' AND
    dc_data_id in ( select max(dc_data_id)as id from dc_datamain GROUP BY dc_datamain.dc_data_doccode ORDER BY dc_datamain.dc_data_id DESC)

    order by dc_datamain.dc_data_id desc");

}











?>