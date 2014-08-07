# VERSION      1

# use blalor/centos bare bones centos 6.5 image
FROM tianon/centos:latest

MAINTAINER fxrialab

# add epel repo
RUN yum -y install http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm

# update centos
RUN yum -y update

# install required
RUN yum install -y vim
