<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial- scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Nova Solicitação Pendente</title>
</head>
<body>
    <div class="body">
        <header>
            <span class="custom-class">CINE<span class="highlighted-text">IFF</span></span>
            <h1>Nova Solicitação Pendente</h1>
        </header>
        <div class="main">
            <p>
                Olá, foi solicitado uma nova reserva no Cineteatro do Campus Itaperuna.
                <br>
                <br>
                <strong>Nome do Solicitante:</strong> {{ $solicitacao->nome_solicitante }}
                <br>
                <strong>Nome do Evento:</strong> {{ $solicitacao->nome_evento }}
                <br>
                <strong>Data de Início:</strong> {{ date('d/m/Y', strtotime($solicitacao->inicio))}} as {{ date('H:i', strtotime($solicitacao->inicio)) }}
                <br>
                <strong>Data de Término:</strong> {{ date('d/m/Y', strtotime($solicitacao->fim))}} as {{ date('H:i', strtotime($solicitacao->fim))}}
                <br>
                <br>
                Para deferir ou indeferir a solicitação, acesse o sistema de reservas.
                Atenciosamente, equipe do Cineteatro do Campus Itaperuna.
        </div>
        <footer>
            <p>
                <small>
                    <strong>Atenção:</strong> esta é uma mensagem automática, não responda.
                </small>
            </p>
        </footer>
    </div>
</body>
</html>
