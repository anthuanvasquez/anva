#!/usr/bin/env bash

# Before you run this script may sure you have installed
# wp-cli http://wp-cli.org/

if [ $# -lt 3 ]; then
	echo "usage: $0 <project> <url> <db-name> <db-user> <db-pass> [path] db-host] [wp-version]"
	exit 1
fi

NAME=$1
URL=$2
DB_NAME=$3
DB_USER=$4
DB_PASS=$5
PATH=${6-~/Sites/}
DB_HOST=${7-localhost}
WP_VERSION=${8-latest}
WP_CORE_DIR=${WP_CORE_DIR-~/tmp/wordpress/}
WP_TEST_DIR=${WP_TEST_UNIT-~/tmp/wp-test}

set -ex

install_wp() {

	if [ -d $PATH ]; then
		return;
	fi

	mkdir -p $PATH$NAME

	if [ $WP_VERSION == 'latest' ]; then
		local ARCHIVE_NAME='latest'
	else
		local ARCHIVE_NAME="$WP_VERSION"
	fi

	# download wordpress
	wp core download --path=$PATH --version=ARCHIVE_NAME
}

install_db() {

	# generate wp-config.php file
	wp core config --dbname=$DB_NAME --dbuser=$DB_USER --dbpass=$DB_PASS
	wp core install --url=$URL --admin_user=admin --admin_password=1987 --admin_email=me@anthuanvasquez.net --skip-email
}

install_wp
install_db
