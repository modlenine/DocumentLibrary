<!DOCTYPE html>

<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ตู้เอกสาร ควบคุม</title>

    <!-- Date picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/default/zebra_datepicker.min.css" type="text/css" />
    <style>
        .Zebra_DatePicker .dp_actions td{
            color:#000 !important;
        }

        #list_ctrldoc_length , #list_ctrldoc_filter{
            display:none !important;
        }
    </style>
</head>

<?php
    
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
                                <h3>เอกสาร ควบคุม</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDocName" id="ctrldoc-filterDocName" placeholder="ค้นหาด้วยชื่อเอกสาร">
                    </div>

                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDocCode" id="ctrldoc-filterDocCode" placeholder="ค้นหาด้วยรหัสเอกสาร">
                    </div>

                    <!-- <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDocHashtag" id="ctrldoc-filterDocHashtag" placeholder="ค้นหาด้วยแฮชแท็ก">
                    </div> -->

                    <div class="col-md-4 form-group">
                        <select class="form-control" name="ctrldoc-filterSubtype" id="ctrldoc-fillterSubtype">
                            <option value="">ค้นหาด้วยประเภทเอกสาร</option>
                            <option value="01">ระเบียบ/นโยบาย/ประกาศ บริษัท</option>
                            <option value="02">ระเบียบ/นโยบาย/ประกาศ หน่วยงาน</option>
                            <option value="03">หนังสือเวียนภายในบริษัท</option>
                            <option value="04">เอกสารออกภายนอกบริษัท</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDateStart" id="ctrldoc-filterDateStart" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่เริ่ม)">
                    </div>
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDateEnd" id="ctrldoc-filterDateEnd" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่สิ้นสุด)">
                    </div>


                    <!-- <div class="col-md-6 form-group"></div> -->
                    <div class="col-md-4 form-group">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success btn-block" id="btn-searchFilterCtrlDoc">ค้นหา</button>
                            </div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-warning btn-block" id="btn-clearFilterCtrlDoc">รีเซ็ทการค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-3">
                       
                        <div class="card border-danger mb-3">
                            <div class="card-header bg-success text-white" style="font-size:16px;font-weight:400"><i class="fas fa-archive"></i>&nbsp;เอกสารควบคุม</div>
                            <div class="card-body text-danger table-responsive">

                                <ul class="list-group">
                                    <?php foreach ($dct_subtype->result_array() as $rs) { ?>
                                        
                                        <li id="list_document" class="list-group-item d-flex justify-content-between align-items-center">

                                            <a href="javadcript:void(0)" class="ctrlDocSearch"
                                                data_subtypeCode = "<?=$rs['dct_subtype_code']?>"
                                            >
                                                <i class="fas fa-folder text-warning" style="font-size:16px;"></i>&nbsp;
                                                <?= $rs['dct_subtype_name'] ?>
                                            </a>&nbsp;&nbsp;

                                            <span id="count" class="badge badge-warning badge-pill"><?=count_dctFile($rs['dct_subtype_code'])?></span>

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <table id="list_ctrldoc" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:100px;">รหัสเอกสาร</th>
                                    <th style="width:150px;">ชื่อเอกสาร</th>
                                    <th>ประเภทของเอกสาร</th>
                                    <th>วันที่ร้องขอ</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="row mt-2">
                            <div id="showHashTagCtrlDoc"></div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- Main Section -->
        </div><!-- Content Zone -->
    </div><!-- Content Zone -->

</body>

<script type="text/javascript">
    let url = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        $('#ctrldoc-filterDateStart').Zebra_DatePicker({
            pair: $('#ctrldoc-filterDateEnd')
        });
        $('#ctrldoc-filterDateEnd').Zebra_DatePicker({
            direction: true
        });


        $('#btn-searchFilterCtrlDoc').click(function(){
            // Filter Zone
            const ctrldoc_filterDocName = $('#ctrldoc-filterDocName').val();
            const ctrldoc_filterDocCode = $('#ctrldoc-filterDocCode').val();
            const ctrldoc_filterDateStart = $('#ctrldoc-filterDateStart').val();
            const ctrldoc_filterDateEnd = $('#ctrldoc-filterDateEnd').val();
            const ctrldoc_fillterSubtype = $('#ctrldoc-fillterSubtype').val();

            console.log(ctrldoc_fillterSubtype);
            getCtrlDoclist();
            
        });

        $(document).on('click' , '.ctrlDocSearch' , function(){
            const data_subtypeCode = $(this).attr("data_subtypeCode");
            $('#ctrldoc-fillterSubtype').val(data_subtypeCode);
            getCtrlDoclist();
        });

        $('#btn-clearFilterCtrlDoc').click(function(){
            $('#ctrldoc-filterDocName').val('');
            $('#ctrldoc-filterDocCode').val('');
            $('#ctrldoc-filterDateStart').val('');
            $('#ctrldoc-filterDateEnd').val('');
            $('#ctrldoc-fillterSubtype').val('');
            getCtrlDoclist();
        });

        getCtrlDoclist();
        function getCtrlDoclist()
        {
            let thid = 1;

            // Filter Zone
            let ctrldoc_filterDocName = $('#ctrldoc-filterDocName').val();
            let ctrldoc_filterDocCode = $('#ctrldoc-filterDocCode').val();
            let ctrldoc_filterDateStart = $('#ctrldoc-filterDateStart').val();
            let ctrldoc_filterDateEnd = $('#ctrldoc-filterDateEnd').val();
            let ctrldoc_fillterSubtype = $('#ctrldoc-fillterSubtype').val();

            if(ctrldoc_filterDocName == ""){
                ctrldoc_filterDocName = 0;
            }

            if(ctrldoc_filterDocCode == ""){
                ctrldoc_filterDocCode = 0;
            }


            if(ctrldoc_filterDateStart == ""){
                ctrldoc_filterDateStart = 0;
            }

            if(ctrldoc_filterDateEnd == ""){
                ctrldoc_filterDateEnd = 0;
            }

            if(ctrldoc_fillterSubtype == ""){
                ctrldoc_fillterSubtype = 0;
            }



            $('#list_ctrldoc thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="list_ctrldoc'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#list_ctrldoc').DataTable().destroy();
            let table = $('#list_ctrldoc').DataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#list_ctrldoc thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'ctrldoc/getCtrlDoclist/'+ctrldoc_filterDocName+'/'+ctrldoc_filterDocCode+'/'+ctrldoc_filterDateStart+'/'+ctrldoc_filterDateEnd+'/'+ctrldoc_fillterSubtype,
                },
                // "rowCallback": function(row, data) {
                //     let dc_data_id = data[8];
                //     // ตรวจสอบเงื่อนไขและกำหนดสีให้แถวตามข้อมูล
                //     // console.log(dc_data_id);
                //     if(dc_data_id !== null){
                //         let numbers = dc_data_id.match(/\d+/g);  
                //         if (parseInt(numbers) > 5) {
                //             $(row).css('background-color', 'orange');
                //         }
                //     }
                // },
                // dom: 'Bfrtip',
                //     "buttons": [{
                //     extend: 'copyHtml5',
                //     title: 'รายงานการ Service'
                //     },
                //     {
                //     extend: 'excelHtml5',
                //     autoFilter: true,
                //     title: 'รายงานการ Service'
                //     }
                //     ],
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

            $('#list_ctrldoc4').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });


        }

        getCtrlDocHashTag();
        function getCtrlDocHashTag()
        {
            axios.get(url+'ctrldoc/ctrldoc/getCtrlDocHashTag').then(res=>{
                console.log(res.data);
                $('#showHashTagCtrlDoc').html('<b>Hashtag : </b> '+res.data.result);
            });
        }

        $(document).on('click' , '.attr_ctrhashtag' , function(){
            let data_hashtag = $(this).attr("data_hashtag");
            data_hashtag = data_hashtag.replace(/#/g, '');
            console.log(data_hashtag);
            getCtrlDoclist_hashtag(data_hashtag);
        });
        function getCtrlDoclist_hashtag(hashtag)
        {
            let thid = 1;

            if(hashtag == ""){
                hashtag = 0;
            }


            $('#list_ctrldoc thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="list_ctrldoc'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#list_ctrldoc').DataTable().destroy();
            let table = $('#list_ctrldoc').DataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#list_ctrldoc thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'ctrldoc/getCtrlDoclist_hashtag/'+hashtag,
                },
                // "rowCallback": function(row, data) {
                //     let dc_data_id = data[8];
                //     // ตรวจสอบเงื่อนไขและกำหนดสีให้แถวตามข้อมูล
                //     // console.log(dc_data_id);
                //     if(dc_data_id !== null){
                //         let numbers = dc_data_id.match(/\d+/g);  
                //         if (parseInt(numbers) > 5) {
                //             $(row).css('background-color', 'orange');
                //         }
                //     }
                // },
                // dom: 'Bfrtip',
                //     "buttons": [{
                //     extend: 'copyHtml5',
                //     title: 'รายงานการ Service'
                //     },
                //     {
                //     extend: 'excelHtml5',
                //     autoFilter: true,
                //     title: 'รายงานการ Service'
                //     }
                //     ],
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

            $('#list_ctrldoc4').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });


        }
    });
</script>

<script src="<?=base_url()?>assets/dist/zebra_datepicker.min.js"></script>
</html>