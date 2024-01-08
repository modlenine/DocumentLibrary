<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php
    $rs_gfd = $get_foldername_deptname->row();
    ?>
    <div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner">
            <!-- Content Zone -->
            <div class="container-fulid border p-4 bg-white">

                <div class="row">
                    <div class="col-md-3">
                        <a href="<?=base_url('librarys/document_center/')?>"><button class="btn btn-secondary btn-sm"><i class="fas fa-angle-double-left"></i>&nbsp;ย้อนกลับ</button></a><br>
                        <label class="mt-4 mb-4" style="font-size:18px;"><b>เอกสารแผนก :</b> <?= $rs_gfd->gl_dept_name ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>โฟลเดอร์ :</b> <?= $rs_gfd->gl_folder_name ?></bเอกสารแผนก></label>
                    </div>
                    <div class="col-md-6">
                        <h1 style="text-align:center;">รายการเอกสารทั่วไป</h1>
                    </div>

                    <div class="col-md-3">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="list_gl_doc" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:30px;">#</th>
                                    <th style="width:80px;">รหัสเอกสาร</th>
                                    <th>ชื่อเอกสาร</th>
                                    <th style="width:100px;">วันที่ร้องขอ</th>
                                    <th style="width:150px;">ผู้ร้องขอ</th>
                                    <th>แฮชแท็ก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($view_gl_document->result_array() as $glg) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><a href="<?=base_url('librarys/viewfull_gl_document/').$glg['gl_doc_deptcode']."/".$glg['gl_doc_folder_number']."/".$glg['gl_doc_code']?>"><?= $glg['gl_doc_code'] ?></a></td>
                                    <td><?= $glg['gl_doc_name'] ?></td>
                                    <td><?=con_date($glg['gl_doc_date_request'])?></td>
                                    <td><?= $glg['gl_doc_username'] ?></td>
                                    
                                    <td>
                                    <?php 
                                    $get_hashtag_list = get_hashtag_doclist($glg['gl_doc_code']);
                                    foreach($get_hashtag_list->result_array() as $ghl){
                                        $string = $ghl['gl_ht_name']."&nbsp;";
                                        $string = convertHashtoLink($string);
                                        echo $string;
                                         } ?>
                                    </td>
                                    
                                </tr>
                                <?php
                                    $i++;
                                } ?>
                            </tbody>
                        </table>
                    </div>

                </div>



                <script type="text/javascript">
                    $(document).ready(function() {

                        var t = $('#list_gl_doc').DataTable({
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


                    });
                </script>