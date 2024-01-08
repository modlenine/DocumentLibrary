





$(function () {





    /***********************************Text area 40 char*****************************************/

    $('#characterLeft').text('40 characters left');

    $('#li_hashtag').keydown(function () {

        var max = 40;

        var len = $(this).val().length;

        if (len >= max) {

            $('#characterLeft').text('You have reached the limit');

            $('#characterLeft').addClass('red');

            $('#dar_addmore').addClass('disabled');

        } else {

            var ch = max - len;

            $('#characterLeft').text(ch + ' characters left');

            $('#dar_addmore').removeClass('disabled');

            $('#characterLeft').removeClass('red');

        }

    });

    /***********************************Text area 40 char*****************************************/



    // Code Check Radio Button loop from database

    $('#related_dept_other').hide();

    $('#get_law').hide();

    $('#get_sds').hide();


if($("input[type=radio][name=dc_data_sub_type]").val() == "l"){
    $('#get_law').show();
}
    $("input[type=radio][name=dc_data_sub_type]").click(function () {

        if ($(this).prop("checked")) {



            if ($(this).val() == "l") {

                $('#get_law').show();

            } else {

                $('#get_law').hide();

            }



            if ($(this).val() == "sds") {

                $('#get_sds').show();

            } else {

                $('#get_sds').hide();

            }





            // if($(this).val() == "re17")//check Related dept

            // {

            //     $('#related_dept_other').show();

            // }else{

            //     $('#related_dept_other').hide();

            // }







        }

    });







    // // Code Check Radio Button loop from database

    // if($('#checksds').val() == "sds")

    // {

    //     $('#get_sds').show();

    // }



    // if($('#checksds').val() == "l")

    // {

    //     $('#get_law').show();

    // }









    // Check MGR Aprove

    if ($('#dc_data_result_reson_detail').val() != '') {

        $('#dc_data_result_reson_detail').prop('disabled', true);

        $('#btnSave_sec2').hide();

    }

    // Check MGR Aprove





    //Check Qmr Approve

    if ($('#dc_data_result_reson_detail2').val() != '') {

        $('#dc_data_result_reson_detail2').prop('disabled', true);

        $('#btnSave_sec3').hide();

    }

    //Check Qmr Approve


    // Check Smr Approve
    if ($('#dc_data_result_reson_detail3').val() != '') {

        $('#dc_data_result_reson_detail3').prop('disabled', true);

        $('#btnSave_sec3smr').hide();

    }



    if ($('#dc_data_method').val() != '') {

        $('#dc_data_method').prop('disabled', true);

        $('#btnOpsave').hide();

    }







    // $('#add_dar').click(function (){

    //     $.ajax({

    //         type:"post",

    //         url:"http://192.190.10.27/dc2/document/add_dar",

    //         cache:false,

    //         data:'data',

    //         success: function(data){

    //             $('#show_list').html(data);

    //             // alert(data);

    //             // console.log(data);

    //         }

    //     });

    // });





    // $('#list_dar').click(function (){

    //     $.ajax({

    //         type:"post",

    //         url:"http://192.190.10.27/dc2/document/list_dar",

    //         cache:false,

    //         data:'data',

    //         success: function(data){

    //             $('#show_list').html(data);

    //             // alert(data);

    //             // console.log(data);

    //             // $('#view_dar').DataTable();

    //         }



    //     });



    // });



    // $('#choose_method').change(function (){

    //     var choose_method = $('#choose_method').val();

    //     if(choose_method == "r-01")

    //     {

    //         $.ajax({

    //             type:"post",

    //             url:"http://192.190.10.27/dc2/document/add",

    //             cache:false,

    //             data:'data',

    //             success: function(data){

    //                 $('#show_add').html(data);

    //                 // alert(data);

    //                 // console.log(data);

    //                 // $('#view_dar').DataTable();

    //             }



    //         });

    //     }

    // });





    // Date pickup use

    $('.datepicker').pickadate({

        monthsFull: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],

        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],

        today: 'วันนี้',

        clear: 'ล้าง',

        formatSubmit: 'yyyy/mm/dd',

        hiddenName: true,

        editable: true,

        min: true,

        disable: [

            1, 7

        ]

    });





    $('.datepicker_manual').pickadate({

        monthsFull: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],

        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],

        today: 'วันนี้',

        clear: 'ล้าง',

        formatSubmit: 'yyyy/mm/dd',

        hiddenName: true,

        editable: true

    });





    $('.datepicker_search').pickadate({

        monthsFull: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],

        weekdaysShort: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],

        today: 'วันนี้',

        clear: 'ล้าง',

        format: 'yyyy-mm-dd',

        formatSubmit: 'yyyy-mm-dd',

        hiddenName: true,

        editable: true,

        min: false

    });









    //  ++++++++++++++++++++++++++++++++ Modal Section +++++++++++++++++++++++++++++++++++++

    $('.edit_dept_modal').click(function () {

        var data_dept_id = $(this).attr('data-dept-id');

        var data_dept_code = $(this).attr('data-dept-code');

        var data_dept_name = $(this).attr('data-dept-name');





        $('#edit_gl_dept_code').val(data_dept_code);

        $('#edit_gl_dept_name').val(data_dept_name);

        $('#edit_gl_dept_id').val(data_dept_id);

        $('#edit_dept_modal').modal('show');

    });







    $('.edit_permis_modal').click(function () {

        var data_edit_permis_username = $(this).attr('data_edit_permis_username');

        var data_edit_permis_deptname = $(this).attr('data_edit_permis_deptname');

        var data_edit_permis_groupname = $(this).attr('data_edit_permis_groupname');

        var data_edit_permis_groupid = $(this).attr('data_edit_permis_groupid');

        var data_edit_permis_userid = $(this).attr('data_edit_permis_userid');



        $('#get_user_permis').val(data_edit_permis_username);

        $('#get_gl_dept_name').val(data_edit_permis_deptname);

        $('#get_group_permis').val(data_edit_permis_groupname);

        $('#get_gl_user_id').val(data_edit_permis_userid);

        $('#edit_permis_modal').modal('show');

    });







    $('.edit_user_modal').click(function () {

        var data_edituser_userid = $(this).attr('data_edituser_userid');

        var data_edituser_fname = $(this).attr('data_edituser_fname');

        var data_edituser_lname = $(this).attr('data_edituser_lname');

        var data_edituser_deptname = $(this).attr('data_edituser_deptname');

        var data_edituser_deptcode = $(this).attr('data_edituser_deptcode');

        var data_edituser_ecode = $(this).attr('data_edituser_ecode');

        var data_edituser_memberemail = $(this).attr('data_edituser_memberemail');



        $('#get_userid_edit').val(data_edituser_userid);

        $('#get_fname_edit').val(data_edituser_fname);

        $('#get_lname_edit').val(data_edituser_lname);

        $('#get_deptname_edit').val(data_edituser_deptname);

        $('#get_deptcode_edit').val(data_edituser_deptcode);

        $('#get_ecode_edit').val(data_edituser_ecode);

        $('#get_email_edit').val(data_edituser_memberemail);



        $('#edit_user_modal').modal('show');



    });





    $('.reason_detail').click(function () {

        var data_reason_detail = $(this).attr('data_reason_detail');



        $('#data_reason_detail_show').val(data_reason_detail);



        $('#reason_detail').modal('show');

    })







    //  ++++++++++++++++++++++++++++++++ Modal Section +++++++++++++++++++++++++++++++++++++



















    // Permission Genaral document



    $('.read').prop("readonly", true);



    var result_gl_doc_status = $('#result_gl_doc_status').val();



    if (result_gl_doc_status != '') {

        if (result_gl_doc_status == 1) {

            $('#rs_approve').prop("checked", true);

        } else {

            $('#rs_notapprove').prop("checked", true);

        }

        $('#btn_save2').hide();

    }







    $('.add_more').click(function (e) {

        e.preventDefault();

        $(this).before("<input name='gl_doc_hashtag[]' id='gl_doc_hashtag' type='text' class='form-control mt-2' placeholder='ระบุ แฮชแท็กของไฟล์เอกสาร เช่น #เอกสารทั่วไป #ประกาศบริษัท' required maxlength='40'/>");

    });





    $('.dar_addmore').click(function (e) {

        e.preventDefault();

        $(this).before("<input name='li_hashtag[]' id='li_hashtag' type='text' class='form-control mt-2' placeholder='กรุณาระบุ Hashtag เช่น #คู่มือการใช้งาน' required maxlength='40'/><label id='characterLeft'></label><br>");

    });







    if ($('#check_group').val() == "user" || $('#check_status_gldoc').val() == "Approved") {

        $('a#up_file_gl').prop({ 'href': '#', 'target': '_self' });

        $('input[type=radio][name=gl_doc_status],#gl_doc_reson_detail,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

    }



    // Check section for document control

    if ($('#check_group').val() != "document control" && $('#check_group').val() != "superuser") {

        $('input[type=radio][name=gl_doc_status],#gl_doc_reson_detail,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

    }

    





    // Permission Genaral document



















    // Permission Group

    if ($('#check_group').val() == "it" || $('#check_group').val() == "admin" || $('#check_group').val() == "document control" || $('#check_group').val() == "superuser") {

        $('li#admin_section').css("display", "inline");

    }







    if ($('#check_group').val() == "user" && $('#check_data_status').val() == "Open" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Manager Approved" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Complete" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Manager Not Approve" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Qmr Approved" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Qmr Not Approve" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Smr Approved" || $('#check_group').val() == "user" && $('#check_data_status').val() == "Smr Not Approve") {

        //ถ้าสิทธิ์เท่ากับ User จะทำการ Disable ฟิลส่วนของ Manager และ Document Controller



        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').prop({ 'href': '#', 'target': '_self' });

        $('input[type=radio],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

        $('#dc_data_result_reson_detail,#dc_data_approve_mgr,#btnSave_sec2,#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);



        // Check Manager Section

    } else if ($('#check_group').val() == "manager" && $('#check_data_status').val() == "Open") {

        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').prop({'href':'#','target':'_self'});



        $('input[name=dc_data_result_reson_status2],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

        $('#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);



    } else if ($('#check_group').val() == "manager" && $('#check_data_status').val() == "Manager Approved" || $('#check_group').val() == "manager" && $('#check_data_status').val() == "Qmr Approved" || $('#check_group').val() == "manager" && $('#check_data_status').val() == "Manager Not Approve" || $('#check_group').val() == "manager" && $('#check_data_status').val() == "Qmr Not Approve" || $('#check_group').val() == "manager" && $('#check_data_status').val() == "Smr Approved" || $('#check_group').val() == "manager" && $('#check_data_status').val() == "Smr Not Approve") {



        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').prop({ 'href': '#', 'target': '_self' });



        $('input[name=dc_data_result_reson_status2],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

        $('#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);

        // Check Manager Section







    // Check QMR Section

    } else if ($('#check_group').val() == "qmr" && $('#check_data_status').val() == "Open" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Complete" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Manager Not Approve" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Qmr Approved" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Qmr Not Approve" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Smr Approved" || $('#check_group').val() == "qmr" && $('#check_data_status').val() == "Smr Not Approve") {

        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').prop({ 'href': '#', 'target': '_self' });

        $('input[type=radio],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

        $('#dc_data_result_reson_detail,#dc_data_approve_mgr,#btnSave_sec2,#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);



    } else if ($('#check_group').val() == "qmr" && $('#check_data_status').val() == "Manager Approved") {

        // $('a#dc_data_file').removeProp();

        $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore').prop('disabled', true);

    }

    // Check QMR Section





    // Check SMR Section

    else if ($('#check_group').val() == "smr" && $('#check_data_status').val() == "Open" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Complete" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Manager Not Approve" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Qmr Approved" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Qmr Not Approve" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Smr Approved" || $('#check_group').val() == "smr" && $('#check_data_status').val() == "Smr Not Approve") {

        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').prop({ 'href': '#', 'target': '_self' });

        $('input[type=radio],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled', true);

        $('#dc_data_result_reson_detail,#dc_data_approve_mgr,#btnSave_sec2,#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);



    } else if ($('#check_group').val() == "smr" && $('#check_data_status').val() == "Manager Approved") {

        // $('a#dc_data_file').removeProp();

        $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dar_addmore').prop('disabled', true);

    }

    // Check SMR Section




    







    // Check document control section

    if ($('#check_group').val() == "document control" && $('#check_data_status').val() != "Qmr Approved" || 
    $('#check_group').val() == "document control" && $('#check_data_status').val() != "Smr Approved") {

        $('a#up_file').prop({ 'href': '#', 'target': '_self' });

        // $('a#dc_data_file').removeProp({ 'href': '#', 'target': '_self' });

        // $('input[type=radio],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled',true);

        $('#dc_data_result_reson_detail,#dc_data_approve_mgr,#btnSave_sec2,#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);

        if($('#check_data_status').val() == "Qmr Approved" || $('#check_data_status').val() == "Smr Approved"){
            $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave').prop('disabled', false);
        }

    } else if ($('#check_group').val() == "document control" && $('#check_data_status').val() == "Qmr Approved" || $('#check_group').val() == "document control" && $('#check_data_status').val() == "Smr Approved") {

        $('a#up_file').prop({ 'href': '#', 'target': '_self' });



        // $('input[type=radio],#gl_doc_reson_detail,#gl_doc_hashtag,#btnAddMore,#gl_doc_approve_by,#btn_save2').prop('disabled',true);

        $('#dc_data_result_reson_detail,#dc_data_approve_mgr,#btnSave_sec2,#dc_data_result_reson_detail2,#dc_data_approve_qmr,#btnSave_sec3,#dc_data_result_reson_detail3,#dc_data_approve_smr,#btnSave_sec3smr').prop('disabled', true);

        // $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave').prop('disabled', false);



    } else if ($('#check_group').val() == "superuser" && $('#check_data_status').val() != "Qmr Approved" || $('#check_group').val() == "superuser" && $('#check_data_status').val() != "Smr Approved") {



        $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave').prop('disabled', true);
        if($('#check_data_status').val() == "Qmr Approved" || $('#check_data_status').val() == "Smr Approved"){
            $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave').prop('disabled', false);
        }



    }else if ($('#check_group').val() == "manager" && $('#check_data_status').val() != "Qmr Approved" || $('#check_group').val() == "manager" && $('#check_data_status').val() != "Smr Approved") {

        $('#document_master,#document_copy,#dc_data_method,#dc_data_operation,#btnOpsave').prop('disabled', true);

    }

    // Check document control section











    // Check Permission สำหรับเอกสาร ISO

    if ($('#get_check_deptcode').val() != $('#check_new_deptcode').val()) {

        if($('#get_check_deptcode').val() == "re10" && $('#check_new_deptcode').val() == "re14"){
            $('.check_option').css("display","");
        }else{
            $('.check_option').css("display","none");
        }
        

    }

    if($('#check_lib_main_status').val() == "inactive"){

        $('.check_option').css("display","none");

    }











    // Search document Section

    $('#form_search_by_hashtag').hide();

    $('#form_search_by_date').hide();

    $('#form_search_by_docname').hide();

    $('#form_search_by_doccode').hide();

    $('#form_search_by_darcode').hide();



    $('#doc_search_method').change(function () {

        var doc_search_method = $('#doc_search_method').val();



        if (doc_search_method == "search_by_hashtag") {

            $('#form_search_by_hashtag').show();

        } else {

            $('#form_search_by_hashtag').hide();

        }



        if (doc_search_method == "search_by_date") {

            $('#form_search_by_date').show();

            $('#filter').hide();

        } else {

            $('#form_search_by_date').hide();

            $('#filter').show();

        }



        if (doc_search_method == "search_by_docname") {

            $('#form_search_by_docname').show();

        } else {

            $('#form_search_by_docname').hide();

        }



        if (doc_search_method == "search_by_doccode") {

            $('#form_search_by_doccode').show();

        } else {

            $('#form_search_by_doccode').hide();

        }



        if (doc_search_method == "search_by_darcode") {

            $('#form_search_by_darcode').show();

        } else {

            $('#form_search_by_darcode').hide();

        }





    });

    // Search document Section







    if ($('#check_tag').val() == 1) {

        $('#hashtag').css("display", "block");

        $('#result').css("display", "none");

    } else {

        $('#result').css("display", "block");

    }















    // Check lib pending status

    $('.pending_text').css("display","none");

    if ($('#check_lib_status').val() == "pending") {

        $('.check_option').css("display","none");

        $('.pending_text').css("display","block");

    }

    // Check lib pending status













    // search zone







    // search zone







    // Check status for control every thing : Check status for control every thing



    // if ($('#check_data_status').val() == 'Open') {

    //     // check status for hide section qmr approve and dcc approve

    //     $('#qmr_approve').css("display", "none");

    //     $('#dcc_approve').css("display", "none");

    //     // For Copy Dept

    // $('.copy_dept').css("display","none");



    //     if ($('#check_group').val() != 'manager' && $('#check_group').val() != 'superuser') {

    //         $('#manager_approve').css("display", "none");

    //     }

    //     // check status for hide section qmr approve and dcc approve



    // } else if ($('#check_data_status').val() == 'Manager Approved') {

    //     // Check status for hide section dcc approve

    //     $('#dcc_approve').css("display", "none");

    //     // For Copy Dept

    // $('.copy_dept').css("display","none");



    //     if ($('#check_group').val() != 'qmr' && $('#check_group').val() != 'superuser') {

    //         $('#qmr_approve').css("display", "none");

    //     }

    //     // Check status for hide section dcc approve

    // } else if ($('#check_data_status').val() == 'Qmr Approved') {



    //     if ($('#check_group').val() != 'document control' && $('#check_group').val() != 'superuser') {

    //         $('#dcc_approve').css("display", "none");

    //         $('.copy_dept').css("display","none");

    //     }

    //     if($('#check_dc_data_reson').val() == "r-03" && $('#check_group').val() != 'user'){

    //         $('.copy_dept').css("display","block");

    //         $('#dcc_approve').css("display","none");

    //     }else{

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","none");

    //     }



    //     if($('#check_dc_data_reson').val() == "r-05" && $('#check_group').val() != 'user'){

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","none");

    //         $('#dcc_approve.cancel_doc').css("display","block");

    //     }else{

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","none");

    //         $('#dcc_approve.cancel_doc').css("display","none");

    //     }



    // }else if ($('#check_data_status').val() == 'Complete') {

    //     if($('#check_dc_data_reson').val() == "r-03"){

    //         $('.copy_dept').css("display","block");

    //         $('#dcc_approve').css("display","none");

    //     }else{

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","block"); 

    //     }



    //     if($('#check_dc_data_reson').val() == "r-05"){

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","none");

    //         $('#dcc_approve.cancel_doc').css("display","block");

    //     }else{

    //         $('.copy_dept').css("display","none");

    //         $('#dcc_approve').css("display","none");

    //         $('#dcc_approve.cancel_doc').css("display","none");

    //     }

            

            

    // } else if ($('#check_data_status').val() == 'Qmr Not Approve') {



    //     $('#dcc_approve').css("display", "none");

    //     $('.copy_dept').css("display","none");



    // } else if ($('#check_data_status').val() == 'Manager Not Approve') {

    //     $('#qmr_approve').css("display", "none");

    //     $('#dcc_approve').css("display", "none");

    //     $('.copy_dept').css("display","none");

    // }





$('#manager_approve').css("display","none");

$('#qmr_approve').css("display","none");

$('#smr_approve').css("display","none");

$('#dcc_approve_normal').css("display","none");

$('#dcc_approve_copydept').css("display","none");

$('#dcc_approve_cancel').css("display","none");



if ($('#check_data_status').val() == 'Open'){

     var checkDeptUser = $('#check_dc_dept_userlogin').val();
    var checkDeptOwner = $('#check_dc_dept_main_code').val();
    // $('#manager_approve').css("display","block");
    // if ($('#check_group').val() !== 'manager' && $('#check_group').val() !== 'superuser'){
    //     $('#manager_approve').css("display","none");
    // }

        if($('#check_group').val() == 'manager' && checkDeptUser == checkDeptOwner || $('#check_group').val() == 'superuser'){
            $('#manager_approve').css("display","");
        }






}else if($('#check_data_status').val() == 'Manager Approved'){

    $('#manager_approve').css("display","block");

    // Check ว่าเป็น SDS หรือไม่
    if($('#checksds').val() == 'sds'){
        $('#smr_approve').css("display","block");
    }else{
        $('#qmr_approve').css("display","block");
    }

    if ($('#check_group').val() !== 'manager' && $('#check_group').val() !== 'superuser' && $('#check_group').val() !== 'smr' && $('#check_group').val() !== 'qmr'){

        $('#qmr_approve').css("display","none");
        $('#smr_approve').css("display","none");

    }



}else if($('#check_data_status').val() == 'Qmr Approved' || $('#check_data_status').val() == 'Smr Approved'){

    $('#manager_approve').css("display","block");

    if($('#checksds').val() == 'sds'){
        $('#smr_approve').css("display","block");
    }else{
        $('#qmr_approve').css("display","block");
    }

  

    if($('#check_dc_data_reson').val() == "r-03"){

        $('#dcc_approve_copydept').css("display","block");

        if($('#check_group').val() !== 'manager' && $('#check_group').val() !== 'superuser'){

            $('#dcc_approve_copydept').css("display","none");

        }

    }else if($('#check_dc_data_reson').val() == "r-05"){

        $('#dcc_approve_cancel').css("display","block");

        if($('#check_group').val() !== 'manager' && $('#check_group').val() !== 'superuser'){

            $('#dcc_approve_cancel').css("display","none");

        }

    }else{

        $('#dcc_approve_normal').css("display","block");

        if($('#check_group').val() !== 'manager' && $('#check_group').val() !== 'superuser' && $('#check_group').val() !== 'document control'){

            $('#dcc_approve_normal').css("display","none");

        }

    }



}else if($('#check_data_status').val() == 'Complete'){

    $('#manager_approve').css("display","block");

    if($('#checksds').val() == 'sds'){
        $('#smr_approve').css("display","block");
    }else{
        $('#qmr_approve').css("display","block");
    }

    

    if($('#check_dc_data_reson').val() == "r-03"){

        $('#dcc_approve_copydept').css("display","block");

        $('.btncopydept').hide();

    }else if($('#check_dc_data_reson').val() == "r-05"){

        $('#dcc_approve_cancel').css("display","block");

        $('.btncancel').hide();

    }else{

        $('#dcc_approve_normal').css("display","block");

    }



}else if($('#check_data_status').val() == 'Manager Not Approve'){

    $('#manager_approve').css("display","block");



}else if($('#check_data_status').val() == 'Qmr Not Approve'){

    $('#manager_approve').css("display","block");

    $('#qmr_approve').css("display","block");

}



// Check status for control every thing : Check status for control every thing









//Hide edit btn

var userlogin = $('#check_userlogin').val();

var userowner = $('#check_dc_data_user').val();

if($('#check_data_status').val() == "Open" && userlogin == userowner){

    $('#btn_edit').css("display","inline");

}



if($('#check_gl_status').val() == "Open" && userlogin == userowner){

    $('#btn_edit_gl').css("display","inline");

    

}



$('#gl_doc_approve').css("display","none");

if($('#check_group').val() == 'superuser'){

    $('#gl_doc_approve').css("display","block");

}



if($('#check_gl_status').val() == "Approved" || $('#check_gl_status').val() == "Not Approve"){

    $('#gl_doc_approve').css("display","block");

}







//Check File size And File type

/*********************Check Upload File*********ADD DAR*******************************/

$('input[type=file][name=dc_data_file]').change(function () {/*********Add Page************/

    var ext = $('#dc_data_file').val().split('.').pop().toLowerCase();

//Allowed file types

    if ($.inArray(ext, ['pdf']) == -1) {

        alert('The file type is invalid!');

        $('#dc_data_file').val("");

    }

    if (this.files[0].size > 83886080) {

        alert("Maximum File size is 80MB !!");

        this.value = "";

        exit;

    }

});









//Check File size And File type

/*********************Check Upload File*********ADD DAR*******************************/

$('input[type=file][name=dc_data_file2]').change(function () {/*********Add Page************/

    var ext = $('#dc_data_file2').val().split('.').pop().toLowerCase();

//Allowed file types

    if ($.inArray(ext, ['pdf']) == -1) {

        alert('The file type is invalid!');

        $('#dc_data_file2').val("");

    }

    if (this.files[0].size > 83886080) {

        alert("Maximum File size is 80MB !!");

        this.value = "";

        exit;

    }

});





/*********************Check Upload File*********MASTER FILE*******************************/

$('input[type=file][name=document_master]').change(function () {/*********Add Page************/

    var ext = $('#document_master').val().split('.').pop().toLowerCase();

//Allowed file types

    if ($.inArray(ext, ['pdf']) == -1) {

        alert('The file type is invalid!');

        $('#document_master').val("");

    }

    if (this.files[0].size > 83886080) {

        alert("Maximum File size is 80MB !!");

        this.value = "";

        exit;

    }

});







/*********************Check Upload File*********COPY FILE*******************************/

$('input[type=file][name=document_copy]').change(function () {/*********Add Page************/

    var ext = $('#document_copy').val().split('.').pop().toLowerCase();

//Allowed file types

    if ($.inArray(ext, ['pdf']) == -1) {

        alert('The file type is invalid!');

        $('#document_copy').val("");

    }

    if (this.files[0].size > 83886080) {

        alert("Maximum File size is 80MB !!");

        this.value = "";

        exit;

    }

});









/*********************Check Upload File*********COPY FILE*******************************/

$('input[type=file][name=gl_doc_file]').change(function () {/*********Add Page************/

    var ext = $('#gl_doc_file').val().split('.').pop().toLowerCase();

//Allowed file types

    if ($.inArray(ext, ['pdf']) == -1) {

        alert('The file type is invalid!');

        $('#gl_doc_file').val("");

    }

    if (this.files[0].size > 83886080) {

        alert("Maximum File size is 80MB !!");

        this.value = "";

        exit;

    }

});





//Check File size And File type



$("#overlay").fadeOut(600);

$(".main-contain").removeClass("main-contain");











// Updata 29-11-2019

$('#dc_data_store').on("change" , function (){

    if($('#dc_data_store').val() == "ตลอดอายุการใช้งาน" || $('#dc_data_store').val() == "ไม่จัดเก็บ (เอกสารติดบรรจุภัณฑ์)"){

        $('#dc_data_store_type').prop("disabled" , true);

    }else{

        $('#dc_data_store_type').prop("disabled" , false);

    }

});




/////////////////////////////////////////////////////////////////////////////////
// Function แก้ไขระยะเวลาจัดเก็บ อัพเดตเพิ่มเติม อ้างอิง CSRO เลขที่ CSR6400060
/////////////////////////////////////////////////////////////////////////////////

$('#editDataStore').click(function(){
    const data_darcodeEdit = $(this).attr("data_darcodeEdit");
    const data_store = $(this).attr("data_store");
    const data_storeType = $(this).attr("data_storeType");

    $('#editDataStore_darcode').val(data_darcodeEdit);
});

$('#edit_dataStore').change(function(){
    if($('#edit_dataStore :selected').val() == "ตลอดอายุการใช้งาน" || $('#edit_dataStore :selected').val() == "ไม่จัดเก็บ (เอกสารติดบรรจุภัณฑ์)"){
        $('#edit_dataStoreType').prop('disabled' , true);
    }else{
        $('#edit_dataStoreType').prop('disabled' , false);
    }
});

$('#btn_saveEditDataStore').click(function(){
    saveEditDataStore();
});

if ($('#check_group').val() != "document control" && $('#check_group').val() != "superuser"){
    $('#editDataStore').css('display' , 'none');
}else{
    $('#editDataStore').css('display' , '');
}


/////////////////////////////////////////////////////////////////////////////////
// Function แก้ไขระยะเวลาจัดเก็บ อัพเดตเพิ่มเติม อ้างอิง CSRO เลขที่ CSR6400060
/////////////////////////////////////////////////////////////////////////////////

















});

// Ready function




// Function zone
function saveEditDataStore()
{
    $.ajax({
        url:"/intsys/doc_library/document/saveEditDataStore",
        method:"POST",
        data:$('#frm_editDataStore').serialize(),
        beforeSend:function(){

        },
        success:function(res){
            console.log(JSON.parse(res));
            location.reload();
        }
    });
}

































