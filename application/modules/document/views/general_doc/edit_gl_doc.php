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
                
            </div><br>


            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->


                <h2 style="text-align:center;">Form ขอใช้งานเอกสารภายใน</h2><label style="float:right;"><b>สถานะ :</b>&nbsp;<?=$get_view_docs->gl_doc_status;?></label><br>
                <input hidden type="text" name="check_gl_status" id="check_gl_status" value="<?=$get_view_docs->gl_doc_status;?>"/>
                <form action="<?=base_url('document/save_edit_gl_doc/').$get_view_docs->gl_doc_code?>" method="post" name="" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">วันที่ร้องขอ</label>
                            <input readonly type="text" name="" id="" value="<?=date("d-m-Y")?>" class="form-control">
                            <input hidden type="text" name="gl_doc_date_request" id="gl_doc_date_request" class="form-control read" value="<?=date("Y-m-d")?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">ผู้ร้องขอ</label>
                            <input type="text" name="gl_doc_username" id="gl_doc_username" class="form-control read" value="<?=$get_view_docs->gl_doc_username;?>">
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
                            <input type="text" name="gl_doc_name" id="gl_doc_name" class="form-control" value="<?=$get_view_docs->gl_doc_name;?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">รหัสเอกสาร</label>
                            <input type="text" name="gl_doc_code" id="gl_doc_code" class="form-control read" readonly value="<?=$get_view_docs->gl_doc_code;?>">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="">โฟลเดอร์ที่เก็บ</label>
                            <select name="gl_doc_folder_number" id="gl_doc_folder_number" class="form-control">
                                <option value="<?=$get_view_docs->gl_doc_folder_number?>"><?=$get_view_docs->gl_folder_name?></option>
                                <?php
                                
                                foreach(get_folder_code($get_user->DeptCode)->result_array() as $gfc){
                                    echo "<option value='".$gfc['gl_folder_number']."'>". $gfc['gl_folder_name']."</option>";
                                }
                                ?>
                            </select>
                            <label style="font-size:12px;color:red;">**หากไม่พบข้อมูล กรุณาติดต่อ DCC เพื่อเพิ่มข้อมูลให้</label>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">อัพโหลดไฟล์เอกสาร</label>&nbsp;&nbsp;<span><a id="up_file_gl" href="<?=base_url().$get_view_docs->gl_doc_file_location.$get_view_docs->gl_doc_file?>" target="_blank"><?=$get_view_docs->gl_doc_file;?></a></span>
                            
                            <input type="file" name="gl_doc_file" id="gl_doc_file" class="form-control" accept=".pdf" >
                            <input hidden type="text" name="check_status_gldoc" id="check_status_gldoc" value="<?=$get_view_docs->gl_doc_status;?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">รายละเอียดของเอกสาร</label>
                            <textarea name="gl_doc_detail" id="gl_doc_detail" cols="30" rows="5" class="form-control"><?=$get_view_docs->gl_doc_detail;?></textarea>
                        </div>
                    </div>
                    <input type="submit" value="บันทึกการแก้ไข" name="btnEdit_gldoc" class="btn btn-primary">

                    <input hidden type="text" name="check_gl_file" id="check_gl_file" value="<?=$get_view_docs->gl_doc_file?>" />
                </form>
