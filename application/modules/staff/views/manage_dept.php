<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Management Department Page</title>

</head>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->


                <div class="row">

                    <div class="col-md-4">
                        <div style="border:1px solid #ccc;padding:15px">
                            <form action="<?= base_url('staff/save_dept') ?>" name="" method="POST">
                                <div class="form-group">
                                    <label for="">รหัสแผนก</label>
                                    <input type="text" name="gl_dept_code" id="gl_dept_code" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">ชื่อแผนก</label>
                                    <input type="text" name="gl_dept_name" id="gl_dept_name" class="form-control">
                                </div>
                                <input type="submit" value="เพิ่ม" name="add_dept" id="add_dept" class="btn btn-success">
                            </form>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-success text-white">รายชื่อแผนก</div>
                            <div class="card-body text-primary">
                                <!-- <h5 class="card-title">Primary card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->

                                <table id="dept" class="table table-striped table-bordered dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;">#</th>
                                            <th style="width:80px;">รหัสแผนก</th>
                                            <th>ชื่อแผนก</th>
                                            <th>โฟลเดอร์</th>
                                            <th style="width:80px;">#</th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $i = 1;
                                        foreach ($get_dept->result_array() as $get_depts) { ?>
                                        <tr>
                                            <th scope="row" style="text-align:center;"><?= $i ?></th>
                                            <td><?= $get_depts['gl_dept_code'] ?></td>
                                            <td><?= $get_depts['gl_dept_name'] ?></td>
                                            <td>
                                                <?php 
                                                $get_folders = get_folder($get_depts['gl_dept_id']);
                                                foreach($get_folders->result_array() as $gf){
                                                    echo $gf['gl_folder_name']."&nbsp;,";
                                                } ?>
                                            </td>
                                            <td>
                                                <div class="dropdown dropleft">
                                                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cog"></i>
                                                        ตัวเลือก
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" style="color:#00BFFF;" href="<?= base_url('staff/select_dept/') ?><?= $get_depts['gl_dept_id'] ?>"><i class="fas fa-check-square"></i>&nbsp;&nbsp;เลือก</a>

                                                        <a class="dropdown-item edit_dept_modal" style="color:green" href="" data-toggle="modal" data-target="#edit_dept_modal"
                                                        data-dept-id="<?= $get_depts['gl_dept_id'] ?>"
                                                        data-dept-code="<?= $get_depts['gl_dept_code'] ?>"
                                                        data-dept-name="<?= $get_depts['gl_dept_name'] ?>"
                                                        ><i class="fas fa-edit"></i>&nbsp;&nbsp;แก้ไข</a>
                                                        
                                                        <a class="dropdown-item" style="color:red;" href="<?= base_url('staff/del_dept/') ?><?= $get_depts['gl_dept_id'] ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;ลบ</a>
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

                        var t = $('#dept').DataTable({
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