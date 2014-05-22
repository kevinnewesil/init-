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

### check if programms needed are installed

hash git 2>/dev/null || {
	echo -e "Git is required but not installed.. Install Git? [y/n] \c"; 
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
	fi
}

### Get the data to preform a clone.

github_username="$1"
github_password="$2"
webserver_base="$3"

echo "Enter github username (case sensitive!)"
read github_username

echo "Enter github password"
read -s github_password

echo "Enter the path of you webserver root: E.G. /var/www (without ending /!!!)"
read -e webserver_base

echo "Cloning repository into $webserver_base/init-"
cd $webserver_base

git clone "https://github.com/kevinnewesil/init-" "init-"
echo "Successfully cloned repository into $webserver_base/init-"

### Copy the index file to the root of the webserver and start the fun.
echo "Copying index to root folder of webserver..."
sudo cp init-/index.php index.php;

### Fix permission first of all.
echo "Settings webserver permissions..."
sudo find . -type f -exec chmod 644 {} \;
sudo find . -type d -exec chmod 755 {} \;

### Get the username and group for the chown command.
echo "Enter username"
read username

echo "Enter webserver Group"
read groupname

### Execute chown command to set user and group for creating config file.
echo "Settings user and group for webserver..."
sudo chown -R $username:$groupname .

### Thank you come again
echo "install script ran successfully"
exit
