<!DOCTYPE html>

<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= label("add_title", $this); ?></title>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
</head>

<?php
    $getuser = $this->login_model->getuser();
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <h5 style="font-size:12px;text-align:right;"><?= getFormcode() ?></h5>
                <h2 style="text-align:center;"><?= label("dar_title_th", $this); ?></h2>
                <h3 style="text-align:center;"><?= label("dar_title_en", $this); ?></h3>
                <h4 style="text-align:center;"><?= label("dar_no", $this); ?></h4>
                <hr>

                <form action="save_sec1" method="POST" name="form1" id="form1" enctype="multipart/form-data">
                    <!-- Form Section 1 -->
                    <!-- Get Form Code -->
                    <input hidden type="text" name="formcode" id="formcode" value="<?= getFormcode(); ?>">
                    <div class="form-row">
                        <?php foreach ($get_doc_type->result_array() as $rs_type) { ?>
                            <!-- Doc type loop -->
                            <div class="col-lg-2 col-md-6">
                                <label class="checkbox-inline"><input type="checkbox" name="dc_data_type[]" id="dc_data_type" value="<?php echo $rs_type['dc_type_code']; ?>" />&nbsp;<?php echo $rs_type['dc_type_name']; ?></label>
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
                                <label class="checkbox-inline col-sm-5 p-2"><input type="radio" name="dc_data_sub_type" id="dc_data_sub_type" value="<?php echo $doc_sub_type['dc_sub_type_code']; ?>">&nbsp;<?php echo $doc_sub_type['dc_sub_type_name']; ?></label>
                                <!-- Get doc sub type loop -->
                            <?php }; ?>


                            <!-- Get law -->
                            <select name="get_law" id="get_law" class="form-control">
                                <option value=""><?= label('get_law_label', $this); ?></option>
                                <?php
                                foreach ($get_law->result_array() as $gl) {
                                    echo "<option value='" . $gl['dc_law_code'] . "'>" . $gl['dc_law_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <!-- Get law -->


                            <!-- Get sds -->
                            <select name="get_sds" id="get_sds" class="form-control">
                                <option value=""><?= label('get_sds_label', $this); ?></option>
                                <?php
                                foreach ($get_sds->result_array() as $gsds) {
                                    echo "<option value='" . $gsds['dc_sds_code'] . "'>" . $gsds['dc_sds_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <!-- Get sds -->
                            <div class="p-1">
                                <span style="font-size:12px;color:#CC0000;">
                                **กรณีที่เลือก Law หรือ SDS แล้วไม่พบรายการย่อยขึ้นมาให้เลือก แนะนำให้ กดที่ Law หรือ SDS อีกครั้ง**
                                </span>
                            </div>
                        </div>
                        <!-- Left content -->


                        <!-- Right content -->
                        <div class="col-sm-6 border p-2">
                            <div class="row mb-2">
                                <!-- Date request -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="text-center"><?= label("date_request", $this); ?>&nbsp;</label><i class="fas fa-calendar-alt" style="font-size:18px;"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input-medium form-control datepicker" data-value="<?= date('Y/m/d') ?>" type="date" placeholder="วว/ดด/ปปปป" name="dc_data_date" id="dc_data_date">
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
                                            <select name="dc_data_dept" id="dc_data_dept" class="form-control">
                                                <?php
                                                    $get_newuser = get_newuser($_SESSION['username']);
                                                    $get_dept_code = get_dept_byuser($get_newuser->dc_user_new_dept_code);
                                                ?>
                                                <option value="<?= $get_dept_code->dc_dept_code; ?>"><?= $get_dept_code->dc_dept_main_name; ?></option>
                                                <?php
                                                    foreach ($get_dept->result_array() as $rs_gd) {
                                                        echo "<option value='" . $rs_gd['dc_dept_code'] . "'>" . $rs_gd['dc_dept_main_name'] . "</option>";
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
                                            <label for=""><?= label("doc_name", $this); ?></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="dc_data_docname" id="dc_data_docname" value="" class="form-control">
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
                                            <input readonly type="text" name="dc_data_doccode" id="dc_data_doccode" class="form-control">
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
                                            <label for=""><?= label("doc_num_edit", $this); ?></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input readonly type="number" name="dc_data_edit" id="dc_data_edit" step="0.01" value="00" class="form-control">
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
                                            <label for=""><?= label("date_start_use", $this); ?>&nbsp;&nbsp;</label><i class="fas fa-calendar-alt" style="font-size:18px;"></i>
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
                                            <select name="dc_data_store" id="dc_data_store" class="form-control">
                                                <?php foreach (get_dcdatastore() as $rsGetDcStore) {

                                                    echo "<option value='" . $rsGetDcStore['dc_datastore_name'] . "'>" . $rsGetDcStore['dc_datastore_name'] . "</option>";
                                                } ?>

                                            </select>
                                            <select name="dc_data_store_type" id="dc_data_store_type" class="form-control">
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
                                if ($rs_reason['dc_reason_code'] == "r-01") {
                                    $checked = ' checked="" ';
                                } else {
                                    $checked = '';
                                }
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                <label class="checkbox-inline"><input <?= $checked ?> type="radio" name="dc_data_reson" id="dc_data_reson" value="<?php echo $rs_reason['dc_reason_code']; ?>" onclick="return false" />&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
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
                            <!-- Check Login newdeptcode -->
                            <?php
                            $checked = '';
                            if ($rs_related_dept['related_code'] == getUserN($getuser->ecode)->dc_user_new_dept_code) {
                                $checked = ' checked="" ';
                            }
                            ?>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <label class="checkbox-inline"><input <?= $checked ?> class="related_dept" type="checkbox" name="related_dept_code[]" id="related_dept_code" value="<?php echo $rs_related_dept['related_code']; ?>" />&nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>
                            </div>
                            <!-- Related dept loop -->
                        <?php }; ?>
                    </div>

                    <!-- Input text for other related dept-->
                    <div style="text-align:center;color:red;" class="mt-3 p-2 border"><?= label('memo2', $this); ?></div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mt-2">
                            <input type="text" name="li_hashtag[]" id="li_hashtag" class="form-control" placeholder="กรุณาระบุ Hashtag เช่น #คู่มือการใช้งาน" required maxlength="40" onblur="check();" />
                            <label id="characterLeft"></label><br>
                            <button type="button" name="dar_addmore" id="dar_addmore" class="btn btn-primary mt-2 dar_addmore"><i class="fas fa-hashtag"></i>&nbsp;เพิ่ม Hashtag</button>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <button type="submit" name="saveSec1_1" id="saveSec1_1" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                    </div>
                    <hr>
                </form><!-- Form Section 1 -->