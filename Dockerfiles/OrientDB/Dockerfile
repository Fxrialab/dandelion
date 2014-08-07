# orientdb
#
# VERSION: 1
FROM fxrialab/base

MAINTAINER fxrialab

# update centos
RUN yum -y update

# install required
RUN yum install -y unzip mkdir java-1.7.0-openjdk make gcc-c++ nano wget

# create network file, missing in centos:6.4
RUN echo "NETWORKING=yes" > /etc/sysconfig/network

# Get orientdb
ADD orientdb-community-1.7-rc1.zip/ /opt/
RUN cd /opt ; unzip orientdb-community-1.7-rc1.zip
CMD chmod 777 -R /opt/orientdb-community-1.7-rc1/

# Add config
ADD orientdb-server-config.xml /opt/orientdb-community-1.7-rc1/config/
CMD chmod 777 /opt/orientdb-community-1.7-rc1/config/orientdb-server-config.xml

RUN cd /opt/orientdb-community-1.7-rc1/bin; chmod 744 -R .
CMD chmod +x /opt/orientdb-community-1.7-rc1/bin/server.sh

# Expose port 2424 and 2480 for orientdb connectivity
EXPOSE 2424
EXPOSE 2480
CMD cd /opt/orientdb-community-1.7-rc1/bin; ./server.sh