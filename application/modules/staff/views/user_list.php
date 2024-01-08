<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>
</head>

<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->


                <div class="container">
                    <h3 style="text-align:center;">User List</h3>
                    <table id="user_list" class="table table-striped table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th style="width:80px;">ชื่อผู้ใช้งาน</th>
                                <th>ชื่อ</th>
                                <th>สกุล</th>
                                <th style="width:80px;">ชื่อแผนก</th>
                                <th>อีเมล</th>
                                <th>กลุ่มของสิทธิ์</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($view_user->result_array() as $vu) { ?>
                            <tr>
                                <td scope="row" style="text-align:center;"><?= $i ?></td>
                                <td><?= $vu['dc_user_username'] ?></td>
                                <td><?= $vu['dc_user_Fname'] ?></td>
                                <td><?= $vu['dc_user_Lname'] ?></td>
                                <td><?= $vu['dc_user_Dept'] ?></td>
                                <td><?= $vu['dc_user_memberemail'] ?></td>
                                <td><?= $vu['dc_gp_permis_name'] ?></td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                            ตัวเลือก
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a class="dropdown-item edit_permis_modal" style="color:#00BFFF;" href="" data-toggle="modal" data-target="#edit_permis_modal" 
                                            data_edit_permis_username="<?= $vu['dc_user_username'] ?>"
                                            data_edit_permis_deptname="<?= $vu['dc_user_Dept'] ?>"
                                            data_edit_permis_groupname="<?= $vu['dc_gp_permis_name'] ?>"
                                            data_edit_permis_groupid="<?= $vu['dc_user_group'] ?>"
                                            data_edit_permis_userid="<?= $vu['dc_user_id'] ?>"
                                            ><i class="fas fa-check-square"></i>&nbsp;&nbsp;แก้ไขกลุ่มผู้ใช้</a>

                                            <a class="dropdown-item edit_user_modal" style="color:green" href="" data-toggle="modal" data-target="#edit_user_modal" 
                                            data_edituser_userid="<?= $vu['dc_user_id'] ?>"
                                            data_edituser_fname="<?= $vu['dc_user_Fname'] ?>"
                                            data_edituser_lname="<?= $vu['dc_user_Lname'] ?>"
                                            data_edituser_deptname="<?= $vu['dc_user_Dept'] ?>"
                                            data_edituser_deptcode="<?= $vu['dc_user_DeptCode'] ?>"
                                            data_edituser_ecode="<?= $vu['dc_user_ecode'] ?>"
                                            data_edituser_memberemail="<?= $vu['dc_user_memberemail'] ?>"
                                            
                                            ><i class="fas fa-edit"></i>&nbsp;&nbsp;แก้ไขข้อมูล</a>

                                            <a class="dropdown-item" style="color:red;" onclick="javascript:return confirm('คุณต้องลบข้อมูล ใช่หรือไม่');" href="<?=base_url('staff/delete_user/').$vu['dc_user_id']?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;ลบ</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>



                <script type="text/javascript">
                    $(document).ready(function() {

                        var t = $('#user_list').DataTable({
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