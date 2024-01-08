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
        <div class="app-main__inner">
            <!-- Content Zone -->

            <div class="container-fulid border p-4 bg-white">


                <?php

                ?>
                <h1 style="text-align:center;">รายการเอกสารทั่วไป</h1>
                <table id="list_gl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:50px;">No.</th>
                            <th>รหัสเอกสาร</th>
                            <th>ชื่อเอกสาร</th>
                            <th>วันที่ร้องขอ</th>
                            <th>ผู้ร้องขอ</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($get_list_gl->result_array() as $glg) {
                            if ($glg['gl_doc_status'] == "Not Approve") {
                                $gl_color = ' color:red; ';
                            } else if ($glg['gl_doc_status'] == "Open") {
                                $gl_color = ' color:#33CCFF; ';
                            }else if ($glg['gl_doc_status'] == "Approved"){
                                $gl_color = ' color:green; ';
                            }else{
                                $gl_color = '';
                            }
                            ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><a href="<?= base_url('document/gl_view_doc/') . $glg['gl_doc_code'] ?>"><i class="fas fa-book-open"></i>&nbsp;&nbsp;<?= $glg['gl_doc_code'] ?></a></td>
                            <td><?= $glg['gl_doc_name'] ?></td>
                            <td><?= con_date($glg['gl_doc_date_request']) ?></td>
                            <td><i class="fas fa-user"></i>&nbsp;&nbsp;<?= $glg['gl_doc_username'] ?></td>
                            <td style="<?=$gl_color?>"><?= $glg['gl_doc_status'] ?></td>
                        </tr>
                        <?php
                            $i++;
                        } ?>
                    </tbody>
                </table>

</body>
<script type="text/javascript">
    $(document).ready(function() {

        var t = $('#list_gl').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }]
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

</html>