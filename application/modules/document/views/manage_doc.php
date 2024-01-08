<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Document</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <div class="row">
                    <div class="col-md-6">

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400">เอกสาร รอจัดเก็บ</div>


                            <div class="card-body text-danger table-responsive">
                                <h5 class="card-title">Danger card title</h5>

                                <table id="mytable" class="mb-0 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัสเอกสาร</th>
                                            <th>ชื่อไฟล์</th>
                                            <th>สถานะ</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($get_docready->result_array() as $rsdocready) { ?>
                                            <tr>
                                                <th scope="row"><?= $i ?></th>
                                                <td><a target="_blank" href="<?= base_url('document/viewfull/'); ?><?= $rsdocready['lib_main_doccode']; ?>"><?= $rsdocready['lib_main_doccode']; ?></a></td>
<?php
    if($rsdocready['lib_status_code'] == 'lib02')

    { 
        $doccode = $rsdocready['lib_main_doccode'];
        $result = $this->db->query("SELECT lib_master_doccode , lib_master_file_location FROM library_master_file WHERE lib_master_doccode = '$doccode' ");
        foreach($result->result_array() as $rss){
            $locationFile = $rss['lib_master_file_location'];
        
        ?>

<td><a href="<?=base_url();?><?=$locationFile;?>" target="_blank"><?= $rsdocready['lib_main_file']; ?></a></td>

<?php
}
    }else{ ?>

<td><?= $rsdocready['lib_main_file']; ?></td>

<?php
    }
?>
                                                

                                                <td><?= $rsdocready['lib_status_name']; ?></td>

                                                <?php
                                    if($rsdocready['lib_status_code'] == 'lib02')
                                    {
                                        $btn_lib = 'disabled' ;
                                    }else{
                                        $btn_lib = '';
                                    }
                                                ?>
                                                <td><a href="javascript:popup2('<?=base_url("document/create_master/")?><?=$rsdocready['lib_main_doccode'];?>','',500,500)"><button class="btn btn-success btn-sm" id="btn_lib01" <?=$btn_lib?>>เก็บ</button></a></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

<!-- Start code popup -->
<script type="text/javascript">
function popup2(url, name, windowWidth, windowHeight) {
myleft = (screen.width) ? (screen.width - windowWidth) / 2 : 100;
mytop = (screen.height) ? (screen.height - windowHeight) / 2 : 100;
properties = "width=" + windowWidth + ",height=" + windowHeight;
properties += ",scrollbars=yes, top=" + mytop + ",left=" + myleft;
window.open(url, name, properties);
}
</script>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-primary text-white" style="font-size:16px;font-weight:400">เอกสาร รอแจกจ่าย</div>


                            <div class="card-body text-danger table-responsive">
                                <h5 class="card-title">Danger card title</h5>

                                <table id="mytable2" class="mb-0 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัสเอกสาร</th>
                                            <th>ชื่อไฟล์</th>
                                            <th>สถานะ</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($get_docalready->result_array() as $rsdocready) { ?>
                                            <tr>
                                                <th scope="row"><?= $i ?></th>
                                                <td><a target="_blank" href="<?= base_url('document/viewfull/'); ?><?= $rsdocready['lib_main_doccode']; ?>"><?= $rsdocready['lib_main_doccode']; ?></a></td>
                                                <td><?= $rsdocready['lib_main_file']; ?></td>
                                                <td><?= $rsdocready['lib_status_name']; ?></td>
                                                <td><a href="javascript:popup1('<?=base_url("document/create_copy/")?><?=$rsdocready['lib_main_doccode'];?>','',500,500)"><button class="btn btn-primary btn-sm">แจกจ่าย</button></a></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Start code popup -->
<script type="text/javascript">
function popup1(url, name, windowWidth, windowHeight) {
myleft = (screen.width) ? (screen.width - windowWidth) / 2 : 100;
mytop = (screen.height) ? (screen.height - windowHeight) / 2 : 100;
properties = "width=" + windowWidth + ",height=" + windowHeight;
properties += ",scrollbars=yes, top=" + mytop + ",left=" + myleft;
window.open(url, name, properties);
}
</script>


                            </div>
                        </div>

                    </div>

                </div>
                <!-- END ROW -->


                <div class="row">
                    <div class="col-md-6">

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400">เอกสาร Master</div>


                            <div class="card-body text-danger table-responsive">
                                <h5 class="card-title">Danger card title</h5>

                                <table id="mytable3" class="mb-0 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัสเอกสาร</th>
                                            <th>ชื่อไฟล์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($get_master_file->result_array() as $get_master_files) { ?>
                                       <tr>
                                           <th scope="row"><?= $i ?></th>
                                           <td><?=$get_master_files['lib_master_doccode'];?></td>
                                           <td><a href="<?=base_url()?><?=$get_master_files['lib_master_file_location'];?>" target="_blank"><?=$get_master_files['lib_master_file_location'];?></a></td>
                                       </tr>

                                       <?php
                                            $i++;
                                        }
                                        ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-danger mb-3">
                            <div class="card-header bg-primary text-white" style="font-size:16px;font-weight:400">เอกสาร Document control</div>


                            <div class="card-body text-danger table-responsive">
                                <h5 class="card-title">Danger card title</h5>

                                <table id="mytable4" class="mb-0 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัสเอกสาร</th>
                                            <th>ชื่อไฟล์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($get_copy_file->result_array() as $get_copy_files) { ?>
                                       <tr>
                                           <th scope="row"><?= $i ?></th>
                                           <td><?=$get_copy_files['lib_copy_doccode'];?></td>
                                           <td><a href="<?=base_url()?><?=$get_copy_files['lib_copy_file_location'];?>" target="_blank"><?=$get_copy_files['lib_copy_file_location'];?></a></td>
                                       </tr>

                                       <?php
                                            $i++;
                                        }
                                        ?>

                                    </tbody>
                                </table>




                            </div>
                        </div>

                    </div>

                </div>
                <!-- END ROW -->




            </div>
            
        </div>

</body>
<script type="text/javascript">
    $(document).ready(function() {

        var t = $('#mytable').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [4, 'desc']
            ]
        });

        var t = $('#mytable2').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [4, 'desc']
            ]
        });


        var t = $('#mytable3').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [0, 'desc']
            ]
        });


        var t = $('#mytable4').DataTable({
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



</html>