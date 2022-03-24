<center>
    <img src="https://superjogo.loteriabr.com/{{env('logo')}}" alt="" width=150 height=150>

    <h1>Reset de Senha</h1>
</center>

<pre>
    Olá, você solicitou o reset de senha, segue o link abaixo para realizar o procedimento:
    
    <a href="{{ route('reset.password.get', $token) }}">Recuperar Senha</a>

    Atenciosamente,
    {{ env("nome_sistema") }}</pre>
