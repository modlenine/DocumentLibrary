<?php



class pdf_fn {

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











function get_iso_type()

{

    $obj = new pdf_fn();

   return $obj->getci()->db->get("dc_type");

}



function get_check_type($darcode)

{

    $obj = new pdf_fn();

    return $obj->getci()->db->query("SELECT

dc_datamain.dc_data_doccode,

dc_datamain.dc_data_darcode,

dc_type_use.dc_type_use_code

FROM

dc_datamain

INNER JOIN dc_type_use ON dc_type_use.dc_type_use_doccode = dc_datamain.dc_data_doccode

WHERE dc_datamain.dc_data_darcode = '$darcode' ");

}



function getFullData($darcode)

{

    $obj = new pdf_fn();

    return $obj->getci()->db->query("SELECT

    dc_sub_type.dc_sub_type_name,

    dc_reason_request.dc_reason_name,

    dc_dept_main.dc_dept_main_name,

    dc_dept_main.dc_dept_main_code,

    dc_dept_main.dc_dept_short_name,

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

    dc_datamain.dc_data_doccode,

    dc_datamain.dc_data_doccode_display,

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
    dc_datamain.dc_data_formcode

    FROM

    dc_datamain

    INNER JOIN dc_sub_type ON dc_sub_type.dc_sub_type_code = dc_datamain.dc_data_sub_type

    INNER JOIN dc_reason_request ON dc_reason_request.dc_reason_code = dc_datamain.dc_data_reson

    INNER JOIN dc_dept_main ON dc_dept_main.dc_dept_code = dc_datamain.dc_data_dept

    WHERE dc_datamain.dc_data_darcode = '$darcode' ");

}





function getdocsubtype()

{

    $obj = new pdf_fn();

    return $obj->getci()->db->get("dc_sub_type");

}



function getdocsubtype_name($subtypecode)

{

    $obj = new pdf_fn();

    $result = $obj->getci()->db->query("SELECT * FROM dc_sds WHERE dc_sds_code='$subtypecode' ");

    return $result->row();

}



function getdept()

{

    $obj = new pdf_fn();

    return $obj->getci()->db->get("dc_related_dept");

}



function getdept_use($darcode)

{

    $obj = new pdf_fn();

    return $obj->getci()->db->query("SELECT

    dc_related_dept.related_id,

    dc_related_dept.related_dept_name,

    dc_related_dept_use.related_dept_darcode,

    dc_related_dept_use.related_dept_id,

    dc_related_dept_use.related_dept_code,

    dc_related_dept_use.related_dept_status,

    dc_datamain.dc_data_doccode

    FROM

    dc_related_dept

    INNER JOIN dc_related_dept_use ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code

    INNER JOIN dc_datamain ON dc_related_dept_use.related_dept_darcode = dc_datamain.dc_data_darcode

    

    WHERE related_dept_darcode= '$darcode'");

}









?>