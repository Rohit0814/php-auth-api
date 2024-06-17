<?php

use Firebase\JWT\JWT;

class Api extends Rest
{
    public $conn;
    public function __construct()
    {
        parent::__construct();
        $db = new Db();
        $this->conn = $db->conn;
        /*if (!($this->conn instanceof mysqli)) {
            die("Database connection is not a valid mysqli object.");
        }*/
    }

    public function generateToken()
    {
        $email = $this->validateParameter('email', $this->param['email'], 3, true);
        $pass = $this->validateParameter('pass', $this->param['pass'], 3, true);

        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $email, $pass);
        $stmt->execute();
        print_r($stmt);
        $user = $stmt->get_result();
        print_r($user);
        if ($user->num_rows > 0) {
            $users = $user->fetch_assoc();
            echo $users['email'];

            $payload = [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + (60),
                'userId' => $user['id']
            ];

            define('SECRETE_KEY', 'Abc123');
            $algorithm = 'HS256';

            $token = JWT::encode($payload, SECRETE_KEY, $algorithm);
            $data = ['token' => $token];

            $this->returnResponse(200, $data);
        }
    }
}
