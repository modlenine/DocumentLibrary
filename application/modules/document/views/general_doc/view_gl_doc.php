<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View General Document</title>
</head>
<?php 
$this->load->model("login_model");
$get_user = $this->login_model->getuser();
$get_view_docs = $get_view_doc->row(); 
?>
<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->

            <div class="container-fulid border p-2 bg-white mb-2">
                <a href="<?=base_url('document/list_generel')?>"><button class="btn btn-secondary"><i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;กลับ</button></a>
                <a href="<?= base_url('document/edit_gl_doc/').$get_view_docs->gl_doc_code?>"><input style="display:none;" type="button" name="btn_edit_gl" id="btn_edit_gl" class="btn btn-info" value="แก้ไข"/></a>
            </div><br>


            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->

<div class="row" style="float:right;">
<label style="float:right;"><b>สถานะ :</b>&nbsp;<?=$get_view_docs->gl_doc_status;?></label>
</div>
                <h2 style="text-align:center;">Form ขอใช้งานเอกสารภายใน</h2>
                <input hidden type="text" name="check_gl_status" id="check_gl_status" value="<?=$get_view_docs->gl_doc_status;?>"/>
                <!-- <form action="<?=base_url('document/save_gl_doc')?>" method="post" name="" enctype="multipart/form-data"> -->

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">วันที่ร้องขอ</label>
                            <input readonly type="text" name="" id="" value="<?=con_date($get_view_docs->gl_doc_date_request)?>" class="form-control">
                            <input hidden type="text" name="gl_doc_date_request" id="gl_doc_date_request" class="form-control read" value="<?=$get_view_docs->gl_doc_date_request;?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">ผู้ร้องขอ</label>
                            <input type="text" name="gl_doc_username" id="gl_doc_username" class="form-control read" value="<?=$get_view_docs->gl_doc_username;?>">
                            <input hidden type="text" name="check_dc_data_user" id="check_dc_data_user" value="<?= $get_view_docs->gl_doc_username; ?>">
                                            <!-- Check owner user for btn_edit -->
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">รหัสพนักงาน</label>
                            <input type="text" name="gl_doc_ecode" id="gl_doc_ecode" class="form-control read" value="<?=$get_view_docs->gl_doc_ecode;?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">แผนก</label>
                            <input type="text" name="gl_doc_deptname" id="gl_doc_deptname" class="form-control read" value="<?=$get_view_docs->gl_doc_deptname;?>">
                            <input type="text" name="gl_doc_deptcode" id="gl_doc_deptcode" value="<?=$get_view_docs->gl_doc_deptcode;?>" hidden>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">ชื่อเอกสาร</label>
                            <input type="text" name="gl_doc_name" id="gl_doc_name" class="form-control read" value="<?=$get_view_docs->gl_doc_name;?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">รหัสเอกสาร</label>
                            <input type="text" name="gl_doc_code" id="gl_doc_code" class="form-control read" readonly value="<?=$get_view_docs->gl_doc_code;?>">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="">โฟลเดอร์ที่เก็บ</label>
                            <input type="text" name="" id="" class="form-control read" value="<?=$get_view_docs->gl_folder_name;?>">
                            <!-- <select name="gl_doc_folder_number" id="gl_doc_folder_number" class="form-control read">
                                <option value="<?=$get_view_docs->gl_doc_folder_number;?>"><?=$get_view_docs->gl_folder_name;?></option>
                                <?php
                                
                                foreach(get_folder_code($get_user->DeptCode)->result_array() as $gfc){
                                    echo "<option value='".$gfc['gl_folder_number']."'>". $gfc['gl_folder_name']."</option>";
                                }
                                ?>
                            </select> -->
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">อัพโหลดไฟล์เอกสาร</label><br>
                            <span><a id="up_file_gl" href="<?=base_url().$get_view_docs->gl_doc_file_location.$get_view_docs->gl_doc_file?>" target="_blank"><?=$get_view_docs->gl_doc_file;?></a></span>
                            <!-- <input type="file" name="gl_doc_file" id="gl_doc_file" class="form-control" accept=".pdf"> -->
                            <input hidden type="text" name="check_status_gldoc" id="check_status_gldoc" value="<?=$get_view_docs->gl_doc_status;?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">รายละเอียดของเอกสาร</label>
                            <textarea name="gl_doc_detail" id="gl_doc_detail" cols="30" rows="5" class="form-control read"><?=$get_view_docs->gl_doc_detail;?></textarea>
                        </div>
                    </div>
                    <!-- <input type="submit" value="บันทึกข้อมูล" name="btnAdd_gldoc" class="btn btn-primary"> -->
                <!-- </form> -->

<div id="gl_doc_approve">
                <hr>
                <h2 style="text-align:center;">สำหรับ Document Control</h2><br>
                <form action="<?=base_url('document/save_gl_doc2/').$get_view_docs->gl_doc_code;?>" method="post" name="" id="">
                    <div class="form-row">
                        <label for="" class="checkbox-inline"><input type="radio" name="gl_doc_status" id="rs_approve" value="1">&nbsp;อนุมัติ</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="" class="checkbox-inline"><input type="radio" name="gl_doc_status" id="rs_notapprove" value="0">&nbsp;ไม่อนุมัติ</label>
                        <input hidden type="text" name="result_gl_doc_status" id="result_gl_doc_status" value="<?=$get_view_docs->gl_doc_approve_status;?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">เหตุผลในครั้งนี้</label>
                            <?php 
                            if($get_view_docs->gl_doc_reson_detail == ""){ ?>
                            <textarea name="gl_doc_reson_detail" id="gl_doc_reson_detail" cols="30" rows="5" class="form-control"></textarea>
                          <?php  } else{ ?>
                            <textarea name="gl_doc_reson_detail" id="gl_doc_reson_detail" cols="30" rows="5" class="form-control read"><?=$get_view_docs->gl_doc_reson_detail;?></textarea>
                       <?php   }
                            ?>
                            
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <?php 
                            $string = $get_view_docs->gl_doc_hashtag;
                            $string = convertHashtoLink($string);
                            ?>
                            <span><?=$string?></span>
                            <?php 
                            if($get_view_docs->gl_doc_reson_detail == ""){ ?>
                        <input type="text" name="gl_doc_hashtag[]" id="gl_doc_hashtag" class="form-control" placeholder="ระบุ แฮชแท็กของไฟล์เอกสาร เช่น #เอกสารทั่วไป #ประกาศบริษัท" maxlength='40'>
                        <?php    }
                            ?>
                            <button type="button" name="btnAddMore" id="btnAddMore" class="add_more btn btn-primary mt-2">เพิ่ม</button>
                        </div> -->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">ชื่อผู้อนุมัติ</label>

                            <?php  if($get_view_docs->gl_doc_approve_by == ""){ ?>

                            <input type="text" name="gl_doc_approve_by" id="gl_doc_approve_by" class="form-control " value="<?= convert_name($get_user->Fname, $get_user->Lname) ?>">

                           <?php } else { ?>

                            <input type="text" name="gl_doc_approve_by" id="gl_doc_approve_by" class="form-control read" value="<?=$get_view_docs->gl_doc_approve_by;?>">

                         <?php  }
                            ?>
                        </div>
                    </div>
                    <input type="submit" value="บันทึก" name="btn_save2" id="btn_save2" class="btn btn-primary">
                </form>
                </div>