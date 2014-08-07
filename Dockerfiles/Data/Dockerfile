# VERSION      1

# use base image
FROM fxrialab/base

MAINTAINER fxrialab

# update centos
RUN yum -y update

# install required
RUN  rpm -e cracklib-dicts --nodeps
RUN yum install -y openssh-server openssh-clients cracklib-dicts rsync unzip


RUN sed -i 's/UsePAM yes/UsePAM no/g' /etc/ssh/sshd_config

# start up to generate keys 
RUN service sshd start

# set users & group
RUN useradd dandelion -m
RUN echo root:w38T52007 | chpasswd
RUN echo dandelion:w38T52007 | chpasswd
RUN echo 'www:x:333:dandelion,apache' >> /etc/group

# VOLUME /home/dandelion/orientdb
# VOLUME /home/dandelion/www
# VOLUME /home/dandelion/logs

# RUN chown -R dandelion:www /home/dandelion/www

ENTRYPOINT ["/usr/sbin/sshd"]
CMD ["-D"]
