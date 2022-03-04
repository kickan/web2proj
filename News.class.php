<?php

class News
{
    #Properties
    private $db;
    public  $newsLst = [];


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

        #get all saved news
        $allNews = $this->getAllNews();

        #push all news to newsLst
        foreach ($allNews as $row) {
            $this->setNewsLst($row);
        }
        #push list to jsonfile
        $this->lstToJson();
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
     * Create new newspost
     * @param string $title
     * @param string $content
     * @param string $createdBy
     * @return bool
     */
    public function createNews(string $title, string $content, string $createdBy): bool
    {
        #secure input
        $title = $this->secureInput($title);
        $content = $this->secureInput($content);
        $createdBy = $this->secureInput($createdBy);

        #Create shortened content
        $contentShort = implode(" ", array_slice(explode(" ", $content), 0, 30));


        #Create question to DB
        $sql = "INSERT INTO news (title, content, contentShort, createdBy) VALUES
                ('$title', '$content', '$contentShort', '$createdBy');";

        #Send question to db, return bool
        return $this->db->query($sql);
    }

    /**
     * Get all published news
     * @return array
     */
    public function getAllNews(): array
    {
        #Create question to db
        $sql = "SELECT * FROM news ORDER BY created DESC;";

        #Send question to db
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get latest published news
     * @param int $numberOfNews
     * @return array
     */
    public function getLatestNews(int $numberOfNews): array
    {
        #Create question to DB
        $sql = "SELECT * FROM news ORDER BY created DESC limit $numberOfNews;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return latest news as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get single news
     * @param string $id
     * @return array 
     */
    public function getSingleNews(string $id): array
    {
        #Secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "SELECT * FROM news WHERE id = $id;";

        #Send question to db
        $result = $this->db->query($sql);

        #Return single news as assoc array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Delete single news
     * @param string $id
     * @return bool
     */
    public function deleteNews(string $id): bool
    {
        #secure input
        $id = $this->secureInput($id);

        #Create question to db
        $sql = "DELETE FROM news WHERE id = $id;";

        #Send question to db
        return $this->db->query($sql);
    }

    /**
     * Add news to newsLst
     * @param $news
     */
    public function setNewsLst($news)
    {
        array_push($this->newsLst, $news);
    }

    /**
     * Return newsLst
     * @return array
     */
    public function getNewsLst(): array
    {
        return $this->newsLst;
    }

    /**
     * Make newsLst to JSON and add to JSON file
     */
    public function lstToJson()
    {
        $jsonData = json_encode($this->newsLst);

        if (file_put_contents("news.json", $jsonData)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get news from JSON file and add to newsLst
     * @return bool
     */
    public function JsonToLst(): bool
    {
        if (file_exists("news.json")) {
            $jsonData = file_get_contents("news.json");
            $this->taskLst = json_decode($jsonData, true);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove news from newsLst
     * @param int $index
     */
    public function removeNewsFromLst(int $index)
    {
        unset($this->newsLst[$index]);
        $this->newsLst = array_values($this->newsLst);
    }
}
