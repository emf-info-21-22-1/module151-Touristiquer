<!doctype html>
<html>
<header>
  <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
</header>

<body>
  <div id="conteneur">
    <h1>Les équipes de National League</h1>
    <table border="1">
      <tr>
        <td>ID</td>
        <td>Club</td>
      </tr>
      <?php
      // Inclure le contrôleur pour obtenir les équipes
      require('ctrl.php');

      $equipes = getEquipes();

      // Méthode ajouteCelluleHtml
      function ajouteCelluleHtml($contenu, $id)
      {
        echo "<td id='{$id}'>{$contenu}</td>";
      }

      // Affichage des équipes dans le tableau HTML
      foreach ($equipes as $id => $club) {
        echo "<tr>";
        ajouteCelluleHtml($id, 'id');
        ajouteCelluleHtml($club, 'club');
        echo "</tr>";
      }
      ?>
    </table>
  </div>
</body>

</html>