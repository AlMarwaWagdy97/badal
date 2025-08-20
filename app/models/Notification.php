<?php


class Notification extends Model
{
    public function __construct()
    {
        parent::__construct('app_notifications');
    }

    
    /**
     * add notify in app_notfication 
     * @param array $data
     * @return boolean
     */
    public function storeNotify($data)
    {
        $this->db->query('INSERT INTO app_notifications ( `donor_id`, `title`, `content`, `type`,`badal_id`, `order_id`, `status`, `modified_date`, `create_date`)
        VALUES (:donor_id, :title, :content, :type, :badal_id, :order_id, :status, :modified_date, :create_date )');
        // binding values
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['msg']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':badal_id', $data['badal_id']);
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':status', 1);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }


    /**
     * add notify in app_notfication 
     * @param array $data
     * @return boolean
     */
    public function getOrderInfo($order_identifier)
    {
        $query = "SELECT  `orders`.order_id, `badal_orders`.badal_id
        FROM `orders`, `badal_orders` 
        WHERE  `orders`.order_identifier = :order_identifier
        AND `orders`.order_id = `badal_orders`.order_id
        ORDER BY orders.create_date DESC ";
        $this->db->query($query);
        $this->db->bind(':order_identifier', $order_identifier);
        return $this->db->single();
    }


    /**
     * get all notification by donor_id 
     * @param Array $ids
     */
    public function getNotfications($donor_id)
    {
        $query = "SELECT app_notifications.*, from_unixtime(app_notifications.create_date) as create_date, from_unixtime(app_notifications.modified_date) as modified_date
                FROM app_notifications 
                WHERE  `app_notifications`.donor_id = :donor_id
                AND app_notifications.status = 1
                ORDER BY app_notifications.create_date DESC
                LIMIT 20 ";
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);
        return $this->db->resultSet();
    }


    /**
     * get all notification by donor_id pagination
     * @param Array $ids
     */
    public function getNotficationsPaginate($donor_id, $offset, $per_page)
    {
        $query = "SELECT app_notifications.*, from_unixtime(app_notifications.create_date) as create_date, from_unixtime(app_notifications.modified_date) as modified_date
                FROM app_notifications 
                WHERE  `app_notifications`.donor_id = :donor_id
                AND app_notifications.status = 1
                ORDER BY app_notifications.notfication_id DESC 
                LIMIT :offset, :per_page
            ";
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':per_page', $per_page, PDO::PARAM_INT);
        return $this->db->resultSet();
    }


    /**
     * get count notification by donor_id 
     * @param Array $ids
     */
    public function getCountNotfication($donor_id)
    {
        $this->db->query('SELECT count(*) as count FROM app_notifications WHERE donor_id = ' . $donor_id . ' AND status = 1  LIMIT 1 ');
        $this->db->excute();
        return $this->db->single();
    }


    /**
     * read all notification by donor_id 
     * @param Array $ids
     */
    public function readNotfications($donor_id)
    {
        $query = 'UPDATE `app_notifications` SET  `read` = 1,  `modified_date` = :modified_date WHERE `donor_id`= :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * read one  notification by notfication_id 
     * @param Array $ids
     */
    public function readNotficationByID($notfication_id)
    {
        $query = 'UPDATE `app_notifications` SET  `read` = 1,  `modified_date` = :modified_date WHERE `notfication_id`= :notfication_id';
        $this->db->query($query);
        $this->db->bind('notfication_id', $notfication_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * read one  notification by notfication_id 
     * @param Array $ids
     */
    public function unreadNotfication($donor_id)
    {
        $this->db->query('SELECT * FROM app_notifications WHERE donor_id = ' . $donor_id . ' AND status = 1 AND `read` = 0  LIMIT 20 ');
        $this->db->excute();
        return $this->db->resultSet();
    }
  
  
}
