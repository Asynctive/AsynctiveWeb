# Asynctive Web
This is the official repo of the Asynctive website. It is based off of the CodeIgniter framework 
and is early in development. Things will tend to change a lot as the design becomes more concrete.

## Setup
### Server Requirements
+ PHP >= 5.5.0
+ MySQL >= 5.5.42 (unsure about earlier versions)
+ Mcrypt extension
+ OpenSSL

### Configuration
All configuration files are located under application/config/. You will have to copy the database.php.default 
file and change it to contain your database credentials. You will also have to copy config.php.default and 
set $config['encryption_key']

Asynctive Web specific settings are located in asynctive_config.php

Visiting {website\_url}/setup will give you a setup page. If the ENVIRONMENT variable in public\_html/index.php 
is set to 'production' then the website will be inaccessible until the page is completed. It will then delete itself 
when done.

## Reference Documentation
### Technologies
+ [CodeIgniter 3](http://www.codeigniter.com/)
+ [Bootstrap](http://getbootstrap.com/)
+ [jQuery](https://jquery.com/)
+ [jQuery Validation Plugin](http://jqueryvalidation.org/)

### Permissions System
The permissions system will store roles and user-role associations in the database. The permissions 
themselves will be hard-coded into an array within application/library/Roles.php. This was decided 
because the system will be quite small, and the only person who will be making changes to it will 
be the head coder(s). 

Permission constants can be reviewed in: application/config/constants.php

Roles can be defined in: application/library/Roles.php

#### Available Permissions:
	PERMISSION_LOGIN
	PERMISSION_CREATE_NEWS_CATEGORY
	PERMISSION_EDIT_NEWS_CATEGORY
	PERMISSION_DELETE_NEWS_CATEGORY
	PERMISSION_CREATE_NEWS_ARTICLE
	PERMISSION_EDIT_NEWS_ARTICLE
	PERMISSION_DELETE_NEWS_ARTICLE
	PERMISSION_CREATE_PRODUCT_CATEGORY
	PERMISSION_EDIT_PRODUCT_CATEGORY
	PERMISSION_DELETE_PRODUCT_CATEGORY
	PERMISSION_CREATE_PRODUCT
	PERMISSION_EDIT_PRODUCT
	PERMISSION_DELETE_PRODUCT
	PERMISSION_ADD_TO_CART
	PERMISSION_CHECKOUT
	PERMISSION_VIEW_ADMIN_PANEL
	PERMISSION_VIEW_USER_LIST
	PERMISSION_EDIT_USER
	PERMISSION_DELETE_USER
	PERMISSION_CHANGE_USER_ROLE
	PERMISSION_CREATE_ROLE
	PERMISSION_EDIT_ROLE
	PERMISSION_DELETE_ROLE
	PERMISSION_BAN_USER
	PERMISSION_VIEW_OFFLINE_SITE
	
#### Available Roles:
	ROLE_SUPER_ADMIN
	ROLE_ADMIN
	ROLE_USER


### Base Controllers
**AS_Controller**: Base page controller. Handles loading configuration settings and the apropiate libraries and models required for the system to work.
It also automatically retrieves any logged in user's roles.

**Site_Controller**: Regular page controller. Checks site status, checks for and authenticates logins. Extends AS_Controller

**Admin_Controller**: Admin page controller. Checks for and authenticates logins while checking for required permissions. Extends AS_Controller