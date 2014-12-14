# Installing and Configuration

#### OrientDB

* After download OrientDB 1.7-rc2, extract archive files and copy to bin folder of wamp and rename to orientdb.
* Open file orientdb-server-config.xml in the folder ../wamp/bin/orientdb/config and seek to declare line of account root and password for authentication information to create DB. Like this:
```
<user resources="*" password="123123" name="root"/> //declare this on <users> tag```

* Run file server.bat in folder ../wamp/bin/orientdb/bin to turn server orientDB on. Note: Make sure your computer is install java and set environment variables.
* Ready to configure for orientDB:
  * Go to orientDB on local with this link: http://localhost:2480/
  * Create New DB for project by click link Create new database. Then enter DB name ( dandelion is its name). Choose Type is Graph, Storage Type still is local. When click Create that would require for information of account root to create.
    * Choose DB to login with user and password default: admin/admin
* After login to OrientDB, it should be prepare some class for run dandelion. Only type and run below commands on Browse tab:
```
create class user extends V
create class notify
create class sessions
create class status
create class comment
create class activity
create class actions
create class friendship extends E
create class follow
create class album
create class photo
create class information
create class permission
create class like
create class group
create class groupMember
create class location```

#### Dandelion

* Configure vhost for Dandelion source code.
* Open file structure.php in folder ../dandelion/apps/config/ and fix BASE_URL_ in the very same with setup.
