<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หน้าแสดงรายการ ใบคำร้องขอลงทะเบียนเอกสารควบคุม</title>
</head>

<body>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">
                <h1 class="mb-3" style="text-align:center;">รายการใบคำร้องเอกสารควบคุม</h1>

                    <table id="list_ctrlDoc" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:100px;">เลขที่ใบคำร้อง</th>
                                <th style="width:100px;">รหัสเอกสาร</th>
                                <th>ประเภทเอกสาร</th>
                                <th style="width:100px;">วันที่ร้องขอ</th>
                                <th style="width:100px;">วันที่แจกจ่าย</th>
                                <th>ผู้ร้องขอ</th>
                                <th>เหตุผลในการร้องขอ</th>
                                <th style="width:100px;">สถานะ</th>
                                <th style="width:100px;">ระยะเวลาดำเนินงาน</th>
                            </tr>
                        </thead>
                    </table>
              
                <div class="row">
                    <div class="col-md-12">
                        <span>หมายเหตุ : Duration มากกว่า 5 วันทำการ</span>
                    </div>
                </div>
            </div>

        </div><!-- Content Zone -->
    </div><!-- Content Zone -->

</body>

<script type="text/javascript">
    let url = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        getctrlDoclist();
        function getctrlDoclist()
        {
            let thid = 1;

            $('#list_ctrlDoc thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="list_ctrlDoc'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#list_ctrlDoc').DataTable().destroy();
            let table = $('#list_ctrlDoc').DataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#list_ctrlDoc thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'ctrldoc/get_listCtrlDoc',
                },
                "rowCallback": function(row, data) {
                    let dc_data_id = data[8];
                    // ตรวจสอบเงื่อนไขและกำหนดสีให้แถวตามข้อมูล
                    // console.log(dc_data_id);
                    if(dc_data_id !== null){
                        let numbers = dc_data_id.match(/\d+/g);  
                        if (parseInt(numbers) > 5) {
                            $(row).css('background-color', 'orange');
                        }
                    }
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

            $('#list_ctrlDoc9 , #list_ctrlDoc4 , #list_ctrlDoc5').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });


        }



    });
</script>





</html>