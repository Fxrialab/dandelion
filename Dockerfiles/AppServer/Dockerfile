# VERSION      1

# use blalor/centos bare bones centos 6.5 image
FROM fxrialab/base

MAINTAINER fxrialab

# update centos
RUN yum -y update

# install required
RUN yum install -y httpd php-gd php-mcrypt openssh-server openssl-devel wget rsync gcc php-devel php-pear make passwd php-mysql mod_ssl

RUN sed -i 's/display_errors = Off/display_errors = On/g' /etc/php.ini
ADD httpd.conf etc/httpd/conf/httpd.conf


# set users & group
RUN useradd dandelion
RUN echo 'www:x:333:dandelion,apache' >> /etc/group

ENTRYPOINT ["/usr/sbin/httpd"]
CMD ["-D", "FOREGROUND"]
