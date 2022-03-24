<center>
    <img src="https://superjogo.loteriabr.com/{{env('logo')}}" alt="" width=150 height=150>

    <h1>Seu Bilhete</h1>
    <p>
    Olá, você acaba de realizar o
    Jogo de ID: {{ $idjogo }}
    <br>
    Segue anexo o seu bilhete.
    <br>
    Obrigado por jogar conosco.
    <br>
    Atenciosamente,
    {{ env("nome_sistema") }}
</p>
</center>
