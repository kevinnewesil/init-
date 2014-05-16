init dashboard
=========

A webserver dashboard for nerds by nerds.

Install the system as following:

1. Clone the project into your localhost root folder. 
	git clone https://github.com/kevinnewesil/init-

2. Copy the index file into the root folder. 
	(sudo) cp /path/to/webserver/init-/index.php /path/to/webserver/index.php*

4. Make sure the permission, owner, and user are correct for your localhost.
to fix permission issues type the following in ur command line:

	find /path/to/werbserver/ -type f -exec chmod 644 {} \;
	find /path/to/webserver/ -type d -exec chmod 775 {} \;
	chown -r yourusername:webgroup /path/to/webserver;

To find the webgroup open the httpd.conf or apache2.conf file and search for the 2 lines saying:
user: username
group: groupname
