<?php

namespace Hotel;

use PDO;

class User 
{
	 // Signing key
	const	TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';
	
	private static $currentUserId;

    private $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $user = 'nmouts';
        $password = 'nmouTs_2020';
        $dbname = 'hotel';

        //Set DSN
        $dsn = 'mysql:host='. $host.';dbname='. $dbname;


        $this->pdo = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
    }

    // Get a user's data by his email
	public function getByEmail($email)
    {
        $statement = $this->getPdo()->prepare('SELECT * FROM user WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Get a list of all users
	public function getList()
    {
        $statement = $this->getPdo()->prepare('SELECT * FROM user');

        $statement->execute();
        
        return $statement->fetchALL(PDO::FETCH_ASSOC);
    }

	// Insert a new user
    public function insert($name, $email, $password)
    {
        //prepare statement
        $statement = $this->getPdo()->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');

        //Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Bind parameters
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);

        $rows = $statement->execute();

        return $rows ==1;
    }

	// Verify a user by his email and password
    public function verify($email, $password)
    {
        // Step1 - Retrieve user
        $user = $this->getByEmail($email);
        print_r($user);
        print_r($user['password']);

        //Step2 - Verify user password
        return password_verify($password, $user['password']);
    }

	// Generate session token
	public function generateToken($userId)
	{
		// Create token payload
		$payload = [
			'user_id' => $userId,
		];
		$payloadEncoded = base64_encode(json_encode($payload));
		$signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

		// return sprintf('%s.%s', $payloadEncoded, $signature);
	}

	public function getTokenPayload($token)
	{
		// Get payload and signature
		[$payloadEncoded] = explode('.', $token);

		// Get payload
		return json_decode(base64_decode($payloadEncoded), true);
	}

	public function verifyToken($token)
	{
		// Get payload
		$payload = $this->getTokenPayload($token);
		$userId = $payload['user_id'];

		// Generate signature and verify
		return $this->generateToken($userId) == $token;
	}

    // Pdo getter
	protected function getPdo()
    {
        return $this->pdo;
    }
	
	public static function getCurrentUserId()
	{
		return self::$currentUserId;
	}
	
	public static function setCurrentUserId($userId)
	{
		self::$currentUserId = $userId;
	}
}