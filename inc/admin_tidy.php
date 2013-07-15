<?php

/*
|--------------------------------------------------------------------------
| Left Menu Items (Top Level)
|--------------------------------------------------------------------------
*/

function remove_menu_items() {
  global $menu;
  $restricted = array(
  						//__('Dashboard'),
						//__('Posts'),
						//__('Pages'),
  						//__('Links'), 
  						//__('Comments'), 
  						//__('Media'),
  						//__('Appearance'),
  						//__('Plugins'), 
  						//__('Tools'), 
  						//__('Users'),
  						//__('Settings')
  					);

  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      unset($menu[key($menu)]);}
    }
 }

//add_action('admin_menu', 'remove_menu_items');

/*
|--------------------------------------------------------------------------
| Left Sub-Menu Items (Level 2)
|--------------------------------------------------------------------------
*/

function remove_submenus() {
  global $submenu;
  unset($submenu['index.php'][10]); // Removes 'Updates'.
  unset($submenu['themes.php'][5]); // Removes 'Themes'.
  unset($submenu['options-general.php'][15]); // Removes 'Writing'.
  unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
  unset($submenu['edit.php'][16]); // Removes 'Tags'.  
}

//add_action('admin_menu', 'remove_submenus');

/*
|--------------------------------------------------------------------------
| Hide Inline Editing
|--------------------------------------------------------------------------
*/

function hide_quick_edit_css() { ?>
  <style type="text/css">
    .row-actions a.editinline {display:none!important}
  </style>
<?php }

//add_action('admin_init','hide_quick_edit_css');



//Hide WP Admin Bar
add_filter('show_admin_bar', '__return_false');

?>