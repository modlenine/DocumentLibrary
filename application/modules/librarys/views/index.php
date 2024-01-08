<!DOCTYPE html>

<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library Saleecolour..</title>
</head>

<?php
    $this->load->model("get_lib_model");
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
?>



<body>

    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <!-- Main Section -->
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-2">
                                <h3>เอกสาร ISO</h3>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">

                        <div class="col-md-3">
                        <?php foreach ($get_deptlib->result_array() as $get_deptlibs) { ?>
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400"><i class="fas fa-archive"></i>&nbsp;<?= $get_deptlibs['related_dept_name']; ?></div>
                                <div class="card-body text-danger table-responsive">

                                    <ul class="list-group">
                                        <?php foreach ($get_sub_type->result_array() as $get_sub_types) { ?>
                                            <?php
                                                $count_file = $this->get_lib_model->get_file1($get_sub_types['dc_sub_type_code'], $get_deptlibs['related_code']);
                                                $rs_count = $count_file->num_rows();
                                            ?>
                                            <li id="list_document" class="list-group-item d-flex justify-content-between align-items-center">

                                                <a href="<?= base_url('librarys/view_document/') ?><?= $get_sub_types['dc_sub_type_code'] ?>/<?= $get_deptlibs['related_code']; ?>">

                                                    <i class="fas fa-folder text-warning" style="font-size:16px;"></i>&nbsp;

                                                    <?= $get_sub_types['dc_sub_type_name'] ?>

                                                </a>&nbsp;&nbsp;

                                                <span id="count" class="badge badge-warning badge-pill"><?= $rs_count ?></span>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php } ?>

                            <?php
                                if($getuser->dc_user_ecode == "M0040"){
                                    $fileForsompong = "";
                                }else{
                                    $fileForsompong = 'style="display:none;"';
                                }

                            ?>
                            <div class="card border-danger mb-3" <?=$fileForsompong?>>
                                <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400"><i class="fas fa-archive mr-2"></i> PD</div>
                                <div class="card-body text-danger table-responsive">

                                    <ul class="list-group">
                                        <?php foreach ($get_sub_type->result_array() as $get_sub_types) { ?>
                                            <?php
                                                $count_file = $this->get_lib_model->new_getdata1($get_sub_types['dc_sub_type_code'],'re11');
                                                $rs_count = $count_file->num_rows();
                                            ?>
                                            <li id="list_document" class="list-group-item d-flex justify-content-between align-items-center">

                                                <a href="<?= base_url('librarys/view_document/') ?><?= $get_sub_types['dc_sub_type_code'] ?>/re11">

                                                    <i class="fas fa-folder text-warning" style="font-size:16px;"></i>&nbsp;

                                                    <?= $get_sub_types['dc_sub_type_name'] ?>

                                                </a>&nbsp;&nbsp;

                                                <span id="count" class="badge badge-warning badge-pill"><?= $rs_count ?></span>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>

                        </div>


                    <div class="col-md-9">
                        <div class="row mb-2">
                            <div class="col-md-6 form-group">
                                <select name="doc_search_method" id="doc_search_method" class="form-control">
                                    <option value="">โปรดเลือกช่องทางการค้นหา</option>
                                    <option value="search_by_date">ค้นหาจากวันที่แจ้ง</option>
                                    <option value="search_by_docname">ค้นหาจากชื่อเอกสาร</option>
                                    <option value="search_by_doccode">ค้นหาจากรหัสเอกสาร</option>
                                    <!-- <option value="search_by_darcode">ค้นหาจากเลขที่ใบDAR</option> -->
                                    <option value="search_by_hashtag">ค้นหาจากแฮชแท็ก</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-4 form-group">
                                <a href="<?= base_url('librarys/view_by_dept') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>
                            </div>
                        </div>
                        <!-- SEARCH ZONE -->

                        <!-- Search With Hashtag -->

                        <!-- <form action="" name="" method="post"> -->

                        <div class="row mb-2" id="form_search_by_hashtag">
                            <div class="col-md-7">
                                <div class="input-group flex-nowrap">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search_doc" id="search_doc" class="form-control" placeholder="ค้นหาเอกสารด้วย แฮชแท็ก">
                                </div>
                            </div>
                        </div>

                        <!-- </form> -->

                        <!-- Search With Hashtag -->



                        <!-- Search With Date -->

                        <!-- <form action="" name="" method="post"> -->

                        <div class="row mb-2" id="form_search_by_date">
                            <div class="col-md-8 form-inline">
                                <input type="date" name="start_date" id="start_date" class="form-control datepicker_search">&nbsp;TO&nbsp;
                                <input type="date" name="end_date" id="end_date" class="form-control datepicker_search">
                                &nbsp;&nbsp;
                                <button type="submit" name="btn_search_date" id="btn_search_date" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button>
                            </div>
                        </div>
                        <!-- </form> -->
                        <!-- Search With Date -->





                        <!-- Search With Document Name -->

                        <!-- <form action="" name="" id="" method="post"> -->

                        <div class="row mb-2" id="form_search_by_docname">
                            <div class="col-md-7 form-inline">
                                <input type="text" name="document_name" id="document_name" class="form-control" placeholder="กรุณาระบุชื่อเอกสาร" style="width:550px;">
                                <!-- &nbsp;&nbsp;<button type="submit" name="btn_search_docname" id="btn_search_docname" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button> -->
                            </div>
                        </div>
                        <!-- </form> -->
                        <!-- Search With Document Name -->





                        <!-- Search With Document Number -->

                        <!-- <form action="" name="" id="" method="post"> -->

                        <div class="row mb-2" id="form_search_by_doccode">
                            <div class="col-md-7 form-inline">
                                <input type="text" name="document_code" id="document_code" class="form-control" placeholder="กรุณาระบุรหัสเอกสาร" style="width:550px;">
                                <!-- &nbsp;&nbsp;<button type="submit" name="btn_search_doccode" id="btn_search_doccode" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button> -->
                            </div>
                        </div>
                        <!-- </form> -->
                        <!-- Search With Document Number -->

                        <!-- Search With Darnumber -->
                        <form action="" name="" id="" method="post">
                            <div class="row mb-2" id="form_search_by_darcode">
                                <div class="col-md-8 form-inline">
                                    <input type="text" name="dar_code" id="dar_code" class="form-control" placeholder="กรุณาระบุเลขที่ใบ DAR" style="width:400px;">
                                    &nbsp;&nbsp;<button type="submit" name="btn_search_darcode" id="btn_search_darcode" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button>
                                </div>
                            </div>
                        </form>
                        <!-- Search With Darnumber -->

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
                                            <th>วันที่แจ้ง</th>
                                            <th>เอกสารของแผนก</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        $rsget = $get_deptlib->row();
                                        if (isset($_POST['btn_search_hashtag'])) {
                                            if (isset($_GET['tag'])) {
                                                $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
                                                $tag = preg_replace($expression, '', $_GET['tag']);
                                            } else {
                                                $tag = $this->input->post("search_doc");
                                            }
                                            $result = search_by_hashtag($rsget->related_code, $tag);
                                        } else if (isset($_POST['btn_search_date'])) {
                                            $result = search_by_date($rsget->related_code, $this->input->post('date_start'), $this->input->post('date_end'));
                                        } else if (isset($_POST['btn_search_docname'])) {
                                            $result = search_by_docname($rsget->related_code, $this->input->post('document_name'));
                                        } else if (isset($_POST['btn_search_doccode'])) {
                                            $result = search_by_doccode($rsget->related_code, $this->input->post('document_code'));
                                        } else if (isset($_POST['btn_search_darcode'])) {
                                            $result = search_by_darcode($rsget->related_code, $this->input->post('dar_code'));
                                        } else {
                                            if (isset($_GET['tag'])) {
                                                $check_tag = 1;
                                                $expression = "/#+([ก-เa-zA-Z0-9_]+)/";
                                                $tag = preg_replace($expression, '', $_GET['tag']);
                                            } else {
                                                $check_tag = 0;
                                                $tag = $this->input->post("search_doc");
                                            }
                                            $result = search_by_hashtag($rsget->related_code, $tag);
                                        }

                                        $i = 1;
                                        foreach ($result->result_array() as $rss) {
                                        ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><a href="<?= base_url('librarys/viewFull_document/') . $rss['dc_data_sub_type'] . "/" . $rsget->related_code . "/" . $rss['lib_main_doccode'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $rss['dc_data_doccode']; ?></a></td>
                                                <td><?= $rss['dc_data_docname']; ?></td>
                                                <td><?= con_date($rss['dc_data_date']) ?></td>
                                                <td><?= $rss['dc_dept_main_name']; ?></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        } ?>

                                    </tbody>
                                    <input type="text" name="check_tag" id="check_tag" value="<?= $check_tag ?>">
                                </table>
                            </div>

                            <div class="col-md-12">
                                <?php
                                    $query = $this->db->query("SELECT
                                        library_hashtag.li_hashtag_id,
                                        library_hashtag.li_hashtag_doc_code,
                                        library_hashtag.li_hashtag_name,
                                        library_hashtag.li_hashtag_status,
                                        dc_related_dept.related_dept_name,
                                        dc_related_dept.related_code,
                                        dc_related_dept_use.related_dept_code
                                        FROM
                                        library_hashtag
                                        INNER JOIN dc_related_dept_use ON dc_related_dept_use.related_dept_doccode = library_hashtag.li_hashtag_doc_code
                                        INNER JOIN dc_related_dept ON dc_related_dept.related_code = dc_related_dept_use.related_dept_code
                                        WHERE dc_related_dept_use.related_dept_code = '$rsget->related_code' && library_hashtag.li_hashtag_status = 'active'
                                        GROUP BY li_hashtag_name DESC LIMIT 50");



                                    foreach ($query->result_array() as $rs) {
                                        $string =  $rs['li_hashtag_name'] . "  ";
                                        $string = convertHashtoLink2($string);
                                        echo $string;
                                    }

                                    ?>

                            </div>

                        </div>

                    </div>


                </div>

            </div>
            <!-- Main Section -->
        </div><!-- Content Zone -->
    </div><!-- Content Zone -->

</body>

<script type="text/javascript">
    $(document).ready(function() {
        var t = $('#rs_search_gl').DataTable({
            "columnDefs": [{
                "searching": false,
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

        //Result iso live search  Result iso live search  Result iso live search  Result iso live search 
        load_datas();
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

        $('#search_doc').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });

        $('#btn_search_date').click(function() {
            var fromdate = $('#start_date').val();
            var todate = $('#end_date').val();
            if (fromdate != '' && todate != '') {
                load_search_date(fromdate, todate);
            } else {
                load_datas();
            }
        });

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


        function load_datas(query) {
            $.ajax({
                url: "<?php echo base_url(); ?>librarys/fetch_iso_doccode",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                    $('#rs_search_iso_live thead th').each(function() {
                        var title = $(this).text();
                        $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                    });

                    var table = $('#rs_search_iso_live').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": "_all"
                        }],
                        dom: 'Bfrtip',
                        "buttons": [{
                                extend: 'copyHtml5',
                                title: 'Document library'
                            },
                            {
                                extend: 'excelHtml5',
                                autoFilter: true,
                                title: 'Document library'
                            }
                        ]
                    });



                    table.columns().every(function() {
                        var table = this;
                        $('input', this.header()).on('keyup change', function() {
                            if (table.search() !== this.value) {
                                table.search(this.value).draw();
                            }
                        });
                    });

                }

            });

        }

        function load_data(query) {
            if (check_input == 1) {
                $.ajax({
                    url: "<?php echo base_url(); ?>librarys/fetch_iso_doccode/",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                        $('#rs_search_iso_live thead th').each(function() {
                        var title = $(this).text();
                        $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                        });

                        var table = $('#rs_search_iso_live').DataTable({
                            "columnDefs": [{
                                "searching": false,
                                "orderable": false,
                                "targets": "_all"
                            }],
                            dom: 'Bfrtip',
                            "buttons": [{
                                    extend: 'copyHtml5',
                                    title: 'Document library'
                                },
                                {
                                    extend: 'excelHtml5',
                                    autoFilter: true,
                                    title: 'Document library'
                                }
                            ],
                            "order": [
                                [0, 'asc']
                            ]
                        });



                        table.columns().every(function() {
                            var table = this;
                            $('input', this.header()).on('keyup change', function() {
                                if (table.search() !== this.value) {
                                    table.search(this.value).draw();
                                }
                            });
                        });

                    }

                });

            } else if (check_input == 2) {

                $.ajax({

                    url: "<?php echo base_url(); ?>librarys/fetch_iso_docname/",

                    method: "POST",

                    data: {

                        query: query

                    },

                    success: function(data) {

                        $('#result').html(data);

                        $('#rs_search_iso_live thead th').each(function() {
                        var title = $(this).text();
                        $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                    });

                    var table = $('#rs_search_iso_live').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": "_all"
                        }],
                        dom: 'Bfrtip',
                        "buttons": [{
                                extend: 'copyHtml5',
                                title: 'Document library'
                            },
                            {
                                extend: 'excelHtml5',
                                autoFilter: true,
                                title: 'Document library'
                            }
                        ],
                        "order": [
                            [0, 'asc']
                        ]
                    });

                

                    table.columns().every(function() {
                        var table = this;
                        $('input', this.header()).on('keyup change', function() {
                            if (table.search() !== this.value) {
                                table.search(this.value).draw();
                            }
                        });
                    });

                    }

                });

            } else if (check_input == 3) {

                $.ajax({
                    url: "<?php echo base_url(); ?>librarys/fetch_iso_hashtag",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                        $('#rs_search_iso_live thead th').each(function() {
                        var title = $(this).text();
                        $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                    });

                    var table = $('#rs_search_iso_live').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": "_all"
                        }],
                        dom: 'Bfrtip',
                        "buttons": [{
                                extend: 'copyHtml5',
                                title: 'Document library'
                            },
                            {
                                extend: 'excelHtml5',
                                autoFilter: true,
                                title: 'Document library'
                            }
                        ],
                        "order": [
                            [0, 'asc']
                        ]
                    });

            

                    table.columns().every(function() {
                        var table = this;
                        $('input', this.header()).on('keyup change', function() {
                            if (table.search() !== this.value) {
                                table.search(this.value).draw();
                            }
                        });
                    });

                    }

                });

            }
        }

        function load_search_date(start_date, end_date)
        {

            $.ajax({
                url: "<?php echo base_url(); ?>librarys/fetch_iso_date",
                method: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(data) {
                    $('#result').html(data);
                    $('#rs_search_iso_live thead th').each(function() {
                        var title = $(this).text();
                        $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                    });

                    var table = $('#rs_search_iso_live').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": "_all"
                        }],
                        dom: 'Bfrtip',
                        "buttons": [{
                                extend: 'copyHtml5',
                                title: 'Document library'
                            },
                            {
                                extend: 'excelHtml5',
                                autoFilter: true,
                                title: 'Document library'
                            }
                        ],
                        "order": [
                            [0, 'asc']
                        ]
                    });



                    table.columns().every(function() {
                        var table = this;
                        $('input', this.header()).on('keyup change', function() {
                            if (table.search() !== this.value) {
                                table.search(this.value).draw();
                            }
                        });
                    });

                }

            });

        }

    });
</script>

</html>