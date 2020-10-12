#!/usr/bin/env bash

# Go home
cd $HOME

# We need to create the WordPress folder
mkdir -p $WP_FOLDER

# We need to create the tools
mkdir -p tools

# Download and install wp-cli  
wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar --no-verbose -P $(pwd)/tools/
chmod +x tools/wp-cli.phar && mv tools/wp-cli.phar tools/wp

# Export path
export PATH=$PATH:$(pwd)/tools
export PATH=vendor/bin:$PATH

# Go to wordpress folder
cd $WP_FOLDER

# Download, create, install and configure
wp core download --version=$WP_VERSION
wp config create --dbname="$DB_NAME" --dbuser="root" --dbpass="root" --dbhost="127.0.0.1" --dbprefix="$WP_TABLE_PREFIX"
wp core install --url="$WP_URL" --title="WP DEV" --admin_user="$WP_ADMIN_USERNAME" --admin_password="$WP_ADMIN_PASSWORD" --admin_email="admin@$WP_DOMAIN" --skip-email
wp rewrite structure '/%postname%/' --hard  
wp core update-db           
wp db export $GITHUB_WORKSPACE/tests/_data/dump.sql            

# Start a wp server
nohup wp server --host=wp.local >/dev/null 2>&1 &            

# Link our workspace (which is a plugin) to the wordpress folder
ln -s $GITHUB_WORKSPACE $WP_FOLDER/wp-content/plugins

# Activate it
wp plugin activate $WP_PLUGIN
