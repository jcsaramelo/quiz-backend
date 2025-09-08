<?php
session_start();
include "perguntas.php";

/**
 * Estados possíveis do fluxo:
 * - home: tela inicial com botão Iniciar
 * - pergunta: exibe questão atual e opções
 * - feedback: mostra se acertou/errou e botão Próxima
 * - final: mostra pontuação e botão Reiniciar
 */

// Inicializa estado na primeira visita
if (!isset($_SESSION['estado'])) {
    $_SESSION['estado'] = 'home';
    $_SESSION['indice'] = 0;
}

function reset_quiz() {
    $_SESSION['estado'] = 'home';
    $_SESSION['indice'] = 0;
    $_SESSION['pontuacao'] = 0;
}

// Tratar ações do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Iniciar quiz
    if (isset($_POST['iniciar'])) {
        $_SESSION['estado'] = 'pergunta';
        $_SESSION['indice'] = 0;
        $_SESSION['pontuacao'] = 0;
    }

    // Enviar resposta
    if (isset($_POST['responder']) && isset($_POST['resposta'])) {
        $indice = $_SESSION['indice'];
        $resposta = intval($_POST['resposta']);
        $correta = $perguntas[$indice]['resposta'];

        if ($resposta === $correta) {
            $_SESSION['pontuacao']++;
            $_SESSION['feedback'] = "✅ Resposta correta!";
        } else {
            $textoCorreto = $perguntas[$indice]['opcoes'][$correta];
            $_SESSION['feedback'] = "❌ Resposta errada! Correto: <strong>{$textoCorreto}</strong>";
        }
        $_SESSION['estado'] = 'feedback';
    }

    // Próxima questão
    if (isset($_POST['proxima'])) {
        $_SESSION['indice']++;
        if ($_SESSION['indice'] >= count($perguntas)) {
            $_SESSION['estado'] = 'final';
        } else {
            $_SESSION['estado'] = 'pergunta';
        }
        unset($_SESSION['feedback']);
    }

    // Reiniciar
    if (isset($_POST['reiniciar'])) {
        reset_quiz();
    }
}

// Variáveis úteis
$estado = $_SESSION['estado'];
$indice = $_SESSION['indice'];
$pontuacao = $_SESSION['pontuacao'];
$total = count($perguntas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mini Quiz Backend</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div class="container">
        <header>
            <h1>Mini Quiz Backend</h1>
            <p class="sub">PHP • Arrays • Sessão • Condicionais</p>
        </header>

        <?php if ($estado === 'home'): ?>
            <section class="card">
                <p>Bem-vindo! Clique no botão abaixo para iniciar o quiz.</p>
                <form method="post">
                    <button class="btn primary" name="iniciar">Iniciar</button>
                </form>
            </section>

        <?php elseif ($estado === 'pergunta'): ?>
            <?php
                $questao = $perguntas[$indice]['questao'];
                $opcoes = $perguntas[$indice]['opcoes'];
            ?>
            <section class="card">
                <div class="status">
                    <span>Pergunta <?php echo $indice + 1; ?> de <?php echo $total; ?></span>
                    <span>Pontos: <?php echo $pontuacao; ?></span>
                </div>

                <h2 class="question"><?php echo $questao; ?></h2>
                <form method="post" class="options">
                    <?php foreach ($opcoes as $i => $opcao): ?>
                        <label class="option">
                            <input type="radio" name="resposta" value="<?php echo $i; ?>" required />
                            <span><?php echo $opcao; ?></span>
                        </label>
                    <?php endforeach; ?>
                    <button type="submit" class="btn primary" name="responder">Enviar resposta</button>
                </form>
            </section>

        <?php elseif ($estado === 'feedback'): ?>
            <section class="card">
                <div class="status">
                    <span>Pergunta <?php echo $indice + 1; ?> de <?php echo $total; ?></span>
                    <span>Pontos: <?php echo $pontuacao; ?></span>
                </div>
                <div class="feedback">
                    <?php echo $_SESSION['feedback'] ?? ''; ?>
                </div>
                <form method="post">
                    <button class="btn primary" name="proxima">Próxima</button>
                </form>
            </section>

        <?php elseif ($estado === 'final'): ?>
            <section class="card final">
                <h2>Fim do Quiz!</h2>
                <p>Sua pontuação: <strong><?php echo $pontuacao; ?></strong> de <strong><?php echo $total; ?></strong></p>
                <form method="post">
                    <button class="btn" name="reiniciar">Reiniciar</button>
                </form>
            </section>
        <?php endif; ?>

        <footer>
            <small>Feito com em PHP puro (sem banco de dados) E.C</small>
        </footer>
    </div>
</body>
</html>
