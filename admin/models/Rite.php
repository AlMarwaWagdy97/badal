<?php


class Rite extends ModelAdmin
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('rites');
    }

    /**
     * get all deceased from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Deceased data
     */
    public function getRites($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT rites.*, projects.name as project, projects.project_id  FROM rites, projects ' . $cond . ' ORDER BY rites.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allRitesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    
    /**
     * get all projects datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object charity vendors data
     */
    public function getProjects($cond = '', $bind = '', $limit = '', $bindLimit = 50, $cols = '*'){
        $query  = "SELECT projects.project_id, projects.name, project_categories.category_id 
                    FROM projects, project_categories 
                    WHERE   project_categories.category_id = projects.category_id AND projects.status = 1 AND badal = 1;  
                    ORDER BY projects.create_date DESC ";
        return $this->getAll($query);
    }


    /**
     * insert new rites
     * @param array $data
     * @return boolean
     */
    public function addRites($data)
    {
        $this->db->query('INSERT INTO rites( title, project_id, image, arrangement, time_taken, proof, status, modified_date, create_date)'
            . ' VALUES (:title, :project_id, :image, :arrangement, :time_taken, :proof, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':time_taken', $data['time_taken']);
        $this->db->bind(':proof', $data['proof']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * get rites by id
     * @param integer $id
     * @return object rites data
     */
    public function getRituaById($id)
    {
        return $this->getById($id, 'rite_id');
    }
    
    /**
     * update rites  id in project  
     *
     * @return object rites data
     */
    public function updateRites($data)
    {     
        $query = 'UPDATE `rites` SET  `title`= :title, `project_id`= :project_id,  `arrangement` = :arrangement, `time_taken` = :time_taken, `proof`= :proof, `status`= :status, modified_date = :modified_date ';
        (empty($data['image'])) ? null : $query .= ', image = :image';

        $query .= ' WHERE `rite_id` = :rite_id';

        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':time_taken', $data['time_taken']);
        $this->db->bind(':proof', $data['proof']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':rite_id', $data['rite_id']);
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);

          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    /**
     * getProjectsById
     *
     * @param  mixed $id
     *
     * @return object product
     */
    public function getProjectById($id)
    {
        // prepare Query
        $query = 'SELECT * FROM projects WHERE project_id = :project_id   LIMIT 1 ';
        $this->db->query($query);
        //bind values
        $this->db->bind(':project_id', $id);
        return $this->db->single();
    }

}


