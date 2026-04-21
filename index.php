<?php
session_start();
require 'conexao.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Professores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container mt-4">
    <?php include('mensagem.php'); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Lista de Professores
              <a href="professor-create.php" class="btn btn-primary float-end">Adicionar professor</a>
            </h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Data de Nascimento</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'SELECT * FROM professores';
                $professores = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($professores) > 0) {
                  foreach ($professores as $professor) {
                ?>
                    <tr>
                      <td><?= $professor['id'] ?></td>
                      <td><?= $professor['nome'] ?></td>
                      <td><?= $professor['email'] ?></td>
                      <td><?= date('d/m/Y', strtotime($professor['data_nascimento'])) ?></td>
                      <td>
                        <a href="professor-view.php?id=<?= $professor['id'] ?>" class="btn btn-secondary btn-sm">Visualizar</a>
                        <a href="professor-edit.php?id=<?= $professor['id'] ?>" class="btn btn-success btn-sm">Editar</a>
                        <form action="acoes.php" method="POST" class="d-inline"
                          onsubmit="return confirm('Tem certeza que deseja excluir?')">

                          <button type="submit"
                            name="delete_professor"
                            value="<?= $professor['id'] ?>"
                            class="btn btn-danger btn-sm">
                            Excluir
                          </button>
                        </form>
                      </td>
                    </tr>
                <?php
                  }
                } else {
                  echo '<h5>Nenhum professor encoontrado</h5>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>