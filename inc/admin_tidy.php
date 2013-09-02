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

/*
|--------------------------------------------------------------------------
| Admin Bar
|--------------------------------------------------------------------------
*/

function remove_admin_bar_links() {
    global $wp_admin_bar;
    //$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    //$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    //$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    //$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    //$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    //$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    //$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    //$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    //$wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    //$wp_admin_bar->remove_menu('new-content');      // Remove the content link
    //$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

?>