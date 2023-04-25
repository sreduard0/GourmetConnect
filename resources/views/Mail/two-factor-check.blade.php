<!DOCTYPE html>
<html>
<head>
    <title>Código de Verificação</title>
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

        .code {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            background-color: #f5f5f5;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
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
            <h1 class="title">Código de Verificação</h1>
        </div>
        <div class="content">
            <p>Aqui está o seu código de verificação:</p>
            <p class="code">{{ $data }}</p>
            <p>Este código é válido por 4 minutos.</p>
            <p>Se você não solicitou este código, por favor, ignore este email.</p>
        </div>
        <div class="footer">
            <p>Não responda a este email. Se você tiver alguma dúvida, entre em contato com o administrador do sistema.</p>
        </div>
    </div>
</body>
</html>
