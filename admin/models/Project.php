<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

class Project extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('projects');
    }

    /**
     * get all projects from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object projects data
     */
    public function getProjects($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT projects.*, project_categories.name as category, project_categories.category_id  FROM projects, project_categories ' . $cond . ' ORDER BY projects.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allProjectsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new projects
     * @param array $data
     * @return boolean
     */
    public function addProject($data)
    {
        $this->db->query('INSERT INTO projects( name, alias, project_number, beneficiary, description, image, arrangement, kafara, background_image, background_color, featured, badal, badal_type,
        back_home, meta_keywords, meta_description, status, finished, modified_date, create_date,enable_cart, mobile_confirmation, gift, gift_card_title, donation_type, target_price, 
         target_unit, unit_price, payment_methods, fake_target, min_price, hidden, thanks_message, advertising_code, header_code, whatsapp, mobile, end_date, start_date, category_id, secondary_image, sms_msg
        )'
            . ' VALUES (:name, :alias, :project_number, :beneficiary, :description, :image, :arrangement, :kafara, :background_image, :background_color, :featured, :badal, :badal_type,
            :back_home, :meta_keywords, :meta_description, :status, :finished, :modified_date, :create_date, :enable_cart, :mobile_confirmation, :gift, :gift_card_title, :donation_type, :target_price,
            :target_unit, :unit_price, :payment_methods, :fake_target, :min_price, :hidden, :thanks_message, :advertising_code, :header_code, :whatsapp, :mobile, :end_date, :start_date, :category_id, :secondary_image, :sms_msg
        )');

        // binding values
        $this->db->bind(':enable_cart', $data['enable_cart']);
        $this->db->bind(':gift_card_title', $data['gift_card_title']);
        $this->db->bind(':gift', $data['gift']);
        $this->db->bind(':project_number', $data['project_number']);
        $this->db->bind(':beneficiary', $data['beneficiary']);
        $this->db->bind(':mobile_confirmation', $data['mobile_confirmation']);
        $this->db->bind(':donation_type', json_encode($data['donation_type']));
        $this->db->bind(':target_price', (int) $data['target_price']);
        $this->db->bind(':target_unit', $data['target_unit']);
        $this->db->bind(':unit_price', $data['unit_price']);
        $this->db->bind(':payment_methods', json_encode($data['payment_methods']));
        $this->db->bind(':fake_target', (int) $data['fake_target']);
        $this->db->bind(':min_price', (int) $data['min_price']);
        $this->db->bind(':hidden', $data['hidden']);
        $this->db->bind(':sms_msg', $data['sms_msg']);
        $this->db->bind(':thanks_message', $data['thanks_message']);
        $this->db->bind(':advertising_code', $data['advertising_code']);
        $this->db->bind(':header_code', $data['header_code']);
        $this->db->bind(':whatsapp', $data['whatsapp']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':secondary_image', $data['secondary_image']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':kafara', $data['kafara']);
        $this->db->bind(':badal', $data['badal']);
        $this->db->bind(':badal_type', @$data['badal_type'] ?? NULL);
        $this->db->bind(':background_image', $data['background_image']);
        $this->db->bind(':background_color', $data['background_color']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':back_home', $data['back_home']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':finished', $data['finished']);
        $this->db->bind(':status', $data['status']);
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
     * updateProject
     * @param  array $data
     * @return void
     */
    public function updateProject($data)
    {
        $query = 'UPDATE projects SET name = :name, project_number= :project_number, beneficiary= :beneficiary, description = :description, arrangement = :arrangement, kafara = :kafara, back_home = :back_home, meta_keywords = :meta_keywords, 
        alias = :alias, enable_cart = :enable_cart, gift = :gift, gift_card_title = :gift_card_title, mobile_confirmation = :mobile_confirmation, donation_type = :donation_type, target_price = :target_price,unit_price = :unit_price, 
        target_unit = :target_unit, payment_methods = :payment_methods, fake_target = :fake_target, min_price = :min_price, hidden = :hidden, thanks_message = :thanks_message, advertising_code = :advertising_code, 
        header_code = :header_code, whatsapp = :whatsapp, mobile = :mobile, end_date = :end_date, start_date = :start_date, category_id = :category_id, sms_msg = :sms_msg, badal_type = :badal_type,
        background_color =:background_color, featured=:featured, meta_description = :meta_description, status = :status, finished = :finished, modified_date = :modified_date';

        (empty($data['background_image'])) ? null : $query .= ', background_image = :background_image';
        (empty($data['secondary_image'])) ? null : $query .= ', secondary_image = :secondary_image';
        (empty($data['image'])) ? null : $query .= ', image = :image';

        $query .= ' WHERE project_id = :project_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':beneficiary', $data['beneficiary']);
        $this->db->bind(':project_number', $data['project_number']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':kafara', $data['kafara']);
        $this->db->bind(':back_home', $data['back_home']);
        $this->db->bind(':background_color', $data['background_color']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':finished', $data['finished']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':enable_cart', $data['enable_cart']);
        $this->db->bind(':gift', $data['gift']);
        $this->db->bind(':gift_card_title', $data['gift_card_title']);
        $this->db->bind(':mobile_confirmation', $data['mobile_confirmation']);
        $this->db->bind(':donation_type', json_encode($data['donation_type']));
        $this->db->bind(':target_price', (int) $data['target_price']);
        $this->db->bind(':target_unit', $data['target_unit']);
        $this->db->bind(':unit_price', $data['unit_price']);
        $this->db->bind(':payment_methods', json_encode($data['payment_methods']));
        $this->db->bind(':fake_target', (int) $data['fake_target']);
        $this->db->bind(':min_price', (int) $data['min_price']);
        $this->db->bind(':hidden', $data['hidden']);
        $this->db->bind(':sms_msg', $data['sms_msg']);
        $this->db->bind(':thanks_message', $data['thanks_message']);
        $this->db->bind(':advertising_code', $data['advertising_code']);
        $this->db->bind(':header_code', $data['header_code']);
        $this->db->bind(':whatsapp', $data['whatsapp']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':badal_type', @$data['badal_type']??NULL);
        empty($data['background_image']) ? null : $this->db->bind(':background_image', $data['background_image']);
        empty($data['secondary_image']) ? null : $this->db->bind(':secondary_image', $data['secondary_image']);
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get project by id
     * @param integer $id
     * @return object project data
     */
    public function getProjectById($id)
    {
        return $this->getById($id, 'project_id');
    }

    /**
     * get list of projects categories
     * @param string $cond
     * @return object categories list
     */
    public function categoriesList($cond = '')
    {
        $query = 'SELECT category_id, name FROM project_categories  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get list of projects categories
     * @param string $cond
     * @return object categories list
     */
    public function tagsList($cond = '')
    {
        $query = 'SELECT tag_id, name FROM project_tags  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }
    /**
     * get list of projects tags
     * @param string $cond
     * @return object tags list
     */
    public function tagsListByProject($project_id)
    {
        $query = 'SELECT project_tags.tag_id,  project_tags.name FROM tags_projects ,project_tags WHERE tags_projects.project_id = ' . $project_id . ' and project_tags.tag_id = tags_projects.tag_id ';
        $this->db->query($query);
        $results = $this->db->resultSet(PDO::FETCH_COLUMN);
        return $results;
    }
    /**
     * get list of pamyment methods
     * @param string $cond
     * @return object categories list
     */
    public function paymentMethodsList($cond = '')
    {
        $query = 'SELECT payment_id, title FROM payment_methods  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }



    /**
     * insertTags
     *
     * @param  mixed $tags
     * @param  mixed $project_id
     *
     * @return void
     */
    public function insertTags($tags, $project_id)
    {
        foreach ($tags as $tag_id) {
            $this->db->query('INSERT INTO tags_projects( tag_id, project_id, modified_date, create_date) VALUES (:tag_id, :project_id, :modified_date, :create_date)');

            // binding values
            $this->db->bind(':tag_id', $tag_id);
            $this->db->bind(':project_id', $project_id);
            $this->db->bind(':create_date', time());
            $this->db->bind(':modified_date', time());

            // excute
            $this->db->excute();
        }
    }

    /**
     * delete Tags By Project Id
     *
     * @param  mixed $projectId
     *
     * @return void
     */
    public function deleteTagsByProjectId($project_id)
    {
        $this->db->query('DELETE FROM tags_projects WHERE project_id = :project_id');

        $this->db->bind(':project_id', $project_id);

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get last Id
     * @return integr
     */
    public function lastId()
    {
        return $this->db->lastId();
    }

    /**
     * handling Search Condition, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchCondition($searches)
    {
        //reset search session
        unset($_SESSION['search']);
        $cond = '';
        $bind = [];
        if (!empty($searches)) {
            foreach ($searches as $keyword) {
                if ($keyword == 'category_id' && !empty($_SESSION['search'][$keyword])) {
                    $cond .= ' AND ' . $this->table . '.' . $keyword . ' = :' . $keyword . ' ';
                } else {
                    $cond .= ' AND ' . $this->table . '.' . $keyword . ' LIKE :' . $keyword . ' ';
                }
                $bind[':' . $keyword] = $_POST['search'][$keyword];
                $_SESSION['search'][$keyword] = $_POST['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }

    /**
     * handling Search Condition on the stored session, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchSessionCondition($searches)
    {
        $cond = '';
        $bind = [];
        foreach ($searches as $keyword) {
            if (isset($_SESSION['search'][$keyword])) {
                if ($keyword == 'category_id' && !empty($_SESSION['search'][$keyword])) {
                    $cond .= ' AND ' . $this->table . '.' . $keyword . ' = :' . $keyword . ' ';
                } else {
                    $cond .= ' AND ' . $this->table . '.' . $keyword . ' LIKE :' . $keyword . ' ';
                }
                $bind[':' . $keyword] = $_SESSION['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }
    /**
     * getAll data from database
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  array $bindLimit
     *
     * @return Object
     */
    public function getAll($query, $bind = '', $limit = '', $bindLimit = '')
    {
        $this->db->query($query . $limit);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                if ($key == ':category_id' && !empty($value)) {
                    $this->db->bind($key, '' . $value . '');
                } else {
                    $this->db->bind($key, '%' . $value . '%');
                }
            }
        }
        if (!empty($bindLimit)) {
            foreach ($bindLimit as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        return $this->db->resultSet();
    }

    /**
     * update projects order
     *
     * @param [int] $data
     * @return void
     */
    public function arrangeProject($data)
    {
        $this->db->query('UPDATE projects SET arrangement = :arrangement WHERE project_id = :project_id');
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':arrangement', $data['arrangement']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * load API and check if item ID exist
     *
     * @param [type] $item_id
     * @return void
     */
    public function itemExistAPI($item_id)
    {
        return true;
        // $data = json_decode(file_get_contents('http://ataa.namaa.sa:78/api/lists/GetAll_RevenueItems_nama'));
        $data = json_decode(file_get_contents('https://bogfreeapi.azurewebsites.net/API/lists/GetAll_RevenueItems_nama'));
        $itemLest = [];
        foreach ($data->itemsList as $item) {
            $itemLest[] = $item->itemID;
        }
        return in_array($item_id, $itemLest);
    }

    /**
     * get all projects from datatbase with status
     *
     * @return object projects data
     */
    public function getProjectsActive()
    {
        $query  = "SELECT `project_id`, `name` FROM `projects` WHERE projects.status = 1;";
        return $this->getAll($query);
    }

    /**
     * get all projects hits
     *
     * @return object projects data
     */
    public function getProjectsHits()
    {
        $query = 'SELECT p.project_id, p.name, sp.hits
        FROM stores_projects sp
        INNER JOIN projects p ON sp.project_id = p.project_id
        WHERE sp.store_id IS NULL';

        $this->db->query($query);

        return ($this->db->resultSet());
    }
    
}
