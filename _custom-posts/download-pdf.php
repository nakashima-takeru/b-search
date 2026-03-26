<?php
add_action('init', 'downloadpdf');
function downloadpdf() {
  register_post_type('download-pdf', [
    'public' => true,
    'labels' => [
      'name' => __('資料ダウンロード'),
      'singular_name' => __('download-pdf'),
    ],
    'has_archive' => true,
    'menu_position' => 7,
    'show_in_rest' => true,
    'rewrite' => ['with_front' => false],
    'supports' => [
      'title',
      'custom-fields',
      'author',
      'thumbnail',
      'editor',
      'revisions',
      'page-attributes',
    ],
  ]);
  register_taxonomy('download-pdf_cate', 'download-pdf', [
    'label' => '資料ダウンロードカテゴリ',
    'hierarchical' => true,
    'public' => true,
    'show_admin_column' => true,
    'show_ui' => true,
    'show_in_rest' => true,
    'rewrite' => [
      'with_front' => false,
    ],
  ]);
}
