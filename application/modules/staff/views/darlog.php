<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Dar Log Sheet</title>





    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>







    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" />

</head>



<body>



    <div class="app-main__outer">

        <!-- Content Zone -->

        <div class="app-main__inner">

            <!-- Content Zone -->



            <div class="container-fulid border p-4 bg-white">



                <h1 style="text-align:center;">DAR LOG SHEET</h1>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4" style="text-align:right;">
                        <h5>MO-F-002-01-15/11/59</h5>
                    </div>
                </div>
                



                <div class="row mb-2 mt-4">

                    <div class="col-md-4">

                        <select name="doc_search_method" id="doc_search_method" class="form-control">

                            <option value="">โปรดเลือกช่องทางการค้นหา</option>

                            <option value="search_by_date">ค้นหาจากวันที่แจ้ง</option>

                            <!-- <option value="search_by_docname">ค้นหาจากชื่อเอกสาร</option>

                            <option value="search_by_doccode">ค้นหาจากรหัสเอกสาร</option>

                            <option value="search_by_darcode">ค้นหาจากเลขที่ใบDAR</option>

                            <option value="search_by_hashtag">ค้นหาจากแฮชแท็ก</option> -->

                        </select>

                    </div>

                    <div class="col-md-4">

                        <a href="<?= base_url('staff/darLogSheet') ?><?php echo "/"; ?>"><button type="button" class="btn btn-warning"><i class="fas fa-sync-alt"></i>&nbsp;Reset</button></a>

                    </div>

                    <div class="col-md-4">

                        <select name="filter" id="filter" class="form-control">

                            <option value="">All</option>

                            <option value="Creating DAR">Creating DAR</option>

                            <option value="Open">Open</option>

                            <option value="Manager Approved">Manager Approved</option>

                            <option value="Qmr Approved">Qmr Approved</option>

                            <option value="Complete">Complete</option>

                        </select>

                    </div>

                </div>







                <div class="row mb-2" id="form_search_by_date">

                    <div class="col-md-8 form-inline">

                        <input type="date" name="start_date" id="start_date" class="form-control datepicker_search">&nbsp;TO&nbsp;

                        <input type="date" name="end_date" id="end_date" class="form-control datepicker_search">

                        &nbsp;&nbsp;

                        <select name="filter_withdate" id="filter_withdate" class="form-control">

                            <option value="">Filter By Status</option>

                            <option value="Creating DAR">Creating DAR</option>

                            <option value="Open">Open</option>

                            <option value="Manager Approved">Manager Approved</option>

                            <option value="Qmr Approved">Qmr Approved</option>

                            <option value="Complete">Complete</option>

                        </select>&nbsp;&nbsp;

                        <button type="submit" name="btn_search_date" id="btn_search_date" class="btn btn-success"><i class="fas fa-search"></i>&nbsp;ค้นหา</button>

                    </div>

                </div>









                <div class="row" id="result"></div>







            </div>



        </div><!-- Content Zone -->

    </div><!-- Content Zone -->



</body>

<script type="text/javascript">

    $(document).ready(function() {



        load_datas();



        $('#filter').change(function() {

            var search = $(this).val();

            if (search != '') {

                filter_data(search);

            } else {

                load_datas();

            }

        });





        $('#btn_search_date').click(function() {

            var fromdate = $('#start_date').val();

            var todate = $('#end_date').val();

            var filter_withdate = $('#filter_withdate').val();



            if (fromdate != '' && todate != '' && filter_withdate != '') {

                load_search_date(fromdate, todate , filter_withdate);



            }else if(fromdate != '' && todate != '' && filter_withdate == ''){

                load_search_dates(fromdate, todate);



            }else if(fromdate == '' && todate == '' && filter_withdate != ''){

                filter_data(filter_withdate);



            } else {

                load_datas();

            }



        });









    }); //Ready Function





    function load_datas(status) {

        $.ajax({

            url: "<?php echo base_url(); ?>staff/fetch_darlog/",

            method: "POST",

            data: {

                status: status

            },

            success: function(data) {

                $('#result').html(data);

                var tt = $('#dar_log_sheet').DataTable({

                    "columnDefs": [{

                        "searching": false,

                        "orderable": false,

                        "targets": 0

                    }],

                    "order": [

                        [0, 'desc']

                    ],

                    dom: 'Bfrtip',

                    buttons: [{

                        extend: 'excel',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

                    }, 

                    {

                        extend:'print',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

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

            }

        });

    }







    function filter_data(status) {

        $.ajax({

            url: "<?php echo base_url(); ?>staff/fetch_filter_data/",

            method: "POST",

            data: {

                status: status

            },

            success: function(data) {

                $('#result').html(data);

                var tt = $('#dar_log_sheet').DataTable({

                    "columnDefs": [{

                        "searching": false,

                        "orderable": false,

                        "targets": 0

                    }],

                    "order": [

                        [0, 'desc']

                    ],

                    dom: 'Bfrtip',

                    buttons: [{

                        extend: 'excel',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

                    }, 

                    {

                        extend:'print',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

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

            }

        });

    }











    function load_search_date(start_date, end_date , filter_withdate) {

        $.ajax({

            url: "<?php echo base_url(); ?>staff/fetch_date_darlog",

            method: "POST",

            data: {

                start_date: start_date,

                end_date: end_date,

                filter_withdate: filter_withdate

            },

            success: function(data) {

                $('#result').html(data);

                var tt = $('#dar_log_sheet').DataTable({

                    "columnDefs": [{

                        "searching": false,

                        "orderable": false,

                        "targets": 0

                    }],

                    "order": [

                        [4, 'desc']

                    ],

                    dom: 'Bfrtip',

                    buttons: [{

                        extend: 'excel',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

                    }, 

                    {

                        extend:'print',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

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

            }

        });

    }







    function load_search_dates(start_date, end_date) {

        $.ajax({

            url: "<?php echo base_url(); ?>staff/fetch_date_darlogs",

            method: "POST",

            data: {

                start_date: start_date,

                end_date: end_date

            },

            success: function(data) {

                $('#result').html(data);

                var tt = $('#dar_log_sheet').DataTable({

                    "columnDefs": [{

                        "searching": false,

                        "orderable": false,

                        "targets": 0

                    }],

                    "order": [

                        [4, 'desc']

                    ],

                    dom: 'Bfrtip',

                    buttons: [{

                        extend: 'excel',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

                    }, 

                    {

                        extend:'print',

                        messageTop: '<strong>DAR LOG SHEET</strong>',

                        title:''

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

            }

        });

    }

</script>





</html>