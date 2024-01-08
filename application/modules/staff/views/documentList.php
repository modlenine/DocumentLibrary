<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ทะเบียนเอกสาร</title>


    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" />

    <!-- Date picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/default/zebra_datepicker.min.css" type="text/css" />
    <style>
        #tbl_report_document{
            width:100% !important;
        }

        .Zebra_DatePicker .dp_actions td{
            color:#000 !important;
        }

        #list_ctrldoc_length , #list_ctrldoc_filter{
            display:none !important;
        }
    </style>
</head>



<body>



    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">

                <h1 style="text-align:center;">ทะเบียนเอกสาร</h1>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4" style="text-align:right;">
                        <h5>MO-F-003-02-15/01/64</h5>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="reportdar-filterDateStart" id="reportdar-filterDateStart" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่เริ่ม)">
                    </div>
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="reportdar-filterDateEnd" id="reportdar-filterDateEnd" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่สิ้นสุด)">
                    </div>


                    <!-- <div class="col-md-6 form-group"></div> -->
                    <div class="col-md-4 form-group">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success btn-block" id="btn-searchFilterReportDar">ค้นหา</button>
                            </div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-warning btn-block" id="btn-clearFilterReportDar">รีเซ็ทการค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tbl_report_document" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>DAR No.</th>
                                        <th>Document Type.</th>
                                        <th>Document No.</th>
                                        <th>Document Name.</th>
                                        <th>Rev.</th>
                                        <th>Reason for request.</th>
                                        <th>Disposition</th>
                                        <th>Register Date.</th>
                                        <th>Effective Date.</th>
                                        <th>Distribution Date.</th>
                                        <th>Duration (Day)</th>
                                        <th>Department Distribution</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>



        </div><!-- Content Zone -->

    </div><!-- Content Zone -->



</body>

<script type="text/javascript">
    const url = "<?php echo base_url(); ?>";
    $(document).ready(function() {

        $('#reportdar-filterDateStart').Zebra_DatePicker({
            pair: $('#reportdar-filterDateEnd')
        });
        $('#reportdar-filterDateEnd').Zebra_DatePicker({
            direction: true
        });

        $('#btn-searchFilterReportDar').click(function(){
            get_reportDocument();
        });

        $('#btn-clearFilterReportDar').click(function(){
            $('#reportdar-filterDateStart').val('');
            $('#reportdar-filterDateEnd').val('');
            get_reportDocument();
        });

        get_reportDocument();
        function get_reportDocument()
        {
            let reportdar_filterDateStart = $('#reportdar-filterDateStart').val();
            let reportdar_filterDateEnd = $('#reportdar-filterDateEnd').val();

            if(reportdar_filterDateStart == ""){
                reportdar_filterDateStart = 0;
            }

            if(reportdar_filterDateEnd == ""){
                reportdar_filterDateEnd = 0;
            }

            let thid = 1;

            $('#tbl_report_document thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="tbl_report_document'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#tbl_report_document').DataTable().destroy();
            let table = $('#tbl_report_document').DataTable({
                // "scrollX": true,
                // "processing": true,
                // "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#tbl_report_document thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'staff/load_reportDocument/'+reportdar_filterDateStart+'/'+reportdar_filterDateEnd,
                },
                dom: 'Bfrtip',
                    "buttons": [{
                    extend: 'copyHtml5',
                    title: 'รายงานการ Service'
                    },
                    {
                    extend: 'excelHtml5',
                    autoFilter: true,
                    title: 'รายงานการ Service'
                    }
                    ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                        targets: "_all",
                        orderable: false
                    },
                ],
            });

            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

            // $('#list_dar9 , #list_dar4 , #list_dar5').prop('readonly' , true).css({
            //     'background-color':'#F5F5F5',
            //     'cursor':'no-drop'
            // });


        }

    }); //Ready Function

</script>

<script src="<?=base_url()?>assets/dist/zebra_datepicker.min.js"></script>
</html>