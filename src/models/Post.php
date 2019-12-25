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
     * Get all posts
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


    /**
     * Get single post matching id
     */
    public function read_single()
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
                  WHERE 
                    p.id = ?
                  LIMIT 0,1';

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /**
         * Set properties
         */
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->createdAt = $row['created_at'];
        $this->categoryName = $row['category_name'];
        $this->categoryId = $row['category_id'];

    }

}