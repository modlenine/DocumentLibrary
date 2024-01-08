<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>เปลี่ยนแปลงเอกสาร</title>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">




</head>

<?php
$get_fulldatas = $getfulldata_edit->row();
?>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->

            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <h5 style="font-size:12px;text-align:right;"><?= selectFormcode($get_fulldatas->dc_data_darcode) ?></h5>
                <h2 style="text-align:center;"><?= label("dar_title_th", $this); ?></h2>
                <h3 style="text-align:center;"><?= label("dar_title_en", $this); ?></h3>
                <h4 style="text-align:center;"><?= label("dar_no", $this).$get_fulldatas->dc_data_darcode?></h4>
                <hr>

                <form action="<?= base_url('document/save_sec1change/') . $get_fulldatas->dc_data_doccode; ?>" method="POST" name="form1" id="form1" enctype="multipart/form-data">
                    <!-- Form Section 1 -->
                    <!-- Get Form Code -->
                    <input hidden type="text" name="formcode" id="formcode" value="<?= getFormcode(); ?>">
                    
                    <?php
                    $get_doc_type_use = $this->db->query("SELECT
                        dc_datamain.dc_data_doccode,
                        dc_datamain.dc_data_darcode,
                        dc_type_use.dc_type_use_code
                        FROM
                        dc_datamain
                        INNER JOIN dc_type_use ON dc_type_use.dc_type_use_doccode = dc_datamain.dc_data_doccode
                        WHERE dc_datamain.dc_data_doccode = '$get_fulldatas->dc_data_doccode' ");
                        ?>


                        <div class="form-row">
                            <?php foreach ($get_doc_type->result_array() as $rs_type) { ?>

                                <?php
                                $checked = "";
                                foreach ($get_doc_type_use->result_array() as $get_doc_type_uses) {
                                    if ($rs_type['dc_type_code'] == $get_doc_type_uses['dc_type_use_code']) {
                                        $checked = ' checked="" ';
                                        continue;
                                    }
                                }
                                ?>
                                <!-- Doc type loop -->
                                <div class="col-lg-2 col-md-3 col-sm-3 col-4">
                                    <label class="checkbox-inline"><input <?= $checked; ?> type="checkbox" name="dc_data_type[]" id="dc_data_type" value="<?php echo $rs_type['dc_type_code']; ?>" onclick="return false" />&nbsp;<?php echo $rs_type['dc_type_name']; ?></label>
                                </div>
                                <!-- Doc type loop -->
                            <?php }; ?>
                        </div>

                        <hr>

                        <!-- descript section -->
                        <h3 style="text-align:center;"><?= label("dc_des", $this); ?></h3>
                        <div class="form-row">

                            <!-- Left content -->
                            <div class="col-sm-6 border">
                                <?php foreach ($get_doc_sub_type->result_array() as $doc_sub_type) { ?>
                                    <!-- Get doc sub type loop -->
                                    <?php
                                    foreach ($getfulldata_edit->result_array() as $gf) {


                                        if ($gf['dc_data_sub_type'] == $doc_sub_type['dc_sub_type_code']) {
                                            $checked = ' checked="" ';
                                        } else {
                                            $checked = '';
                                        }
                                    }
                                    ?>

                                    <label class="checkbox-inline col-sm-5 p-2"><input <?= $checked ?> type="radio" name="dc_data_sub_type" id="dc_data_sub_type" value="<?php echo $doc_sub_type['dc_sub_type_code']; ?>" onclick="return false">&nbsp;<?php echo $doc_sub_type['dc_sub_type_name']; ?></label>

                                    <!-- Get doc sub type loop -->
                                <?php }; ?>


                                <!-- Get law -->
                                <select name="get_law" id="get_law" class="form-control">
                                    <option value="<?=$get_fulldatas->dc_data_sub_type_law;?>"><?=$get_fulldatas->dc_data_sub_type_law;?></option>
                                    <?php
                                    foreach ($get_law->result_array() as $gl) {
                                        echo "<option value='" . $gl['dc_law_code'] . "'>" . $gl['dc_law_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <!-- Get law -->



                                <!-- Get sds -->
                                <select name="get_sds" id="get_sds" class="form-control">
                                    <option value="<?=$get_fulldatas->dc_data_sub_type_sds;?>"><?=$get_fulldatas->dc_data_sub_type_sds;?></option>
                                    <?php
                                    foreach ($get_sds->result_array() as $gsds) {
                                        echo "<option value='" . $gsds['dc_sds_code'] . "'>" . $gsds['dc_sds_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <!-- Get sds -->


                            </div>
                            <!-- Left content -->


                            <!-- Right content -->
                            <div class="col-sm-6 border p-2">


                                <div class="row mb-2">
                                    <!-- Date request -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="text-center"><?= label("date_request", $this); ?>&nbsp;</label><i class="far fa-calendar-alt" style="font-size:18px;"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="input-medium form-control datepicker" type="date" data-value="<?=date('Y/m/d')?>" placeholder="วว/ดด/ปปปป" name="dc_data_date" id="dc_data_date">
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
                                                <label for=""><?= label("user_request", $this); ?></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input readonly type="text" name="dc_data_user" id="dc_data_user" value="<?= $username; ?>" class="form-control">
                                                
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
                                                <label for=""><?= label("department", $this); ?></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select readonly name="dc_data_dept" id="dc_data_dept" class="form-control">
                                                    <option value="<?= $get_fulldatas->dc_dept_code; ?>"><?= $get_fulldatas->dc_dept_main_name; ?></option>

                                        <!-- <?php
                                        foreach ($get_dept->result_array() as $rs_gd) {
                                            echo "<option value='" . $rs_gd['dc_dept_code'] . "'>" . $rs_gd['dc_dept_main_name'] . "</option>";
                                        }
                                        ?> -->

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
                                    <label for=""><?= label("doc_name", $this); ?></label>
                                </div>
                                <div class="col-md-8">
                                    <input readonly type="text" name="dc_data_docname" id="dc_data_docname" value="<?= $get_fulldatas->dc_data_docname; ?>" class="form-control">
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
                                    <label for=""><?= label("doc_id", $this); ?></label>
                                </div>
                                <div class="col-md-8">

                                    <?php
                                    if ($get_fulldatas->dc_data_sub_type == "l") {
                                        $doccode = $get_fulldatas->dc_data_doccode_display;
                                    } else {
                                        $doccode = $get_fulldatas->dc_data_doccode;
                                    }

                                    ?>
                                    <input readonly type="text" name="dc_data_doccode" id="dc_data_doccode" class="form-control" value="<?= $doccode; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Doccode -->


                    <?php
                    $checkEdit = $this->db->query("SELECT dc_data_edit FROM dc_datamain WHERE dc_data_doccode='$get_fulldatas->dc_data_doccode' AND dc_data_edit > '0' ORDER BY dc_data_id DESC ");
                    $checkNumRow = $checkEdit->num_rows();
                    $result_edit= $checkEdit->row();
                    $count_data_edit = $result_edit->dc_data_edit;
                    $count_data_edit++;
                    $checkNumRow++;
                    if($count_data_edit < 10){
                        $dataedits = '0'.$count_data_edit;
                    }else{
                        $dataedits = $count_data_edit;
                    }
                    ?>
                    <!-- Doc Edit -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for=""><?= label("doc_num_edit", $this); ?></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="dc_data_edit" id="dc_data_edit" value="<?= $dataedits; ?>" class="form-control" readonly>
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
                                    <label for=""><?= label("date_start_use", $this); ?>&nbsp;&nbsp;</label><i class="far fa-calendar-alt" style="font-size:18px;"></i>
                                </div>
                                <div class="col-md-8">
                                    <input class="input-medium form-control datepicker" type="date" placeholder="วว/ดด/ปปปป" name="dc_data_date_start" id="dc_data_date_start">
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
                                    <label for=""><?= label("time_store", $this); ?></label>
                                </div>
                                <div class="col-md-8 form-inline">
                                    <select name="dc_data_store" id="dc_data_store" class="form-control" required>
                                        <?php foreach (get_dcdatastore() as $rsGetDcStore) {
                                            echo "<option value='" . $rsGetDcStore['dc_datastore_name'] . "'>" . $rsGetDcStore['dc_datastore_name'] . "</option>";
                                        } ?>
                                    </select>
                                    <select name="dc_data_store_type" id="dc_data_store_type" class="form-control" required>
                                        <option value="ปี">ปี</option>
                                        <option value="เดือน">เดือน</option>

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
            <h3 class="p-2"><?= label("reason_request", $this); ?></h3>
            <div class="form-row">
                <?php foreach ($get_reason->result_array() as $rs_reason) { ?>
                    <!-- Reason request loop -->
                    <?php
                    if ($rs_reason['dc_reason_code'] == "r-02") {
                        $checked = ' checked="" ';
                    } else {
                        $checked = '';
                    }
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <label class="checkbox-inline"><input <?= $checked ?> type="radio" name="dc_data_reson" id="dc_data_reson" value="<?php echo $rs_reason['dc_reason_code']; ?>" onclick="return false"/>&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
                    </div>
                    <!-- Reason request loop -->
                <?php }; ?>
            </div>
            <div class="form-row pt-3">
                <textarea name="dc_data_reson_detail" id="dc_data_reson_detail" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div style="text-align:center;color:red;" class="mt-3 p-2 border"><?= label('memo1', $this); ?></div>
            <hr>
            <!-- เหตุผลในการร้องขอ -->


            <!-- หน่วยงานที่เกี่ยวข้อง -->
            <h3 class="p2 mb-3"><?= label("related_dept", $this); ?></h3>
            <div class="form-row">
                <?php foreach ($get_related_dept->result_array() as $rs_related_dept) { ?>
                    <!-- Related dept loop -->
                    <?php
                    $query_related_use = $this->db->query("SELECT
                        dc_related_dept.related_id,
                        dc_related_dept.related_dept_name,
                        dc_related_dept_use.related_dept_doccode,
                        dc_related_dept_use.related_dept_id,
                        dc_related_dept_use.related_dept_code,
                        dc_datamain.dc_data_doccode
                        FROM
                        dc_related_dept
                        INNER JOIN dc_related_dept_use ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
                        INNER JOIN dc_datamain ON dc_related_dept_use.related_dept_doccode = dc_datamain.dc_data_doccode
                        
                        WHERE related_dept_darcode= '$get_fulldatas->dc_data_darcode' ");

                    $checked = '';
                    foreach ($query_related_use->result_array() as $get_related_use) {
                        if ($get_related_use['related_dept_code'] == $rs_related_dept['related_code']) {
                            $checked = ' checked="" ';
                            continue;
                        }
                    }

                    ?>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <label class="checkbox-inline"><input <?= $checked ?> class="related_dept" type="checkbox" name="related_dept_code[]" id="related_dept_code" value="<?php echo $rs_related_dept['related_code']; ?>" onclick="return false">&nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>
                    </div>
                    <!-- Related dept loop -->
                <?php }; ?>

            </div>

            <!-- Input text for other related dept-->
            <div style="text-align:center;color:red;" class="mt-3 p-2 border"><?= label('memo2', $this); ?></div>
            <div class="form-row mt-2">
                <label for="">เอกสารเดิม : &nbsp;</label><a href="<?= base_url() . $get_fulldatas->lib_main_file_location_copy . $get_fulldatas->lib_main_doccode_copy ?>#toolbar=0" target="_blank"><?= $get_fulldatas->lib_main_doccode_copy; ?></a>
            </div>
            <div class="form-row mt-2">
                <div class="form-group">
                    <label for=""><?= label("uploadfile", $this); ?></label>
                    <input type="file" name="dc_data_file" id="dc_data_file" class="form-control" accept=".pdf">
                </div>
            </div>
            <div class="col-md-3 mt-2">
                <input type="submit" name="btnUser_submit" id="btnUser_submit" value="<?= label('btnUser_submit', $this); ?>" class="btn btn-primary btn-block">
            </div>
            <input hidden type="text" name="darcode_h" id="darcode_h" value="<?=$get_fulldatas->dc_data_darcode?>">
        </form><!-- Form Section 1 -->
        <hr>
        <!-- หน่วยงานที่เกี่ยวข้อง -->

    </div><!-- Main Section -->







</div><!-- Content Zone -->
</div><!-- Content Zone -->

</body>


</html>