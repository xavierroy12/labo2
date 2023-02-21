<?php $title = 'Produits';

$titreH1 = 'Les produits'; 
if (isset($categories)){
    require_once('model/Categorie.php');
}
if (isset($categorie))
$titreH1 .= ' de categorie ' . $categorie;

?>
<button id="buttonGet">Tester AJAX</button>





<?php ob_start(); ?>
<h1><?=$titreH1?></h1>
<input id="addProduit" type="image"  src="./inc/img/add-icon.png" alt="Ajouter un produit" width="40" 
height="40"/>

<?php foreach($produits as $produit) { ?>
    <div>
        <h3>Produit: <?= htmlspecialchars($produit->get_produit()) ?> </h3> 

        
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>
        <input type="image" src="./inc/img/delete-icon.png" alt="Supprimer un produit"
        value="<?= htmlspecialchars($produit->get_id_produit()) ?>"width="40"  height="40" />        
        <hr>
    </div>
<?php } ?>

<form action="index.php" method="post" id='form'>
      <label for="produit">Produit:</label>
      <input type="text" id="produit" name="produit"><br>

      <label for="categorie">Catégorie:</label>

      <select id="categorie" name="categorie">
      <?php foreach($categories as $cat) { ?>
        <option value=<?= htmlspecialchars($cat->get_categorie()) ?>><?= htmlspecialchars($cat->get_categorie()) ?></option>
        <?php } ?>
      </select><br>
      <label for="description">Description:</label><br>
      <textarea id="description" name="description" rows="4" cols="50"></textarea><br>

      <input type="submit" value="Envoyer" id='produitAdd'>
    </form>

<?php $content = ob_get_clean(); ?>


<?php require('template.php'); ?>

<script>
document.getElementById('buttonGet').addEventListener('click', testAjax)
function testAjax() {
    /*En get*/ 
    /*
    fetch('index.php?action=testAjax')
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error(error));
    */
   /*En post*/ 
    fetch('index.php', {
    method: 'POST',
    body: new URLSearchParams({
      'action': 'testAjax',
      'nom':'xavier'
    })
  })
    .then(response => response.text())
    .then(response => console.log(response))
    .catch(error => console.error(error));
}



       


function addForm(){
    form = document.getElementById('form');
    if (form.style.display === "none") {
        form.style.display = "block";
    } 
    else {
    form.style.display = "none";
    }
}


/*traiter formulaire*/
function addPost(e){

e.preventDefault();
let produit = document.getElementById('produit').value;
let categorie = document.getElementById('categorie').value;
let description = document.getElementById('description').value;
let action = 'addProduit'

    const params = {
                    "action":action,
                    "produit":produit,
                    "categorie":categorie,
                    "description":description
                    };
    envoieFetch(params);

}

async function envoieFetch(params){
    try{
    let serverResponse = await fetch(
                                        "index.php",
                                        {
                                                method: 'POST',
                                                headers: {'Accept': 'application/json; charset=utf-8', 'Content-Type': 'application/json; charset=utf-8'}, 
                                                body:JSON.stringify(params)
                                        }
                                    );
    publierInfo(serverResponse);
    }
    catch(erreurRequete){
        console.log("un probleme est survenue : " + erreurRequete.message);
    }
}

async function publierInfo(serverResponse){
    let infoProduit = await serverResponse.json();
    console.log(infoProduit);
}


var buttonAddForm = document.getElementById('addProduit');
buttonAddForm.addEventListener('click', addForm);
var buttonAddProduit = document.getElementById('produitAdd');
buttonAddProduit.addEventListener('click', addPost);




</script>