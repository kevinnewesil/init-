#!/usr/bin/env bash
# Copyright Kevin Newesil 2014 <kevin@sourjelly.net>
# All rights reserved. Please don't use this script to cause harm. 
# For which we can not be held responsible and all usage of this script is completely in the 
# hands of the user executing it.
# 
# We are not responsible for any errors caused by this script.
# 
# enjoy using init-
# 

### check if programms needed are installed

echo #newline
for i in {16..21} {21..16} ; do echo -en "\e[38;5;${i}m#\e[0;0;0m" ; done ;
for i in {16..21} {21..16} ; do echo -en "\e[38;5;${i}m#\e[0;0;0m" ; done ; echo;
echo -e "\e[0;0;0mChecking if programs needed are installed...\e[0;0;0m"

hash git 2>/dev/null || {
	echo -e "\e[1;1;1mGit\e[0;0;0m is required but not installed.. \r\n" 
	echo -e "Install Git? \e[1;1;1m[y/n]\e[0;0;0m \c";
	read gitinstall;

	if [ $gitinstall = "y" ] || [ $gitinstall = "Y" ];
	then
		if type "apt-get" > /dev/null; then
			sudo apt-get install git;
		fi

		if type "yum" > /dev/null; then
			sudo yum install git;
		fi

		if type "brew" > /dev/null; then
			sudo brew install git;
		fi
	else
		echo -e "\e[1;40;31mAborting...";
		exit 1;
	fi
}

echo -e "\e[0;38;32mGit found and working on this system\e[0;0;0m \r\n"

### Get the data to preform a clone.

github_username="$1"
github_password="$2"
webserver_base="$3"

echo -e "Enter github username (\e[1;1;1mcase sensitive!\e[0;0;0m)"
read github_username

echo -e "Enter github password"
read -s github_password

echo -e "Enter the path of you webserver root: E.G. /var/www (\e[1;1;1m without ending / !!!\e[0;0;0m)"
read -e webserver_base

echo #newline

echo -e "Cloning repository into \e[1;1;1m$webserver_base/init-\e[0;0;0m"
cd $webserver_base

git clone "https://github.com/kevinnewesil/init-" $webserver_base"/init-" || { echo -e "\e[1;38;31mFailed to clone... Aborting...\e[0;0;0m"; exit 1; }

echo -e "\e[1;38;32mSuccessfully cloned repository into $webserver_base/init-\e[0;0;0m \r\n"

### Copy the index file to the root of the webserver and start the fun.
echo -e "Copying index to root folder of webserver...";
echo -e "cp init-/index.php index.php";
sudo cp init-/index.php index.php || { echo -e "\e[1;38;31mFailed to copy index file \e[0;0;0m"; exit 1; } 
echo -e "\e[1;38;32mIndex file successfully copied\e[0;0;0m.\r\n"

### Fix permission first of all.
echo -e "Settings webserver permissions..."
echo -e "sudo find . -type f -exec chmod 644 {} \;";
sudo find . -type f -exec chmod 644 {} \;
echo -e "sudo find . -type d -exec chmod 755 {} \;"
sudo find . -type d -exec chmod 755 {} \;

echo -e "\e[1;38;32mSuccessfully set file and folder permissions \e[0;0;0m \r\n"

### Get the username and group for the chown command.
echo "Enter username"
read username

echo "Enter webserver Group"
read groupname
echo #new line

### Execute chown command to set user and group for creating config file.
echo "Settings user and group for webserver..."
echo "sudo chown -R $username:$groupname";
sudo chown -R $username:$groupname .;
echo -e "\e[1;38;32mSuccessfully set webserver user and group \e[0;0;0m \r\n"

### Thank you come again
echo -e "\e[1;38;32mInstall script ran successfully \e[0;0;0m \r\n"; 
exit 1;
