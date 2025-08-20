<?php

/*
 * Copyright (C) 2024 Easy CMS Framework Ahmed Elmahdy
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

class EvaluationsAnswer extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('evaluation_answers');
    }

    /**
     * get all Substitutes from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Substitutes data
     */
    public function getEvaluationAnswers($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM evaluation_answers ' . $cond . ' ORDER BY evaluation_answers.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allEvaluationAnswersCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    public function updateEvaluationAnswers($data)
    {
        $query = 'UPDATE evaluation_answers SET `status` = :status modified_date = :modified_date WHERE evaluation_answers_id = :evaluation_answers_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':evaluation_answers_id', $data['evaluation_answers_id']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get EvaluationsAnswers by id
     * @param integer $id
     * @return object EvaluationsAnswers data
     */
    public function getEvaluationAnswerById($id)
    {
        return $this->getById($id, 'evaluation_answers_id');
    }
}
