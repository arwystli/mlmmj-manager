# mlmmj-manager
Web based management of mlmmj mailing lists

mlmmj-manager is a web based management tool for mlmmj
It requires mlmmj-1.3.0.tar.gz from http://mlmmj.org or a debian/ubuntu package
These instructions were written using postfix as the mail server.
Mlmmj-manager uses Bootstrap, Bootswatch and Fontawesome to enhance the web usage.
All business logic is in php and all output is in Smarty templates so modifying to suit your needs is pretty easy.

Installation
You can install it anywhere you like but the assumption is /usr/local/mlmmj-manager on debian/ubuntu.
Unpack into /usr/local so you get /usr/local/mlmmj-manager
If you have full control over your server you can symlink /usr/local/mlmmj-manager/scripts/apache.conf to /etc/apache2/conf-available
and run a2enconf mlmmj-manager and service apache2 reload. This will enable mlmmj-manager on the default domain.
You can also copy and edit the contents of /usr/local/mlmmj-manager/scripts/apache.conf and apply to the apache virtual host file of your choice.
Your webserver document root should be pointed to the /usr/local/mlmmj-manager/html directory
If you have php-fpm available you should use it as this will make setting up permissions easier.

If the directory 'vendor' does not exist you will need to run composer to install smarty:

composer install

Alternately if you already have Smarty you can edit src/init.php to suit.

You will need to copy /usr/local/mlmmj-manager/src/config.php.dist to /usr/local/mlmmj-manager/src/config.php and edit to suit.

There is no function to create lists, they have to already exist.
There is however a script /usr/local/mlmmj-manager/scripts/make_mlmmj_list.sh which might prove useful or could be adapted.

Author Bob Hutchinson <arwystli@gmail.com>
copyright GNU GPL

