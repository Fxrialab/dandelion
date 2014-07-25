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

// render view: $this->render('path',array())
    public function render($path, $set = array())
    {
        foreach ($set as $k => $value)
        {
            $this->f3->set($k, $value);
        }
        if (file_exists(LAYOUTS . $this->layout . '/' . $path . '.php'))
            $page = LAYOUTS . $this->layout . '/' . $path . '.php';
        else
            $page = LAYOUTS . $path . '.php';

        if (!empty($this->layout))
            require_once(UI . LAYOUTS . $this->layout . '.php');
        else
            echo View::instance()->render($page);
    }

    // render view: $this->renderPartial('path',array())
    public function renderPartial($path, $set = array())
    {
        foreach ($set as $k => $value)
        {
            $this->f3->set($k, $value);
        }
        $page = LAYOUTS . $path . '.php';
        if (!empty($this->layout))
            require_once(UI . LAYOUTS . $this->layout . '.php');
        else
            echo View::instance()->render($page);
    }

    public function renderModule($action, $type)
    {
        $postInfo = Register::getModule($type);
        //var_dump($pathInfo);
        $themePath = $postInfo[0]['viewPath'];
        require_once(MODULES . $themePath . $action . ".php");
    }

}

?>
