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

            </div><br>

            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <h5 style="font-size:12px;text-align:right;"><?=$getfulldata->dct_formcode?></h5>
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
                    <section>
                        <!-- เหตุผลในการร้องขอ -->
                        <h3 class="p-2">เหตุผลในการร้องขอ</h3>
                        <div class="form-row">
                            <?php foreach ($get_reason->result_array() as $rs_reason) { ?>
                                <!-- Reason request loop -->
                                <?php
                                if ($getfulldata->dct_reson == $rs_reason['dc_reason_code']) {
                                    $checked = ' checked="" ';
                                } else {
                                    $checked = '';
                                }
                                ?>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                    <label class="checkbox-inline"><input <?= $checked; ?> type="radio" name="dc_data_reson" id="dc_data_reson" value="<?php echo $rs_reason['dc_reason_code']; ?>" disabled />&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
                                </div>
                                <!-- Reason request loop -->
                            <?php }; ?>
                        </div>

                        <div class="form-row pt-3">
                            <textarea name="dc_data_reson_detail" id="dc_data_reson_detail" cols="30" rows="5" class="form-control" disabled><?= $getfulldata->dct_reson_detail; ?></textarea>
                        </div>
                        <div style="text-align:center;color:red;" class="mt-3 p-2 border">*กรุณาให้เหตุผลในการร้องขอทุกครั้ง เพื่อบันทึกเป็นหลักฐานในประวัติการแก้ไข*</div>
                    </section>
                    <hr>
                    <!-- เหตุผลในการร้องขอ -->


                    <!-- หน่วยงานที่เกี่ยวข้อง -->
                    <section>
                        <h3 class="p2 mb-3">หน่วยงานที่เกี่ยวข้อง</h3>
                        <div class="form-row">
                            <?php foreach ($get_related_dept->result_array() as $rs_related_dept) { ?>
                                <!-- Related dept loop -->
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <label class="checkbox-inline"><input checked class="related_dept" type="checkbox" name="related_dept_code[]" id="related_dept_code" value="<?php echo $rs_related_dept['related_code']; ?>" disabled />&nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>
                                </div>
                                <!-- Related dept loop -->
                            <?php }; ?>
                        </div>
                    </section>
                    <!-- หน่วยงานที่เกี่ยวข้อง -->


                    <!-- Input text for other related dept-->
                    <div style="text-align:center;color:red;" class="mt-3 p-2 border">*กรุณาเลือกติ๊กถูกให้ครบถ้วน เพื่อเจ้าหน้าที่จะได้ดำเนินการได้อย่างทั่วถึง*</div>
                    


                    <!-- <div class="form-row mt-2">
                        <div class="col-md-12">
                            <label>แฮชแท็ก :</label>
                            <?php
                            $get_hashtag = get_hashtag_iso($getF->dc_data_doccode);
                            foreach ($get_hashtag->result_array() as $ght) {
                                echo "<a href='#'><label>" . $ght['li_hashtag_name'] . "&nbsp;&nbsp;</label></a>";
                            }
                            ?>
                        </div>
                    </div> -->
                <!-- Form Section 1 -->

                <div id="manager_approve">
                    <!-- ผลการร้องขอ -->
                    <h3 class="p2 mb-3"><?= label("request_stat", $this); ?>&nbsp;<?= label('managerapprove', $this) ?></h3>
                    <form action="<?= base_url('document/save_sec2/' . $getF->dc_data_darcode); ?>" method="POST" name="">
                        <input hidden type="text" name="check_dc_dept_userlogin" id="check_dc_dept_userlogin" value="<?=$getuser->DeptCode?>">
                        <input hidden type="text" name="check_dc_dept_main_code" id="check_dc_dept_main_code" value="<?=$getF->dc_dept_main_code?>">
                        <!-- Check Deptcode Manager -->
                        <div class="form-row">
                            <?php
                            if ($getF->dc_data_result_reson_status == "") {   ?>

                                <div><label for=""><input type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <div><label for=""><input type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                            <?php

                            } else {
                                if ($getF->dc_data_result_reson_status == 1) { ?>
                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php

                                } else { ?>

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php
                                }
                            }
                            ?>
                            <textarea name="dc_data_result_reson_detail" id="dc_data_result_reson_detail" cols="30" rows="5" class="form-control" placeholder="<?= label('text_result_request', $this); ?>"><?= $getF->dc_data_result_reson_detail; ?></textarea>

                        </div>



                        <div class="form-row mt-3">
                            <div class="col-md-9 border p-5">
                                <label style="color:red;"><?= label('memo3', $this); ?> :&nbsp;</label><label for=""><?= label('memo4', $this); ?></label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""><?= label("approvers", $this); ?></label>
                                    <?php
                                    $mgrDateApprove = "";
                                    if ($getF->dc_data_approve_mgr == "") {
                                        $mgrDateApprove = "";
                                    ?>
                                        <input type="text" class="form-control" name="dc_data_approve_mgr" id="dc_data_approve_mgr" value="<?= $getuserCon; ?>">
                                    <?php
                                    } else {
                                        $mgrDateApprove = conDateFromDb($getF->dc_data_date_approve_mgr);
                                    ?>
                                        <input disabled type="text" class="form-control" name="dc_data_approve_mgr" id="dc_data_approve_mgr" value="<?= $getF->dc_data_approve_mgr; ?>">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="">วันที่ :</label>
                                    <input type="text" name="dc_data_date_approve_mgr" id="dc_data_date_approve_mgr" class="form-control" value="<?= $mgrDateApprove; ?>" readonly>
                                    <input type="submit" value="<?= label('save', $this); ?>" class="btn btn-primary mt-2" name="btnSave_sec2" id="btnSave_sec2">
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <!-- ผลการร้องขอ -->
                </div>


                <!-- ผลการร้องขอ -->
                <div id="qmr_approve">
                    <h3 class="p2 mb-3"><?= label("request_stat", $this); ?>&nbsp;<?= label('qmrapprove', $this) ?></h3>
                    <form action="<?= base_url('document/save_sec3/' . $getF->dc_data_darcode); ?>" method="POST" name="">
                        <div class="form-row">
                            <?php
                            if ($getF->dc_data_result_reson_status2 == "") {   
                            ?>
                                <div><label for=""><input type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div><label for=""><input type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                            <?php
                            } else {
                                if ($getF->dc_data_result_reson_status2 == 1) { 
                                    ?>
                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php
                                } else { 
                                    ?>

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php
                                }
                            }
                            ?>

                            <textarea name="dc_data_result_reson_detail2" id="dc_data_result_reson_detail2" cols="30" rows="5" class="form-control" placeholder="<?= label('text_result_request', $this); ?>"><?= $getF->dc_data_result_reson_detail2; ?></textarea>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-9 border p-5">
                                <label style="color:red;"><?= label('memo3', $this); ?> :&nbsp;</label><label for=""><?= label('memo4', $this); ?></label>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""><?= label("approvers", $this); ?></label>
                                        <?php
                                        $dataDateApproveQmr= "";
                                    if ($getF->dc_data_approve_qmr == "") {
                                        $dataDateApproveQmr= "";
                                        ?>
                                        <input type="text" class="form-control" name="dc_data_approve_qmr" id="dc_data_approve_qmr" value="<?= $getuserCon; ?>">
                                        <?php
                                    } else {
                                        $dataDateApproveQmr= conDateFromDb($getF->dc_data_date_approve_qmr);
                                        ?>
                                        <input disabled type="text" class="form-control" name="dc_data_approve_qmr" id="dc_data_approve_qmr" value="<?= $getF->dc_data_approve_qmr; ?>">
                                        <?php
                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label for="">วันที่ :</label>
                                    <input type="text" name="dc_data_date_approve_qmr" id="dc_data_date_approve_qmr" class="form-control" value="<?=$dataDateApproveQmr?>" readonly>
                                    <input type="submit" value="<?= label('save', $this); ?>" class="btn btn-primary mt-2" name="btnSave_sec3" id="btnSave_sec3">
                                </div>


                            <!-- ผลการร้องขอ -->
                            </div>

                        </div>
                    </form>
                    <hr>
                </div>
                <!-- ผลการร้องขอ -->


                <!-- ผลการร้องขอ -->
                <div id="smr_approve">
                    <h3 class="p2 mb-3">ผลการร้องขอ จาก SMR</h3>
                    <form action="<?= base_url('document/save_sec3smr/' . $getF->dc_data_darcode); ?>" method="POST" name="">
                        <div class="form-row">
                            <?php
                            if ($getF->dc_data_result_reson_status3 == "") {   ?>
                                <div><label for=""><input type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div><label for=""><input type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>
                                <?php
                            } else {

                                if ($getF->dc_data_result_reson_status3 == 1) { ?>

                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php

                                } else { ?>

                                    <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status3" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                                    <?php

                                }
                            }

                            ?>
                            <textarea name="dc_data_result_reson_detail3" id="dc_data_result_reson_detail3" cols="30" rows="5" class="form-control" placeholder="<?= label('text_result_request', $this); ?>"><?= $getF->dc_data_result_reson_detail3; ?></textarea>

                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-9 border p-5">
                                <label style="color:red;"><?= label('memo3', $this); ?> :&nbsp;</label><label for=""><?= label('memo4', $this); ?></label>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""><?= label("approvers", $this); ?></label>
                                    <?php
                                    $dataDateApproveSmr = "";
                                    if ($getF->dc_data_approve_smr == "") {
                                        $dataDateApproveSmr = "";
                                        ?>
                                        <input type="text" class="form-control" name="dc_data_approve_smr" id="dc_data_approve_smr" value="<?= $getuserCon; ?>">
                                        <?php
                                    } else {
                                        $dataDateApproveSmr = conDateFromDb($getF->dc_data_date_approve_smr);
                                        ?>
                                        <input disabled type="text" class="form-control" name="dc_data_approve_smr" id="dc_data_approve_smr" value="<?= $getF->dc_data_approve_smr; ?>">
                                        <?php

                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label for="">วันที่ :</label>
                                    <input type="text" name="dc_data_date_approve_smr" id="dc_data_date_approve_smr" class="form-control" value="<?=$dataDateApproveSmr?>" readonly>
                                    <input type="submit" value="<?= label('save', $this); ?>" class="btn btn-primary mt-2" name="btnSave_sec3smr" id="btnSave_sec3smr">
                                </div>
                            <!-- ผลการร้องขอ -->
                            </div>

                        </div>
                    </form>
                    <hr>
                </div>
                <!-- ผลการร้องขอ -->

                <div id="dcc_approve_normal">
                    <!-- สำหรับผู้ควบคุมเอกสาร -->
                    <h3 class="p2 mb-3"><?= label("forstaff", $this); ?></h3>
                    <form action="<?= base_url('document/save_sec4/' . $getF->dc_data_darcode); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="">กรุณาดาวน์โหลดเอกสารต้นฉบับที่นี่ :</label>&nbsp;<label for=""><a id="dc_data_file" href="<?= base_url() ?><?= $getF->dc_data_file_location . $getF->dc_data_file; ?>" target="_blank"><?= $getF->dc_data_file; ?></a></label>

                            <input hidden type="text" name="dc_data_file" id="dc_data_file" value="<?= $getF->dc_data_file; ?>" />

                        </div>

                        <div class="form-row">

                            <label class="all">เพื่อทำลายน้ำสำหรับจัดเก็บ และ แจกจ่าย หลังจากใส่ลายน้ำเรียบร้อยแล้ว ให้นำไฟล์มาอัพโหลดเข้าระบบอีกครั้งที่นี่</label>

                        </div>

                        <div class="form-inline mb-2">
                            <div class="form-group col-md-4">
                                <input type="file" name="document_master" id="document_master" class="form-control m-2" accept=".pdf">
                                <label for="">อัพโหลดไฟล์สำหรับ จัดเก็บ</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="file" name="document_copy" id="document_copy" class="form-control m-2" accept=".pdf">
                                <label for="">อัพโหลดไฟล์สำหรับ แจกจ่าย</label>
                            </div>
                        </div>

                        <div class="form-row">

                            <textarea name="dc_data_method" id="dc_data_method" cols="30" rows="5" class="form-control" placeholder="การดำเนินการ"><?= $getF->dc_data_method; ?></textarea>

                        </div>


                        <div class="form-row mt-3">
                            <div class="col-md-4 form-group">
                            <?php
                                $dataDateDcc = "";
                            if ($getF->dc_data_operation == '') {
                                $dataDateDcc = "";
                                ?>
                                <label>ผู้ดำเนินการ : </label>
                                <input type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getuserCon; ?>">
                                <?php
                            } else { 
                                $dataDateDcc = conDateFromDb($getF->dc_data_date_operation);
                                ?>
                                <label>ผู้ดำเนินการ : </label>
                                <input disabled type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getF->dc_data_operation; ?>">
                                <?php
                            }

                            ?>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">วันที่ :</label>
                                <input type="text" name="dc_date_date_operation" id="dc_date_date_operation" class="form-control" readonly value="<?=$dataDateDcc?>">
                            </div>
                        </div>

                        <input class="btn btn-primary " type="submit" name="btnOpsave" id="btnOpsave" value="<?= label('save2', $this); ?>">

                    </form>
                </div>


                <div id="dcc_approve_copydept">
                    <!-- สำหรับผู้ควบคุมเอกสาร -->
                    <h3 class="p2 mb-3"><?= label("forstaff", $this); ?></h3>
                    <form action="<?= base_url('document/save_sec4deptedit/' . $getF->dc_data_darcode); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="">ยืนยันการทำสำเนาเอกสาร :</label>&nbsp;<label for=""><a href="<?= base_url() ?><?= $getF->dc_data_file_location . $getF->dc_data_file; ?>" target="_blank"><?= $getF->dc_data_file; ?></a></label>
                            <input hidden type="text" name="dc_data_file" id="dc_data_file" value="<?= $getF->dc_data_file; ?>" />
                        </div>

                        <div class="form-row">
                            <textarea name="dc_data_method" id="dc_data_method" cols="30" rows="5" class="form-control" placeholder="การดำเนินการ"><?= $getF->dc_data_method; ?></textarea>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-4 form-group">
                            <?php
                            $dataDateDcc2 = "";
                            if ($getF->dc_data_operation == '') {
                                $dataDateDcc2 = "";
                                ?>
                                <label>ผู้ดำเนินการ : <input type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getuserCon; ?>"></label>
                                <?php
                            } else { 
                                $dataDateDcc2 = conDateFromDb($getF->dc_data_date_operation);
                                ?>
                                <label>ผู้ดำเนินการ : <input disabled type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getF->dc_data_operation; ?>"></label>
                                <?php
                            }
                            ?>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">วันที่ :</label>
                                <input type="text" name="dc_data_date_operation" id="dc_data_date_operation" class="form-control" value="<?=$dataDateDcc2?>" readonly>
                            </div>
                        </div>

                        <input class="btn btn-primary btncopydept" type="submit" name="btnOpsave" id="btnOpsave" value="<?= label('save2', $this); ?>">

                        <input hidden type="text" name="dc_data_old_dar" id="dc_data_old_dar" value="<?= $getF->dc_data_old_dar; ?>">
                    </form>
                </div>

                <input hidden type="text" name="check_dc_data_reson" id="check_dc_data_reson" value="<?= get_data_reson($getF->dc_data_darcode)->dc_data_reson ?>">


                <div id="dcc_approve_cancel">
                    <!-- สำหรับผู้ควบคุมเอกสาร -->
                    <h3 class="p2 mb-3"><?= label("forstaff", $this); ?></h3>
                    <form action="<?= base_url('document/save_sec4cancel/' . $getF->dc_data_darcode); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="">กรุณาดาวน์โหลดเอกสารต้นฉบับที่นี่ :</label>&nbsp;<label for=""><a id="dc_data_file" href="<?= base_url() ?><?= $getF->dc_data_file_location . $getF->dc_data_file; ?>" target="_blank"><?= $getF->dc_data_file; ?></a></label>
                            <input hidden type="text" name="dc_data_file" id="dc_data_file" value="<?= $getF->dc_data_file; ?>" />
                        </div>
                        <div class="form-row">

                            <label class="cancel">เพื่อทำลายน้ำสำหรับ ยกเลิกเอกสาร หลังจากใส่ลายน้ำเรียบร้อยแล้ว ให้นำไฟล์มาอัพโหลดเข้าระบบอีกครั้งที่นี่</label>
                        </div>



                        <div class="form-inline mb-2">
                            <div class="form-group col-md-4">
                                <input type="file" name="document_master_cancel" id="document_master_cancel" class="form-control m-2" accept=".pdf">
                                <label for="">อัพโหลดไฟล์สำหรับ จัดเก็บ</label>
                            </div>
                        </div>

                        <div class="form-row">
                            <textarea name="dc_data_method" id="dc_data_method" cols="30" rows="5" class="form-control" placeholder="การดำเนินการ"><?= $getF->dc_data_method; ?></textarea>
                        </div>

                            <!-- <div class="form-row">

                            <div class="form-group col-md-6 mt-2">

                            <input type="text" name="li_hashtag[]" id="li_hashtag" class="form-control" placeholder="กรุณาระบุ Hashtag เช่น #คู่มือการใช้งาน" required/>

                            <button type="button" name="dar_addmore" id="dar_addmore" class="btn btn-primary mt-2 dar_addmore"><i class="fas fa-hashtag"></i>&nbsp;เพิ่ม Hashtag</button>

                            </div>

                        </div> -->



                        <div class="form-row mt-3">
                            <div class="col-md-4 form-group">
                            <?php
                                $dataDateDcc3 = "";
                            if ($getF->dc_data_operation == '') {
                                $dataDateDcc3 = "";
                                ?>
                                <label>ผู้ดำเนินการ : </label>
                                <input type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getuserCon; ?>">
                                <?php
                            } else { 
                                $dataDateDcc3 = conDateFromDb($getF->dc_data_date_operation);
                                ?>
                                <label>ผู้ดำเนินการ : </label>
                                <input disabled type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?= $getF->dc_data_operation; ?>">
                                <?php
                            }
                            ?>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">วันที่ :</label>
                                <input type="text" name="dc_data_date_operation" id="dc_data_date_operation" class="form-control" value="<?=$dataDateDcc3?>" readonly>
                            </div>
                        </div>

                        <input class="btn btn-primary btncancel" type="submit" name="btnOpsave" id="btnOpsave" value="<?= label('save2', $this); ?>">
                    </form>
                </div>

</div><!-- Main Section -->


</div><!-- Content Zone -->

</div><!-- Content Zone -->

</body>



</html>