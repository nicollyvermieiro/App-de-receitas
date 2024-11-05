<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Receitas</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
    <h1>Receitas</h1>
    <a href="/receita/nova">Nova Receita</a>
    <ul>
        <?php foreach ($receitas as $receita): ?>
            <li>
                <a href="/receita/<?php echo $receita['id']; ?>"><?php echo $receita['titulo']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
