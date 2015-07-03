# Asynctive Web
This is the official repo of the Asynctive website. It is based off of the CodeIgniter framework 
and is early in development.

## Reference Documentation
### Technologies
+ [CodeIgniter](http://www.codeigniter.com/)
+ [Bootstrap](http://getbootstrap.com/)
+ [jQuery](https://jquery.com/)
+ [jQuery Validation Plugin](http://jqueryvalidation.org/)

### Permissions System
The permissions system will store roles and user-role associations in the database. The permissions 
themselves will be hard-coded into role specific classes. This was decided because the system will
be quite small, and the only person who will be making changes to it will be the head coder(s).
Constants can be reviewed in application/config/constants.php

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
	PERMISSION_CHANGE_USER_CATEGORIES