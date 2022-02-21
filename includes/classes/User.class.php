<?php
class User
{
    #Properties
    private $db;
    private string $username;
    private string $password;

    #Methods

    /**
     * Construct
     * Connect to database
     * If connection error, die
     */
    function __construct()
    {
        #Make new connection 
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        #Check for connection error
        if ($this->db->connect_errno > 0) {
            die("Database connection error " . $this->db->connect_error);
        }
    }

    /**
     * Secure input with real_escape_string
     * @param string $input
     * @return string 
     */
    private function secureInput(string $input): string
    {
        $secure_string = $this->db->real_escape_string($input);
        return $secure_string;
    }

    /**
     *Check that username fulfills critera and set username
     * @param string $username
     * @return bool 
     */
    public function setUsername(string $username): bool
    {
        if ($username != "" && strlen($username) > 2) {
            $this->username = $username;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check that password fulfills critera and set password
     * @param string $password
     * @return bool 
     */
    public function setPassword(string $password): bool
    {
        #Set mandatory characters
        $chars = ["uppercase" => "@[A-Z]@", "lowercase" => "@[a-z]@", "numbers" => "@[0-9]@"];
        foreach ($chars as $format) {
            #Check if password contains all mandatory characters
            if (!preg_match($format, $password)) {
                return false;
            }
        }
        # Check if password fullfills length
        if (strlen($password) < 7) {
            return false;
        } else {
            # Return true if all criterias are fullfilled
            return true;
        }
    }

    /**
     * Login user 
     * @param string username
     * @param string password
     * @return bool
     */
    public function loginUser(string $username, string $password): bool
    {
        #Secure input
        $username = $this->secureInput($username);
        $password = $this->secureInput($password);

        #Get username info from database
        $sql = "SELECT * FROM user WHERE username = '$username';";
        $result = $this->db->query($sql);

        #Check if username is registered
        if ($result->num_rows > 0) {

            #Extract users password
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];

            #Verify hasched password
            if (password_verify($password, $stored_password)) {
                $_SESSION['username'] = $username;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        if (isset($_SESSION['k_user'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create new user
     * @param string $name
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function createUser(string $name, string $username, string $password): bool
    {
        #Secure all inputs
        $name = $this->secureInput($name);
        $username = $this->secureInput($username);
        $password = $this->secureInput($password);

        #Hash password
        $hased_password = password_hash($password, PASSWORD_DEFAULT);

        #Create question to DB, create user
        $sql = "INSERT INTO user(name, username, password) VALUES
                ('$name', '$username', '$hased_password');";

        #Send question to DB
        return $this->db->query($sql);
    }

    /**
     * Check if username is occupied
     * @param string $username
     * @return bool
     */
    public function doUserExist(string $username)
    {
        #Secure input
        $username = $this->secureInput($username);

        #Create question, ask for user
        $sql = "SELECT * FROM users WHERE username = '$username';";

        #Send question to DB
        $result = $this->db->query($sql);

        #check result (does user exist?)
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all users
     * @return array
     */
    public function getAllUsers(): array
    {
        #Create question to db, ask for all users
        $sql = "SELECT id, name, username FROM users;";

        #Send question to db
        $allUsers = $this->db->query($sql);

        #return array of usernames
        return mysqli_fetch_all($allUsers, MYSQLI_ASSOC);
    }
}
