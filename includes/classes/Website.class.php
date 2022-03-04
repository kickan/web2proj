<?php
class Website
{
    #Properties
    private $db;

    #Methods

    /**
     * Constructor 
     * connect to db
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
     * Add website to portfolio
     * @param string $title
     * @param string $content
     * @param string $img
     * @return bool
     */
    public function addWebsite(string $title, string $content, string $img, string $link): bool
    {
        #Secure input
        $title = $this->secureInput($title);
        $content = $this->secureInput($content);
        $img = $this->secureInput($img);
        $link = $this->secureInput($link);

        #Create question to db
        $sql = "INSERT INTO website (title, content, img, link) VALUES ('$title', '$content', '$img', '$link');";

        #Send question to db
        return $this->db->query($sql);
    }

    /**
     * Remove website from portfolio
     * @param string $id
     * @return bool
     */
    public function removeWebsite(string $id): bool
    {
        #Secure input
        $id = $this->secureInput($id);

        #create question to db
        $sql = "DELETE FROM website WHERE id = $id;";

        #send question to db
        return $this->db->query($sql);
    }

    /**
     * Get specific website
     * @param string $id
     * @return array
     */
    public function getWebsite(string $id): array
    {
        #secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "SELECT * FROM website WHERE id = $id;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return website as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get all websites
     * @return array
     */
    public function getAllWebsites() : array {
        #Create question to db
        $sql = "SELECT * FROM website;";

        #Send question to db
        $result = $this->db->query($sql);

        #return all websites as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

        /**
     * Update website
     * @param string $id
     * @return bool
     */
    public function updateWebsite(string $id, string $title, string $content, string $link): bool
    {
        #Secure input
        $id = $this->secureInput($id);
        
        #Create question to db
        $sql = "UPDATE website SET title = '$title', content = '$content', link ='$link' WHERE id = $id;";

        #Send question to db adn return result
        return $this->db->query($sql);
    }

}
