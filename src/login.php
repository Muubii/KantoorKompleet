<?php
session_start();
include "database verzoeken/ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $myusername = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];

    $query = "SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam = '$myusername' AND Wachtwoord = '$mypassword'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['login_user'] = $myusername;
        header("Location: index.html");
        exit();
    } else {
        $error = "Jouw login naam of wachtwoord is incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>    
    <nav class="navbar">
        <ul>
            <a href="index.html" id="s">Home</a>
            <a href="login.html" id="s">Login</a>
            <a href="chat.html" id="s">Chat</a>
        </ul>
    </nav>
  
    
<div class="login-container">
    <form class="login-form" action="" method="POST">
        <h1>Login</h1>
        <div class="form-field">
            <label for="Gebruikersnaam">Gebruikersnaam:</label>
            <input type="text" id="Gebruikersnaam" name="Gebruikersnaam" placeholder="Voer je gebruikersnaam in" required>
        </div>
        
        <div class="form-field">
            <label for="Wachtwoord">Wachtwoord:</label>
            <input type="Wachtwoord" id="Wachtwoord" name="Wachtwoord" placeholder="Voer je wachtwoord in" required>
            <a href="registreren.php">Registreren</a>
        </div>

            <?php if(isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?> 


        <button type="submit" name="login">Login</button>
    </form>
</form>

</div>

</body>
<style>
.navbar {
    background-color: #79899afa;
    overflow: hidden;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

#s{
    padding: 1%;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.login-form h1 {
    color: #333;
    margin-bottom: 24px;
    text-align: center;
}

.form-field {
    margin-bottom: 20px;
}

.form-field label {
    display: block;
    margin-bottom: 8px;
}

.form-field input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #79899afa;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #98abc0fa;
}

.error-message {
    color: #d9534f;
    margin-bottom: 20px;
}

a{
    color: black;
    text-decoration: none;
}
</style>
</html>