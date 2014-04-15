<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/31/13 - 2:18 PM
 * Project: UserWired Network - Version: beta
 * <ul>
 * <li>{Model::get()->find():Model::get()->find("params = ? ", array())}</li>
 * <li>{Model::get()->findAll():Model::get()->findAll}</li>
 * <li>{Model::get()->findByPk():Model::get()->findByPk($id)}</li>
 * <li>{Model::get()->findByAttributes():Model::get()->findByAttributes(array())}</li>
 * <li>{Model::get()->findAllByAttributes():Model::get()->findAllByAttributes(array())}</li>
 * <li>{Model::get()->count()}</li>
 * </ul>
 */
require_once CONFIG . 'ExtraConfig.php';
require_once MODELS . "DB.php";
require_once MODEL_UTILS . "interfaces/IDataModel.php";

class OrientDBModel implements IDataModel
{
    protected $helpers = array('Security', 'String');
    protected $_db;
    protected $_config;
    protected $_className;
    protected $_clusterID;
    private $flagLoaded = false;
    public $conditions = '';

    protected function loadHelpers()
    {
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
        $this->_db = getDBConnection();
        $this->_config = $this->_db->DBOpen(DATABASE, USER, PASSWORD);
        $this->_className = $className;
        $this->_clusterID = ExtraConfig::getId($className);
        $this->loadHelpers();
    }

    public function save($data)
    {
        $record = new OrientDBRecord();
        $record->className = $this->_className;

        foreach ($data as $key => $value) {
            $record->data->$key = $value;
        }
        $this->_db->recordCreate($this->_clusterID, $record);

        return $record->recordID;
    }

    public function load($id)
    {
        return $this->_db->recordLoad($id);
    }

    /*
     * Find a record by condition
     * @return a object
     * */

    public function find($id)
    {
        $sql = "SELECT FROM " . $this->_className ." WHERE @rid = #".$id;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0];
    }

    /*
     * Find record by condition
     * @return a object array
     * */

    public function findByCondition($conditions, $values)
    {
        for ($i = 0; $i < count($values); $i++)
        {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "SELECT FROM " . $this->_className . (empty($conditions) ? "" : (" WHERE " . $conditions)) ;
        echo $sql;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult;
    }

    public function findAll()
    {
        $sql = "SELECT FROM " . $this->_className;

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    /*
     * Update record is determined by recordID
     * @return
     * */

    public function update($recordID, $record)
    {
        $recordUpdate = $this->_db->recordUpdate($recordID, $record);
        return $recordUpdate;
    }

    /*
     * Update data for record was determined by separate conditions with values
     * @return
     * */

    public function updateByCondition($data, $conditions, $values)
    {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++)
        {
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

    /*
     * Count record by separate conditions with values
     * @return number
     * */

    public function countByCondition($conditions, $values)
    {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++)
        {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "SELECT COUNT(*) FROM " . $this->_className . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0]->data->COUNT;
    }

    /*
     * Delete record is determined by recordID
     * @return
     * */

    public function delete($recordID)
    {
        return $this->_db->recordDelete($recordID);
    }

    /*
     * delete an record was determined by separate conditions with values
     * @return
     * */

    public function deleteByCondition($conditions, $values)
    {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0; $i < count($values); $i++)
        {
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
