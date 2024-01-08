<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<div class="app-main__outer">
        <!-- Content Zone -->
        <div class="app-main__inner mb-5">
            <!-- Content Zone -->
            <div class="container border p-4 bg-white">
                <!-- Main Section -->

                <div class="row">
                    <div class="col-md-12">
                        <h1 style="text-align:center;">รายการเอกสาร ISO ทั้งหมด</h1>
                    </div>
                </div>
                <table id="view_doc_staff_gl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสเอกสาร</th>
                            <th>ชื่อเอกสาร</th>
                            <th>วันที่ร้องขอ</th>
                            <th>สถานะ</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php $i = 1;
                        foreach ($get_doc_list->result_array() as $get_doc_lists) { 
                        
                            ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><a href="<?=base_url('staff/view_full_data/')?><?=$get_doc_lists['lib_main_doccode']?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?=$get_doc_lists['dc_data_doccode_display']?></a></td>
                                <td><?=$get_doc_lists['dc_data_docname']?></td>
                                <td><?=con_date($get_doc_lists['dc_data_date'])?></td>
                                <td <?=$color_status?>><b><?=$get_doc_lists['lib_main_status']?></b></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>



                <script type="text/javascript">
    $(document).ready(function() {

        var t = $('#view_doc_staff_gl').DataTable({
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