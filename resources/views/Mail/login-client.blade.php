<!DOCTYPE html>
<html>
<head>
    <title>Credenciais de Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            margin: 0;
        }

        .content {
            margin-bottom: 20px;
        }

        .label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .field {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .button {
            background-color: #000000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            text-transform: none;

        }

        .footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Credenciais de Login</h1>
        </div>
        <div class="content">
            <p>Olá, {{ $data['name'] }}.</p>

            <p>Aqui estão as suas credenciais de login:</p>
            <label for="email" class="label">Endereço de Email:</label>
            <input id="email" class="field" value=" {{ $data['login'] }}" readonly>
            <label for="password" class="label">Senha:</label>
            <input id="password" class="field" value=" {{ $data['password'] }}" readonly>
            <p>Por motivos de segurança, recomendamos que você altere sua senha assim que fizer o login.</p>
            <a href="{{ route('form_login') }}" class="button">Fazer Login</a>
        </div>
        <div class="footer">
            <p>Não responda a este email.</p>
        </div>
    </div>
</body>
