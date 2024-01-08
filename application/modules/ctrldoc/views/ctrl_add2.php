<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เขียนคำร้องขอลงทะเบียนเอกสารควบคุม</title>
<?php
    $getuser = $this->login_model->getuser();
    $getfulldata = $get_fulldata->row();
    $getHashtag = $this->ctrldoc_model->getDctHashtag($getfulldata->dct_doccode);
?>
</head>

<body>


    <div class="app-main__outer">
        <div class="app-main__inner mb-5">
            <div class="container-fulid border p-4 bg-white">
                <!-- <h5 style="font-size:12px;text-align:right;"><?= getFormcode() ?></h5> -->
                <div class="row form-group">
                    <div class="col-md-6">
                        <!-- coding -->
                    </div>
                    <div class="col-md-6">
                        <h5 style="font-size:12px;text-align:right;"><b>Status :</b>&nbsp;<?= $getfulldata->dct_status; ?>
                            <input hidden type="text" name="check_data_status" id="check_data_status" value="<?= $getfulldata->dct_status; ?>">
                        </h5>
                    </div>
                </div>


                <form id="frm_uploadCtrlDoc">
                    <!-- Main Section -->
                    <h2 style="text-align:center;">ใบคำร้องเกี่ยวกับเอกสาร</h2>
                    <hr>

                    <div class="form-row">
                        <!-- Doc type loop -->
                        <div class="col-lg-2 col-md-6">
                            <label class="checkbox-inline">
                                <input checked type="checkbox" name="datatype-ctrl2" id="datatype-ctrl2" value="dc_type7" onclick="return false;" />&nbsp;Control Document
                            </label>
                        </div>
                        <!-- Doc type loop -->
                    </div>
                    <hr>

                    <!-- descript section -->
                    <h3 style="text-align:center;">Document Type and Description</h3>
                    <div class="row form-group">
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
                                    </div>
                                </div>
                                <!-- Doc Store -->
                            </div>

                        </div>
                        <!-- Right content -->
                    </div>
                    <!-- descript section -->


                    <!-- เหตุผลในการร้องขอ -->
                    <h3 class="p-2">เหตุผลในการร้องขอ</h3>
                    <div class="form-row">
                        <?php foreach ($get_reason->result_array() as $rs_reason) { ?>
                            <!-- Reason request loop -->
                            <?php
                                if ($rs_reason['dc_reason_code'] == "rt-01") {
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

                    <!-- Input text for other related dept-->
                    <div style="text-align:center;color:red;" class="mt-3 p-2 border">*กรุณาเลือกติ๊กถูกให้ครบถ้วน เพื่อเจ้าหน้าที่จะได้ดำเนินการได้อย่างทั่วถึง*</div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="">แฮชแท็ก : </label>
                            <?php
                            $hashtag_html = "";
                            foreach($getHashtag->result() as $rs){
                                $hashtag_html .='<a href="javascript:void(0)">'.$rs->dct_hashtag_name.' </a>';
                            }
                            echo $hashtag_html;
                            ?>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">อัพโหลดเอกสาร</label>
                            <input type="file" name="dataFile-ctrl2" id="dataFile-ctrl2" class="form-control" accept=".pdf">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" name="saveSec1-ctrl2" id="saveSec1-ctrl2" class="btn btn-primary">บันทึกข้อมูล</button>
                            <a href="<?=base_url('ctrldoc/ctrl_editsec1/').$darcode?>"><button type="button" name="editSec1-ctrl2" id="editSec1-ctrl2" class="btn btn-warning">แก้ไขเอกสาร</button></a>
                            <button type="button" name="cancelSec1-ctrl2" id="cancelSec1-ctrl2" class="btn btn-danger">ยกเลิกเอกสาร</button>
                        </div>
                    </div>
                    <hr>

                    <!-- check Darcode -->
                    <input hidden type="text" name="dataDarcode-ctrl2" id="dataDarcode-ctrl2" value="<?=$darcode?>">
     
                </form>
            </div>
        </div>
    </div>

</body>
</html>

<script>
    let url = "<?php echo base_url(); ?>";
    let darcode = "<?php echo $darcode; ?>";
    let doccode = "<?php echo $getfulldata->dct_doccode;?>";
    $(document).ready(function(){
        console.log(url);

        $(document).on('click' , '#saveSec1-ctrl' , function(e){
            e.preventDefault();
            save_ctrldocNew();
        });

        function save_ctrldocNew()
        {
            $('#saveSec1-ctrl2').prop('disabled' , true);
            //check Data null
            let datatype = $('input[name="datasubtype-ctrl"]:checked').map(function(){
                return this.value;
            }).get();
            if(datatype == ""){
                swal({
                    title: 'กรุณาเลือกประเภทเอกสาร',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else if($('#dataDocname-ctrl').val() == ""){
                swal({
                    title: 'กรุณากำหนดชื่อเอกสาร',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else if($('#dataDateStart-ctrl').val() == ""){
                swal({
                    title: 'กรุณาระบุวันที่เริ่มใช้งาน',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else if($('#dataReasonDetail-ctrl').val() == ""){
                swal({
                    title: 'กรุณาระบุเหตุผลของการร้องขอ',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else if($('#hashtag_ctrldoc').val() == ""){
                swal({
                    title: 'กรุณาระบุ Hashtag',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                });
            }else{
                const form = $('#form1_ctrl')[0];
                const data = new FormData(form);
                axios.post(url+'ctrldoc/ctrldoc/save_ctrldocNew',data , {
                    header:{
                        'Content-Type' : 'multipart/form-data'
                    },
                }).then(res=>{
                    console.log(res.data);
                    $('#saveSec1-ctrl2').prop('disabled' , false);
                    if(res.data.status == "Insert Data Success"){
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer:1000
                        }).then(function(){
                            location.href = url;
                        });
                    }else{
                        swal({
                            title: 'พบข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง',
                            type: 'error',
                            showConfirmButton: false,
                            timer:1000
                        });
                    }
                });
            }

        }

        $('#dataDept-ctrl2 option:not(:selected)').remove();

        $(document).on('click' , '#cancelSec1-ctrl2' , function(){
            swal({
                title: 'ต้องการยกเลิกเอกสารเลขที่ '+darcode+' ใช่หรือไม่',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'ใช่',
                cancelButtonText:'ไม่ใช่'
            }).then((result)=> {
                if(result.value == true){
                    //cancel function
                    cancelCtrlDoc(darcode , doccode);
                }
                
            });
        });

        function cancelCtrlDoc(darcode , doccode)
        {
            if(darcode !== ""){
                axios.post(url+'ctrldoc/ctrldoc/cancelCtrlDoc' , {
                    action:'cancelCtrlDoc',
                    darcode:darcode,
                    doccode:doccode
                }).then(res=>{
                    console.log(res.data);
                    if(res.data.status == "Update Data Success"){
                        swal({
                            title: 'ยกเลิกเอกสารเรียบร้อย',
                            type: 'success',
                            showConfirmButton: false,
                            timer:1000
                        }).then(function(){
                            location.href = url+'ctrldoc/list_docctrl';
                        });
                    }
                });
            }
        }

        $(document).on('click' , '#saveSec1-ctrl2' , function(e){
            e.preventDefault();
            saveUploadCtrlDoc();
        });
        function saveUploadCtrlDoc()
        {
            $('#saveSec1-ctrl2').prop('disabled' , true);

            const form = $('#frm_uploadCtrlDoc')[0];
            const data = new FormData(form);
            axios.post(url+'ctrldoc/ctrldoc/saveUploadCtrlDoc' , data , {
                header:{
                    'Content-Type' : 'multipart/form-data'
                },
            }).then(res=>{
                console.log(res.data);
                $('#saveSec1-ctrl2').prop('disabled' , false);
                if(res.data.status == "Update Data Not Success"){
                    swal({
                        title: 'อัพโหลดไฟล์ไม่สำเร็จ',
                        type: 'error',
                        showConfirmButton: false,
                        timer:1000
                    });
                }else{
                    swal({
                        title: 'อัพโหลดไฟล์สำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer:1000
                    }).then(function(){
                        location.href = url+'ctrldoc/list_docctrl';
                    });
                }
            })
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