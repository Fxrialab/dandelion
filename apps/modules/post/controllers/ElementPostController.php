<?php

class ElementPostController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFormPost()
    {
        $this->renderModule('elements/formPost','post');
    }
} 