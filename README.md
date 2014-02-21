# Dandelion 1.0


##Overview

realtime social network platform with nodejs, php, orientdb

[Read more about dandelion](http://dandelion.fxrialab.net)

##Features

- Realtime notification/updates (socket.io + Redis)
- MVC based
- PHP for easy templating
- Plugin architecture (default: post/photos/group/event)
- Simple template engine
- Fast graph database( OrientDB)

##Site administration
- Separate admin site using angularjs
- Plugin management

##Development backend using docker
h1. Running dandelion server

*First start*
Intalls vagrant, follow instructions here 
http://www.vagrantup.com

Start a terminal (cmd.exe) at your work folder (such as e:/projects/)
<pre>
$ git clone https://github.com/gtdminh/coreos-vagrant.git
$ cd coreos-vagrant
$ vagrant up
</pre>

if failed you need to do vagrant up again (from now it is inside the VM coreos)
<pre>
vagrant ssh
sudo git clone https:/github.com/Fxrialab/dandelion-docker.git
mv dandelion-docker Dockerfiles
cd Dockerfiles
sudo git checkout coreos
cd ..
cp Dockerfiles/dandelion dandelion
chmod +x dandelion
sudo su
./dandelion build
</pre>

this will take a while, 

once you see it has started building mongo you are good to upload files
connect to via (you can use cyberduck/filezilla to connect to host:localhost,port:2222 user:vagrant, pwd:vagrant)

upload the app files into home/dandelion/www
back in terminal, you see "Build complete!" 

*Normal Run*

up your machine, 
<pre>
cd ~
sudo ./dandelion start
</pre>

*Other comands*

update dockerfiles (this also creates copty of dandelion file in home directory)
<pre>
sudo ./dandelion update
</pre>

*Test its working*
* upload systemate www folder to /home/systm8/www followed above instructions and define demo.v-systm8.com(in windows' hosts file) and open browser at http://demo.v-systm8.com:8080 to start systemate

## license

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