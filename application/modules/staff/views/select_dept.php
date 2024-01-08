<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Dept for create folder</title>
</head>
<?php
$select_depts = $select_dept->row();
?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->

                <div class="row">
                    <div class="col-md-12">
                        <label for="">
                            <h3><a href="<?= base_url('staff/manage_dept') ?>"><button class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i></button></a>&nbsp;&nbsp;ขณะนี้คุณอยู่ที่หน้าแผนก : &nbsp;<?= $select_depts->gl_dept_name ?></h3>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div style="border:1px solid #ccc;padding:15px">
                            <form action="<?= base_url('staff/save_folder') ?>" name="" method="POST">
                                <div class="form-group">
                                    <label for="">รหัสแผนก</label>
                                    <input readonly type="text" name="gl_folder_dept_code" id="gl_folder_dept_code" class="form-control" value="<?= $select_depts->gl_dept_code ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">เลขที่เอกสาร</label>
                                    <input readonly type="text" name="gl_folder_number" id="gl_folder_number" class="form-control" value="<?=get_gl_folder_number($select_depts->gl_dept_id);?>">
                                </div>
                                <div class="form-group">
                                    <label for="">ชื่อ โฟลเดอร์เอกสาร</label>
                                    <input type="text" name="gl_folder_name" id="gl_folder_name" class="form-control">
                                </div>
                                <input type="submit" value="เพิ่ม" name="add_dept" id="add_dept" class="btn btn-success">
                                <!-- Hide input for add to data base -->
                                <input hidden type="text" name="hide_dept_id" id="hide_dept_id" value="<?= $select_depts->gl_dept_id ?>">
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-success text-white">รายชื่อโฟลเดอร์</div>
                            <div class="card-body text-primary">

                                <table id="folder" class="table table-striped table-bordered dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;">#</th>
                                            <th>ชื่อโฟลเดอร์</th>
                                            <th style="width:100px;"></th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $i = 1;
                                        foreach ($get_folder->result_array() as $get_folders) { ?>
                                        <tr>
                                            <th scope="row" style="text-align:center;"><?= $i ?></th>
                                            <td><i class="fas fa-folder-open fa-2x" style="color:orange;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $get_folders['gl_folder_name'] ?></td>
                                            <td>
                                                <div class="dropdown dropleft">
                                                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                        ตัวเลือก
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" style="color:green" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;แก้ไข</a>
                                                        <a class="dropdown-item" style="color:red;" href="<?= base_url('staff/del_folder/') ?><?= $get_folders['gl_folder_id'] . "/" . $get_folders['gl_folder_dept_id'] ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;ลบ</a>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {

                        var t = $('#folder').DataTable({
                            "columnDefs": [{
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [0, 'desc']
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


                    });
                </script>