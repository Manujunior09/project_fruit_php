<?php
$title = "Ajouter un Fruit";
?>
<div class="form-container">
    <h1>Ajouter un nouveau fruit</h1>
    
    <form method="POST" action="index.php?action=store" class="form">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        
        <button type="submit" class="btn-primary">
            Ajouter
        </button>
    </form>
</div>