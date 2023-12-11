<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial- scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Ingresso</title>
</head>
<body>
    <div class="body">
        <header>
            <span class="custom-class">CINE<span class="highlighted-text">IFF</span></span>
            <h1>Ingresso</h1>
            <small> Você reservou um ingresso para o evento {{ $ingresso->nome_evento }} com sucesso!</small>
        </header>
        <div class="main">
            <p>
                <h2>{{ $ingresso->nome_evento }}</h2>
                <strong>Documento:</strong> {{ $ingresso->documento }}
                <strong>Data de Início:</strong> {{ date('d/m/Y', strtotime($ingresso->data_inicio))}} as {{ date('H:i', strtotime($ingresso->data_inicio)) }}
                <br>
                <strong>Data de Término:</strong> {{ date('d/m/Y', strtotime($ingresso->data_fim))}} as {{ date('H:i', strtotime($ingresso->data_fim))}}
                <br>
                <br>
                <strong>Localização:</strong> Cineteatro do IFF Campus Itaperuna - Rodovia BR 356, Km3, Cidade Nova - Itaperuna, RJ - CEP 28.300-000
                <br>
                <br>
                <a href="{{ $ingresso->url }}" class="url">Acessar Ingresso</a>
        </div>
        <footer>
            <p>
                <small>
                    <strong>Atenção:</strong> Escolha do lugar é por ordem de chegada. Esta é uma mensagem automática, não responda.
                </small>
            </p>
        </footer>
    </div>
</body>
</html>
