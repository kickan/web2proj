<?php

class Skills
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
     * Get About me information
     * @return array 
     */
    public function getAboutMe(): array
    {
        #Create question to db
        $sql = "SELECT * FROM about WHERE id = 1;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return single post as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update About me information
     * @param string $slogan
     * @param string $content
     * @param string $img
     * @return bool
     */
    public function updateAboutMe(string $slogan, string $content, string $img): bool
    {
        #Secure Input
        $slogan = $this->secureInput($slogan);
        $content = $this->SecureInput($content);
        $img = $this->SecureInput($img);

        #Create question to db
        $sql = "UPDATE about SET slogan = '$slogan', content = '$content', img = '$img' WHERE id = 1;";

        #Send question to db adn return result
        return $this->db->query($sql);
    }

    /**
     * Create new experience
     * @param string $title
     * @param string $location
     * @param string $startDate
     * @param string $endDate
     * @param string $content
     * @param string $type
     * @return bool
     */
    public function createExp(string $title, string $location, string $startDate, string $endDate, string $content, string $type): bool
    {
        #secure input
        $title = $this->secureInput($title);
        $startDate = $this->secureInput($startDate);
        $endDate = $this->secureInput($endDate);
        $location = $this->secureInput($location);
        $type = $this->secureInput($type);
        $content = $this->secureInput($content);

        #Create question to DB
        $sql = "INSERT INTO experience (title, location, startdate, enddate, content, type) VALUES
                ('$title', '$location', '$startDate', '$endDate', '$content', '$type');";

        #Send question to db, return bool
        return $this->db->query($sql);
    }

    /**
     * Get all experiences of special type
     * @param string $type = null
     * @return array
     */
    public function getExp(string $type = null): array
    {
        #Chek if type of experience is specified
        if ($type) {
            #Get a specific experiences
            $sql = "SELECT * FROM experience where type = '$type' ORDER BY startdate;";
        } else {
            #Get all experiences
            $sql = "SELECT * FROM experience ORDER BY startdate DESC;";
        }
        #Send question to db
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get specific experience
     * @param int $id
     * @return array
     */
    public function getSingleExp(int $id) : array
    {
        #Create question to db
        $sql = "SELECT * FROM experience WHERE id = $id;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return single post as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update experience
     * @param int $id
     * @return bool
     */
    public function updateExp(int $id, string $title, string $location, string $startDate, string $endDate, string $content, string $type): bool
    {
        #secure input
        $id = $this->secureInput($id);
        $title = $this->secureInput($title);
        $startDate = $this->secureInput($startDate);
        $endDate = $this->secureInput($endDate);
        $location = $this->secureInput($location);
        $type = $this->secureInput($type);
        $content = $this->secureInput($content);

        #Create question to db
        $sql = "UPDATE experience SET 
                title = '$title', 
                content = '$content', 
                startDate = '$startDate', 
                enddate = '$endDate', 
                location = '$location',
                type = '$type' 
                WHERE id = $id;";

        #Send question to db adn return result
        return $this->db->query($sql);
    }

    /**
     * Delete experience
     * @param int $id
     * @return bool
     */
    public function deleteExp(int $id): bool
    {
        #secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "DELETE FROM experience WHERE id = $id;";

        #Send question to db
        return $this->db->query($sql);
    }

    /**
     * Create new language
     * @param string $name
     * @param string $level
     * @param string $type
     */
    public function createLan(string $name, string $level, string $type): bool
    {
        #secure input
        $name = $this->secureInput($name);
        $level = $this->secureInput($level);
        $type = $this->secureInput($type);

        #Create question to DB
        $sql = "INSERT INTO language (name, level, type) VALUES
                ('$name', '$level', '$type');";

        #Send question to db, return bool
        return $this->db->query($sql);
    }

    /**
     * Get languages
     * @return array
     */
    public function getLan(): array
    {
        #create SQL question
        $sql = "SELECT * FROM language ORDER BY type";

        #Send question to db
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get specific language
     * @param int $id
     * @return array
     */
    public function getSingleLan(int $id) : array
    {
        #Create question to db
        $sql = "SELECT * FROM language WHERE id = $id;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return single post as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update language
     * @param int $id
     * @param string $name
     * @param string $level
     * @param string $type
     * @return bool
     */
    public function updateLan(int $id, string $name, string $level, string $type): bool
    {
        #Create question to db
        $sql = "UPDATE language SET name = '$name', level = '$level', type = '$type' WHERE id = $id;";

        #Send question to db adn return result
        return $this->db->query($sql);
    }

    /**
     * Delete language
     * @param int $id
     * @return bool
     */
    public function deleteLan(int $id): bool
    {
        #secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "DELETE FROM language WHERE id = $id;";

        #Send question to db
        return $this->db->query($sql);
    }
}
