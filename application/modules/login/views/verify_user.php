<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify User</title>
</head>
<?php 
$getuser = $this->login_model->getuser();
$getuserCon = $this->doc_get_model->convertName($getuser->Fname, $getuser->Lname);
?>
<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container border p-4 bg-white" style="margin-top:100px;">
                <!-- Main Section -->

                <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                    <h3>กรุณายืนยันตัวตนเพื่อเข้าใช้งานโปรแกรม</h3><br>
                            <button class="btn btn-primary btn-lg" style="font-size:25px;" data-toggle="modal" data-target="#verify_user_modal" >
                            Verify User
                        </button>
                        <br><br>
                        <a href="<?=base_url('login/logout')?>"><button class="btn btn-danger btn-lg">ยกเลิก</button></a>
                        
                    </div>
                </div>




                <!-- Verify user -->
                <div class="modal fade" id="verify_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <!-- Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">ยืนยันข้อมูลผู้ใช้โปรแกรม Document Library</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Header -->

                            <!-- Body -->
                            <div class="modal-body">
                                <form action="<?= base_url('login/save_verify_user/') ?>" name="" id="" method="post">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Username(Eng)</label>
                                            <input readonly type="text" name="dc_user_username" id="dc_user_username" class="form-control" value="<?=$getuser->username?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Password(Eng)</label>
                                            <input readonly type="password" name="dc_user_password" id="dc_user_password" class="form-control" value="<?=$getuser->password?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div class="form-group col-md-6">
                                            <label for="">ชื่อ(Eng)</label>
                                            <input type="text" name="dc_user_Fname" id="dc_user_Fname" class="form-control" value="<?=$getuser->Fname?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">นามสกุล(Eng)</label>
                                            <input type="text" name="dc_user_Lname" id="dc_user_Lname" class="form-control" value="<?=$getuser->Lname?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">รหัสพนักงาน(Eng)</label>
                                            <input type="text" name="dc_user_ecode" id="dc_user_ecode" class="form-control" value="<?=$getuser->ecode?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">อีเมล์</label>
                                            <input type="text" name="dc_user_memberemail" id="dc_user_memberemail" class="form-control" value="<?=$getuser->memberemail?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">ชื่อแผนก(Eng)</label>
                                            <input type="text" name="dc_user_Dept" id="dc_user_Dept" class="form-control" value="<?=$getuser->Dept?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">รหัสแผนก</label>
                                            <input readonly type="text" name="dc_user_DeptCode" id="dc_user_DeptCode" class="form-control" value="<?=$getuser->DeptCode?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <select name="verify_dept" id="verify_dept" class="form-control" required >
                                            <option value="">กรุณาเลือกแผนก</option>
<?php 
$get_dept = $this->db->where('dc_dept_main_code',$getuser->DeptCode);
$get_dept = $this->db->get('dc_dept_main');
foreach($get_dept->result_array() as $get_depts){
?>
                                            <option value="<?=$get_depts['dc_dept_code']?>"><?=$get_depts['dc_dept_main_name']?></option>
<?php } ?>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <input hidden type="text" name="conUsername" id="conUsername" value="<?=$getuserCon?>">
                                        </div>
                                    </div>


                            </div>
                            <!-- Body -->

                            <!-- Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" value="บันทึก" name="btnSaveUser_edit" class="btn btn-primary">
                            </div>
                            <!-- Footer -->
                            </form>

                        </div>
                    </div>
                </div>
                <!-- Verify user -->