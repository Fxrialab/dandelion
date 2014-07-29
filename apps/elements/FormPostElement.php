<?php

require_once CONTROLLERS . "Controller.php";

class FormPostElement extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFormPostElement()
    {
        $this->renderPartial('elements/formPost');
    }

}
