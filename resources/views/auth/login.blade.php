<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="w-100" style="max-width: 330px;">
        <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="name" name="name" placeholder="Usuário" required>
                <label for="name">Usuário</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                <label for="password">Senha</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
        </form>
        <p class="mt-3 text-center"><a href="{{ route('register') }}">Criar conta</a></p>
    </div>
</body>
</html>
