#!/bin/sh

# current dir to get location of webserver.
current_dir=$(pwd)

if [[ "$current_dir" =~ "init-" ]]; then
	### Fix permission first of all.
	find $current_dir/../ -type f -exec chmod 644 {} \;
	find $current_dir/../ -type d -exec chmod 775 {} \;

	cp $current_dir/index.php $current_dir/../index.php;
else
    echo "Not in correct directory. CD to the init- folder and try executing ./install.sh again"
    exit
fi
