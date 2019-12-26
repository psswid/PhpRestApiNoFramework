<?php

/**
 * GET All categories
 * url: /src/api/category/read.php
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

/**Blog category query*/
$result = $category->read();
/**Get row count*/
$num = $result->rowCount();

/**Check if any categories*/
if ($num > 0) {
    $categoryArr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row, null);

        $categoryItem = [
            'id' => $id,
            'name' => $name,
        ];

        $categoryArr[] = $categoryItem;
    }

    echo json_encode($categoryArr);

} else {
    echo json_encode(['message' => 'No categories Found']);
}
