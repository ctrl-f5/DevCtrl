DevCtrl
=======================

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use composer to install dependencies:

    cd my/project/dir
    git clone git://github.com/ctrl-f5/DevCtrl.git
    cd DevCtrl
    php composer.phar install

configure your database connection:

    cd config/autoload
    cp local.php.dist local.php

edit the newly created local.php config file with your database credentials

database files can be found in the build/db/ directory

Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!
