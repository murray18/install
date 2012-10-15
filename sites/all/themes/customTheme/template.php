<?php

function customTheme_user_listing($variables){
    $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];
  $email = $variables['email'];
  $uid = $variables['ID'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '<div class="user_listing">';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . 'List of all the users' . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    foreach ($items as $i => $item) {
      $attributes = array();
      $children = array();
      $data = '';
      if (is_array($item)) {
       $i=0;
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_user_listing(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      if ($i == 0) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items - 1) {
        $attributes['class'][] = 'last';
      }
      $attributes['class'][] = 'list_items';
      $output .= '<li' . drupal_attributes($attributes) . '><a href="/user/' . $uid[$i] . '#overlay-context=list/users' . '" >' . $data . "</a></li>\n";
      $output .= '<p>eeeeeemail - ' . $email[$i] . '</p>';
      $i++;
    }
    $output .= "</$type>";
  }
  $output .= '</div>';
  return $output;
}