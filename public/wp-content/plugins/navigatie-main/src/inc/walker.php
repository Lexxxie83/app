<?php 

//define the custom post type
//could use "page" or "post" as well.
define("MENU_CPT", "page");

//custom function for selecting posts based on a page parent (ne' term_id)
function hgs_get_children_by_id($parent_id, $post_type=MENU_CPT) {

  // global $wp_query;
  // global $post;
  
  //TODO: juiste volgorde kiezen? welke order by moeten we kiezen?
          
  $string = get_field('menu-id', 'option');
    // use of explode
    // $string = "2, 15";
    if (empty($string)) {
      return;
    }
    $allowed = explode (",", $string); 

    //niet in de array dan niets tonen:
    if (!in_array($parent_id, $allowed)) {
      return;
    } 
  
    // find all subpages uf the menu item:
    //only page posttype
    $the_query = new WP_Query( array( 'post_type' => 'page', 'posts_per_page' => 0, 'post_parent' => $parent_id) );
  
    $childname = '';
    if ( $the_query->have_posts() ) {
      
      //opbouwen van de sub pages
      $childname .= '<ul class="sub-menu">';
        // voeg eerst de hoofdpagina toe als extra menu item:
        $childname .= "<li class='menu-item'><a href=" . get_the_permalink($parent_id) . " >" . get_the_title($parent_id) . "</a></li>";
        while($the_query->have_posts()) {
          $the_query->the_post(); 
            
            $childname .= "<li class='menu-item'><a href=" . get_the_permalink() . " >" . get_the_title() . "</a></li>";
        }
      $childname .= '</ul>';
    }

    wp_reset_postdata();
    wp_reset_query(); 

    return $childname;
}

//custom nav menu walker class for Take Action Dropdown
class SUB_Menu_Maker_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';        
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }


    /* Check for children  based on WP subpages, not menu items!*/
    $childposts = hgs_get_children_by_id( $item->object_id );

    if (!empty($childposts)) {
      $classes[] = 'has-sub-page';
    }


    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .'>';
  

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span class="link_text">';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    
    if (!empty($childposts)) {
      $output .= $childposts;
      }
    
  }

}


?>
