Installation and startup:
-------------------------

Required packages:
    
    mysql-server
    apache2
    php
    php-mysql
    php-mysqlnd

Launching (Linux Ubuntu):
    
    service apache2 start
    service mysql start
*(folder `html` must be in `/var/www/`)*

Creating DB and table (at first launching):
    
    php setup.php
*(`mysql` must be running)*


Screenshots
-----------

Simple version of the application:
![](/screenshots/1.png)

Advanced version (added styles, feedback, buttons `Try again` and `Cancel` if sending fails):

![](/screenshots/2.png)

![](/screenshots/3.png)

![](/screenshots/4.png)

![](/screenshots/5.png)

![](/screenshots/6.png)
