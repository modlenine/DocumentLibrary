<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หน้าแสดงรายละเอียดเอกสารควบคุม ฉบับเต็ม</title>
</head>

<?php
    $getuser = $this->login_model->getuser();
    $getHashtag = $this->ctrldoc_model->getDctHashtag($doccode);
    $activeDarcode = getDataFileCtrlDoc($doccode)->row()->dct_lib_darcode;
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <div class="row">
                    <div class="col-md-12 form-group editbar-ctrldoc" style="display:none;">
                        <label class="pending_text-ctrldoc" for="" style="color:red;display:none;">เอกสารนี้อยู่ระหว่างถูกร้องขอดำเนินการแก้ไข ยังไม่พร้อมให้แก้ไข เปลี่ยนแปลง ในขณะนี้</label><br>
                        
                        <a href="<?= base_url('ctrldoc/requestEditCtrlDoc/'.$activeDarcode) ?>" style="display:none;" class="check_option-ctrldoc">
                            <button class="btn btn-warning"><i class="fas fa-exchange-alt" style="font-size:16px;"></i>&nbsp;&nbsp;ขอแก้ไขเอกสาร</button>
                        </a>
                        <a href="<?= base_url('ctrldoc/requestCancelCtrlDoc/'.$activeDarcode) ?>" style="display:none;" class="check_option-ctrldoc">
                            <button class="btn btn-danger"><i class="fas fa-ban" style="font-size:16px;"></i>&nbsp;&nbsp;ขอยกเลิกเอกสาร</button>
                        </a>
                    </div>
                    <!-- check lib_main_status -->

                </div>

                <div class="row">
                    <div class="col-md-8">
                        <?php foreach ($getdata_library->result_array() as $rs) {
                            if ($rs['dct_lib_status'] == "inactive") {
                                $cardcolor = " background-color:#F5F5F5!important;color:#696969!important; ";
                            } else {
                                $cardcolor = '';
                            }
                        ?>
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-info text-white" style="<?= $cardcolor ?>">
                                    <i class="fas fa-file-signature" style="font-size:18px;">&nbsp;&nbsp;</i>Document Detail&nbsp;:&nbsp;<?= $rs['dct_doccode']; ?>
                                </div>

                                <div class="card-body text-primary table-responsive" style="<?= $cardcolor ?>">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for=""><b>ชื่อเอกสาร : </b></label>&nbsp;<?= $rs['dct_docname']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class=""><b>ประเภทเอกสาร :</b></label>&nbsp;<?= $rs['dct_subtype_name']; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="" class=""><b>เลขที่ใบ DAR :</b></label>&nbsp;<?= $rs['dct_darcode']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>เลขที่เอกสาร : </b></label>&nbsp;<?= $rs['dct_doccode']; ?>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="" class=""><b>ระบบที่เกี่ยวข้อง :</b></label>&nbsp;<span>เอกสารควบคุม</span>
                                        </div>

                                        <div class="col-md-6">
                                            <label for=""><b>ไฟล์เอกสาร : </b></label>&nbsp;<a target="_blank" href="<?= base_url() ?><?= $rs['dct_file_location']; ?><?= $rs['dct_file']; ?>"><b><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $rs['dct_doccode_display']; ?></b></a>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="" class=""><b>วันที่ร้องขอ :</b></label>&nbsp;<?= con_date($rs['dct_date']); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class=""><b>วันที่เริ่มใช้ :</b></label>&nbsp;<?= con_date($rs['dct_datestart']); ?>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="" class=""><b>ครั้งที่แก้ไข :</b></label>&nbsp;<?= $rs['dct_editcount']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class=""><b>ระยะเวลาจัดเก็บ :</b></label>&nbsp;<?= $rs['dct_store']; ?>&nbsp;<?= $rs['dct_store_type']; ?>
                                        </div>
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label><b>ประเภทการร้องขอ :</b>&nbsp;<?= $rs['dc_reason_name'] ?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>รายละเอียดการร้องขอ :</b>&nbsp;<?=$rs['dct_reson_detail']?></label>
                                            </div>
                                    </div>

                                    <!-- Modal Section Reson detail -->

                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><b>แผนกที่เกี่ยวข้อง :&nbsp;</b> All</label>
                                        </div>
                                    </div>

                                    <!-- Modal Section Reson detail -->
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for=""><b>ผู้ร้องขอ :</b></label>&nbsp;<?= $rs['dct_user']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                                if($rs['dct_lib_status'] == "inactive"){
                                                    $show_status = "inactive";
                                                }else{
                                                    $show_status = "active";
                                                }
                                                $laststatus = $dcdoccode;
                                            ?>

                                            <label for=""><b>สถานะ :</b></label>&nbsp;<?= $show_status; ?>

                                        </div>
                                    </div>


                                    <div class="form-row mt-2">
                                        <div class="col-md-12">
                                            <label><b>แฮชแท็ก :&nbsp;</b></label>
                                            <?php
                                            $hashtag_html = "";
                                            foreach($getHashtag->result() as $rs){
                                                $hashtag_html .='<a href="javascript:void(0)">'.$rs->dct_hashtag_name.' </a>';
                                            }
                                            echo $hashtag_html;
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php  } ?>
                    </div>
                    <div class="col-md-4">
                        <?php 
                            $resultFile = getDataFileCtrlDoc($doccode)->row();
                        ?>

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-info text-white" style="font-size:18px;"></div>
                            <div class="card-body text-primary table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""><a target="_blank" href="<?= base_url() ?><?= $resultFile->dct_file_location; ?><?= $resultFile->dct_file?>"><i class="fas fa-search-plus" style="font-size:18px;"></i>&nbsp;&nbsp;ดูไฟล์ฉบับเต็ม</a></label>
                                    </div>
                                    <div class="col-md-12">
                                        <embed src="<?= base_url() . $resultFile->dct_file_location.$resultFile->dct_file; ?>" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        const ctrldoc_deptcode = "<?php echo getDataFileCtrlDoc($doccode)->row()->dc_dept_main_code; ?>";
        const modify_status = "<?php echo getDataFileCtrlDoc($doccode)->row()->dct_lib_modify_status; ?>";
        const userlogin_deptcode = "<?php echo $getuser->DeptCode; ?>";

        if(ctrldoc_deptcode === userlogin_deptcode || userlogin_deptcode == 1002){
            if(modify_status != "pending"){
                $('.editbar-ctrldoc').css('display' , '');
                $('.check_option-ctrldoc').css('display' , '');
            }else if(modify_status == "pending"){
                $('.pending_text-ctrldoc').css('display' , '');
                $('.editbar-ctrldoc').css('display' , '');
                $('.check_option-ctrldoc').css('display' , 'none');
            }
        }else if(ctrldoc_deptcode == "1001"){
            if(userlogin_deptcode == "1011"){
                if(modify_status != "pending"){
                    $('.editbar-ctrldoc').css('display' , '');
                    $('.check_option-ctrldoc').css('display' , '');
                }else if(modify_status == "pending"){
                    $('.pending_text-ctrldoc').css('display' , '');
                    $('.editbar-ctrldoc').css('display' , '');
                    $('.check_option-ctrldoc').css('display' , 'none');
                }
            }
        }

        console.log(ctrldoc_deptcode);
        console.log(userlogin_deptcode);
    });
</script>
</html>