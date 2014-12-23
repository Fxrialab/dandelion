<?php

class FormPostElement extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFormPostElement()
    {
        $this->renderModule('elements/formPost', 'post');
    }

}
