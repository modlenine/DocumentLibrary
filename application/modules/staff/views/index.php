<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main page staff</title>
</head>

<body>


    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container border p-4 bg-white">
                <!-- Main Section -->

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h1 style="text-align:center;">รายการเอกสาร ISO ทั้งหมด</h1>
                    </div>
                </div>


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
                    <div class="col-md-4">
                        <a href="<?= base_url('staff/admin_iso_list') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>
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
                            <!-- <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping"> -->
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                                    <a href="<?= base_url('librarys/view_by_dept') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>
                                    <button type="submit" name="btn_search_hashtag" id="btn_search_hashtag" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button>
                                </div> -->
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

                <div class="row" id="result"></div>

                <!-- <table id="view_doc_staff" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสเอกสาร</th>
                            <th>ชื่อเอกสาร</th>
                            <th>วันที่ร้องขอ</th>
                            <th>เลขที่ใบ DAR</th>
                            <th>สถานะ</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php $i = 1;
                        foreach ($get_doc_list->result_array() as $get_doc_lists) {
                            if ($get_doc_lists['lib_main_status'] == "active") {
                                $color_status = " style='color:green' ";
                            } else {
                                $color_status = " style='color:red' ";
                            }

                            ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><a href="<?= base_url('staff/view_full_data/') ?><?= $get_doc_lists['lib_main_doccode'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $get_doc_lists['dc_data_doccode_display'] ?></a></td>
                                <td><?= $get_doc_lists['dc_data_docname'] ?></td>
                                <td><?= con_date($get_doc_lists['dc_data_date']) ?></td>
                                <td><?= $get_doc_lists['lib_main_darcode'] ?></td>
                                <td <?= $color_status ?>><b><?= $get_doc_lists['lib_main_status'] ?></b></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table> -->








            </div>
            <!-- Main Section -->
        </div><!-- Content Zone -->
    </div><!-- Content Zone -->




</body>

<script type="text/javascript">
    $(document).ready(function() {

        var t = $('#view_doc_staff').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [4, 'desc']
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






        load_datas();

$('#document_code').keyup(function() {
var search = $(this).val();
if (search != '') {
    load_data(search);
} else {
    load_datas();
}
});

$('#document_name').keyup(function() {
var search = $(this).val();
if (search != '') {
    load_data(search);
} else {
    load_datas();
}
});

$('#search_doc').keyup(function() {
var search = $(this).val();
if (search != '') {
    load_data(search);
} else {
    load_datas();
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
    //Function Ready













    
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
                url: "<?php echo base_url(); ?>staff/fetch_iso_doccode_admin/",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                    var tt = $('#admin_search').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": 0
                        }],
                        "order": [
                            [4, 'desc']
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
                    url: "<?php echo base_url(); ?>staff/fetch_iso_doccode_admin/",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                        var tt = $('#admin_search').DataTable({
                            "columnDefs": [{
                                "searching": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [4, 'desc']
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
                    url: "<?php echo base_url(); ?>staff/fetch_iso_docname_admin/",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                        var tt = $('#admin_search').DataTable({
                            "columnDefs": [{
                                "searching": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [4, 'desc']
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
                    url: "<?php echo base_url(); ?>staff/fetch_iso_hashtag_admin",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                        var tt = $('#admin_search').DataTable({
                            "columnDefs": [{
                                "searching": false,
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [4, 'desc']
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





        function load_search_date(start_date, end_date) {
            $.ajax({
                url: "<?php echo base_url(); ?>staff/fetch_iso_date_admin",
                method: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(data) {
                    $('#result').html(data);
                    var tt = $('#admin_search').DataTable({
                        "columnDefs": [{
                            "searching": false,
                            "orderable": false,
                            "targets": 0
                        }],
                        "order": [
                            [4, 'desc']
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
</script>

</html>