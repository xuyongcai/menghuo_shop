<?php
use think\Request;

/**
 * 设置菜单当前选中
 * @param string $menu_c       菜单的控制器
 * @param string $active_class 类的名称
 */
function setMenuActive($menu_c,$active_class)
{
	if (Request::instance()->controller() == ucfirst($menu_c) ) {
		return $active_class;
	}
}