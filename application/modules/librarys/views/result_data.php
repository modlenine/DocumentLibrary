<table id="rs_search_live" class="table table-striped table-bordered dt-responsive" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>รหัสเอกสาร</th>
            <th>ชื่อเอกสาร</th>
            <th>วันที่ร้องขอ</th>
            <th>เอกสารของแผนก</th>
        </tr>
    </thead>
    <tbody>


        <?php $i = 1;
        foreach ($rs->result_array() as $rss) { ?>

            <tr>
                <td><?= $i ?></td>
                <td><a href="<?= base_url('librarys/viewfull_gl_document/') . $rss['gl_doc_deptcode'] . "/" . $rss['gl_doc_folder_number'] . "/" . $rss['gl_doc_code'] ?>"><i class="fas fa-file-pdf" style="color:#CC0000;"></i>&nbsp;&nbsp;<?= $rss['gl_doc_code']; ?></a></td>
                <td><?= $rss['gl_doc_name']; ?></td>
                <td><?= con_date($rss['gl_doc_date_request']) ?></td>
                <td><?= $rss['gl_doc_deptname']; ?></td>
            </tr>


        <?php $i++;
        } ?>

    </tbody>
</table>