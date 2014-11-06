<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 2:48 PM
 * Project: UserWired Network - Version: beta
 */
require_once dirname(__DIR__) . "/config/Structure.php";

require_once FACADE . "DataFacade.php";
require_once FACADE . "AMQFacade.php";
require_once MODEL_UTILS . "ObjectHandler.php";
require_once FACTORY_UTILS . "FactoryUtils.php";

class Controller
{

    protected $f3;
    protected $uses = array("");
    protected $helpers = array("");
    protected $facade;

    public function __construct()
    {
        $f3 = Base::instance();
        $facade = new DataFacade();
        $amq = new AMQFacade();

        $this->f3 = $f3;
        $this->facade = $facade;
        $this->service = $amq;
        $this->_mergeVars(array("uses", "helpers"));
        $this->loadHelpers();
        //$this->loadModels();
    }

    public function _mergeVars($merges)
    {
        $parent = get_class($this);

        while ($parent != '') {
            $appVars = get_class_vars($parent);
            $parent = get_parent_class($parent);

            for ($i = 0; $i < count($merges); $i++)
            {
                $this->$merges[$i] = array_merge($this->$merges[$i], array_diff($appVars[$merges[$i]], $this->$merges[$i]));
            }
        }
    }

    protected function loadHelpers()
    {
        foreach ($this->helpers as $helper)
        {
            // get file name
            $helperFile = lcfirst($helper);
            $helper = $helper . 'Helper';

            if (file_exists(HELPERS . $helperFile . '_helper.php'))
            {
                require_once(HELPERS . $helperFile . '_helper.php');
                $this->$helper = new $helper;
            }
        }
    }

    public function getCurrentUser()
    {
        return $this->f3->get("SESSION.loggedUser");
    }


    /**
     * How to use this render for get variables on view:
     * - If existed layout when render, need $this->f3->get('...') on view for get variables
     * - If not exist layout, only direct echo $variables on view for get variables. It always using when load ajax or return a part data
     *
     * @param $page
     * @param $type
     * @param array $set
     */
    public function render($path, $set = array())
    {
        $page = VIEWS . $path . '.php';
        foreach ($set as $k => $value)
            $this->f3->set($k, $value);
        if ($this->layout != '')
            require_once(VIEWS . LAYOUTS . $this->layout . '.php');
        else
            require_once $page;
    }

    public function renderModule($action, $type, $set = array())
    {
        foreach ($set as $k => $value)
            $this->f3->set($k, $value);
        $page = MODULES . $type . '/views/' . $action . '.php';
        if (!empty($this->layout))
            require_once(VIEWS . LAYOUTS . $this->layout . '.php');
        else
            require_once $page;
    }

    public function inc($param, $type, $array = array())
    {
        foreach ($array as $k => $value)
        {
            $this->f3->set($k, $value);
        }
        if (file_exists(MODULES . $type . '/views/' . $param . '.php'))
            require MODULES . $type . '/views/' . $param . '.php';
        else if (file_exists(VIEWS . $param . '.php'))
            require VIEWS . $param . '.php';
        else
            throw New Exception('File is not existed !');
    }

    public function including($file)
    {
        if (file_exists(VIEWS . 'includes/' . $file . '.php'))
            require_once (VIEWS . 'includes/' . $file . '.php');
        else
            throw New Exception('File is not existed !');
    }

    public function loadContent($path)
    {
        if (file_exists($path))
            require_once $path;
        else
            echo View::instance()->render($path);
    }
    
    

}

?>
