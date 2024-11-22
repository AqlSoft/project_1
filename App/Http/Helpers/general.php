<?php
use App\Models\Admin;
use App\Models\AdminProfile;
use App\Models\Role;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\AdminRolePermission;
use App\Models\Menu;
use App\Models\RolePermission;

function canDo ($param) {
	$role = auth() -> user () -> role;
	$rolePermissions = RolePermission::select('permission_link')->where(['role_id' => $role])->get();
	$permissionsArray = [];
	foreach ($rolePermissions as $key => $val) {
		$action = Permission::select('permission_link')->where(['id'=>$val->permission_id])->first();
		$permissionsArray[] = $val->permission_link;
	}
	return in_array($param, $permissionsArray);
}

function calcTotalPrice($unit_price, $discount, $period, $qty){
	$total =  (floatval($unit_price) - intval($discount)) * intval($qty) * intval($period);
	return $total;
}


/**
 * @param mixed $array the array of contract items
 * @param mixed $item the item type [1=> small-table, 2=> large-table, 3=> large-table, 4=> small-table]
 * 
 * @return [Number] will return 0 if item not exist or the item quantity if found
 */
function findItemQty($array, $item) {
    foreach ($array as $object) {
        if ($object !== null && $object->item == $item) {
            return $object->qty;
        }
		
    }
    return 0; // Object not found
}

/**
 * @param mixed $array the array of contract items
 * @param mixed $item the item type [1=> small-table, 2=> large-table, 3=> large-table, 4=> small-table]
 * 
 * @return [Number] will return 0 if item not exist or the item quantity if found
 */
function findItemPrice($array, $item) {
    foreach ($array as $object) {
        if ($object !== null && $object->item == $item) {
            return $object->price;
        }
		
    }
    return 0; // Object not found
}

function canAccess ($param) {
	$role = auth() -> user () -> role;
	$rolePermissions = AdminRolePermission::where(['role_id' => $role])->get();
	$menuesArray = [];
	foreach ($rolePermissions as $key => $value) {
		$menu = Menu::select('menu_link')->where(['id'=>$value->menu])->first();
		$menuesArray[] = $menu->menu_link;
	}
	
	return in_array($param, $menuesArray);
}

function canAccessSubMenu ($param) {
	$role = auth() -> user () -> role;
	$rolePermissions = RolePermission::select('submenu')->where(['role_id' => $role])->get();
	$menuesArray = [];
	foreach ($rolePermissions as $key => $value) {
		$menu = SubMenu::select('menu_link')->where(['id'=>$value->submenu])->first();
		$menuesArray[] = $menu->menu_link;
	}
	return in_array($param, $menuesArray);
}

function buildIndexedArray($collection) {
	$out = [];
	foreach ($collection as $i => $item) {
		$out[$item->client_id][]= $item;
	}
	return $out;
}

function itemExists ($id, $query) {
    if (null == $query || !is_array($query)) {
        return false;
    }
    return in_array($id, $query);
}

function getUserName ($id) {
	$profile = AdminProfile::where('user_id', $id)->first();
	return $profile->first_name . ' ' . $profile->last_name;
}

function receiptType($type) {
    $r = '';
    switch ($type) {
        case 1:
            $r = "سند إدخال";
            break;
        case 2: 
            $r = "سند إخراج";
            break;
        case 3: 
            $r = "ترتيب طبالى";
            break;
    }
    return $r;
}
