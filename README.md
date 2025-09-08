# Mini Quiz Backend (PHP)

Projeto simples exigido na Avaliação Formadora (Back-End / ADS).

## 🎯 Objetivo
Criar um mini-quiz processado no backend usando **PHP**, sem banco de dados, com perguntas em **arrays** e controle de progresso/pontuação via **sessão**.

## 🧩 Funcionalidades
- Perguntas com 3 opções cada (armazenadas em `perguntas.php`)
- Verificação de respostas no backend
- Pontuação com `$_SESSION['pontuacao']`
- Progresso com `$_SESSION['indice']`
- Fluxo completo: Home → Pergunta → Feedback → Final → Reiniciar
- HTML semântico + CSS básico

## 📂 Estrutura
```
/quiz-backend
  ├── index.php        # Fluxo do quiz (home, pergunta, feedback, final)
  ├── perguntas.php    # Array com perguntas, opções e índice da correta
  ├── style.css        # Estilos básicos
  └── README.md
```

## ▶️ Como rodar
1. Copie a pasta `quiz-backend` para o diretório do seu servidor local (ex.: `htdocs` no XAMPP).
2. Acesse no navegador: `http://localhost/quiz-backend/`
3. Clique em **Iniciar**, responda e avance com **Próxima**.

## ✏️ Como editar perguntas
Abra `perguntas.php` e adicione itens no array:
```php
[
  "questao" => "Texto da pergunta",
  "opcoes" => ["A", "B", "C"],
  "resposta" => 1 // índice da opção correta (0, 1 ou 2)
]
```

## 📸 Vídeo (sugestão de roteiro em 5 min)
1. Mostrar o quiz funcionando (home → pergunta → feedback → final).
2. Abrir `index.php` e explicar:
   - uso de `$_SESSION`, condicionais `if/else`, repetição `foreach` para listar opções;
3. Abrir `perguntas.php` e explicar o array.
4. Mostrar `style.css` (breve).
5. Encerrar com a pontuação final.

## 🧪 Dicas
- Não precisa de banco de dados.
- Mantenha 3 opções por pergunta.
- Commits no Git com mensagens claras (ex.: `feat: fluxo de feedback`).
