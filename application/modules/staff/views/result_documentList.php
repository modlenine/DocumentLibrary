<table id="docList" class="table table-striped table-bordered dt-responsive" style="width:100%">

    <thead>

        <tr>

            <th>No.</th>

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

            <th>Duration (Day).</th>

            <th>Department Distribution</th>

        </tr>

    </thead>



    <tbody>



        <?php foreach ($get_list->result_array() as $rslist) {

            $i = 1;



        ?>







            <!-- Change color status -->

            <?php

            if ($rslist['dc_data_status'] == "Manager Approved" || $rslist['dc_data_status'] == "Qmr Approved" || $rslist['dc_data_status'] == "Complete") {

                $tdcolor = '  style="color:green"  ';
            } else if ($rslist['dc_data_status'] == "Manager Not Approve" || $rslist['dc_data_status'] == "Qmr Not Approve") {

                $tdcolor = '  style="color:red"  ';
            } else if ($rslist['dc_data_status'] == "Open") {

                $tdcolor = '  style="color:#33CCFF"  ';
            } else {

                $tdcolor = '';
            }





            if ($rslist['dc_data_status'] == "Creating DAR") {

                $linkpage = "add_dar2/";
            } else {

                $linkpage = "viewfull/";
            }



            ?>





            <tr>

                <td><?= $i ?></td>

                <td><?= $rslist['dc_data_darcode']; ?></td>

                <td><?= $rslist['dc_sub_type_name']; ?></td>

                <td><?= $rslist['dc_data_doccode']; ?></td>

                <td><?= $rslist['dc_data_docname']; ?></td>

                <td><?= $rslist['dc_data_edit']; ?></td>

                <td><?= $rslist['dc_reason_name']; ?></td>

<?php 
$conDataStore = "";
    if($rslist['dc_data_store'] == "ตลอดอายุการใช้งาน" || $rslist['dc_data_store'] == "ไม่จัดเก็บ (เอกสารติดบรรจุภัณฑ์)"){
        $conDataStore = $rslist['dc_data_store'];
    }else{
        $conDataStore = $rslist['dc_data_store'] . "&nbsp;" . $rslist['dc_data_store_type'];
    }
?>
                <td><?= $conDataStore; ?></td>

                <td><?= con_date($rslist['dc_data_date']) ?></td>

                <td><?= con_date($rslist['dc_data_date_start']) ?></td>

                <td><?= con_date($rslist['dc_data_date_operation']) ?></td>

                <?php


$conDurationDate = "";
$date1 = $rslist['dc_data_date'];
$date2 = $rslist['dc_data_date_operation'];


$conDurationDate = duration($date1, $date2);


                
                ?>
                <td><?= $conDurationDate ?> วันทำการ</td>



                <td>

                    <?php



                    foreach (get_related_use($rslist['dc_data_darcode'])->result_array() as $get_ru) {

                        echo $get_ru['related_dept_name'] . "&nbsp;,&nbsp;";
                    } ?>

                </td>



            </tr>

        <?php $i++;
        } ?>

    </tbody>

</table>