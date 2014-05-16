# copyright Kevin Newesil 2014 <kevin@sourjelly.net>
# all rights reserver. please dont use this script to cause harm. 
# for which we can not be held responsible and all useage of this script is completely in the 
# hands of the user executing it.
# 
# We are not responsible for error caused by this script.
# 
# enjoy using init-
# 
#!/bin/sh

# current dir to get location of webserver.
current_dir=$(pwd)

if [[ "$current_dir" =~ "init-" ]]; then

	### Fix permission first of all.
	echo "Settings webserver permissions..."

	find $current_dir/../ -type f -exec chmod 644 {} \;
	find $current_dir/../ -type d -exec chmod 775 {} \;

	### Get the username and group for the chown command.
	echo "Enter username"
	read username

	echo "Enter webserver Group"
	read groupname

	### Execute chown command to set user and group for creating config file.
	echo "Settings user and group for webserver..."
	chown -R $username:$groupname $current_dir/../

	### Copy the index file to the root of the webserver and start the fun.
	echo "Copying index to root folder of webserver..."
	cp $current_dir/index.php $current_dir/../index.php;

	### Thank you come again
	echo "install script ran successfully"
	exit

else
    echo "Not in correct directory. CD to the init- folder and try executing ./install.sh again"
    exit
fi
