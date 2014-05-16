#!/bin/sh
# copyright Kevin Newesil 2014 <kevin@sourjelly.net>
# all rights reserver. please dont use this script to cause harm. 
# for which we can not be held responsible and all useage of this script is completely in the 
# hands of the user executing it.
# 
# We are not responsible for error caused by this script.
# 
# enjoy using init-
# 

### Get the data to preform a clone.

github_username="$1"
github_password="$2"
webserver_base="$3"

echo "Enter github username (case sensitive!)"
read github_username

echo "Enter github password"
read -s github_username

echo "Enter the path of you webserver root: E.G. /var/www/"
read -e webserver_base

echo "Cloning repository into $webserver_base/init-"
cd $webserver_base

git clone "git@github.com:kevinnewesil/init-.git" "$webserver_base/init-"
echo "Successfully cloned repository into $webserver_base/init-"

### Copy the index file to the root of the webserver and start the fun.
echo "Copying index to root folder of webserver..."
sudo cp $webserver_base/init-/index.php $webserver_base/index.php;

### Fix permission first of all.
echo "Settings webserver permissions..."
sudo find $webserver_base -type f -exec chmod 644 {} \;
sudo find $webserver_base -type d -exec chmod 775 {} \;

### Get the username and group for the chown command.
echo "Enter username"
read username

echo "Enter webserver Group"
read groupname

### Execute chown command to set user and group for creating config file.
echo "Settings user and group for webserver..."
sudo chown -R $username:$groupname $webserver_base

### Thank you come again
echo "install script ran successfully"
exit
