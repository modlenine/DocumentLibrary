<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หน้าแสดง รายการใบคำร้องเอกสารควบคุม</title>
    <!-- Title -->
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <link href="<?php echo base_url('css/datepicker.css'); ?>" rel="stylesheet" type="text/css" media="screen" />

<style>
.radiosize{
    width:18px !important;
    height:18px !important;
    margin-right:5px;
}
.editDatastore_ctrl{
    color:#FF6600;
    font-size:18px;
    position:absolute;
    right:10px;
    top:10px;
    transition:transform .2s;
}
.editDatastore_ctrl:hover{
    transform:scale(1.2);
    cursor:pointer;
}
</style>


</head>


<?php
    $getuser = $this->login_model->getuser();
    $getfulldata = $get_fulldata->row();
    $getHashtag = $this->ctrldoc_model->getDctHashtag($getfulldata->dct_doccode);
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">

            <!-- Content Zone -->
            <div class="container-fulid border p-2 bg-white mb-2">
                <a href="<?= base_url('document/list_dar') ?>"><button class="btn btn-secondary"><i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;กลับ</button></a>

                <a href="<?= base_url('document/edit_dar/') ?><?=$darcode?>"><input style="display:none;" type="button" name="btn_edit" id="btn_edit" class="btn btn-info" value="แก้ไข" /></a>
            </div><br>

            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <h5 style="font-size:12px;text-align:right;"><?= selectFormcode($darcode) ?></h5>
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?=base_url('ctrldoc/print_ctrldoc/').$darcode?>" target="_blank">
                            <!-- <input type="submit" name="btn_print" id="btn_print" class="btn btn-info" value="ปริ้น" /> -->
                            <button type="submit" name="btn_print" id="btn_print" class="btn btn-info"><i class="fas fa-print"></i>&nbsp;Print</button>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <h5 style="font-size:12px;text-align:right;"><b>Status :</b>&nbsp;<?= $getfulldata->dct_status; ?>
                        <input hidden type="text" name="check_data_status" id="check_data_status" value="<?= $getfulldata->dct_status; ?>">
                        </h5>

                    </div>

                </div>

                <h2 style="text-align:center;">ใบคำร้องเกี่ยวกับเอกสาร</h2>
                <h4 style="text-align:center;">เลขที่เอกสาร : <?=$getfulldata->dct_darcode?></h4>
                <hr>

                <!-- Form Section 1 -->

                    <!-- Form Section 1 -->
                    <section>
                        <!-- Document type Section -->
                        <div class="form-row">
                            <!-- Doc type loop -->
                            <div class="col-lg-2 col-md-6">
                                <label class="checkbox-inline">
                                    <input checked type="checkbox" name="datatype-ctrl2" id="datatype-ctrl2" value="dc_type7" onclick="return false;" />&nbsp;Control Document
                                </label>
                            </div>
                            <!-- Doc type loop -->
                        </div>
                        <!-- Document type Section -->
                    </section>

                    <hr>

                    <section>
                        <!-- descript section -->
                        <h3 style="text-align:center;">Document Type and Description</h3>
                        <div class="form-row">
                            <!-- Left content -->
                            <div class="col-sm-6 border">
                                <?php foreach ($get_doc_sub_type->result_array() as $doc_sub_type) { 
                                    $resultCheckDctSub = checkDctSubtype($darcode)->row();
                                    $checkDctSubtype = "";
                                    if($resultCheckDctSub->dct_subtype == $doc_sub_type['dct_subtype_code']){
                                        $checkDctSubtype = "checked";
                                    }
                                ?>

                                    <!-- Get doc sub type loop -->
                                    <label class="checkbox-inline col-sm-12 p-2">
                                        <input <?=$checkDctSubtype?> required type="radio" name="datasubtype-ctrl2" id="datasubtype-ctrl2" value="<?php echo $doc_sub_type['dct_subtype_code']; ?>" onclick="return false">&nbsp;<?php echo $doc_sub_type['dct_subtype_name']; ?></label>
                                    <!-- Get doc sub type loop -->
                                <?php }; ?>
                            </div>
                            <!-- Left content -->

                            <!-- Right content -->
                            <div class="col-sm-6 border p-2">
                                <div class="row mb-2">
                                    <!-- Date request -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="text-center">วันที่ร้องขอ :&nbsp;</label><i class="fas fa-calendar-alt" style="font-size:18px;"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="input-medium form-control datepicker" data-value="<?=$getfulldata->dct_date?>" type="date" placeholder="วว/ดด/ปปปป" name="dataDate-ctrl2" id="dataDate-ctrl2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Date request -->

                                <!-- User Request -->
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">ผู้ร้องขอ :</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input readonly type="text" name="datauser-ctrl2" id="datauser-ctrl2" value="<?= $getfulldata->dct_user; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- User Request -->
                                </div>


                                <div class="row mb-2">
                                    <!-- Department -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">แผนก :</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select readonly name="dataDept-ctrl2" id="dataDept-ctrl2" class="form-control" onclick="return false">
                                                    <?php
                                                        foreach ($get_dept->result_array() as $rs_gd) {
                                                            $selectedDept = "";
                                                            if($getfulldata->dct_dept == $rs_gd['dc_dept_code']){
                                                                $selectedDept = "selected";
                                                            }

                                                            echo "<option ".$selectedDept." value='" . $rs_gd['dc_dept_code'] . "'>" . $rs_gd['dc_dept_main_name'] . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Department -->


                                <!-- Document name -->
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">ชื่อเอกสาร :</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input readonly type="text" name="dataDocname-ctrl2" id="dataDocname-ctrl2" value="<?=$getfulldata->dct_docname?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Document name -->
                                </div>


                                <div class="row mb-2">
                                    <!-- Doccode -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">รหัสเอกสาร :</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input readonly type="text" name="dataDoccode-ctrl2" id="dataDoccode-ctrl2" class="form-control" value="<?=$getfulldata->dct_doccode?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Doccode -->



                                <!-- Doc Edit -->
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">ครั้งที่แก้ไข :</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input readonly type="number" name="dataEdit-ctrl2" id="dataEdit-ctrl2" class="form-control" value="<?=$getfulldata->dct_editcount?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Doc Edit -->
                                </div>


                                <div class="row mb-2">
                                    <!-- Date Start -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">วันที่เริ่มใช้ :</label>&nbsp;<i class="fas fa-calendar-alt" style="font-size:18px;"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="input-medium form-control datepicker" type="date" placeholder="วว/ดด/ปปปป" name="dataDateStart-ctrl2" id="dataDateStart-ctrl2" data-value="<?=$getfulldata->dct_datestart?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Date Start -->
                                </div>


                                <div class="row">
                                    <!-- Doc Store -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="">ระยะเวลาการจัดเก็บ :</label>
                                            </div>
                                            <div class="col-md-8 form-inline">
                                                <input readonly class="form-control" type="text" name="dataStore-ctrl2" id="dataStore-ctrl2" value="<?=$getfulldata->dct_store?>">
                                                <input readonly class="form-control" type="text" name="dataStoreType-ctrl2" id="dataStoreType-ctrl2" value="<?=$getfulldata->dct_store_type?>">
                                            </div>
                                            <i class="fas fa-edit editDatastore_ctrl" style="margin-left:5px;" data_darcodeedit="<?=$darcode?>" data_store="<?=$getfulldata->dct_store?>" data_storetype="<?=$getfulldata->dct_store_type?>" data-toggle="modal" data-target="#editDataStoreCtrlModal"></i>
                                        </div>
                                    </div>
                                    <!-- Doc Store -->
                                </div>

                            </div>
                            <!-- Right content -->
                        </div>
                        <!-- descript section -->
                    </section>

                    <!-- เหตุผลในการร้องขอ -->
                    <h3 class="p-2">เหตุผลในการร้องขอ</h3>
                    <div class="form-row">
                        <?php foreach ($get_reason->result_array() as $rs_reason) { ?>
                            <!-- Reason request loop -->
                            <?php
                                if ($rs_reason['dc_reason_code'] == $getfulldata->dct_reson) {
                                    $checked = ' checked="" ';
                                } else {
                                    $checked = '';
                                }
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                <label class="checkbox-inline"><input <?= $checked ?> type="radio" name="dataReason-ctrl" id="dataReason-ctrl" value="<?php echo $rs_reason['dc_reason_code']; ?>" onclick="return false" />&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
                            </div>
                            <!-- Reason request loop -->
                        <?php }; ?>
                    </div>

                    <div class="form-row pt-3">
                        <textarea readonly name="dataReasonDetail-ctrl" id="dataReasonDetail-ctrl" cols="30" rows="5" class="form-control"><?=$getfulldata->dct_reson_detail?></textarea>
                    </div>
                    <div style="text-align:center;color:red;" class="mt-3 p-2 border">*กรุณาให้เหตุผลในการร้องขอทุกครั้ง เพื่อบันทึกเป็นหลักฐานในประวัติการแก้ไข*</div>
                    <hr>
                    <!-- เหตุผลในการร้องขอ -->


                    <!-- หน่วยงานที่เกี่ยวข้อง -->
                    <h3 class="p2 mb-3">หน่วยงานที่เกี่ยวข้อง</h3>
                    <div class="form-row">
                        <?php foreach ($get_related_dept->result_array() as $rs_related_dept) { ?>
                            <!-- Related dept loop -->
                            <!-- Check Login newdeptcode -->
                            <?php
                            $checked = '';
                            if ($rs_related_dept['related_code'] == getUserN($getuser->ecode)->dc_user_new_dept_code) {
                                $checked = ' checked="" ';
                            }
                            ?>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <label class="checkbox-inline">
                                    <input <?= $checked ?> class="related_dept" type="checkbox" name="relatedDeptcode-ctrl[]" id="relatedDeptcode-ctrl" value="<?php echo $rs_related_dept['related_code']; ?>" checked onclick="return false"/>
                                    &nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>
                            </div>
                            <!-- Related dept loop -->
                        <?php }; ?>
                    </div>
                    <!-- หน่วยงานที่เกี่ยวข้อง -->


                    <!-- Input text for other related dept-->
                    <div style="text-align:center;color:red;" class="mt-3 p-2 border">*กรุณาเลือกติ๊กถูกให้ครบถ้วน เพื่อเจ้าหน้าที่จะได้ดำเนินการได้อย่างทั่วถึง*</div>
                    <div class="form-row mt-2">
                        <div class="form-group">
                            <label for=""><b>อัพโหลดไฟล์เอกสาร</b></label><br>
                            <!-- <input type="file" name="dc_data_file" id="dc_data_file" class="form-control"> -->
                            <label for="">
                                <a id="dc_data_file" href="<?= base_url() ?><?= $getfulldata->dct_file_location . $getfulldata->dct_file; ?>#toolbar=0" target="_blank"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $getfulldata->dct_file; ?></a>
                            </label>
                            <!-- Upload file -->
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for=""><b>แฮชแท็ก : </b></label>
                            <?php
                            $hashtag_html = "";
                            foreach($getHashtag->result() as $rs){
                                $hashtag_html .='<a href="javascript:void(0)">'.$rs->dct_hashtag_name.' </a>';
                            }
                            echo $hashtag_html;
                            ?>
                        </div>
                    </div>
                <!-- Form Section 1 -->
                <hr>

                <div id="dcc_ctrldoc_approve">
                    <!-- ผลการร้องขอ -->
                    <h3 class="p2 mb-3">ผลการอนุมัติ จากเจ้าหน้าที่</h3>
                    <form id="frm_saveDccCtrldocApprove" autocomplete="off" class="needs-validation" novalidate>
                        <!-- Check Deptcode Manager -->

                        <?php
                            $approveTypeChecked1 = "";
                            $approveTypeChecked2 = "";
                            if($getfulldata->dct_result_reson_status == "อนุมัติ"){
                                $approveTypeChecked1 = "checked";
                            }else if($getfulldata->dct_result_reson_status == "ไม่อนุมัติ"){
                                $approveTypeChecked2 = "checked";
                            }

                            $userapprove = "";
                            $dateapprove = "";
                            $onclickFalse = "";
                            $readonly = "";
                            $appBtn = "";
                            if($getfulldata->dct_result_reson_status != ""){
                                $userapprove = $getfulldata->dct_userapprove;
                                $dateapprove = con_date($getfulldata->dct_datetimeapprove);
                                $onclickFalse = 'onclick="return false"';
                                $readonly = "readonly";
                                $appBtn = 'style="display:none;"';
                            }else{
                                $userapprove = $getuser->username;
                                $dateapprove = date("m/d/Y");
                            }
                        ?>

                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="">
                                    <input required <?=$approveTypeChecked1?> type="radio" class="radiosize" name="dct_approveType" id="dct_approveType1" value="อนุมัติ" <?=$onclickFalse?>>อนุมัติ
                                </label>
                                <label for="">
                                    <input required <?=$approveTypeChecked2?> type="radio" class="radiosize ml-4" name="dct_approveType" id="dct_approveType2" value="ไม่อนุมัติ" <?=$onclickFalse?>>ไม่อนุมัติ
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-8">
                                <textarea <?=$readonly?> required name="dct_approveReason" id="dct_approveReason" cols="30" rows="5" class="form-control mt-3" placeholder="เหตุผลในการอนุมัติ"><?= $getfulldata->dct_result_reson_detail; ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12 form-group">
                                        <label for=""><b>ผู้อนุมัติ</b></label>
                                        <input type="text" name="dct_approveUsername" id="dct_approveUsername" class="form-control" value="<?=$userapprove?>" readonly>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for=""><b>วันที่อนุมัติ :</b></label>
                                        <input type="text" name="dct_approveDate" id="dct_approveDate" class="form-control" value="<?=$dateapprove?>" readonly>
                                    </div>

                                    <div class="col-md-12 form-group" <?=$appBtn?>>
                                        <input type="submit" value="บันทึก" class="btn btn-primary mt-2 btn-block" name="btn_dctApproveDcc" id="btn_dctApproveDcc">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Get Darcode , Doccode -->
                        <input hidden type="text" name="dct_approveDarcode" id="dct_approveDarcode" value="<?=$darcode?>">
                        <input hidden type="text" name="dct_approveDoccode" id="dct_approveDoccode" value="<?=$getfulldata->dct_doccode?>">
                        <input hidden type="text" name="dct_approve_olddar" id="dct_approve_olddar" value="<?=$getfulldata->dct_olddar?>">
                        <input hidden type="text" name="dct_approve_reson" id="dct_approve_reson" value="<?=$getfulldata->dct_reson?>">

                    </form>
                    <hr>
                    <!-- ผลการร้องขอ -->
                </div>


            </div><!-- Main Section -->

        </div><!-- Content Zone -->
    </div><!-- Content Zone -->
</body>

<script>
    const url = "<?php echo base_url(); ?>";
    $(document).ready(function(){

        $(document).on('click' , '.editDatastore_ctrl' , function(){
            const editDataStoreCtrl_darcode = $(this).attr("data_darcodeedit");
            $('#editDataStoreCtrl_darcode').val(editDataStoreCtrl_darcode);
        });

        $(document).on('click' , '#btn_saveEditDataStoreCtrl' , function(){
            // console.log($('#edit_dataStoreTypeCtrl').val());
            // console.log($('#edit_dataStoreCtrl').val());
            saveEditDataStoreCtrl();
        });
        function saveEditDataStoreCtrl()
        {
            axios.post(url+'ctrldoc/ctrldoc/saveEditDataStoreCtrl' , {
                action:"saveEditDataStoreCtrl",
                datastore:$('#edit_dataStoreCtrl').val(),
                datastoretype:$('#edit_dataStoreTypeCtrl').val(),
                darcode:$('#editDataStoreCtrl_darcode').val()
            }).then(res=>{
                console.log(res.data);
                if(res.data.status == "Update Data Success"){
                    location.reload();
                }
            });
        }

        $('#btn_dctApproveDcc').on('click' , function(e){
            e.preventDefault();
            if($('input:radio[name="dct_approveType"]:checked').length == 0){
                swal({
                    title: 'กรุณาเลือกประเภทการอนุมัติ',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else if($('#dct_approveReason').val() == ""){
                swal({
                    title: 'กรุณาระบุเหตุผลในการร้องขอ',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else{
                saveDccApprove();
            }
        })

        function saveDccApprove()
        {
            $('#btn_dctApproveDcc').prop('disabled' , true);
            const form = $('#frm_saveDccCtrldocApprove')[0];
            const data = new FormData(form);

            axios.post(url+'ctrldoc/ctrldoc/saveDccApprove' , data).then(res=>{
                console.log(res.data);
                $('#btn_dctApproveDcc').prop('disabled' , false);
                if(res.data.status == "Update Data Success"){
                    swal({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer:1000
                    }).then(function(){
                        location.href = url+'ctrldoc/list_docctrl';
                    });
                }else{
                    swal({
                        title: 'บันทึกข้อมูลไม่สำเร็จ',
                        type: 'error',
                        showConfirmButton: false,
                        timer:1000
                    });
                }
            });
        }
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

</html>