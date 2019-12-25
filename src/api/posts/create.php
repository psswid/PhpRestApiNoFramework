<?php

/**
 * POST All Posts
 * url: /src/api/posts/create.php
 *
 * Example:
 * {
 * "title": "Test title",
 * "body": "Test body",
 * "author": "Test author",
 * "category_id": 1
 * }
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


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
 * Get post data
 */
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->categoryId = $data->category_id;

if($post->create()) {
    echo json_encode(["message" => 'Post Created']);
} else {
    echo json_encode(["message" => 'Post not created']);
}
