<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= label("add_title", $this); ?></title>

    <!-- Title -->

    <meta name="description" content="This is an example dashboard created using build-in elements and components.">



    <link href="<?php echo base_url('css/datepicker.css'); ?>" rel="stylesheet" type="text/css" media="screen" />



    <link href="//getbootstrap.com/2.3.2/assets/js/google-code-prettify/prettify.css" rel="stylesheet">



</head>



<?php

$getF = $get_fulldata->row();

?>



<?php

$getuser = $this->login_model->getuser();

$getuserCon = $this->doc_get_model->convertName($getuser->Fname, $getuser->Lname);

?>



<body>

    <div class="app-main__outer">

        <!-- Content Zone -->

        <div class="app-main__inner mb-5">

            <!-- Content Zone -->



            <div class="container-fulid border p-2 bg-white mb-2">

                <a href="<?=base_url('document/viewfull/').$getF->dc_data_darcode?>"><button class="btn btn-secondary"><i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;กลับ</button></a>

            </div><br>



            <div class="container-fulid border p-4 bg-white">

                <div style="background-color:orange;height:20px;" class="mb-2"></div>

                <!-- Main Section -->

                <h5 style="font-size:12px;text-align:right;"><?= getFormcode(); ?></h5>

                <div class="row">

                    <div class="col-md-6">

                    

                    </div>

                    <div class="col-md-6">

                    <h5 style="font-size:12px;text-align:right;"><b>Status :</b>&nbsp;<?= $getF->dc_data_status; ?>

            <input hidden type="text" name="check_data_status" id="check_data_status" value="<?= $getF->dc_data_status; ?>">

            </h5>

                    </div>

                </div>

                

            

                <h2 style="text-align:center;">แก้ไข ใบคำร้องเกี่ยวกับเอกสาร</h2>

                <h3 style="text-align:center;"><?= label("dar_title_en", $this); ?></h3>

                <h4 style="text-align:center;"><?= label("dar_no", $this); ?><?= $getF->dc_data_darcode; ?></h4>

                <hr>



                <form action="<?=base_url('document/save_editdar/').$getF->dc_data_darcode?>" method="POST" name="form1" id="form1" enctype="multipart/form-data">

                    <!-- Form Section 1 -->

                <input hidden type="text" name="formcode" id="formcode" value="<?= getFormcode(); ?>">

                    <section>

                        <!-- Document type Section -->

                        <div class="form-row">

                            <?php foreach ($get_doc_type->result_array() as $rs_type) { ?>

                            <!-- Doc type loop -->

                            <?php

                                $checked = "";

                                foreach ($get_doctype_use->result_array() as $get_doctype_uses) {

                                    if ($rs_type['dc_type_code'] == $get_doctype_uses['dc_type_use_code']) {

                                        $checked = ' checked="" ';

                                        continue;

                                    }

                                }

                                ?>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">

                                <label class="checkbox-inline"><input <?= $checked; ?> type="checkbox" name="dc_data_type[]" id="dc_data_type" value="<?php echo $rs_type['dc_type_code']; ?>" class="" />&nbsp;<?php echo $rs_type['dc_type_name']; ?></label>

                            </div>

                            <!-- Doc type loop -->

                            <?php }; ?>

                        </div>

                        <!-- Document type Section -->

                    </section>

                    <hr>





                    <section>

                        <!-- descript section -->

                        <h3 style="text-align:center;"><?= label("dc_des", $this); ?></h3>

                        <div class="form-row">

                            <!-- Left content -->

                            <div class="col-sm-6 border">

                                <?php

                                foreach ($get_doc_sub_type->result_array() as $doc_sub_type) { ?>

                                <!-- Get doc sub type loop -->

                                <?php

                                    foreach ($get_fulldata->result_array() as $gf) {

                                        if ($gf['dc_data_sub_type'] == $doc_sub_type['dc_sub_type_code']) {

                                            $checked = ' checked="" ';

                                        } else {

                                            $checked = '';

                                        }

                                    }

                                    ?>

                                <label class="checkbox-inline col-sm-4 p-2"><input <?= $checked; ?> type="radio" name="dc_data_sub_type" id="dc_data_sub_type" value="<?php echo $doc_sub_type['dc_sub_type_code']; ?>">&nbsp;<?php echo $doc_sub_type['dc_sub_type_name']; ?></label>

                                <!-- Get doc sub type loop -->

                                <?php }; ?>



                                <input hidden type="text" name="checksds" id="checksds" value="<?= $getF->dc_data_sub_type; ?>" />

                                <!-- Element for check subtype = sds and law -->

                                <?php

                                if ($getF->dc_data_sub_type == "l") {

                                    $glawuse = $get_law_use->row();

                                    $lawcode = $glawuse->dc_law_code;

                                    $lawname = $glawuse->dc_law_name;

                                } else {

                                    $lawcode = '';

                                    $lawname = '';

                                }





                                if ($getF->dc_data_sub_type == "sds") {

                                    $gsdsuse = $get_sds_use->row();

                                    $sdscode = $gsdsuse->dc_sds_code;

                                    $sdsname = $gsdsuse->dc_sds_name;

                                } else {

                                    $sdscode = '';

                                    $sdsname = '';

                                }

                                ?>

                                <!-- Get law -->

                                <select name="get_law" id="get_law" class="form-control" >

                                    <option value="<?= $lawcode; ?>"><?= $lawname; ?></option>

                                    <?php

                                    foreach ($get_law->result_array() as $gl) {

                                        echo "<option value='" . $gl['dc_law_code'] . "'>" . $gl['dc_law_name'] . "</option>";

                                    }

                                    ?>

                                </select>

                                <!-- Get law -->



                                <!-- Get sds -->

                                <select name="get_sds" id="get_sds" class="form-control" >

                                    <option value="<?= $sdscode; ?>"><?= $sdsname; ?></option>

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

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label class="text-center"><?= label("date_request", $this); ?>&nbsp;</label><i class="fas fa-calendar-alt" style="font-size:18px;"></i>

                                        </div>

                                        <div class="col-md-8">

                                            <input class="input-medium form-control datepicker" data-value="<?= $getF->dc_data_date ?>" type="date" placeholder="วว/ดด/ปปปป" name="dc_data_date" id="dc_data_date">

                                        </div>

                                    </div>

                                </div>

                                <!-- Date request -->



                                <!-- User Request -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("user_request", $this); ?></label>

                                        </div>

                                        <div class="col-md-8">

                                            <input type="text" name="dc_data_user" id="dc_data_user" value="<?= $getF->dc_data_user; ?>" class="form-control" disabled>

                                            <input hidden type="text" name="check_dc_data_user" id="check_dc_data_user" value="<?= $getF->dc_data_user; ?>">

                                            <!-- Check owner user for btn_edit -->

                                        </div>

                                    </div>

                                </div>

                                <!-- User Request -->



                            </div>







                            <div class="row mb-2">

                                <!-- Department -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("department", $this); ?></label>

                                        </div>

                                        <div class="col-md-8">

                                        <select name="dc_data_dept" id="dc_data_dept" class="form-control">

                                            <option value="<?= $getF->dc_data_dept; ?>"><?= $getF->dc_dept_main_name; ?></option>



                                            <?php

                                            foreach ($get_dept->result_array() as $rs_gd) {

                                                echo "<option value='" . $rs_gd['dc_dept_code'] . "'>" . $rs_gd['dc_dept_main_name'] . "</option>";

                                            }

                                            ?>



                                        </select>

                                        </div>

                                    </div>

                                </div>

                                <!-- Department -->



                                <!-- Document name -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("doc_name", $this); ?></label>

                                        </div>

                                        <div class="col-md-8">

                                        <input type="text" name="dc_data_docname" id="dc_data_docname" value="<?= $getF->dc_data_docname; ?>" class="form-control" >

                                        </div>

                                    </div>

                                </div>

                                <!-- Document name -->

                            </div>







                            <div class="row mb-2">

                                <!-- Doccode -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("doc_id", $this); ?></label>

                                        </div>

                                        <div class="col-md-8">

                                        <input type="text" name="dc_data_doccode" id="dc_data_doccode" class="form-control" value="<?= $getF->dc_data_doccode_display; ?>" disabled>

                                        </div>

                                    </div>

                                </div>

                                <!-- Doccode -->



                                <!-- Doc Edit -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("doc_num_edit", $this); ?></label>

                                        </div>

                                        <div class="col-md-8">

                                        <input type="number" name="dc_data_edit" id="dc_data_edit" value="<?= $getF->dc_data_edit; ?>" class="form-control" disabled>

                                        </div>

                                    </div>

                                </div>

                                <!-- Doc Edit -->



                            </div>







                            <div class="row mb-2">

                                <!-- Date Start -->

                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <label for=""><?= label("date_start_use", $this); ?>&nbsp;&nbsp;</label><i class="fas fa-calendar-alt" style="font-size:18px;"></i>

                                        </div>

                                        <div class="col-md-8">

                                            <input class="input-medium form-control datepicker" type="date" placeholder="วว/ดด/ปปปป" name="dc_data_date_start" id="dc_data_date_start" data-value="<?=$getF->dc_data_date_start?>">

                                        </div>

                                    </div>

                                </div>

                                <!-- Date Start -->



                            </div>







                            <div class="row">

                                                <!-- Doc Store -->

                                <div class="col-md-8">

                                    <div class="row">

                                        <div class="col-md-3">

                                            <label for=""><?= label("time_store", $this); ?></label>

                                        </div>

                                        <div class="col-md-8 form-inline">

                                        <select name="dc_data_store" id="dc_data_store" class="form-control">

                                            <option value="<?=$getF->dc_data_store?>"><?=$getF->dc_data_store?></option>
                                                <?php foreach (get_dcdatastore() as $rsGetDcStore) {

                                                    echo "<option value='" . $rsGetDcStore['dc_datastore_name'] . "'>" . $rsGetDcStore['dc_datastore_name'] . "</option>";

                                                } ?>

                                            </select>

                                        <select name="dc_data_store_type" id="dc_data_store_type" class="form-control" >

                                                <option value="<?= $getF->dc_data_store_type; ?>"><?= $getF->dc_data_store_type; ?></option>

                                                <option value="เดือน">เดือน</option>

                                                <option value="ปี">ปี</option>

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

                    </section>









                    <!-- เหตุผลในการร้องขอ -->

                    <h3 class="p-2"><?= label("reason_request", $this); ?></h3>

                    <div class="form-row">



                        <?php foreach ($get_reason->result_array() as $rs_reason) { ?>

                        <!-- Reason request loop -->

                        <?php

                            if ($getF->dc_data_reson == $rs_reason['dc_reason_code']) {

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

                        <textarea name="dc_data_reson_detail" id="dc_data_reson_detail" cols="30" rows="5" class="form-control" ><?= $getF->dc_data_reson_detail; ?></textarea>

                    </div>

                    <div style="text-align:center;color:red;" class="mt-3 p-2 border"><?= label('memo1', $this); ?></div>

                    <hr>

                    <!-- เหตุผลในการร้องขอ -->





                    <!-- หน่วยงานที่เกี่ยวข้อง -->

                    <h3 class="p2 mb-3"><?= label("related_dept", $this); ?></h3>

                    <div class="form-row">

                        <?php foreach ($get_related_dept->result_array() as $rs_related_dept) { ?>



                        <?php

                            $checked = '';

                            foreach ($get_related_use->result_array() as $grelated) {

                                if ($grelated['related_dept_code'] == $rs_related_dept['related_code']) {

                                    $checked = ' checked="" ';

                                    continue;

                                }

                            }

                            ?>





                        <!-- Related dept loop -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <label class="checkbox-inline"><input <?= $checked; ?> class="related_dept" type="checkbox" name="related_dept_code[]" id="related_dept_code" value="<?php echo $rs_related_dept['related_code']; ?>" />&nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>

                        </div>

                        <!-- Related dept loop -->

                        <?php }; ?>



                    </div>



                    <!-- Input text for other related dept-->

                    <div style="text-align:center;color:red;" class="mt-3 p-2 border"><?= label('memo2', $this); ?></div>

                    <div class="form-row mt-2">

                        <div class="form-group">

                            <label for=""><?= label("uploadfile", $this); ?></label><br>

                            <!-- <input type="file" name="dc_data_file" id="dc_data_file" class="form-control"> -->

                            <label for=""><a id="dc_data_file" href="<?= base_url() ?><?= $getF->dc_data_file_location . $getF->dc_data_file; ?>#toolbar=0" target="_blank"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $getF->dc_data_file; ?></a></label>

                            <!-- Upload file -->

                        </div>

                    </div>

                    <div class="form-row mt-2">

                        <div class="form-group">

                            <label for=""><?= label("uploadfile", $this); ?></label>

                            <input type="file" name="dc_data_file2" id="dc_data_file2" class="form-control" accept=".pdf">

                        </div>

                    </div>



                    <div class="form-row mt-2">

                        <div class="col-md-12">

                            <label>แฮชแท็ก :</label>

                            <?php 

                            $get_hashtag = get_hashtag_iso($getF->dc_data_doccode);

                                foreach($get_hashtag->result_array() as $ght){

                                    echo "<a href='#'><label>".$ght['li_hashtag_name']."&nbsp;&nbsp;</label></a>";

                                }

                            ?>

                        </div>

                    </div>



                    <div class="form-row">

                        <div class="form-group col-md-6 mt-2">

                            <input type="text" name="li_hashtag[]" id="li_hashtag" class="form-control" placeholder="กรุณาระบุ Hashtag เช่น #คู่มือการใช้งาน" required maxlength="40"/>

                            <label id="characterLeft"></label><br>

                            <button type="button" name="edit_dar_addmore" id="edit_dar_addmore" class="btn btn-info mt-2 dar_addmore"><i class="fas fa-hashtag"></i>&nbsp;เพิ่ม Hashtag</button>

                        </div>

                    </div>

                    <input type="submit" value="บันทึกการแก้ไข" name="btnEditDar" id="btnEditDar" class="btn btn-primary">

                    

                    <input hidden type="text" name="check_edit_doccode" id="check_edit_doccode" value="<?=$getF->dc_data_doccode?>">

                    <input hidden type="text" name="check_edit_data_file" id="check_edit_data_file" value="<?= $getF->dc_data_file; ?>">

                    <input hidden type="text" name="check_edit_darcode" id="check_edit_darcode" value="<?= $getF->dc_data_darcode; ?>">

                </form><!-- Form Section 1 -->

                <hr>

                <!-- หน่วยงานที่เกี่ยวข้อง -->



