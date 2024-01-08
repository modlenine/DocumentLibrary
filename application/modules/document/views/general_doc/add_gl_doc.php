<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add General Document</title>
</head>
<?php $this->load->model("login_model");
$get_user = $this->login_model->getuser();
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->


                <h2 style="text-align:center;">Form ขอใช้งานเอกสารภายใน</h2><br>
                <form action="<?=base_url('document/save_gl_doc')?>" method="post" name="" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">วันที่ร้องขอ</label>
                            <input readonly type="text" name="" id="" value="<?= date("d/m/Y") ?>" class="form-control">
                            <input hidden type="text" name="gl_doc_date_request" id="gl_doc_date_request" class="form-control" value="<?= date("Y-m-d") ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">ผู้ร้องขอ</label>
                            <input readonly type="text" name="gl_doc_username" id="gl_doc_username" class="form-control" value="<?= convert_name($get_user->Fname, $get_user->Lname) ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">รหัสพนักงาน</label>
                            <input readonly type="text" name="gl_doc_ecode" id="gl_doc_ecode" class="form-control" value="<?= $get_user->ecode ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">แผนก</label>
                            <input readonly type="text" name="gl_doc_deptname" id="gl_doc_deptname" class="form-control" value="<?= $get_user->Dept ?>">
                            <input type="text" name="gl_doc_deptcode" id="gl_doc_deptcode" value="<?= $get_user->DeptCode ?>" hidden>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">ชื่อเอกสาร</label>
                            <input type="text" name="gl_doc_name" id="gl_doc_name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">รหัสเอกสาร</label>
                            <input type="text" name="gl_doc_code" id="gl_doc_code" class="form-control" readonly>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="">โฟลเดอร์ที่เก็บ</label>
                            <select name="gl_doc_folder_number" id="gl_doc_folder_number" class="form-control" required>
                                <option value="">กรุณาเลือก โฟลเดอร์ที่เก็บเอกสาร</option>
                                <?php
                                
                                foreach(get_folder_code($get_user->DeptCode)->result_array() as $gfc){
                                    echo "<option value='".$gfc['gl_folder_number']."'>". $gfc['gl_folder_name']."</option>";
                                }
                                ?>
                            </select>
                            <label style="font-size:12px;color:red;">**หากไม่พบข้อมูล กรุณาติดต่อ DCC เพื่อเพิ่มข้อมูลให้</label>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">อัพโหลดไฟล์เอกสาร</label>
                            <input type="file" name="gl_doc_file" id="gl_doc_file" class="form-control" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">รายละเอียดของเอกสาร</label>
                            <textarea name="gl_doc_detail" id="gl_doc_detail" cols="30" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <?php 
                            $string = $get_view_docs->gl_doc_hashtag;
                            $string = convertHashtoLink($string);
                            ?>
                            <span><?=$string?></span>
                            <?php 
                            if($get_view_docs->gl_doc_reson_detail == ""){ ?>
                        <input type="text" name="gl_doc_hashtag[]" id="gl_doc_hashtag" class="form-control" placeholder="ระบุ แฮชแท็กของไฟล์เอกสาร เช่น #เอกสารทั่วไป #ประกาศบริษัท" required maxlength='40'>
                        <?php    }
                            ?>
                            <button type="button" name="btnAddMore" id="btnAddMore" class="add_more btn btn-primary mt-2">เพิ่ม</button>
                        </div>
                    </div>
                    <input type="submit" value="บันทึกข้อมูล" name="btnAdd_gldoc" class="btn btn-primary">
                </form>


                <!-- <hr>
                <h2 style="text-align:center;">สำหรับ Document Control</h2><br>
                <form action="" method="post" name="" id="">
                    <div class="form-row">
                        <label for="" class="checkbox-inline"><input disabled type="radio" name="gl_doc_status" id="approve" value="1">&nbsp;อนุมัติ</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="" class="checkbox-inline"><input disabled type="radio" name="gl_doc_status" id="notapprove" value="0">&nbsp;ไม่อนุมัติ</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">เหตุผลในครั้งนี้</label>
                            <textarea disabled name="gl_doc_reson_detail" id="gl_doc_reson_detail" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input disabled type="text" name="hashtag" id="hashtag" class="form-control" placeholder="ใส่แฮชแท็ก Ex, #ประกาศบริษัท">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">ชื่อผู้อนุมัติ</label>
                            <input disabled type="text" name="gl_doc_approve" id="gl_doc_approve" class="form-control">
                        </div>
                    </div>
                </form> -->
                