<!DOCTYPE html>

<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library Saleecolour..</title>

    <!-- Date picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/default/zebra_datepicker.min.css" type="text/css" />

    <style>
        #list_isodoc_length , #list_isodoc_filter{
            display:none !important;
        }

        .Zebra_DatePicker .dp_actions td{
            color:#000 !important;
        }

        .selectHashtagUl{
            max-height: 200px;
            margin-bottom: 10px;
            overflow:scroll;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<?php
    $this->load->model("get_lib_model");
    $getuser = $this->get_lib_model->get_new_user();
    $get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);
    $relatedcode = $getuser->dc_user_new_dept_code;
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
                                <h3>เอกสาร ISO [New]</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="isodoc-filterDocName" id="isodoc-filterDocName" placeholder="ค้นหาด้วยชื่อเอกสาร">
                    </div>

                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="isodoc-filterDocCode" id="isodoc-filterDocCode" placeholder="ค้นหาด้วยรหัสเอกสาร">
                    </div>

                    <!-- <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="ctrldoc-filterDocHashtag" id="ctrldoc-filterDocHashtag" placeholder="ค้นหาด้วยแฮชแท็ก">
                    </div> -->

                    <div class="col-md-4 form-group">
                        <select class="form-control" name="isodoc-filterSubtype" id="isodoc-filterSubtype">
                            <option value="">ค้นหาด้วยประเภทเอกสาร</option>
                            <option value="m">Manual (M)</option>
                            <option value="p">Procedure (P)</option>
                            <option value="w">Work Instruction (W)</option>
                            <option value="f">Form (F)</option>
                            <option value="s">Support Document (S)</option>
                            <option value="x">External Document (X)</option>
                            <option value="l">Law (L)</option>
                            <option value="sds">Safety Data Sheet (SDS)</option>
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <input class="form-control" type="text" name="isodoc-filterHashtag" id="isodoc-filterHashtag" placeholder="ค้นหาด้วย Hashtag">
                        <div id="isodoc-show-filterHashtag"></div>
                    </div>

                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="isodoc-filterDateStart" id="isodoc-filterDateStart" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่เริ่ม)">
                    </div>
                    <div class="col-md-4 form-group">
                        <input class="form-control" type="text" name="isodoc-filterDateEnd" id="isodoc-filterDateEnd" placeholder="ค้นหาด้วยวันที่ร้องขอ (วันที่สิ้นสุด)">
                    </div>


                    <!-- <div class="col-md-6 form-group"></div> -->
                    <div class="col-md-4 form-group">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success btn-block" id="btn-searchFilterIsoDoc">ค้นหา</button>
                            </div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-warning btn-block" id="btn-clearFilterIsoDoc">รีเซ็ทการค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

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

                                            <a href="javascript:void(0)" class="filterSubtypeClass" data_subtypecode = "<?=$get_sub_types['dc_sub_type_code']?>">

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
 
                        <table id="list_isodoc" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:150px;">รหัสเอกสาร</th>
                                    <th>ชื่อเอกสาร</th>
                                    <th style="width:100px;">ประเภทของเอกสาร</th>
                                    <th style="width:100px;">วันที่ร้องขอ</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="row mt-2">
                            <div id="showHashTagIsoDoc"></div>
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
    let deptlib = "<?php echo $relatedcode; ?>";
    $(document).ready(function() {
        console.log(deptlib);

        $('#isodoc-filterDateStart').Zebra_DatePicker({
            pair: $('#isodoc-filterDateEnd')
        });
        $('#isodoc-filterDateEnd').Zebra_DatePicker({
            direction: true
        });

        $(document).on('click' , '.filterSubtypeClass' , function(){
            $('#list_isodoc').DataTable().state.clear();
            const data_subtypecode = $(this).attr("data_subtypecode");
            $('#isodoc-filterSubtype').val(data_subtypecode);
            getIsoDoclist();
        });

        getIsoDoclist();

        $('#btn-searchFilterIsoDoc').click(function(){
            $('#list_isodoc').DataTable().state.clear();
            getIsoDoclist();
            console.log($('#isodoc-filterDateStart').val());
            console.log($('#isodoc-filterDateEnd').val());
        });

        $('#btn-clearFilterIsoDoc').click(function(){
            $('#list_isodoc').DataTable().state.clear();
            $('#isodoc-filterDocName').val('');
            $('#isodoc-filterDocCode').val('');
            $('#isodoc-filterDateStart').val('');
            $('#isodoc-filterDateEnd').val('');
            $('#isodoc-filterSubtype').val('');
            $('#isodoc-filterHashtag').val('');
            getIsoDoclist();
        });

        function getIsoDoclist()
        {
            let thid = 1;

            // Filter Zone
            let isodoc_filterDocName = $('#isodoc-filterDocName').val();
            let isodoc_filterDocCode = $('#isodoc-filterDocCode').val();
            let isodoc_filterDateStart = $('#isodoc-filterDateStart').val();
            let isodoc_filterDateEnd = $('#isodoc-filterDateEnd').val();
            let isodoc_filterSubtype = $('#isodoc-filterSubtype').val();
            let isodoc_filterHashtag = $('#isodoc-filterHashtag').val();

            if(isodoc_filterDocName == ""){
                isodoc_filterDocName = 0;
            }

            if(isodoc_filterDocCode == ""){
                isodoc_filterDocCode = 0;
            }


            if(isodoc_filterDateStart == ""){
                isodoc_filterDateStart = 0;
            }

            if(isodoc_filterDateEnd == ""){
                isodoc_filterDateEnd = 0;
            }

            if(isodoc_filterSubtype == ""){
                isodoc_filterSubtype = 0;
            }

            isodoc_filterHashtag = isodoc_filterHashtag.replace(/#/g, '');
            if(isodoc_filterHashtag == ""){
                isodoc_filterHashtag = 0;
            }



            $('#list_isodoc thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="list_isodoc'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#list_isodoc').DataTable().destroy();
            let table = $('#list_isodoc').DataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#list_isodoc thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'librarys/getIsoDoclist/'+isodoc_filterDocName+'/'+isodoc_filterDocCode+'/'+isodoc_filterDateStart+'/'+isodoc_filterDateEnd+'/'+isodoc_filterSubtype+'/'+isodoc_filterHashtag,
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

            $('#list_isodoc4').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });

        }

        getIsoDocHashTag();
        function getIsoDocHashTag()
        {
            axios.get(url+'librarys/getIsoDocHashTag').then(res=>{
                console.log(res.data);
                $('#showHashTagIsoDoc').html('<b>Hashtag : </b> '+res.data.result);
            });
        }

        $(document).on('click' , '.attr_isohashtag' , function(){
            $('#list_isodoc').DataTable().state.clear();
            $('#isodoc-filterDocName').val('');
            $('#isodoc-filterDocCode').val('');
            $('#isodoc-filterDateStart').val('');
            $('#isodoc-filterDateEnd').val('');
            $('#isodoc-filterSubtype').val('');
            $('#isodoc-filterHashtag').val('');
            let data_hashtag = $(this).attr("data_hashtag");
            data_hashtag = data_hashtag.replace(/#/g, '');
            console.log(data_hashtag);
            getIsoDoclist_hashtag(data_hashtag);
        });
        function getIsoDoclist_hashtag(hashtag)
        {
            let thid = 1;

            if(hashtag == ""){
                hashtag = 0;
            }

            $('#list_isodoc thead th').each(function() {
				var title = $(this).text();
				$(this).html(title + ' <input type="text" id="list_isodoc'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
				thid++;
			});

            $('#list_isodoc').DataTable().destroy();
            let table = $('#list_isodoc').DataTable({
                "scrollX": true,
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                stateLoadParams: function(settings, data) {
                    for (let i = 0; i < data.columns["length"]; i++) {
                        let col_search_val = data.columns[i].search.search;
                        if (col_search_val !== "") {
                            $("input", $("#list_isodoc thead th")[i]).val(col_search_val);
                        }
                    }
                },
                "ajax": {
                "url":url+'librarys/getIsoDoclist_hashtag/'+hashtag,
                },

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

            $('#list_isodoc4').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });

        }

        $("#isodoc-filterHashtag").keyup(function(){
            if($(this).val() == ""){
                $('#isodoc-show-filterHashtag').html('');
            }else{
                getIsoDocHashTagSearch($(this).val())
            }
        });
        function getIsoDocHashTagSearch(hashtagSearch)
        {
            if(hashtagSearch != ""){
                axios.post(url+'librarys/getIsoDocHashTagSearch/',{
                    action:"hashtagSearch",
                    hashtagSearch:hashtagSearch
                }).then(res=>{
                    console.log(res.data);
                    if(res.data.status == "Select Data Success"){
                        let result = res.data.result;
                        let output = `<ul class="list-group mt-2 selectHashtagUl">`;
                        for(let i = 0; i < result.length; i ++){
                            output +=`
                            <a href="javascript:void(0)" class="list-group-item selectHashtagLi"
                                data_hashtag_search = "`+result[i].li_hashtag_name+`"
                            >
                                <span>`+result[i].li_hashtag_name+`</span>
                            </a>`;
                        }
                        output +=`</ul>`;
                        $('#isodoc-show-filterHashtag').html(output);
                    }
                });
            }
        }

        $(document).on('click' , '.selectHashtagLi' , function(){
            const data_hashtag_search = $(this).attr("data_hashtag_search");
            $('#isodoc-filterHashtag').val(data_hashtag_search);
            $('#isodoc-show-filterHashtag').html('');
        });
    });
</script>
<script src="<?=base_url()?>assets/dist/zebra_datepicker.min.js"></script>

</html>