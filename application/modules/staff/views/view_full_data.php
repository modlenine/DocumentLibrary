<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Full Data For Staff</title>
</head>

<?php
// $get_file1s = $get_file2->row();

?>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->


                <div class="row">
                <div class="col-md-8">

                <?php foreach ($view_full_data->result_array() as $get_file2s) {
                        if ($get_file2s['lib_main_status'] == "inactive") {
                            $cardcolor = " background-color:#F5F5F5!important;color:#696969!important; ";
                        } else {
                            $cardcolor = '';
                        }

                        ?>
                    <div class="card border-danger mb-3">
                        <div class="card-header bg-info text-white" style="<?= $cardcolor ?>"><i class="fas fa-file-signature" style="font-size:18px;">&nbsp;&nbsp;</i>Document Detail&nbsp;:&nbsp;<?= $get_file2s['dc_data_doccode']; ?></div>
                        <div class="card-body text-primary table-responsive" style="<?= $cardcolor ?>">

                        <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for=""><b>ชื่อเอกสาร : </b></label>&nbsp;<?= $get_file2s['dc_data_docname']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class=""><b>ประเภทเอกสาร :</b></label>&nbsp;<?= $get_file2s['dc_sub_type_name']; ?>
                                        </div>
                                        
                                    </div>


                                    <div class="row mb-2">
                                    <div class="col-md-6">
                                            <label for="" class=""><b>เลขที่ใบ DAR :</b></label>&nbsp;<?= $get_file2s['dc_data_darcode']; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>เลขที่เอกสาร : </b></label>&nbsp;<?= $get_file2s['dc_data_doccode_display']; ?>
                                        </div>
                                    </div>
                                  
                                    
                                    <div class="row mb-2">
                                    <div class="col-md-6">
                                            <label for="" class=""><b>ระบบที่เกี่ยวข้อง :</b></label>&nbsp;
                                            <?php
                                                $dcdatadept = $get_file2s['dc_data_dept'];
                                                $dcdarcode = $get_file2s['dc_data_darcode'];
                                                $dcdoccode = $get_file2s['dc_data_doccode'];

                                                $get_doc_type = $this->db->query("SELECT
                                    dc_type_use.dc_type_useid,
                                    dc_type_use.dc_type_use_darcode,
                                    dc_type_use.dc_type_use_doccode,
                                    dc_type_use.dc_type_use_code,
                                    dc_type.dc_type_name
                                    FROM
                                    dc_type_use
                                    INNER JOIN dc_type ON dc_type.dc_type_code = dc_type_use.dc_type_use_code
                                    WHERE dc_type_use_doccode = '$dcdoccode' && dc_type_use_status ='active' ");

                                                foreach ($get_doc_type->result_array() as $get_doc_types) {
                                                    echo "<label>" . $get_doc_types['dc_type_name'] . "</label>&nbsp;,&nbsp;";
                                                }
                                                ?>
                                        </div>
                                        <?php
                                            if ($get_file2s['lib_main_status'] == "inactive") {
                                                ?>
                                            <div class="col-md-6">
                                                <label for=""><b>ไฟล์เอกสาร : </b></label>&nbsp;<?= $get_file2s['lib_main_doccode_copy']; ?>
                                            </div>
                                        <?php   } else { ?>
                                            <div class="col-md-6">
                                                <label for=""><b>ไฟล์เอกสาร : </b></label>&nbsp;<a target="_blank" href="<?= base_url() ?><?= $get_file2s['lib_main_file_location_copy']; ?><?= $get_file2s['lib_main_doccode_copy']; ?>"><b><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_file2s['lib_main_doccode_copy']; ?></b></a>
                                            </div>
                                        <?php    }
                                            ?>
                                    </div>


                                    <div class="row mb-2">

                                        <div class="col-md-3">
                                            <label for="" class=""><b>วันที่ร้องขอ :</b></label>&nbsp;<?=con_date($get_file2s['dc_data_date']); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="" class=""><b>วันที่เริ่มใช้ :</b></label>&nbsp;<?=con_date($get_file2s['dc_data_date_start']); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="" class=""><b>ครั้งที่แก้ไข :</b></label>&nbsp;<?= $get_file2s['dc_data_edit']; ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="" class=""><b>ระยะเวลาจัดเก็บ :</b></label>&nbsp;<?= $get_file2s['dc_data_store']; ?>&nbsp;<?= $get_file2s['dc_data_store_type']; ?>
                                        </div>
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label><b>ประเภทการร้องขอ :</b>&nbsp;<?= get_reason($get_file2s['dc_data_reson']) ?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""><b>รายละเอียดการร้องขอ :</b>&nbsp;<a class="reason_detail" href="#" data-toggle="modal" data-target="#reason_detail"
                                            data_reason_detail = "<?=$get_file2s['dc_data_reson_detail']?>"
                                            >ดูรายละเอียด&nbsp;<i class="fas fa-search-plus" style="font-size:18px;"></i></a></label>
                                        </div>
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label for=""><b>แผนกที่เกี่ยวข้อง :&nbsp;</b></label>
                                            <?php
                                            
                                            foreach(get_related_use($get_file2s['dc_data_darcode'])->result_array() as $get_ru){
                                                echo $get_ru['related_dept_name']."&nbsp;,&nbsp;";
                                            } ?>
                                        </div>
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <label for=""><b>ผู้ร้องขอ :</b></label>&nbsp;<?= $get_file2s['dc_data_user']; ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for=""><b>สถานะ :</b></label>&nbsp;<?= $get_file2s['lib_main_status']; ?>
                                        </div>
                                    </div>



                        </div>
                    </div>
                    <?php  } ?>

                </div>

                <div class="col-md-4">

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-info text-white" style="font-size:18px;"></div>
                            <div class="card-body text-primary table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
<label for=""><a target="_blank" href="<?= base_url() ?><?= $get_file2s['lib_main_file_location_copy']; ?><?= $get_file2s['lib_main_doccode_copy']; ?>"><i class="fas fa-search-plus" style="font-size:18px;"></i>&nbsp;&nbsp;ดูไฟล์ฉบับเต็ม</a></label>
                                    </div>
                                    <div class="col-md-12">
                                        <embed src="<?= base_url().$get_file2s['lib_main_file_location_copy'].$get_file2s['lib_main_doccode_copy'] ?>" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>




 