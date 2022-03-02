<?php

class Post
{
    #Properties
    private $db;

    #Methods
    /**
     * Constructor
     * Connect to database
     */
    function __construct()
    {
        #Make new db connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        #Check for errors
        if ($this->db->connect_errno > 0) {
            die("Database connection error: " . $this->db->connect_error);
        }
    }

    /**
     * Secure input with real_escape_string
     * @param string $input
     * @return string
     */
    private function secureInput(string $input): string
    {
        $secure_string = $this->db->real_escape_string(($input));
        return $secure_string;
    }

    /**
     * Create new Post
     * @param string $title
     * @param string $content
     * @param string $img
     * @param string $imgText
     * @return bool
     */
    public function createPost(string $title, string $content, string $img, string $imgText): bool
    {
        #secure input
        $title = $this->secureInput($title);
        $content = $this->secureInput($content);
        $img = $this->secureInput($img);
        $imgText = $this->secureInput($imgText);

        #Create question to DB
        $sql = "INSERT INTO post (title, content, img, imgtext) VALUES
                ('$title', '$content', '$img', '$imgText');";

        #Send question to db, return bool
        return $this->db->query($sql);
    }

    /**
     * Get all or a specific number of published posts
     * @param int $number = null
     * @return array
     */
    public function getPosts(int $number = null): array
    {
        #Chek if number of posts is specified
        if ($number) {
            #Get a number of posts
            $sql = "SELECT * FROM post ORDER BY created DESC limit $number;";
        } else {
            #Get all published posts
            $sql = "SELECT * FROM post ORDER BY created DESC;";
        }
        #Send question to db
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    /**
     * Get single post
     * @param string $id
     * @return array 
     */
    public function getSinglePost(string $id): array
    {
        #Secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "SELECT * FROM post WHERE id = $id;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return single post as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Delete single post
     * @param string $id
     * @return bool
     */
    public function deletePost(string $id): bool
    {
        #secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "DELETE FROM post WHERE id = $id;";

        #Send question to db
        return $this->db->query($sql);
    }
}
