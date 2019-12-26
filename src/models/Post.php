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


    /**
     * Create new post
     */
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
                  SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';

        $stmt = $this->connection->prepare($query);

        /**
         * clean and validate data
         */
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        /**
         * Bind params
         */
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->categoryId);


        if($stmt->execute()) {
            return true;
        }

        /**
         * In case of failure
         */
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    /**
     * Update post
     */
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                  SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id 
                  WHERE 
                    id = :id';

        $stmt = $this->connection->prepare($query);

        /**
         * clean and validate data
         */
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        /**
         * Bind params
         */
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->categoryId);


        if($stmt->execute()) {
            return true;
        }

        /**
         * In case of failure
         */
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    /**
     * Delete post
     */
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        /**
         * In case of failure
         */
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

}