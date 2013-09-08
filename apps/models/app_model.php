<?php
require_once('db.php');

class AppModel {
	protected $helpers = array('Security', 'String');
	protected $_clusterID;
	protected $_db;
	protected $_className;
	protected $_config;

	public function __construct($clusterID, $className)
    {
		$this->_clusterID = $clusterID;
		$this->_className = $className;
		$this->_db =& getDBConnection();			
		$this->_config = $this->_db->DBOpen(DATABASE, USER, PASSWORD);
		$this->loadHelpers();
	}

    protected function loadHelpers()
    {
        foreach ($this->helpers as $helper) {
            // get file name
            $helperFile = lcfirst($helper);
            $helper = $helper . 'Helper';

            if (file_exists(HELPERS . $helperFile  . '_helper.php')) {
                require_once(HELPERS . $helperFile . '_helper.php');
                $this->$helper= new $helper;
            }
        }
    }
	
	public function __destruct()
    {}

    /**
     *
     * Some functions for interactive support with OrientDB
     *
     */

	//get cluster ID of Class
	public function getClusterID()
    {
		return $this->_clusterID;
	}
    // get class name
    public function getClassName()
    {
        return $this->_className;
    }

    /**
     * Create an class to OrientDB server
     * @type: V for vertex, E for edge or another superclass
     */
    public function createClass($className, $type='')
    {
        if ($className)
        {
            if ($type)
                $sql = "Create class ".$className." extends ".$type;
            else
                $sql = "Create class ".$className;
            $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        }else{
            echo "Syntax error, please check.";
        }
    }

    /**
     * Create vertex
     *
     */
    public function createVertex($data,$excludes='')
    {
        if (is_string($excludes)) $excludes = explode(",",$excludes);
        //$conditionQuery
        $sql = "CREATE VERTEX " . $this->_className . " SET ";
        foreach ($data as $key=>$value)
        {
            if (!in_array($key, $excludes))
                $sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "',";
        }
        $sql = substr($sql, 0, -1);
        echo $sql;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult;
    }

    /**
     * Create edge
     *
     */
    public function createEdge($sourceID, $destinationID, $data=null)
    {
        $sql = "CREATE EDGE " . $this->_className . " FROM ".$sourceID." TO ".$destinationID;
        if ($data)
        {
            $sql = $sql." SET ";
            foreach ($data as $key=>$value)
            {
                $sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "',";
            }
            $sql = substr($sql, 0, -1);
        }
        echo $sql;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    /**
     * GREMLIN() SQL function
     *
     */
    public function sqlGremlin($command, $conditions=null, $values=null)
    {
        $toFind = '.map';
        $check = strpos($command, $toFind);
        $tempArray = array();
        if ($check)
        {
            $parentResult = $this->checkCommand($toFind, $command, $conditions, $values);
            $tempArray = $parentResult;
        }

        $sql = "SELECT GREMLIN( '".$command."' ) FROM ".$this->_className;
        if ($conditions && $values)
        {
            for ($i = 0;  $i < count($values);  $i++) {
                $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
                $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
            }
            $sql = $sql." WHERE " . $conditions;
        }
        echo $sql."<br />";
        $queryResult    = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        $stringResult   = $this->getResultString($queryResult[0]->content);
        if ($tempArray)
            $result     = $this->getContentGremlin($stringResult, $tempArray);
        else
            $result     = $this->getContentGremlin($stringResult);

        return $result;
    }

    /**
     * check if exist map command will get parent command for return multi array
     *
     */
    public function checkCommand($find, $command, $conditions, $values)
    {
        $parentCommand = substr($command,0, strlen($command) - strlen($find));
        $resultID = $this->sqlGremlin($parentCommand, $conditions, $values);
        return $resultID;
    }

    public function testGremlin()
    {
        $sql = "select gremlin('current') from user where username = 'naruto'";
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }

    /**
     * get string result to dump array
     *
     */
    public function varDumpToString($var)
    {
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

    /**
     * get string result of Gremlin
     *
     */
    public function getResultString($var)
    {
        $toFind = "GREMLIN";
        $pos    = strpos($var, $toFind) + strlen($toFind);
        $start  = (int)$pos;
        $result = substr($var, $start + 1, strlen($var) - $start);

        return $result;
    }

    /**
     * return array result of Gremlin
     *
     */
    public function getContentGremlin($resultGremlin, $parentResult=null)
    {
        $toFirstFind = '(com.tinkerpop.blueprints.impls.orient.OrientVertex|#';
        $pos1 =  strpos($resultGremlin,$toFirstFind);
        $arrayResult = array();
        if ($pos1)
        {
            $replace = str_replace(array($toFirstFind, ')', '[', ']'), '', $resultGremlin);
            $arrayResult = explode(',', $replace);
        }else {
            $toSecondFind = '[#';
            $pos2 = strpos($resultGremlin,$toSecondFind);
            if ($pos2)
            {
                $replace = str_replace(array('v[#', ']'), '', $resultGremlin);
                array_push($arrayResult, $replace);
            }else {
                $toThirdFind = '}';
                $pos3 = strpos($resultGremlin,$toThirdFind);
                if ($pos3)
                {
                    if ($parentResult)
                    {
                        $startPos = strpos($resultGremlin, '[');
                        $endPos = strpos($resultGremlin, ']');
                        if (!$startPos && !$endPos)
                        {
                            $jsonString = '['.$resultGremlin.']';;
                        }else {
                            $jsonString = $resultGremlin;
                        }
                        $obj = json_decode($jsonString);
                        $arrayResult = array_combine($parentResult, $obj);
                    }
                }else {
                    $replace = str_replace(array('"', '[', ']'), '', $resultGremlin);
                    $arrayResult = explode(',', $replace);
                }
            }
        }
        return $arrayResult;
    }

    //create new record in class with column field by key
	public function create($data, $excludes='')
    {
        if (is_string($excludes)) $excludes = explode(",",$excludes);

		$record = new OrientDBRecord();
		$record->className = $this->_className; 
		 
		foreach ($data as $key=>$value)
        {
            if (!in_array($key, $excludes))
                $record->data->$key = $value;
		}
		$this->_db->recordCreate($this->_clusterID, $record);
				
		return $record->recordID;
	}
	
	public function export($obj) 
	{
		$data = array();
		$data["recordID"] = $obj->recordID;
		
		foreach ($obj->data as $key=>$value) 
		{
			$data[$key] = $value;
		}
		
		return $data; 
	}
	
	public function exportJSON($obj)
	{
		return json_encode($this->export($obj));
	}
	
	public function load($id)
    {
		 return $this->_db->recordLoad($id);
	}
	//delete an record in Class has determine recordID
	public function delete($recordID) 
	{
		return $this->_db->recordDelete($recordID);
	}
    //delete an record was determined by separate conditions with values
    public function deleteByCondition($conditions, $values)
    {
        // @todo: exception for handle parsing error (count("?") != len($values))
        for ($i = 0;  $i < count($values);  $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }
        //$conditionQuery
        $sql = "DELETE FROM " . $this->_className . " WHERE " . $conditions;
        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
    }
	////update an record in Class has determine recordID
	public function update($recordID, $record)
    {
        $recordUpdate = $this->_db->recordUpdate($recordID, $record);
        return $recordUpdate;
	}
    //update data for record was determined by separate conditions with values
	public function updateByCondition($data, $conditions, $values)
    {
		// @todo: exception for handle parsing error (count("?") != len($values))
		for ($i = 0;  $i < count($values);  $i++) {
			$preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
			$conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
		}
		//$conditionQuery
		$sql =  "UPDATE " . $this->_className . " SET ";
	
		foreach ($data as $key=>$value) {
			$sql = $sql . ' ' . $key . " = " . "'" . $this->SecurityHelper->postIn($value) . "',";
		}

        $sql = substr($sql, 0, -1);
		$sql = $sql . " WHERE " . $conditions;
		$queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
        return $queryResult;
	}

	public function count($conditions, $values)
    {
		// @todo: exception for handle parsing error (count("?") != len($values))
		for ($i = 0;  $i < count($values);  $i++) {
			$preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
			$conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
		}
		//$conditionQuery
		$sql = "SELECT COUNT(*) FROM " . $this->_className . " WHERE " . $conditions;		
		$queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);		
		
		return $queryResult[0]->data->COUNT;
	}

	public function findByCondition($conditions, $values)
    {
		// @todo: exception for handle parsing error (count("?") != len($values))
		for ($i = 0;  $i < count($values);  $i++) {			
			$preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
			$conditions = $this->StringHelper->replaceFirst("?", $preparedValue, $conditions); 
		}
		//$conditionQuery 
		$sql = "SELECT FROM " . $this->_className . " WHERE " . $conditions;
		$queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

		return $queryResult;		
	}
	
	public function findOne($conditions, $values)
    {
		for ($i = 0;  $i < count($values);  $i++) {			
			$preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'"; 				
			$conditions =$this->StringHelper->replaceFirst("?", $preparedValue, $conditions); 
		}
		
		$sql = "SELECT FROM " . $this->_className . (empty($conditions) ? "" : (" WHERE " . $conditions)) . " LIMIT 1";
						
		$queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

		return $queryResult[0];
	}

	public function findAll()
    {
		$sql = "SELECT FROM " . $this->_className;
		
		$queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);
		return $queryResult;
	}

    /*
     * Function createLink($linkName,$linkType,$condition);
     *  Where: $linkName : Tên liên kết sẽ được tạo trong class.
     *         $linkType : Loại liên kết được tạo(Notice at http://fxrialab.net/dokuwiki/doku.php?id=projects:socialnetwork:graph-orientdb).
     *         $condition : Điều kiện để tạo liên kết .
     * Example : CREATE LINK comments TYPE LINKSET FROM comments.PostId To posts.Id INVERSE
     *  Where : comments là tên liên kết giữa class comment và post.
     *          LINKSET là loại liên kết (1-N) của 2 class comment và post.
     *          comments.PostId To posts.Id là điều kiện để tạo liên kết.
     * example:  CREATE LINK comments TYPE LINKSET FROM comments.!PostId To posts.Id INVERSE
     * */
    public function createLink($linkName, $linkType, $desClass, $desProp)
    {
        $sql="CREATE LINK ".$linkName." TYPE ".$linkType." FROM ". $desClass." TO ".$desProp." INVERSE";

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult;
    }

    public function join($joinList, $conditions, $values)
    {
        for ($i = 0;  $i < count($values);  $i++) {
            $preparedValue = "'" . $this->SecurityHelper->postIn($values[$i]) . "'";
            $conditions =$this->StringHelper->replaceFirst("?", $preparedValue, $conditions);
        }

        $sql = "SELECT ".$joinList." FROM " . $this->_className . (empty($conditions) ? "" : (" WHERE " . $conditions)) . " LIMIT 1";

        $queryResult = $this->_db->command(OrientDB::COMMAND_QUERY, $sql);

        return $queryResult[0];
    }
}
?>