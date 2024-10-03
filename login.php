<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('achtergrond.jpg') no-repeat center center/cover; 
            background-color: #333;
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.7); 
            padding: 40px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            color: white;
            text-align: center;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2); 
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            background-color: #333;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #e50914;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #e50914;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #f6121d;
        }

        .error-message {
            color: #e87c03;
            margin-bottom: 20px;
            font-size: 14px;
        }

        a {
            color: #757575;
            font-size: 14px;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        .form-footer {
            font-size: 13px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Inloggen</h1>
        <form action="login.php" method="POST">
            <label for="username">Gebruikersnaam</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Wachtwoord</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Inloggen</button>
        </form>

      
    </div>
</body>
</html>
