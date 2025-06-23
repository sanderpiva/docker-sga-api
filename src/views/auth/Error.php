<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Erro</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .error-container {
            text-align: center;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }
        .error-container p {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.1em;
        }
        .error-container a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .error-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <p><?php echo htmlspecialchars($errorMessage ?? 'Ocorreu um erro.'); ?></p>
        <a href='<?php echo htmlspecialchars($homeUrl ?? '/'); ?>'>Voltar para a Home</a>
    </div>
</body>
</html>