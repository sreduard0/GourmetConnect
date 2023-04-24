<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informações de Login</title>
</head>
<body>
    <h1>Informações de Login</h1>
    <p>Olá, {{ $data['name'] }}!</p>
    <p>Para garantir a segurança de sua conta, recomendamos seguir as seguintes diretrizes de login:</p>
    <ul>
        <li><strong>Use senhas fortes:</strong> Crie senhas complexas, com pelo menos 8 caracteres, incluindo números, letras maiúsculas e minúsculas e caracteres especiais.</li>
        <li><strong>Nunca compartilhe suas informações de login:</strong> Mantenha suas informações de login em um local seguro e nunca compartilhe-as com ninguém.</li>
        <li><strong>Evite usar redes Wi-Fi públicas:</strong> Redes Wi-Fi públicas podem não ser seguras e expor suas informações de login.</li>
        <li><strong>Não use sempre a mesma senha:</strong> Altere a sua senha frequentemente.</li>
    </ul>
    <p>Aqui estão suas informações de login:</p>
    <ul>
        <li><strong>Usuário:</strong> {{ $data['login'] }}</li>
        <li><strong>Senha:</strong> {{ $data['password'] }}</li>
    </ul>
    <p>Lembre-se de manter essas informações em um local seguro e nunca compartilhá-las com ninguém.</p>
</body>
</html>
