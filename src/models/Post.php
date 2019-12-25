<?php

include_once 'BaseModel.php';

class Post extends BaseModel
{
    /**
     * Db info
     */
    private $connection;
    private $table = 'posts';


    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $author;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var string
     */
    public $categoryName;


    public function __construct($db)
    {
        $this->connection = $db;
    }


    /**
     * Get posts
     */
    public function read()
    {
        $query = 'SELECT
                    c.name as category_name,
                    p.id,
                    p.title,
                    p.category_id,
                    p.body,
                    p.author,
                    p.created_at
                  FROM ' . $this->table . ' p
                  LEFT JOIN 
                    categories c on p.category_id = c.id
                  ORDER BY 
                    p.created_at DESC';

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

}