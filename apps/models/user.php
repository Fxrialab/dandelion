<?php

require_once('app_model.php');
class User extends AppModel
{

    public function __construct()
    {
        parent::__construct(11, 'user');
    }

//    function __construct($f3) {
//        // Make sure we have a table name
//        $this->table = 'user';
//        if (!isset($this->table))
//            throw new LogicException(get_class($this) . ' must have a $table');
//        else if (!$f3->exists('DB'))
//            throw new LogicException(get_class($this) . ' needs a database variable \'DB\' in $f3');
//
//        // This is where the mapper and DB structure synchronization occurs
//        parent::__construct(11, $this->table);
//    }

    public function __destruct()
    {
        parent::__destruct();
    }

}