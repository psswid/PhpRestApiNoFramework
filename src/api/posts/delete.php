<?php
/**
 * Delete post
 * url: /src/api/posts/delete.php
 *
 * Example:
 * {
 * "id": 1
 * }
 */
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Set ID to delete
$post->id = $data->id;

if($post->delete()) {
    echo json_encode(['message' => 'Post deleted']);
} else {
    echo json_encode(['message' => 'Post not deleted']);
}