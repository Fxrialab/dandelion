# Dandelion 1.0


##Overview

Realtime social network platform with nodejs, php, orientdb

[Read more about dandelion](http://demo.dandelionet.org/)

##Features

- Realtime notification/updates (socket.io + Redis)
- MVC based
- PHP for easy templating
- Plugin architecture (default: post/photos/group/event)
- Simple template engine
- Fast graph database (OrientDB)

##Site administration
- Separate admin site using angularjs
- Plugin management

## Development backend using docker
#### Prerequisites
- Download and installs [Vagrant](http://www.vagrantup.com) and [VirtualBox](https://www.virtualbox.org)
- Download and install [git](http://git-scm.com/).

Remember set environment variables to vagrant and git for easy run.
#### Quick Start
1. Prepare local domain (something like demo.dandelion.net) by open your host file & add record for the domain.
<pre>
    127.0.0.1 demo.dandelion.net
</pre>
2. Download attached [Vagrantfile](https://raw.githubusercontent.com/Fxrialab/dandelion/master/Dockerfiles/Vagrantfile) (Click Save as ... then make sure you remove .txt extension) or from source and put into folder where you want VM
3. Start a terminal (cmd.exe) then type *sh -login* or open git bash at Vagrantfile folder
4. Type `vagrant up`. This command creates and configures guest machines according to Vagrantfile.
5. Type `vagrant ssh`. This will SSH into a running Vagrant machine and give you access to a shell.
6. Cut & paste command bellow. This will take a while
<pre>
$bash -c "$(curl -fsSL https://raw.githubusercontent.com/Fxrialab/dandelion/master/Dockerfiles/install.sh)"
</pre>
7. After done, do like reported on step 6
<pre>
$cp cp dandelion/Dockerfiles/bin/ddlion dandelion
</pre>
<pre>
$chmod +x dandelion
</pre>
<pre>
$./dandelion build
</pre>
8. After you see "Build complete!". You can use cyberduck/filezilla to connect to sftp **host: localhost, port: 2200** with **user: dandelion, pwd: w38T52007**.
Then start upload the dandelion files into `/home/dandelion/www` folder.
9. Now let start dandelion
<pre>
$./dandelion start
</pre>
Thats all, now you can access via [http://demo.dandelion.net:8080/](http://demo.dandelion.net:8080/).

> Remember you make sure the config on `/www/apps/config` are correct

- On Structure.php file change **BASE_URL** to **http://demo.dandelion.net:8080/**
- On Database.php file change **HOST** to **172.17.0.3**

#### Other dandelion commands
###### update
This will pull the latest copy of dandelion repo from git.
<pre>
$./dandelion update
</pre>
###### build
This will build all the docker containers from Dockerfiles folder.
First time you run this it will take a while, after first run it will be quick
<pre>
$./dandelion build
</pre>
###### start
This will start all the docker containers from Dockerfiles folder.
<pre>
$./dandelion start
</pre>
###### stop
This will stop all the docker containers from Dockerfiles folder.
<pre>
$./dandelion stop
</pre>

#### OrientDB
Also download dandelion database files via `/Dockerfiles/database` then upload them into `/home/dandelion/orientdb/databases`.

After this, you can access to orientDB via [http://demo.dandelion.net:2480/](http://demo.dandelion.net:2480/).

With user/password for authentication by browser: **root/dandelion**. After select dandelion database, login with **user: admin** and **pass: admin**.

## License

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
    
    Copyright 2013 @fxrialab.net