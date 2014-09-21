<?php
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
    protected $notUsingHelpers = array('save', 'load', 'find', 'findCustomers', 'update', 'delete');

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
        foreach ($this->notUsingHelpers as $func)
        {
            if ($className != $func)
                $this->loadHelpers();
        }
    }

    /**
     * Save a record
     *
     * @param array $data
     * @return string
     */
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

    /**
     * Find a record by id
     *
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        $sql = "SELECT FROM " . $this->_className ." WHERE @rid = #".$id;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0];
    }

    public function findOne($conditions, $values)
    {
        for ($i = 0; $i < count($values); $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }

        $sql = "SELECT FROM " . $this->_className . (empty($conditions) ? "" : (" WHERE " . $conditions)) . " LIMIT 1";

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

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult;
    }

    public function findCustomers($conditions)
    {
        $sql = "SELECT FROM " . $this->_className . $conditions;

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

    /**
     * Delete record is determined by recordID
     *
     * @param $recordID
     * @return mixed
     */
    public function delete($recordID)
    {
        return $this->_db->recordDelete($recordID);
    }

    /**
     * Delete an record was determined by separate conditions with values
     *
     * @param string $conditions
     * @param array $values
     * @return mixed
     */
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

    /**
     * @param $sourceID
     * @param $destinationID
     * @param array|null $data
     * @return mixed
     */
    public function createEdge($sourceID, $destinationID, $data = null)
    {
        $sql = "CREATE EDGE " . $this->_className . " FROM " . $sourceID . " TO " . $destinationID;
        if (is_array($data) && count($data) > 0)
        {
            $sql = $sql . " SET ";
            foreach ($data as $key => $value) {
                $sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "',";
            }
            $sql = substr($sql, 0, -1);
        }
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    public function deleteEdge($sourceID, $desID, $data = null)
    {
        $sql = "DELETE EDGE " . $this->_className . " FROM " . $sourceID . " TO " . $desID;
        if (is_array($data) && count($data) > 0)
        {
            $sql = $sql . " WHERE ";
            foreach ($data as $key => $value) {
                $sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "' AND";
            }
            $sql = substr($sql, 0, -3);
        }
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    /**
     * @param string $command
     * @param array|null $arrays
     * @return array|bool
     */
    public function callGremlin($command, $arrays = null)
    {
        if (!empty($command))
        {
            $sql = "SELECT GREMLIN( '" . $command . "' ) FROM " . $this->_className;
            if (is_array($arrays) && count($arrays) > 0)
            {
                $conditions  = "";
                $operator   = " AND ";
                foreach ($arrays as $key => $v) {
                    $conditions = $conditions.$operator.$key." = ?";
                    $values[] = $v;
                }
                $conditions = substr($conditions,strlen($operator));

                for ($i = 0; $i < count($values); $i++) {
                    $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
                    $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
                }
                $sql = $sql . " WHERE " . $conditions;
            }

            $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

            if (!empty($queryResult))
            {
                $stringResult = $this->getString($queryResult);
                $result = $this->getContentResult($stringResult, $this->_className);

                return $result;
            }else
                return false;
        }else {
            return false;
        }
    }

    private function getString($var)
    {
        $toFind = "GREMLIN";
        $array = array();
        for ($i = 0; $i < count($var); $i++)
        {
            $pos[$i] = strpos($var[$i]->content, $toFind) + strlen($toFind);
            $start[$i] = (int) $pos[$i];
            $result[$i] = substr($var[$i]->content, $start[$i] + 1, strlen($var[$i]->content) - $start[$i]);
            array_push($array, $result[$i]);
        }
        return $array;
    }

    private function getContentResult($resultGremlin, $className)
    {
        $toFirstFind = 'com.tinkerpop.blueprints.impls.orient.OrientVertex|#';
        $toSecondFind = '#';
        $toThirdFind = '}';
        $arrayResult = array();
        for ($i = 0; $i < count($resultGremlin); $i++)
        {
            $pos1[$i] = strpos($resultGremlin[$i], $toFirstFind);
            if (isset($pos1[$i]) && is_numeric($pos1[$i]))
            {
                $replace[$i] = str_replace(array($toFirstFind, ')', '[', ']'), '', $resultGremlin[$i]);
                $arrayResult = explode(',', $replace[$i]);
            }else {
                $pos2[$i] = strpos($resultGremlin[$i], $toSecondFind);
                if (isset($pos2[$i]) && is_numeric($pos2[$i]))
                {
                    $replace[$i] = str_replace(array('v(' . $className . ')[#', ']', '#'), '', $resultGremlin[$i]);
                    array_push($arrayResult, $replace[$i]);
                }else {
                    $pos3[$i] = strpos($resultGremlin[$i], $toThirdFind);
                    if (isset($pos2[$i]) && is_numeric($pos3[$i]))
                    {
                        $startPos[$i] = strpos($resultGremlin[$i], '[');
                        $endPos[$i] = strpos($resultGremlin[$i], ']');
                        if (!$startPos[$i] && !$endPos[$i]) {
                            $jsonString[$i] = '[' . $resultGremlin[$i] . ']';
                        } else {
                            $jsonString[$i] = $resultGremlin[$i];
                        }

                        $obj[$i] = json_decode($jsonString[$i]);

                        $arrayResult = $obj[$i];
                    } else {
                        /*$replace[$i] = str_replace(array('"', '[', ']'), '', $resultGremlin[$i]);
                        $arrayResult = explode(',', $replace[$i]);*/
                        return false;
                    }
                }
            }
        }

        return $arrayResult;
    }
}

?>
