<?php
session_start();
require_once '..\function.php';

if (isset($_SESSION["user"])) {
    header("Location: ..\index.php");
    exit();
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $password = cleanStringInput($_POST["password"]);
        
        $conn = db_connect();

        if ($conn) {
            $query = "SELECT * FROM user WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
    
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();

                    if (isset($row["Password"]) && password_verify($password, $row["Password"])) {
                        session_regenerate_id();
                        $_SESSION["user"] = [
                            "UserID" => $row["UserID"],
                            "FirstName" => $row["FirstName"],
                            "Email" => $row["Email"],
                            "role" => $row["role"]
                        ];
                        
                        if (isset($_POST["rememberme"])) {
                            setCookieToken($row["email"]);
                        }
                        
                        $stmt->close();
                        $conn->close();

                        switch ($row['role']) {
                            case 'a':
                                header("Location: ..\index.php");
                                break;
                            case 't':
                                header("Location: ..\index.php");
                                break;
                            case 's':
                                header("Location: ..\index.php");
                                break;
                            default:
                                echo "Invalid role";
                        }
                        exit();
                    } else {
                        $error[] = "Invalid Credentials";
                    }
                } else {
                    $error[] = "Invalid Credentials";
                }

                $stmt->close();
            } else {
                $error[] = "Failed to prepare statement";
            }

            $conn->close();
        } else {
            $error[] = "Database connection failed";
        }
    } else {
        $error[] = "Email and Password are required";
    }

if ($_SERVER["REQUEST_METHOD"] === 'GET' || !empty($error)) {
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>sentrixcore</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<!doctype html>

<html lang="en"> 

 <head> 

  <meta charset="UTF-8"> 

  <title>sentrixcore</title> 

  <link rel="stylesheet" href="./style.css"> 

 </head> 

 <body> <!-- partial:index.partial.html --> 

  <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 

   <div class="signin"> 

    <div class="content"> 
     
     <h2>Sign In</h2>
     
     <form class="form1" method="POST" action="">

      <div class="form"> 

        <div class="inputBox"> 

        <input type="email" name="email" required/> <i>email</i>

        </div> 

        <div class="inputBox"> 

        <input type="password" name="password" required/> <i>Password</i>

        </div> 

        <div class="links"> <a href="reset\email.php">Forgot Password</a> <a href="signup.php">Signup</a> 

        </div> 

        <div class="inputBox"> 

        <input type="submit" value="Login"> 

        </div> 

      </form>
     
    </div> 

    </div> 

   </div> 

  </section> <!-- partial --> 

 </body>

</html>
<!-- partial -->
  
</body>
</html>
<?php
} else {
    http_response_code(404);
    die();
}
?>