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
    public function sqlGremlin($command, $conditions, $values)
    {
        $toFind = '.map';
        $check = strpos($command, $toFind);
        $tempArray = array();
        if ($check)
        {
            $parentResult = $this->checkCommand($toFind, $command, $conditions, $values);
            $tempArray = $parentResult;
        }

        switch ($command)
        {
            case "current":
            case "current.out":
            case "current.out.both":
            case "current.in":
            case "current.in.map":
            case "current.in.both":
            case "current.in.both.map":
            case "current.both":
            case "current.out.in":
            case "current.out.in.both":
            case "current.in.out":
            case "current.in.out.both":
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
                $obResult       = $this->varDumpToString($queryResult);
                $stringResult   = $this->getResultString($obResult);
                if ($tempArray)
                    $result         = $this->getContentGremlin($stringResult, $tempArray);
                else
                    $result         = $this->getContentGremlin($stringResult);
                break;
            default:
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
                $stringResult   = $this->getResultString($queryResult[0]);
                $result         = $this->getContentGremlin($stringResult);
                break;
        }
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
        $toFirstFind    = "GREMLIN";
        $toSecondFind   = "]'</font>";
        $toThirdFind    = "}]'";
        $toFourthFind   = "}'</font>";
        $firstPos   = strpos($var, $toFirstFind) + strlen($toFirstFind);
        $secondPos  = strpos($var, $toSecondFind);
        $thirdPos   = strpos($var, $toThirdFind);
        $fourthFind = strpos($var, $toFourthFind);
        $start      = (int)$firstPos;
        if ($secondPos)
        {
            $end    = (int)$secondPos;
            $result = substr($var, $start + 1, $end - $start);
        }else {
            if ($thirdPos)
            {
                $end    = (int)$thirdPos;
                $result = substr($var, $start + 1, $end - $start);
            }
            elseif ($fourthFind)
            {
                $end    = (int)$fourthFind;
                $result = substr($var, $start + 1, $end - $start);
            }else
                $result = substr($var, $start + 1);
        }
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
            $replace1 = str_replace($toFirstFind, '', $resultGremlin);
            $replace2 = str_replace(')', '', $replace1);
            $replace3 = str_replace('[', '', $replace2);
            $replace4 = str_replace(']', '', $replace3);
            $arrayResult = explode(',', $replace4);
        }else {
            $toSecondFind = '[#';
            $pos2 = strpos($resultGremlin,$toSecondFind);
            echo $pos2;
            if ($pos2)
            {
                $replace1 = str_replace('v[#', '', $resultGremlin);
                $replace2 = str_replace(']', '', $replace1);
                array_push($arrayResult, $replace2);
            }else {
                $toThirdFind = '}';
                $pos3 = strpos($resultGremlin,$toThirdFind);
                if ($pos3)
                {
                    if ($parentResult)
                    {
                        $replace1 = str_replace('&quot;', '', $resultGremlin);
                        $recordArray = explode('},{', $replace1);
                        foreach ($parentResult as $node)
                        {
                            foreach ($recordArray as $record)
                            {
                                $replace2 = str_replace('[{', '', $record);
                                $replace3 = str_replace('}]', '', $replace2);
                                $replace4 = str_replace('{', '', $replace3);
                                $replace5 = str_replace('}', '', $replace4);
                                $replace6 = str_replace(':', '=>', $replace5);
                                $result   = explode(',', $replace6);
                                foreach ($result as $parameter)
                                {
                                    $title = substr($parameter, 0, strpos($parameter, '=>'));
                                    $value = substr($parameter, strlen($title) + strlen('=>'));
                                    $arrayResult[$node][$title] = $value;
                                }
                            }
                        }
                    }
                }else {
                    $replace1 = str_replace('"', '', $resultGremlin);
                    $replace2 = str_replace('[', '', $replace1);
                    $replace3 = str_replace(']', '', $replace2);
                    $arrayResult = explode(',', $replace3);
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