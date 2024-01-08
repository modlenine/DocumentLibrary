<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>View Document</title>

</head>



<body>



    <div class="app-main__outer">

        <!-- Content Zone -->

        <div class="app-main__inner mb-5">

            <!-- Content Zone -->

            <div class="container-fulid border p-4 bg-white">

                <!-- Main Section -->

                <div class="table-responsive">
                    <table id="view_doc" class="table table-striped table-bordered" style="width:100%">

                        <thead>

                            <tr>


                                <th>รหัสเอกสาร</th>

                                <th>เลขที่ใบ DAR</th>

                                <th>ชื่อเอกสาร</th>

                                <th>วันที่ร้องขอ</th>

                                <th>ชื่อไฟล์</th>

                                

                            </tr>

                        </thead>



                        <tbody>



                            <?php $i = 1;

                            foreach ($get_file1->result_array() as $get_file1s) { ?>

                                <tr>


                                    <td><a href="<?= base_url('librarys/viewFull_document/') ?><?=$get_file1s['dc_data_sub_type'];?>/<?=$get_file1s['related_dept_code'];?>/<?=$get_file1s['dc_data_doccode'];?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<b><?= $get_file1s['dc_data_doccode'] ?></b></a></td>

                                    <td><?= $get_file1s['dc_data_darcode'] ?></td>

                                    <td><?= $get_file1s['dc_data_docname'] ?></td>

                                    <td><?= con_date($get_file1s['dc_data_date']) ?></td>

                                    <td><?= $get_file1s['lib_main_doccode_copy'] ?></td>

                                    

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </div>


            </div>

        </div>

    </div>





</body>

<script type="text/javascript">

    $(document).ready(function() {

        $('#view_doc thead th').each(function() {
            var title = $(this).text();
            $(this).html(title + ' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
        });

        var table = $('#view_doc').DataTable({
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
            [0, 'desc']
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





    });

</script>



</html>