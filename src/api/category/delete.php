<?php
/**
 * Delete category
 * url: /src/api/category/delete.php
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
include_once '../../models/Category.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();

/**
 * Instantiate blog category object
 */
$category = new Category($db);

/**
 * Get category data
 */
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$category->id = $data->id;

if($category->delete()) {
    echo json_encode(['message' => 'Category deleted']);
} else {
    echo json_encode(['message' => 'Category not deleted']);
}