<?php

/**
 * GET Single post
 * url: /src/api/posts/read_single.php?id={id}
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();

/**
 * Instantiate blog post object
 */
$post = new Post($db);

/**
 * Get post ID
 */
$post->id = isset($_GET['id']) ? $_GET['id'] : die('invalid id');

$post->read_single();

$postArr = [
    'id' => $post->id,
    'title' => $post->title,
    'body' => html_entity_decode($post->body),
    'author' => $post->author,
    'category_id' => $post->categoryId,
    'category_name' => $post->categoryName
];

print_r(json_encode($postArr));
