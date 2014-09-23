#!/bin/bash
#systm8 install script


# pull the dandelion repo into into home dir
BASEDIR=`dirname $0`
BASEDIR=`(cd "$BASEDIR"; pwd)`

echo "Base dir = $BASEDIR";

if [ -e  dandelion ] ;
	then
	cd dandelion
	git pull
	else
	echo "Clone https://github.com/Fxrialab/dandelion.git"
	git clone https://github.com/Fxrialab/dandelion.git
fi

# create required dirs
if [ "$UID" -ne 0 ]
then
    sudo mkdir --parent /home/dandelion/www
	sudo mkdir --parent /home/dandelion/logs/httpd /home/dandelion/logs/orientdb /home/dandelion/logs/amqp
	sudo mkdir --parent /home/dandelion/orientdb /home/dandelion/orientdb/databases
	sudo mkdir --parent /home/dandelion/amqp

    # set permissions
    #chown -R systm8:www /home/dandelion &&
    sudo chmod -R 777 /home/dandelion/www
    sudo chmod -R 777 /home/dandelion/logs
    sudo chmod -R 777 /home/dandelion/orientdb
    sudo chmod -R 777 /home/dandelion/amqp
else
    mkdir --parent /home/dandelion/www
	mkdir --parent /home/dandelion/logs/httpd /home/dandelion/logs/orientdb /home/dandelion/logs/amqp
	mkdir --parent /home/dandelion/orientdb /home/dandelion/orientdb/databases
	mkdir --parent /home/dandelion/amqp

    # set permissions
    #chown -R systm8:www /home/dandelion &&
    chmod -R 777 /home/dandelion/www
    chmod -R 777 /home/dandelion/logs
    chmod -R 777 /home/dandelion/orientdb
    chmod -R 777 /home/dandelion/amqp
fi


#set executable permissions 
chmod +x "$BASEDIR"/dandelion/Dockerfiles/bin/ddlion

echo "Done"
echo "Now run 'cp dandelion/Dockerfiles/bin/ddlion ddlion'"
echo "Run 'chmod +x ddlion'"
echo "Then run './ddlion build'"
exit 0


