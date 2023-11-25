<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial- scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Reserva aprovada</title>
</head>
<body>
    <div class="body">
        <header>
            <span class="custom-class">CINE<span class="highlighted-text">IFF</span></span>
            <h1>Reserva aprovada!</h1>
        </header>
        <div class="main">
            <h4>Olá, {{ $solicitacao->nome_solicitante }}. Seu pedido de reserva foi deferido!</h4>
            <p>
                Seu evento {{ $solicitacao->nome_evento }} será realizado no Cineteatro do Campus Itaperuna.
                <br>
                O evento está agendado para o dia {{ date('d/m/Y', strtotime($solicitacao->inicio))}} as {{ date('H:i', strtotime($solicitacao->inicio)) }}
                até o dia {{ date('d/m/Y', strtotime($solicitacao->fim))}} as {{ date('H:i', strtotime($solicitacao->fim))}}.
                <br>
                <br>
                Para mais informações, entre em contato com o setor de reservas.
                <br>
                Atenciosamente, equipe do Cineteatro do Campus Itaperuna.
            </p>
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
