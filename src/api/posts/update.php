<?php
/**
 * POST All Posts
 * url: /src/api/posts/update.php
 *
 * Example:
 * {
 * "id": 1,
 * "title": "Test title",
 * "body": "Test body",
 * "author": "Test author",
 * "category_id": 1
 * }
 */
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

// Set ID to update
$post->id = $data->id;

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->categoryId = $data->category_id;

// Update post
if($post->update()) {
    echo json_encode(['message' => 'Post Updated']);
} else {
    echo json_encode(['message' => 'Post Updated']);
}

