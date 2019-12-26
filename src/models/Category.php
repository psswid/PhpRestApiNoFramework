<?php

include_once 'BaseModel.php';

class Category extends BaseModel
{
    /**
     * Db info
     */
    private $connection;
    private $table = 'categories';


    /**
     * @var string
     */
    public $name;


    public function __construct($db)
    {
        $this->connection = $db;
    }


    /**
     * Get all categories
     */
    public function read()
    {
        $query = 'SELECT
                    id,
                    name,
                    created_at
                  FROM ' . $this->table . '
                  ORDER BY 
                    p.created_at DESC';

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }


    /**
     * Get single category matching id
     */
    public function read_single()
    {
        $query = 'SELECT
                    id,
                    name,
                    created_at
                  FROM ' . $this->table . '
                  WHERE 
                    id = ?
                  LIMIT 0,1';

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /**
         * Set properties
         */
        $this->name = $row['name'];
    }


    /**
     * Create new category
     */
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
                  SET 
                    name = :name';

        $stmt = $this->connection->prepare($query);

        /**
         * clean and validate data
         */
        $this->name = htmlspecialchars(strip_tags($this->name));

        /**
         * Bind params
         */
        $stmt->bindParam(':name', $this->name);


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
     * Update category
     */
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                  SET 
                    name = :name,
                  WHERE 
                    id = :id';

        $stmt = $this->connection->prepare($query);

        /**
         * clean and validate data
         */
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        /**
         * Bind params
         */
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);


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
     * Delete category
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