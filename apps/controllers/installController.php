<?php
require_once(MODELS.'db.php');

class InstallController extends AppController
{
    //protected $uses     = array("User", "Notify", "Friendship", "Actions");

    public function __construct()
    {
        parent::__construct();
    }

    public function install()
    {
        $this->layout = 'index';

        if (ATTEMPT == 'installed')
        {
            $this->f3->set('msgNotice', 'Database is created, pls delete installController file');
            $this->f3->set('flag', '1');
            $this->render('user/install.php', 'default');
        }else {
            //$this->f3->set('msgNotice', 'Fill database name');
            $this->render('user/install.php', 'default');
        }

    }

    public function installDB()
    {
        $this->layout = 'index';
        $dbName = $this->f3->get('POST.dbName');

        if ($dbName)
        {
            $orientDB = &getDBConnection();
            $orientDB->connect(ROOT, ROOT_PW);
            $existedDB = $orientDB->DBExists($dbName);
            if (!$existedDB)
            {
                $createDB = $orientDB->DBCreate($dbName, ORIENTDB::DB_TYPE_LOCAL);

                if ($createDB)
                {
                    $databaseFile = CONFIG."database.php";
                    file_put_contents($databaseFile,str_replace('dandelion',$dbName,file_get_contents($databaseFile)));
                    file_put_contents($databaseFile,str_replace('default', 'installed',file_get_contents($databaseFile)));

                }
                $orientDB->DBClose();

                $db = new OrientDB(HOST, PORT);

                $db->DBOpen($dbName, USER, PASSWORD);

                $sql = array(
                    "create class user"                 => "user",
                    "create class notify"               => "notify",
                    "create class sessions"             => "sessions",
                    "create class status"               => "status",
                    "create class comment"              => "comment",
                    "create class activity"             => "activity",
                    "create class actions"              => "actions",
                    "create class friendship"           => "friendship",
                    "create class follow"               => "follow",
                    "create class album"                => "album",
                    "create class photo"                => "photo",
                    "create class information"          => "information",
                    "create class permission"           => "permission",
                    "create class like"                 => "like",
                );

                foreach ($sql as $command=>$class)
                {

                    $db->command(OrientDB::COMMAND_QUERY, $command);
                }
                $db->DBClose();
                $this->render('user/notice.php','default');
            }else {
                $this->f3->set('msgNotice', 'Existed this database, pls fill another database');
                $this->f3->set('flag', '2');
                $this->render('user/install.php', 'default');
            }
        }
    }

}