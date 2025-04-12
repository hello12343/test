<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    checkCookieToken();
}

function cleanStringInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function db_connect() {
    
    $servername = "localhost";
    $username = "sentrixcore";
    $password = "Haxalog@!1009231";
    $dbname = "sentrixcore";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("MySQL Connection Error: " . $conn->connect_error);
    }

    return $conn;
}

function generateToken() {
    return bin2hex(random_bytes(16));
}

function setCookieToken($email) {
    $conn = db_connect();
    if (!$conn) {
        error_log("Database connection failed");
        return false;
    }

    $token = bin2hex(random_bytes(16));
    $expire = time() + (86400 * 30); 
    setcookie("t_user", $token, $expire, "/", "", false, true);

    $query = "UPDATE user SET token = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        error_log("Query preparation failed: " . $conn->error);
        $conn->close();
        return false;
    }

    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}

function checkCookieToken() {
    if (isset($_COOKIE["t_user"])) {
        $t_user = $_COOKIE["t_user"];

       
        $conn = db_connect();
        if (!$conn) {
            
            error_log("Database connection failed");
            return;
        }

        
        $query = "SELECT userid, firstname, email FROM user WHERE token = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            
            error_log("Query preparation failed: " . $conn->error);
            $conn->close();
            return;
        }

        
        $stmt->bind_param("s", $t_user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            setCookieToken($row["email"]);


            $_SESSION["user"] = [
                "id" => $row["id"],
                "name" => $row["firstname"],
                "email" => $row["email"]  
            ];

            $stmt->close();
            $conn->close();

            header("Location: index.php");
            exit();
        } else {
            $stmt->close();
            $conn->close();
        }
    }
}

?>
