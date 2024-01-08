<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= label("add_title", $this); ?></title>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">

    <link href="<?php echo base_url('css/datepicker.css'); ?>" rel="stylesheet" type="text/css" media="screen" />

    <link href="//getbootstrap.com/2.3.2/assets/js/google-code-prettify/prettify.css" rel="stylesheet">

</head>

<?php
$getF = $get_fulldata->row();
?>

<?php
$getuser = $this->login_model->getuser();
$getuserCon = $this->doc_get_model->convertName($getuser->Fname , $getuser->Lname);
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->



            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <h5 style="font-size:12px;text-align:right;"><?= label('form_code', $this); ?></h5>
                <h2 style="text-align:center;"><?= label("dar_title_th", $this); ?></h2>
                <h3 style="text-align:center;"><?= label("dar_title_en", $this); ?></h3>
                <h4 style="text-align:center;"><?= label("dar_no", $this); ?><?=$getF->dc_data_darcode;?></h4>
                <hr>

                <form action="save_sec1" method="POST" name="form1" id="form1" enctype="multipart/form-data">
                    <!-- Form Section 1 -->

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
                                <label class="checkbox-inline"><input <?= $checked; ?> disabled type="checkbox" name="dc_data_type[]" id="dc_data_type" value="<?php echo $rs_type['dc_type_code']; ?>" class="" />&nbsp;<?php echo $rs_type['dc_type_name']; ?></label>
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
                                <label class="checkbox-inline col-sm-4 p-2"><input <?= $checked; ?> disabled type="radio" name="dc_data_sub_type" id="dc_data_sub_type" value="<?php echo $doc_sub_type['dc_sub_type_code']; ?>">&nbsp;<?php echo $doc_sub_type['dc_sub_type_name']; ?></label>

                                <!-- Get doc sub type loop -->
                            <?php }; ?>

                            <input hidden type="text" name="checksds" id="checksds" value="<?= $getF->dc_data_sub_type; ?>" />
                            <!-- Element for check subtype = sds and law -->
                            <?php
                            if($getF->dc_data_sub_type == "l")
                            {
                                $glawuse = $get_law_use->row();
                                $lawcode = $glawuse->dc_law_code;
                                $lawname = $glawuse->dc_law_name;
                            }else{
                                $lawcode = '';
                                $lawname = '';
                            }


                            if($getF->dc_data_sub_type == "sds")
                            {
                                $gsdsuse = $get_sds_use->row();
                                $sdscode = $gsdsuse->dc_sds_code;
                                $sdsname = $gsdsuse->dc_sds_name;
                            }else{
                                $sdscode = '';
                                $sdsname = '';
                            }
                                
                            ?>
                            <!-- Get law -->
                            <select name="get_law" id="get_law" class="form-control" disabled>
                                <option value="<?=$lawcode;?>"><?=$lawname;?></option>
                                <?php
                                foreach ($get_law->result_array() as $gl) {
                                    echo "<option value='" . $gl['dc_law_code'] . "'>" . $gl['dc_law_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <!-- Get law -->


                            <!-- Get sds -->
                            
                            <select name="get_sds" id="get_sds" class="form-control" disabled>
                                <option value="<?=$sdscode; ?>"><?=$sdsname;?></option>
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
                            <div class="form-group">
                                <div class="form-inline">
                                    <!-- วันที่ร้องขอ -->
                                    <label for=""><?= label("date_request", $this); ?>&nbsp;</label>
                                    <input class="input-medium form-control" type="text" data-provide="datepicker" data-date-language="th-th" placeholder="วว/ดด/ปปปป" name="dc_data_date" id="dc_data_date" value="<?=$getF->dc_data_date;?>" disabled>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <!-- ผู้ร้องขอ -->
                                    <label for=""><?= label("user_request", $this); ?>&nbsp;<input readonly type="text" name="dc_data_user" id="dc_data_user" value="<?=$getF->dc_data_user; ?>" class="form-control" disabled></label>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="form-inline">

                                    <!-- Department section -->
                                    <label for=""><?= label("department", $this); ?></label>&nbsp;&nbsp;
                                    <select name="dc_data_dept" id="dc_data_dept" class="form-control" disabled>
                                        <option value="<?=$getF->dc_data_dept;?>"><?=$getF->dc_dept_main_name;?></option>

                                        <?php
                                        foreach ($get_dept->result_array() as $rs_gd) {
                                            echo "<option value='" . $rs_gd['dc_dept_main_code'] . "'>" . $rs_gd['dc_dept_main_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                    <!-- Department section -->

                                    <!-- Document name section -->
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for=""><?= label("doc_name", $this); ?>&nbsp;&nbsp;<input type="text" name="dc_data_docname" id="dc_data_docname" value="<?=$getF->dc_data_docname;?>" class="form-control" disabled></label>
                                    <!-- Document name section -->

                                </div>
                            </div>



                            <div class="form-group">
                                <div class="form-inline">
                                    <label for=""><?= label("doc_id", $this); ?>&nbsp;&nbsp;<input readonly type="text" name="dc_data_doccode" id="dc_data_doccode" class="form-control" value="<?=$getF->dc_data_doccode_display;?>" disabled></label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for=""><?= label("doc_num_edit", $this); ?>&nbsp;&nbsp;<input type="number" name="dc_data_edit" id="dc_data_edit" value="<?=$getF->dc_data_edit;?>" class="form-control" disabled></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-inline">
                                    <label for=""><?= label("date_start_use", $this); ?>&nbsp;&nbsp;</label>
                                    <input class="input-medium form-control" type="text" data-provide="datepicker" data-date-language="th-th" placeholder="วว/ดด/ปปปป" name="dc_data_date_start" id="dc_data_date_start" value="<?=$getF->dc_data_date_start;?>" disabled>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-inline">
                                    <label for=""><?= label("time_store", $this); ?>&nbsp;&nbsp;<input type="number" name="dc_data_store" id="dc_data_store" value="<?=$getF->dc_data_store;?>" class="form-control" disabled>&nbsp;
                                        <select name="dc_data_store_type" id="dc_data_store_type" class="form-control" disabled>
                                            <option value="<?=$getF->dc_data_store_type;?>"><?=$getF->dc_data_store_type;?></option>
                                            <option value="เดือน">เดือน</option>
                                            <option value="ปี">ปี</option>
                                        </select>
                                </div>
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
                                if($getF->dc_data_reson == $rs_reason['dc_reason_code'])
                                {
                                    $checked = ' checked="" ';
                                }else{
                                    $checked = '';
                                }
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                <label class="checkbox-inline"><input <?=$checked;?> type="radio" name="dc_data_reson" id="dc_data_reson" value="<?php echo $rs_reason['dc_reason_code']; ?>" disabled/>&nbsp;<?php echo $rs_reason['dc_reason_name']; ?></label>
                            </div>
                            <!-- Reason request loop -->
                        <?php }; ?>

                    </div>
                    <div class="form-row pt-3">
                        <textarea name="dc_data_reson_detail" id="dc_data_reson_detail" cols="30" rows="5" class="form-control" disabled><?=$getF->dc_data_reson_detail;?></textarea>
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
                                foreach($get_related_use->result_array() as $grelated){
                                    if($grelated['related_dept_code'] == $rs_related_dept['related_code'])
                                    {
                                        $checked= ' checked="" ';
                                        continue;
                                    }
                                }
                            ?>
                            

                            <!-- Related dept loop -->
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <label class="checkbox-inline"><input <?=$checked;?> class="related_dept" type="checkbox" name="related_dept_code[]" id="related_dept_code" value="<?php echo $rs_related_dept['related_code']; ?>" disabled/>&nbsp;<?php echo $rs_related_dept['related_dept_name']; ?></label>
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
                            <label for=""><a href="<?=base_url()?><?=$getF->dc_data_file_location.$getF->dc_data_file;?>#toolbar=0" target="_blank"><?=$getF->dc_data_file;?></a></label>
                            <!-- Upload file -->
                        </div>
                    </div>
                    
                </form><!-- Form Section 1 -->
                <hr>
                <!-- หน่วยงานที่เกี่ยวข้อง -->


                <!-- ผลการร้องขอ -->
                <h3 class="p2 mb-3"><?= label("request_stat", $this); ?>&nbsp;<?=label('managerapprove',$this)?></h3>
                <form action="<?=base_url('document/save_sec2/'.$getF->dc_data_darcode);?>" method="POST" name="">
                    <div class="form-row">
                        <?php
                            if($getF->dc_data_result_reson_status == "")
                            {   ?>
                         
                         <div><label for=""><input type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                         <?php
                            }else{ 
                                if($getF->dc_data_result_reson_status == 1){ ?>
                        <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>
                            <?php
                                }else{ ?>
                        <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>
                            <?php
                                }
                            }
                        ?>
                        

                        <textarea name="dc_data_result_reson_detail" id="dc_data_result_reson_detail" cols="30" rows="5" class="form-control" placeholder="<?= label('text_result_request', $this); ?>"><?=$getF->dc_data_result_reson_detail;?></textarea>
                    </div>

                    <div class="form-row mt-3">
                        <div class="col-md-9 border p-5">
                            <label style="color:red;"><?= label('memo3', $this); ?> :&nbsp;</label><label for=""><?= label('memo4', $this); ?></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for=""><?= label("approvers", $this); ?></label>
                                <?php
                            if($getF->dc_data_approve_mgr == "")
                            { 
                                ?>
                                <input type="text" class="form-control" name="dc_data_approve_mgr" id="dc_data_approve_mgr" value="<?=$getuserCon;?>">
                           <?php
                            }else{ 
                                ?>
                                <input disabled type="text" class="form-control" name="dc_data_approve_mgr" id="dc_data_approve_mgr" value="<?=$getF->dc_data_approve_mgr;?>">
                        <?php
                            }
                            ?>
                                
                                <input type="submit" value="<?= label('save', $this); ?>" class="btn btn-primary mt-2" name="btnSave_sec2" id="btnSave_sec2">
                            </div>
                </form>
                <!-- ผลการร้องขอ -->
            </div>
        </div>
        <hr>
        <!-- ผลการร้องขอ -->



                        <!-- ผลการร้องขอ -->
                        <h3 class="p2 mb-3"><?= label("request_stat", $this); ?>&nbsp;<?=label('qmrapprove',$this)?></h3>
                <form action="<?=base_url('document/save_sec3/'.$getF->dc_data_darcode);?>" method="POST" name="">
                    <div class="form-row">
                        <?php
                            if($getF->dc_data_result_reson_status2 == "")
                            {   ?>
                         
                         <div><label for=""><input type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>

                         <?php
                            }else{ 
                                if($getF->dc_data_result_reson_status2 == 1){ ?>
                        <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>
                            <?php
                                }else{ ?>
                        <div><label for=""><input disabled type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status1" value="1">&nbsp;&nbsp;<?= label('result_status1', $this); ?></label></div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div><label for=""><input disabled checked type="radio" name="dc_data_result_reson_status2" id="dc_data_result_reson_status0" value="0">&nbsp;&nbsp;<?= label('result_status0', $this); ?></label></div>
                            <?php
                                }
                            }
                        ?>
                        

                        <textarea name="dc_data_result_reson_detail2" id="dc_data_result_reson_detail2" cols="30" rows="5" class="form-control" placeholder="<?= label('text_result_request', $this); ?>"><?=$getF->dc_data_result_reson_detail2;?></textarea>
                    </div>

                    <div class="form-row mt-3">
                        <div class="col-md-9 border p-5">
                            <label style="color:red;"><?= label('memo3', $this); ?> :&nbsp;</label><label for=""><?= label('memo4', $this); ?></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for=""><?= label("approvers", $this); ?></label>
                                <?php
                            if($getF->dc_data_approve_qmr == "")
                            { 
                                ?>
                                <input type="text" class="form-control" name="dc_data_approve_qmr" id="dc_data_approve_qmr" value="<?=$getuserCon;?>">
                           <?php
                            }else{ 
                                ?>
                                <input disabled type="text" class="form-control" name="dc_data_approve_qmr" id="dc_data_approve_qmr" value="<?=$getF->dc_data_approve_qmr;?>">
                        <?php
                            }
                            ?>
                                
                                <input type="submit" value="<?= label('save', $this); ?>" class="btn btn-primary mt-2" name="btnSave_sec3" id="btnSave_sec3">
                            </div>
                </form>
                <!-- ผลการร้องขอ -->
            </div>
        </div>
        <hr>
        <!-- ผลการร้องขอ -->


        <!-- สำหรับผู้ควบคุมเอกสาร -->
        <h3 class="p2 mb-3"><?= label("forstaff", $this); ?></h3>
        <form action="<?=base_url('document/save_sec4deptedit/'.$getF->dc_data_darcode);?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label for="">ยืนยันการทำสำเนาเอกสาร :</label>&nbsp;<label for=""><a href="<?=base_url()?><?=$getF->dc_data_file_location.$getF->dc_data_file;?>" target="_blank"><?=$getF->dc_data_file;?></a></label>
                <input hidden type="text" name="dc_data_file" id="dc_data_file" value="<?=$getF->dc_data_file;?>"/>
            </div>
            
            
            <div class="form-row">
                <textarea name="dc_data_method" id="dc_data_method" cols="30" rows="5" class="form-control" placeholder="การดำเนินการ"><?=$getF->dc_data_method;?></textarea>
            </div>

            <div class="form-row mt-3">
            <?php
    if($getF->dc_data_operation == '')
    { 
    ?>
            <label>ผู้ดำเนินการ : <input type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?=$getuserCon;?>"></label>
    <?php
    }else{ ?>
            <label>ผู้ดำเนินการ : <input disabled type="text" name="dc_data_operation" id="dc_data_operation" class="form-control" value="<?=$getF->dc_data_operation;?>"></label>
<?php
    }
?>
                
            </div>
            <input class="btn btn-primary " type="submit" name="btnOpsave" id="btnOpsave" value="<?= label('save2', $this); ?>">
            <input type="text" name="dc_data_old_dar" id="dc_data_old_dar" value="<?=$getF->dc_data_old_dar;?>">
        </form>







    </div><!-- Main Section -->






    </div><!-- Content Zone -->
    </div><!-- Content Zone -->
</body>

</html>