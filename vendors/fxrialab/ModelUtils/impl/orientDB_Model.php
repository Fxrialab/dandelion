<?php
require_once CONFIG . 'orientDBConfig.php';
require_once MODELS . "db.php";
require_once MODEL_UTILS."interfaces/IDataModel.php";

class OrientDB_Model implements IDataModel
{
    protected $helpers = array('Security', 'String');
    protected $_db;
    protected $_config;
    protected $_className;
    protected $_clusterID;

    protected function loadHelpers() {
        foreach ($this->helpers as $helper) {
            // get file name
            $helperFile = lcfirst($helper);
            $helper = $helper . 'Helper';

            if (file_exists(HELPERS . $helperFile . '_helper.php')) {
                require_once(HELPERS . $helperFile . '_helper.php');
                $this->$helper = new $helper;
            }
        }
    }

    public function setTarget($className)
    {
        $this->_db          = getDBConnection();
        $this->_config      = $this->_db->DBOpen(DATABASE, USER, PASSWORD);
        $map = OrientDBConfig::mapClass($className);
        $this->_className   = $map['className'];
        $this->_clusterID   = $map['clusterID'];
        $this->loadHelpers();
        var_dump($map);
    }

    public function save($data, $excludes = '')
    {
        if (is_string($excludes))
            $excludes = explode(",", $excludes);

        $record = new OrientDBRecord();
        $record->className = $this->_className;

        foreach ($data as $key => $value) {
            if (!in_array($key, $excludes))
                $record->data->$key = $value;
        }
        $this->_db->recordCreate($this->_clusterID, $record);

        return $record->recordID;
    }

    public function load($id) {
        return $this->_db->recordLoad($id);
    }

    public function findOne($conditions, $values) {
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }

        $sql = "SELECT FROM " . $this->_className . (empty($conditions) ? "" : (" WHERE " . $conditions)) . " LIMIT 1";

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0];
    }

    public function findByCondition($conditions, $values)
    {
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }

        //$conditionQuery
        $sql = "SELECT FROM " . $this->_className . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult;
    }

    public function findAll() {
        $sql = "SELECT FROM " . $this->_className;

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    //update an record in Class has determine recordID
    public function update($recordID, $record) {
        $recordUpdate = $this->_db->recordUpdate($recordID, $record);
        return $recordUpdate;
    }

    //update data for record was determined by separate conditions with values
    public function updateByCondition($data, $conditions, $values) {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "UPDATE " . $this->_className . " SET";

        foreach ($data as $key => $value) {
            $sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "',";
        }

        $sql = substr($sql, 0, -1);
        $sql = $sql . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    public function count($conditions, $values) {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "SELECT COUNT(*) FROM " . $this->_className . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0]->data->COUNT;
    }

    //delete an record in Class has determine recordID
    public function delete($recordID) {
        return $this->_db->recordDelete($recordID);
    }

    //delete an record was determined by separate conditions with values
    public function deleteByCondition($conditions, $values) {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "DELETE FROM " . $this->_className . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }
}

?>