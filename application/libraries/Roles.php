<?php
/**
 * Asynctive Web User Roles
 * @author Andy Deveaux
 */
class Roles
{
	/**
	 * Determines if a user has permission to do something
	 */
	public function hasPermission($role_keys, $permission)
	{
		foreach($role_keys as $key)
		{
			if (in_array($permission, $this->PERMISSIONS[$key], TRUE))
				return TRUE;
		}
		
		return FALSE;
	}
	
	protected $PERMISSIONS = array(
		ROLE_SUPER_ADMIN => array(
			PERMISSION_CREATE_NEWS_CATEGORY,
			PERMISSION_EDIT_NEWS_CATEGORY,
			PERMISSION_DELETE_NEWS_CATEGORY,
			PERMISSION_CREATE_NEWS_ARTICLE,
			PERMISSION_EDIT_NEWS_ARTICLE,
			PERMISSION_DELETE_NEWS_ARTICLE,
			PERMISSION_CREATE_PRODUCT_CATEGORY,
			PERMISSION_EDIT_PRODUCT_CATEGORY,
			PERMISSION_DELETE_PRODUCT_CATEGORY,
			PERMISSION_CREATE_PRODUCT,
			PERMISSION_EDIT_PRODUCT,
			PERMISSION_DELETE_PRODUCT,
			PERMISSION_ADD_TO_CART,
			PERMISSION_CHECKOUT,
			PERMISSION_VIEW_ADMIN_PANEL,
			PERMISSION_VIEW_USER_LIST,
			PERMISSION_EDIT_USER,
			PERMISSION_DELETE_USER,
			PERMISSION_CHANGE_USER_ROLE,
			PERMISSION_CREATE_ROLE,
			PERMISSION_EDIT_ROLE,
			PERMISSION_DELETE_ROLE,
			PERMISSION_CHANGE_USER_ROLE,
			PERMISSION_BAN_USER,
			PERMISSION_VIEW_OFFLINE_SITE,
			PERMISSION_BYPASS_PAYMENT
		),
		
		ROLE_ADMIN => array(
			PERMISSION_CREATE_NEWS_CATEGORY,
			PERMISSION_EDIT_NEWS_CATEGORY,
			PERMISSION_DELETE_NEWS_CATEGORY,
			PERMISSION_EDIT_NEWS_ARTICLE,
			PERMISSION_DELETE_NEWS_ARTICLE,
			PERMISSION_CREATE_PRODUCT_CATEGORY,
			PERMISSION_EDIT_PRODUCT_CATEGORY,
			PERMISSION_DELETE_PRODUCT_CATEGORY,
			PERMISSION_CREATE_PRODUCT,
			PERMISSION_EDIT_PRODUCT,
			PERMISSION_DELETE_PRODUCT,
			PERMISSION_ADD_TO_CART,
			PERMISSION_CHECKOUT,
			PERMISSION_VIEW_ADMIN_PANEL,
			PERMISSION_BAN_USER,
			PERMISSION_VIEW_OFFLINE_SITE
		),
		
		ROLE_USER => array(
			PERMISSION_ADD_TO_CART,
			PERMISSION_CHECKOUT
		)
	);
}
