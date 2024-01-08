<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Center</title>
</head>
<?php
$this->load->model("get_lib_model");

?>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner">
            <!-- Content Zone -->

            <div class="container-fulid border p-4 bg-white">

                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-2">
                                <h3>เอกสารทั่วไป</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <?php foreach ($get_dept_folder->result_array() as $get_dept_folders) { ?>
                                <div class="col-md-12">
                                    <div class="card border-danger mb-3">
                                        <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400"><i class="fas fa-archive"></i>&nbsp;<?= $get_dept_folders['gl_dept_name'] ?></div>
                                        <?php
                                            $get_gl_dept_id = $get_dept_folders['gl_dept_id'];
                                            $get_folder_name = $this->db->query("SELECT * FROM gl_folder WHERE gl_folder_dept_id='$get_gl_dept_id' ")
                                            ?>

                                        <div class="card-body text-danger table-responsive">
                                            <ul class="list-group">
                                                <?php foreach ($get_folder_name->result_array() as $get_folder_names) { ?>

                                                    <?php $result_count = $this->get_lib_model->count_gl_doc($get_folder_names['gl_folder_number'], $get_folder_names['gl_folder_dept_code']);  ?>

                                                    <li id="list_document" class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="<?= base_url('librarys/view_gl_document/') . $get_folder_names['gl_folder_dept_code'] . "/" . $get_folder_names['gl_folder_number'] ?>">
                                                            <i class="fas fa-folder text-warning" style="font-size:16px;"></i>&nbsp;
                                                            <?= $get_folder_names['gl_folder_name'] ?>
                                                        </a>&nbsp;&nbsp;
                                                        <span id="count" class="badge badge-warning badge-pill"><?= $result_count ?></span>
                                                    </li>

                                                <?php } ?>
                                            </ul>
                                        </div>


                                    </div>
                                </div>

                            <?php } ?>
                        </div>

                    </div>
                    <div class="col-md-8">


                        <div class="row mb-2">
                            <div class="col-md-6 form-group">
                                <select name="doc_search_method" id="doc_search_method" class="form-control">
                                    <option value="">โปรดเลือกช่องทางการค้นหา</option>
                                    <option value="search_by_date">ค้นหาจากวันที่แจ้ง</option>
                                    <option value="search_by_docname">ค้นหาจากชื่อเอกสาร</option>
                                    <option value="search_by_doccode">ค้นหาจากรหัสเอกสาร</option>
                                    <option value="search_by_hashtag">ค้นหาจากแฮชแท็ก</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <a href="<?= base_url('librarys/document_center') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>
                            </div>
                        </div>


                        <!-- SEARCH ZONE -->
                        <!-- Search With Date -->
                        <!-- <form action="" name="" method="post"> -->
                            <div class="row mb-2" id="form_search_by_date">
                                <div class="col-md-12 form-inline">
                                    <input type="date" name="start_date" id="start_date" class="form-control datepicker_search" >&nbsp;TO&nbsp; 
                                    <input type="date" name="end_date" id="end_date" class="form-control datepicker_search" >
                                    &nbsp;&nbsp;
                                    <button type="submit" name="btn_search_date" id="btn_search_date" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button>
                                </div>

                            </div>
                        <!-- </form> -->
                        <!-- Search With Date -->


                        <!-- Search With Document Name -->
                        <!-- <form action="" name="" id="" method="post"> -->
                            <div class="row mb-2" id="form_search_by_docname">
                                <div class="col-md-8 form-inline">
                                    <input type="text" name="document_name" id="document_name" class="form-control" placeholder="กรุณาระบุชื่อเอกสาร" style="width:400px;">
                                    <!-- &nbsp;&nbsp;<button type="submit" name="btn_search_docname" id="btn_search_docname" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button> -->
                                </div>
                            </div>
                        <!-- </form> -->
                        <!-- Search With Document Name -->


                        <!-- Search With Document Number -->
                        <!-- <form action="" name="" id="" method="post"> -->
                        <div class="row mb-2" id="form_search_by_doccode">
                            <div class="col-md-8 form-inline">
                                <input type="text" name="document_code" id="document_code" class="form-control" placeholder="กรุณาระบุรหัสเอกสาร" style="width:400px;">
                                <!-- &nbsp;&nbsp;<button type="button" name="btn_search_doccode" id="btn_search_doccode" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button> -->
                            </div>
                        </div>
                        <!-- </form> -->
                        <!-- Search With Document Number -->

                        <!-- Search With Hashtag -->
                        <!-- <form action="" name="" method="post"> -->
                            <div class="row" id="form_search_by_hashtag">
                                <div class="col-md-8">
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" name="search_gl_doc" id="search_gl_doc" class="form-control" placeholder="ค้นหาเอกสารด้วย แฮชแท็ก">
                                    </div>
                                    <!-- <input type="text" name="search_gl_doc" id="search_gl_doc" class="form-control" placeholder="ค้นหาเอกสารด้วย แฮชแท็ก"> -->
                                </div>

                                <!-- <div class="col-md-4">
                                    <a href="<?= base_url('librarys/document_center') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>
                                    <button type="submit" name="btn_search_hashtag" id="btn_search_hashtag" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;Search</button>
                                </div> -->
                                
                            </div><br>
                        <!-- </form> -->
                        <!-- Search With Hashtag -->

                        <!-- SEARCH ZONE -->



                        <div class="row">

                            <div class="col-md-12" id="result"></div>

                            <div id="hashtag" class="col-md-12" style="display:none;">
                                <table id="rs_search_gl" class="table table-striped table-bordered dt-responsive" style="width:100%">
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
                                        <?php

                                        if (isset($_POST['btn_search_date'])) {

                                            $result = gl_search_by_date($this->input->post('date_start'), $this->input->post('date_end'));
                                        } else if (isset($_POST['btn_search_docname'])) {

                                            $result = gl_search_by_docname($this->input->post('document_name'));
                                        } else if (isset($_POST['btn_search_doccode'])) {

                                            $result = gl_search_by_doccode($this->input->post('document_code'));
                                        } else {

                                            if (isset($_GET['tag'])) {
                                                $check_tag = 1;
                                                $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
                                                $tag = preg_replace($expression, '', $_GET['tag']);
                                            } else {
                                                $check_tag = 0;
                                                $tag = $this->input->post("search_gl_doc");
                                            }
                                            $result = gl_search_by_hashtag($tag);
                                        }

                                        $i = 1;


                                        foreach ($result->result_array() as $rss) {
                                            ?>
                                            
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><a href="<?= base_url('librarys/viewfull_gl_document/') . $rss['gl_doc_deptcode'] . "/" . $rss['gl_doc_folder_number'] . "/" . $rss['gl_doc_code'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $rss['gl_doc_code']; ?></a></td>
                                                <td><?= $rss['gl_doc_name']; ?></td>
                                                <td><?= con_date($rss['gl_doc_date_request']) ?></td>
                                                <td><?= $rss['gl_doc_deptname']; ?></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        } ?>
                                    </tbody>
                                    <input type="text" name="check_tag" id="check_tag" value="<?=$check_tag?>">
                                </table>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function() {

                                    // Data table original   Data table original   Data table original   Data table original
                                    var t = $('#rs_search_gl').DataTable({
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
                                    // Data table original  Data table original    Data table original   Data table original






                                    var check_input;
                                    $('#doc_search_method').change(function() {
                                        var doc_search_method = $('#doc_search_method').val();

                                        if (doc_search_method == "search_by_doccode") {
                                            check_input = 1;
                                        } else if (doc_search_method == "search_by_docname") {
                                            check_input = 2;
                                        } else if (doc_search_method == "search_by_hashtag") {
                                            check_input = 3;
                                        }


                                    });
                                    // Search document Section

                                    load_datas();

                                    function load_datas(query) {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>librarys/fetch_doccode",
                                            method: "POST",
                                            data: {
                                                query: query
                                            },
                                            success: function(data) {
                                                $('#result').html(data);
                                                var tt = $('#rs_search_live').DataTable({
                                                    "columnDefs": [{
                                                        "searchable": false,
                                                        "orderable": false,
                                                        "targets": 0
                                                    }],
                                                    "order": [
                                                        [3, 'desc']
                                                    ]
                                                });

                                                tt.on('order.dt search.dt', function() {
                                                    tt.column(0, {
                                                        search: 'applied',
                                                        order: 'applied'
                                                    }).nodes().each(function(cell, i) {
                                                        cell.innerHTML = i + 1;
                                                    });
                                                }).draw();
                                            }
                                        });
                                    }


                                    function load_data(query) {
                                        if (check_input == 1) {
                                            $.ajax({
                                                url: "<?php echo base_url(); ?>librarys/fetch_doccode",
                                                method: "POST",
                                                data: {
                                                    query: query
                                                },
                                                success: function(data) {
                                                    $('#result').html(data);
                                                    var tt = $('#rs_search_live').DataTable({
                                                        "columnDefs": [{
                                                            "searchable": false,
                                                            "orderable": false,
                                                            "targets": 0
                                                        }],
                                                        "order": [
                                                            [3, 'desc']
                                                        ]
                                                    });

                                                    tt.on('order.dt search.dt', function() {
                                                        tt.column(0, {
                                                            search: 'applied',
                                                            order: 'applied'
                                                        }).nodes().each(function(cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                }
                                            });
                                        } else if (check_input == 2) {
                                            $.ajax({
                                                url: "<?php echo base_url(); ?>librarys/fetch_docname",
                                                method: "POST",
                                                data: {
                                                    query: query
                                                },
                                                success: function(data) {
                                                    $('#result').html(data);
                                                    var tt = $('#rs_search_live').DataTable({
                                                        "columnDefs": [{
                                                            "searchable": false,
                                                            "orderable": false,
                                                            "targets": 0
                                                        }],
                                                        "order": [
                                                            [3, 'desc']
                                                        ]
                                                    });

                                                    tt.on('order.dt search.dt', function() {
                                                        tt.column(0, {
                                                            search: 'applied',
                                                            order: 'applied'
                                                        }).nodes().each(function(cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                }
                                            });
                                        } else if (check_input == 3) {
                                            $.ajax({
                                                url: "<?php echo base_url(); ?>librarys/fetch_hashtag",
                                                method: "POST",
                                                data: {
                                                    query: query
                                                },
                                                success: function(data) {
                                                    $('#result').html(data);
                                                    var tt = $('#rs_search_live').DataTable({
                                                        "columnDefs": [{
                                                            "searchable": false,
                                                            "orderable": false,
                                                            "targets": 0
                                                        }],
                                                        "order": [
                                                            [3, 'desc']
                                                        ]
                                                    });

                                                    tt.on('order.dt search.dt', function() {
                                                        tt.column(0, {
                                                            search: 'applied',
                                                            order: 'applied'
                                                        }).nodes().each(function(cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                }
                                            });
                                        }
                                    }




                                    function load_search_date(start_date,end_date)
                                    {
                                            $.ajax({
                                                url: "<?php echo base_url(); ?>librarys/fetch_date",
                                                method: "POST",
                                                data: { start_date:start_date , end_date:end_date },
                                                success: function(data) {
                                                    $('#result').html(data);
                                                    var tt = $('#rs_search_live').DataTable({
                                                        "columnDefs": [{
                                                            "searchable": false,
                                                            "orderable": false,
                                                            "targets": 0
                                                        }],
                                                        "order": [
                                                            [3, 'desc']
                                                        ]
                                                    });

                                                    tt.on('order.dt search.dt', function() {
                                                        tt.column(0, {
                                                            search: 'applied',
                                                            order: 'applied'
                                                        }).nodes().each(function(cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                }
                                            });
                                    }





                                    $('#document_code').keyup(function() {
                                        var search = $(this).val();
                                        if (search != '') {
                                            load_data(search);
                                        } else {
                                            load_data();
                                        }
                                    });

                                    $('#document_name').keyup(function() {
                                        var search = $(this).val();
                                        if (search != '') {
                                            load_data(search);
                                        } else {
                                            load_data();
                                        }
                                    });

                                    $('#search_gl_doc').keyup(function() {
                                        var search = $(this).val();
                                        if (search != '') {
                                            load_data(search);
                                        } else {
                                            load_data();
                                        }
                                    });

                                    $('#btn_search_date').click(function (){
                                        var fromdate = $('#start_date').val();
                                        var todate = $('#end_date').val();
                                        if(fromdate != '' && todate != ''){
                                            load_search_date(fromdate,todate);
                                        }else{
                                            load_datas();
                                        }

                                    });




                                });
                            </script>

                            <div class="col-md-12">
                                <?php
                                $query = $this->db->query("SELECT
 gl_hashtag.gl_ht_name,
 gl_hashtag.gl_ht_doc_code,
 gl_hashtag.gl_ht_id
 FROM
 gl_hashtag
 GROUP BY gl_ht_name DESC LIMIT 50");

                                foreach ($query->result_array() as $rs) {
                                    $string =  $rs['gl_ht_name'] . "  ";
                                    $string = convertHashtoLink($string);
                                    echo $string;
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                </div>