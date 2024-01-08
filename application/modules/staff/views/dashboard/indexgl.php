<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Dasboard</title>
</head>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->

<h2>ปักหมุดเอกสาร ทั่วไป</h2><hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header text-white bg-primary">เอกสาร ทั่วไป ที่ปักหมุด</div>
                            <div class="card-body">

                            <table id="view_dociso_pin" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสเอกสาร</th>
                                    <th>ชื่อเอกสาร</th>
                                    <th>สถานะ</th>
                                    <th>#</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php $i = 1;
                                foreach (glDocPin()->result_array() as $get_doc_lists) {
                                    if ($get_doc_lists['gl_doc_pin_status'] == "pin") {
                                        $color_status = " style='color:green' ";
                                    } else {
                                        $color_status = " style='color:red' ";
                                    }

                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><a href="<?= base_url('librarys/viewfull_gl_document/') ?><?= $get_doc_lists['gl_doc_deptcode']."/". $get_doc_lists['gl_doc_folder_number']."/".$get_doc_lists['gl_doc_code']?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_doc_lists['gl_doc_code'] ?></a></td>
                                        <td><?= $get_doc_lists['gl_doc_name'] ?></td>
                                        <?php
                                            if ($get_doc_lists['lib_main_pin_status'] != "") {
                                                $markpin = ' / ';
                                            } else {
                                                $markpin = '';
                                            }

                                            if ($get_doc_lists['gl_doc_pin_status'] == "pin") {
                                                $upin = 'display:block;';
                                                $pin = 'display:none;';
                                            } else {
                                                $pin = 'display:block;';
                                                $upin = 'display:none;';
                                            }
                                            ?>
                                        <td <?= $color_status ?>><b><?= $get_doc_lists['gl_doc_pin_status'] ?></b></td>
                                        <td><div class="dropdown dropleft">
                                                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                    
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a class="dropdown-item" style="color:#EE0000;<?= $upin ?>" href="<?= base_url('staff/unpin_gldoc/') ?><?= $get_doc_lists['gl_doc_code'] ?>"><i class="fas fa-thumbtack"></i>&nbsp;&nbsp;ยกเลิกปักหมุด</a>

                                                </div>
                                            </div>
                                            
                                        </td>
                                        

                                    </tr>
                                <?php $i++; } ?>
                                <input hidden type="text" name="check_pin" id="check_pin" value="<?= countPin(); ?>">
                            </tbody>
                        </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>เอกสารล่าสุด</h3>
                        <table id="view_dociso" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสเอกสาร</th>
                                    <th>ชื่อเอกสาร</th>
                                    <th>วันที่ร้องขอ</th>
                                    <th>สถานะ</th>
                                    <th>#</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php $i = 1;
                                foreach (getGlDoc()->result_array() as $get_doc_lists) {
                                    if ($get_doc_lists['gl_doc_status'] == "Approved") {
                                        $color_status = " style='color:green' ";
                                    } else {
                                        $color_status = " style='color:red' ";
                                    }

                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><a href="<?= base_url('librarys/viewfull_gl_document/') ?><?= $get_doc_lists['gl_doc_deptcode']."/". $get_doc_lists['gl_doc_folder_number']."/".$get_doc_lists['gl_doc_code']?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_doc_lists['gl_doc_code'] ?></a></td>
                                        <td><?= $get_doc_lists['gl_doc_name'] ?></td>
                                        <td><?= con_date($get_doc_lists['gl_doc_date_request']) ?></td>
                                        <?php
                                            if(countGlPin() >= 5){
                                                $hideOp = 'display:none;';
                                            }else{
                                                $hideOp = 'display:block;';
                                            }
                                            ?>
                                        <td <?= $color_status ?>><b><?= $get_doc_lists['gl_doc_status']?></b></td>
                                        <td>
                                            <div class="dropdown dropleft" style="<?=$hideOp?>">
                                                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                    
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a class="dropdown-item" style="color:#EE0000;" href="<?= base_url('staff/pin_gldoc/') ?><?= $get_doc_lists['gl_doc_code'] ?>"><i class="fas fa-thumbtack"></i>&nbsp;&nbsp;ปักหมุด</a>


                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>




















                <script type="text/javascript">
                    $(document).ready(function() {

                        var t = $('#view_dociso').DataTable({
                            "columnDefs": [{
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [3, 'desc']
                            ]
                        });

                        t.on('order.dt search.dt', function() {
                            t.column(0, {
                                search: 'applied',
                                order: 'applied'
                            }).nodes().each(function(cell, i) {
                                cell.innerHTML = i + 1;
                            });
                        }).draw();


                        var t2 = $('#view_dociso_pin').DataTable({
                            "columnDefs": [{
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [3, 'asc']
                            ]
                        });

                        t2.on('order.dt search.dt', function() {
                            t2.column(0, {
                                search: 'applied',
                                order: 'applied'
                            }).nodes().each(function(cell, i) {
                                cell.innerHTML = i + 1;
                            });
                        }).draw();


                    });
                </script>