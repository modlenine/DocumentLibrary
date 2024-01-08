<?php
class GetMember_model extends CI_Model{
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->db2 = $this->load->database('saleecolour',TRUE);
    }



    public function get_member()
    {
        return $this->db2->get("member");
    }
    
}

?>