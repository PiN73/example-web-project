About the appliction
====================

The page is a list of text notes. Above the list it is a textarea and a button `Add`. When the button is pressed, new note is sent to the server, added to DB and displayed in the list. Each note has button `Delete`. When it is pressed, note is removed from page and from DB.

Installation and startup
========================

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
===========

Simple version of the application
---------------------------------

![](/screenshots/1.png)

Advanced version
----------------

Added styles

![](/screenshots/2.png)

The input textarea automatically resizes

![](/screenshots/3.png)

Width of notes is auto-adjusted to the size of the window, long words and long paragraphs break to a new line

![](/screenshots/4.png)

![](/screenshots/5.png)

While the note is sending, loading icon is shown. If sending fails, buttons `Try again` and `Cancel` appears

![](/screenshots/6.png)
