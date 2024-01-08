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
                <form name="form1_ctrledit" id="form1_ctrledit" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                    <!-- Main Section -->
                    <!-- <h5 style="font-size:12px;text-align:right;"><?= getFormcode() ?></h5> -->
                    <h2 style="text-align:center;">แก้ไข ใบคำร้องเกี่ยวกับเอกสาร</h2>
                    <hr>

                    <div class="form-row">
                            <!-- Doc type loop -->
                            <div class="col-lg-2 col-md-6">
                                <label class="checkbox-inline">
                                    <input checked type="checkbox" name="datatype-ctrlEdit" id="datatype-ctrlEdit" value="dc_type7" onclick="return false;" />&nbsp;Control Document
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
                            <?php foreach ($get_subtype->result_array() as $doc_sub_type) { 
                                $resultCheckDctSub = checkDctSubtype($darcode)->row();
                                $checkDctSubtype = "";
                                if($resultCheckDctSub->dct_subtype == $doc_sub_type['dct_subtype_code']){
                                    $checkDctSubtype = "checked";
                                }
                            ?>

                                <!-- Get doc sub type loop -->
                                <label class="checkbox-inline col-sm-12 p-2">
                                    <input <?=$checkDctSubtype?> required type="radio" name="datasubtype-ctrlEdit" id="datasubtype-ctrlEdit" value="<?php echo $doc_sub_type['dct_subtype_code']; ?>">&nbsp;<?php echo $doc_sub_type['dct_subtype_name']; ?></label>
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
                                            <input required class="input-medium form-control datepicker" data-value="<?=$getfulldata->dct_date?>" type="date" placeholder="วว/ดด/ปปปป" name="dataDate-ctrlEdit" id="dataDate-ctrlEdit">
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
                                            <input readonly type="text" name="datauser-ctrlEdit" id="datauser-ctrlEdit" value="<?= $getfulldata->dct_user; ?>" class="form-control">
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
                                            <select name="dataDept-ctrlEdit" id="dataDept-ctrlEdit" class="form-control">
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
                                            <input required type="text" name="dataDocname-ctrlEdit" id="dataDocname-ctrlEdit" value="<?=$getfulldata->dct_docname?>" class="form-control">
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
                                            <input readonly type="text" name="dataDoccode-ctrlEdit" id="dataDoccode-ctrlEdit" class="form-control" value="<?=$getfulldata->dct_doccode?>">
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
                                            <input readonly type="number" name="dataEdit-ctrlEdit" id="dataEdit-ctrlEdit" value="<?=$getfulldata->dct_editcount?>" class="form-control">
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
                                            <input required class="input-medium form-control datepicker" type="date" placeholder="วว/ดด/ปปปป" name="dataDateStart-ctrlEdit" id="dataDateStart-ctrlEdit" data-value="<?=$getfulldata->dct_datestart?>">
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
                                            <select required name="dataStore-ctrlEdit" id="dataStore-ctrlEdit" class="form-control">
                                                <?php foreach (get_dcdatastore() as $rsGetDcStore) {
                                                    $dataStoreSelect = "";
                                                    if($getfulldata->dct_store == $rsGetDcStore['dc_datastore_name']){
                                                        $dataStoreSelect = "selected";
                                                    }
                                                    echo "<option ".$dataStoreSelect." value='" . $rsGetDcStore['dc_datastore_name'] . "'>" . $rsGetDcStore['dc_datastore_name'] . "</option>";
                                                } ?>

                                            </select>
                                            <select required name="dataStoreType-ctrlEdit" id="dataStoreType-ctrlEdit" class="form-control">
                                                <?php 
                                                    $dataStoreType1 = "";
                                                    $dataStoreType2 = "";
                                                    if($getfulldata->dct_store_type == "ปี"){
                                                        $dataStoreType1 = "selected";
                                                    }else if($getfulldata->dct_store_type == "เดือน"){
                                                        $dataStoreType2 = "selected";
                                                    }
                                                ?>
                                                <option <?=$dataStoreType1?> value="ปี">ปี</option>
                                                <option <?=$dataStoreType2?> value="เดือน">เดือน</option>
                                            </select>
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
                                <label class="checkbox-inline"><input required <?= $checked ?> type="radio" name="dataReason-ctrlEdit" id="dataReason-ctrlEdit" value="<?php echo $rs_reason['dc_reason_code']; ?>" onclick="return false" />&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
                            </div>
                            <!-- Reason request loop -->
                        <?php }; ?>
                    </div>

                    <div class="form-row pt-3">
                        <textarea required name="dataReasonDetail-ctrlEdit" id="dataReasonDetail-ctrlEdit" cols="30" rows="5" class="form-control"><?=$getfulldata->dct_reson_detail?></textarea>
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
                                    <input <?= $checked ?> class="related_dept" type="checkbox" name="relatedDeptcode-ctrlEdit[]" id="relatedDeptcode-ctrlEdit" value="<?php echo $rs_related_dept['related_code']; ?>" checked onclick="return false"/>
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

                    <!-- <div class="form-row">
                        <div class="form-group col-md-6 mt-2">
                            <input type="text" name="hashtag_ctrldoc[]" id="hashtag_ctrldoc" class="form-control" placeholder="กรุณาระบุ Hashtag เช่น #คู่มือการใช้งาน" required maxlength="40"/>
                            <label id="characterLeft"></label><br>
                            <button type="button" name="dar_addmore" id="dar_addmore" class="btn btn-primary mt-2 dar_addmore"><i class="fas fa-hashtag"></i>&nbsp;เพิ่ม Hashtag</button>
                        </div>
                    </div> -->

                    <!-- check Darcode -->
                    <input hidden type="text" name="darcode-ctrlEdit" id="darcode-ctrlEdit" value="<?=$darcode?>">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <button type="submit" name="saveSec1-ctrlEdit" id="saveSec1-ctrlEdit" class="btn btn-primary">บันทึกการแก้ไขข้อมูล</button>
                        </div>
                    </div>
                    <hr>
                </form>
                
            </div>
        </div>
    </div>

</body>
</html>

<script>
    let url = "<?php echo base_url(); ?>";
    $(document).ready(function(){
        console.log(url);

        $(document).on('click' , '#saveSec1-ctrlEdit' , function(e){
            e.preventDefault();
            $('#saveSec1-ctrlEdit').prop('disabled' , true);
            save_ctrldocEdit();
        });

        function save_ctrldocEdit()
        {
            $('#saveSec1-ctrlEdit').prop('disabled' , true);
            //check Data null
            let datatype = $('input[name="datasubtype-ctrlEdit"]:checked').map(function(){
                return this.value;
            }).get();
            if(datatype == ""){
                swal({
                    title: 'กรุณาเลือกประเภทเอกสาร',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                }).then(function(){
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
                });
            }else if($('#dataDate-ctrlEdit').val() == ""){
                swal({
                    title: 'กรุณากำหนดวันที่ร้องขอ',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                }).then(function(){
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
                });
            }else if($('#dataDocname-ctrlEdit').val() == ""){
                swal({
                    title: 'กรุณากำหนดชื่อเอกสาร',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                }).then(function(){
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
                });
            }else if($('#dataDateStart-ctrlEdit').val() == ""){
                swal({
                    title: 'กรุณาระบุวันที่เริ่มใช้งาน',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                }).then(function(){
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
                });
            }else if($('#dataReasonDetail-ctrlEdit').val() == ""){
                swal({
                    title: 'กรุณาระบุเหตุผลของการร้องขอ',
                    type: 'error',
                    showConfirmButton: false,
                    timer:1000
                }).then(function(){
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
                });
            }else{
                const form = $('#form1_ctrledit')[0];
                const data = new FormData(form);
                axios.post(url+'ctrldoc/ctrldoc/ctrl_saveEditsec1',data , {
                    header:{
                        'Content-Type' : 'multipart/form-data'
                    },
                }).then(res=>{
                    console.log(res.data);
                    $('#saveSec1-ctrlEdit').prop('disabled' , false);
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
                            title: 'พบข้อผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง',
                            type: 'error',
                            showConfirmButton: false,
                            timer:1000
                        }).then(function(){
                            $('#saveSec1-ctrlEdit').prop('disabled' , false);
                        });
                    }
                });
            }

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