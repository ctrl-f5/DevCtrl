DevCtrl
=======================

Installation
------------

Using Composer
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use composer to install dependencies:

    cd my/project/dir
    git clone git://github.com/ctrl-f5/DevCtrl.git
    cd DevCtrl
    php composer.phar install

Install database
----------------
create and empty database and configure your database connection for the application:

    cd config/autoload
    cp local.php.dist local.php

edit the newly created local.php config file with your database credentials.

The database is managed by phing and db deploy.
create the build.properties file and execute phing migrate

    cd build
    cp build.properties.dist build.properties
    vim build.properties
    phing migrate

Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!
