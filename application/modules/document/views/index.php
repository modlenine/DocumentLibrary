<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script> -->

</head>

<?php
$this->load->model("librarys/get_lib_model");
$getuser = $this->get_lib_model->get_new_user();
$get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
$rsget = $get_deptlib->row();

?>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container border p-4 bg-white">
                <!-- Main Section -->
                <!-- <div class="row">
    <div class="col-md-6">
     <?= get_graph1() ?>
    </div>

    <div class="col-md-6">
    <?= get_graph2() ?>
    </div>
</div> -->

    <div class="row form-group mt-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="row">
                <div class="col-md-12 form-group">
                    <a href="<?= base_url('librarys/view_by_dept') ?>">
                        <button class="btn btn-primary btn-block" style="font-size:20px;padding:15px;">ค้นหาเอกสาร ISO</button>
                    </a>
                </div>
                <div class="col-md-12 form-group">
                    <a href="<?= base_url('ctrldoc/control_document') ?>">
                        <button class="btn btn-primary btn-block" style="font-size:20px;padding:15px;">ค้นหาเอกสารควบคุม</button>
                    </a>
                </div>
                <div class="col-md-12 form-group">
                    <a href="<?= base_url('librarys/document_center') ?>">
                        <button class="btn btn-primary btn-block" style="font-size:20px;padding:15px;">ค้นหาเอกสารทั่วไป</button>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-2"></div>
    </div>
                <br><br>
                <hr>


               


    <!-- <div class="row">
        <div class="col-md-12 form-group">
            <div class="card mb-3">
                <div class="card-header text-white bg-success">เอกสาร ISO แนะนำ</div>
                <div class="card-body">
                    
                <table id="user_docpin" class="table table-striped table-bordered dt-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รหัสเอกสาร</th>
                        <th>ชื่อเอกสาร</th>
                        <th>วันที่ร้องขอ</th>
                        <th>เอกสารของแผนก</th>

                    </tr>
                </thead>

                <tbody>

                    <?php $i = 1;
                    foreach (getIsoDocPin()->result_array() as $get_doc_lists) {
                        if ($get_doc_lists['lib_main_status'] == "active") {
                            $color_status = " style='color:green' ";
                        } else {
                            $color_status = " style='color:red' ";
                        }

                        ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><a href="<?= base_url('librarys/viewFull_document/').$get_doc_lists['dc_data_sub_type']."/".$rsget->related_code."/".$get_doc_lists['lib_main_doccode']?>"><i class="fas fa-thumbtack"></i>&nbsp;&nbsp;<i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_doc_lists['dc_data_doccode_display'] ?></a></td>
                            <td><?= $get_doc_lists['dc_data_docname'] ?></td>
                            <?php
                                if ($get_doc_lists['lib_main_pin_status'] != "") {
                                    $markpin = ' / ';
                                } else {
                                    $markpin = '';
                                }

                                if ($get_doc_lists['lib_main_pin_status'] == "pin") {
                                    $upin = 'display:block;';
                                    $pin = 'display:none;';
                                } else {
                                    $pin = 'display:block;';
                                    $upin = 'display:none;';
                                }
                                ?>
                            <td><?= con_date($get_doc_lists['dc_data_date']) ?></td>
                            <td><?= $get_doc_lists['dc_dept_main_name'] ?></td>

                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
                    
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12 form-group">
            <div class="card mb-3">
                <div class="card-header text-white bg-info">เอกสาร ทั่วไป แนะนำ</div>
                <div class="card-body">
                    
                <table id="user_docpingl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px;">#</th>
                        <th>รหัสเอกสาร</th>
                        <th>ชื่อเอกสาร</th>
                        <th>วันที่ร้องขอ</th>

                    </tr>
                </thead>

                <tbody>

                    <?php $i = 1;
                    foreach (glDocPin()->result_array() as $get_doc_lists) {
                        
                        ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><a href="<?= base_url('librarys/viewfull_gl_document/') ?><?= $get_doc_lists['gl_doc_deptcode']."/". $get_doc_lists['gl_doc_folder_number']."/".$get_doc_lists['gl_doc_code']?>"><i class="fas fa-thumbtack"></i>&nbsp;&nbsp;<i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_doc_lists['gl_doc_code'] ?></a></td>
                            <td><?= $get_doc_lists['gl_doc_name'] ?></td>
                            
                            <td><?= con_date($get_doc_lists['gl_doc_date_request']) ?></td>
                            
                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
                    
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(document).ready(function() {

            var t = $('#user_docpin').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }]
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();




            var tt = $('#user_docpingl').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }]
            });

            tt.on('order.dt search.dt', function() {
                tt.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();



        });
    </script> -->