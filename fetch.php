<?php

$items = json_decode(file_get_contents('collection.json'), true);

foreach ($items as $item) {
  print_r($item);

  $dir = 'images/' . strtolower($item['Common name'] ?: 'other');

  if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
  }

  preg_match('/(POM\d+)/', $item['image'], $matches);
  list(, $id) = $matches;

  $file = $dir . '/' . $id . '.jpg';

  if (!file_exists($file)) {
    copy($item['image'], $file);
  }
}

// Detect incomplete/corrupt images:
// find . -name '*.jpg' -exec identify -regard-warnings {} \; > identify.txt
