<?php  

$getuser = $this->get_lib_model->get_new_user();

$get_deptlib = $this->get_lib_model->get_deptlib($getuser->dc_user_new_dept_code);

$rsget = $get_deptlib->row();



?>





<table id="rs_search_iso_live" class="table table-striped table-bordered table-responsive" style="width:100%">

    <thead>
        <tr>
            <th>รหัสเอกสาร</th>
            <th>ชื่อเอกสาร</th>
            <th>วันที่ร้องขอ</th>
            <th>เอกสารของแผนก</th>
        </tr>
    </thead>

    <tbody>

        <?php $i = 1;
        foreach ($rs->result_array() as $rss) { 
            if ($rss['dc_data_sub_type'] == "l") {
                $doccode = $rss['dc_data_doccode_display'];
            } else {
                $doccode = $rss['dc_data_doccode'];
            } 
        ?>



            <tr>
                <td><a href="<?= base_url('librarys/viewFull_document/') . $rss['dc_data_sub_type'] . "/" . $rsget->related_code . "/" . $rss['lib_main_doccode'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $doccode; ?></a></td>
                <td><?= $rss['dc_data_docname']; ?></td>
                <td><?= con_date($rss['dc_data_date']) ?></td>
                <td><?= $rss['dc_dept_main_name']; ?></td>
            </tr>

        <?php $i++;
        } ?>



    </tbody>

</table>