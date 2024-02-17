<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial- scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Reserva rejeitada</title>
</head>
<body>
    <div class="body">
        <header>
            <span class="custom-class">CINE<span class="highlighted-text">IFF</span></span>
            <h1>Reserva rejeitada!</h1>
        </header>
        <div class="main">
            <h4>Olá, {{ $solicitacao->nome_solicitante }}. Seu pedido de reserva infelizmente foi indeferido.</h4>
            <p>
                Seu evento {{ $solicitacao->nome_evento }} não foi aceito para ser realizado no Cineteatro do Campus Itaperuna.
                <br>
                Justificativa: {{ $solicitacao->justificativa_indeferimento }}.
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
