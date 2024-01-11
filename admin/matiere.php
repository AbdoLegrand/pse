<title>Les matiéres</title>
<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

include "nav_bar.php";
include_once "../connexion.php";
$searched = false;


$matiere_query = "SELECT * FROM matiere INNER JOIN semestre USING(id_semestre) order by code desc"; 

?>


    <!-- sweetalert2 links -->

    <script src="../JS/sweetalert2.js"></script>



<div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Gestion des matiére :</h4>
                    <div style="display: flex ; justify-content: space-between;">
                        <a href="ajoute_matiere.php" class = "btn btn-primary" >Nouveau</a>
                        <a href="importe_matiere.php"  class="btn btn-primary ml-25">importer</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                      <thead>
                      <tr>
                        <th>Code</th>
                        <th>Libelle</th>
                        <th>Semestre</th>
                        <th>Specialite</th>
                        <th></th>
                        <th>Actions</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $matiere_result = mysqli_query($conn, $matiere_query);

                      if (mysqli_num_rows($matiere_result) == 0) {
                          echo "Il n'y a pas encore de matières ajoutées !";
                      } else { 
                          
                        while ($row = mysqli_fetch_assoc($matiere_result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['code'] ?></td>
                                <td><?php echo $row['libelle'] ?></td>
                                <td><?php echo $row['nom_semestre'] ?></td>
                                <td><?php echo $row['specialite'] ?></td>               
                                <td><a href="detail_matiere.php?id_matiere=<?= $row['id_matiere'] ?>">Details</a></td>
                                <td><a href="affecter_matiere.php?id_matiere=<?= $row['id_matiere'] ?>">Affecter</a></td>
                                <td><a href="supprimer_matiere.php?id_matiere=<?= $row['id_matiere'] ?>" id="supprimer">Supprimer</a></td>
                            </tr>
                            <?php
                        }
                    }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<?php
//if (isset($_GET['succes']) && $_GET['succes'] == 1) {

if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'La matiére a été ajouté avec succès 🎉🎉',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['ajout_reussi']);
}


if (isset($_SESSION['supp_reussi']) && $_SESSION['supp_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Suppression réussi !',
        text: 'La matiére a été supprimer avec succès 🎉🎉',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['supp_reussi']);
}


if (isset($_SESSION['modifier_reussi']) && $_SESSION['modifier_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Modification réussi !',
        text: 'La matiére a été modifier avec succès 🎉🎉',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['modifier_reussi']);
}



if (isset($_SESSION['affecter_reussi']) && $_SESSION['affecter_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Affectation réussi !',
        text: 'La matiére a été affecter avec succès 🎉🎉',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['affecter_reussi']);
}

?>
</div>
</body>
</html>


<script>


var liensArchiver = document.querySelectorAll("#supprimer");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchiver.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment supprimer cette matière ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Supprimer"
    }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = this.href;
            }
        });
      });
    });

   
   
</script>