<?php

class GroupElement extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getGroupElement()
    {
        $model = $this->facade->findAllAttributes('groupMember', array('member' => $this->f3->get('SESSION.userID')));
        $groupArray = array();
        if (!empty($model))
        {
            foreach ($model as $value)
            {
                $group = $this->facade->findByPk('group', $value->data->groupID);
                $groupArray[] = array('group' => $group, 'member' => $value);
            }
        }
        $this->render('elements/groupElement', array('group' => $groupArray));
    }

}
