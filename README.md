init dashboard
=========

*A webserver dashboard for nerds by nerds.*

Install the system as following:
--------
***

1. Clone the project into your localhost root folder.

    ```Batchfile
    git clone https://github.com/kevinnewesil/init-
    ```
***

2. Copy the index file into the root folder. 

    ```Batchfile
    (sudo) cp /path/to/webserver/init-/index.php /path/to/webserver/index.php
    ```
***

3. Make sure the permission, owner, and user are correct for your localhost.
to fix permission issues type the following in ur command line:
    
    ```Batchfile
    find /path/to/werbserver/ -type f -exec chmod 644 {} \; 
    find /path/to/webserver/ -type d -exec chmod 775 {} \;  
    chown -r username:webgroup /path/to/webserver;
    ```

***To find the webgroup open the httpd.conf or apache2.conf file and search for the 2 lines saying:***

```ApacheConf
User username  
Group groupname
```