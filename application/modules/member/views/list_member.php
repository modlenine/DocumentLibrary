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

            <h1 style="text-align:center;">รายการใบทั่วไป</h1>
                <table id="list_member" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>รหัสพนักงาน</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>ชื่อ</th>
                            <th>สกุล</th>
                            <th>แผนก</th>
                            <th>รหัสแผนก</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=1;
                        foreach($get_list_gl->result_array() as $glg){  ?>
                        <tr>
                            <td><?=$i;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php 
                        $i++;
                    } ?>
                    </tbody>
                </table>




                <script type="text/javascript">
    $(document).ready(function() {

        var t = $('#list_member').DataTable({
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


    });
</script>