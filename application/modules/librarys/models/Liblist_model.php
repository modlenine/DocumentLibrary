<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Liblist_model extends CI_Model{

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function getLib_list()
    {
         // DB table to use
         $table = 'liblist';
         // $table = <<<EOT
         // (
         //     select * from listdefault
         // )temp
         // EOT;
 
         // Table's primary key
         $primaryKey = 'lib_main_id';
 
         // Array of database columns which should be read and sent back to DataTables.
         // The `db` parameter represents the column name in the database, while the `dt`
         // parameter represents the DataTables column identifier. In this case simple
         // indexes
 
         $columns = array(
             array(
                 'db' => 'lib_main_doccode', 'dt' => 0,
                 'formatter' => function ($d, $row) {
                     return '<b><a href="#">' . $d . '</a></b>'; //or any other format you require
                 }
             ),
             array('db' => 'dc_data_docname', 'dt' => 1),
             array('db' => 'dc_data_date', 'dt' => 2),
             array('db' => 'dc_dept_main_name', 'dt' => 3,)

         );
 
         // SQL server connection information
         $sql_details = array(
             'user' => 'ant',
             'pass' => 'Ant1234',
             'db'   => 'dc',
             'host' => '192.190.2.52'
         );
 
         /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */
         require('server-side/scripts/ssp.class.php');

         $related_code = "";
         $related_code = getnewdeptcode(getUser()->ecode)->dc_user_new_dept_code;
 
         echo json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, "related_dept_code ='$related_code' ")
        );
    }



    

} //End Class




?>