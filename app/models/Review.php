<?php

class Review extends Model
{
    public function __construct()
    {
        parent::__construct('badal_review');
    }

    /**
     * insert new review
     * @param array $data
     * @return boolean
     */
    public function addReview($data)
    {
        $this->db->query('INSERT INTO `badal_review` ( badal_id, rate, description, status, modified_date, create_date)'
            . ' VALUES ( :badal_id, :rate, :description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':badal_id', $data['badal_id']);
        $this->db->bind(':rate', $data['rate']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', 1);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }


    /**
     * insert new review
     * @param array $data
     * @return boolean
     */
    public function getSubstitute($badal_id){
        $this->db->query('SELECT
        `badal_orders`.substitute_id , `substitutes`.*, `orders`.donor_id,
        `orders`.order_id,`orders`.order_identifier,`orders`.total,`orders`.projects,`orders`.donor_name
        FROM  `badal_orders`, `orders`, `substitutes` 
        WHERE `badal_orders`.badal_id = ' . $badal_id.'
        AND `orders`.order_id = `badal_orders`.order_id'
        );
       return $this->db->single();
    }

    /**
     * insert new review
     * @param array $data
     * @return boolean
     */
    public function getSubstituteNew($substitute){
        $this->db->query('
        SELECT
        `substitutes`.* , `donors`.* 
        FROM `substitutes`, `donors` 
        WHERE `substitutes`.substitute_id = ' . $substitute.'
        AND `substitutes`.phone  =  `donors`.mobile
        AND `substitutes`.status  !=  0'
        );
       return $this->db->single();
    }

    /**
     * check if review is exist 
     * @param array $data
     * @return boolean
     */
    public function checkeview($data){
        $this->db->query('SELECT `badal_id` FROM `badal_review` WHERE `badal_id` = :badal_id ');
        $this->db->bind(':badal_id', $data['badal_id']);
       return $this->db->single();
    }

}