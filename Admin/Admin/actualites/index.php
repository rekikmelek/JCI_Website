<?php
include '../Components/base_admin.php';

$stmt = $pdo->query("SELECT * FROM actualites");
$actualites = $stmt->fetchAll();
?>

<div class="container mt-4" style="max-width: 80%; display: flex; justify-content: center;">
    <div style="width: auto; min-width: 900px;">
        <h2 class="mb-3" style="text-align: center; font-size: 1.5rem;">Liste des Actualités</h2>

        <div class="table-responsive">
            <a href="add.php" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter
            </a>

            <table class="table table-striped table-bordered align-middle text-center table-sm">
                <thead class="table-primary" style="font-size: 0.85rem;">
                    <tr>
                        <th>ID</th>
                        <th>titre</th>
                        <th>contenu</th>
                        <th>photo_couverture</th>
                        <th>date_publication</th>
                        <th>auteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    <?php foreach ($actualites as $actualite): ?>
                        <tr id="row-<?= $actualite['id'] ?>">
                            <td><?= htmlspecialchars($actualite['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($actualite['titre'] ?? '') ?></td>
                            <td><?= htmlspecialchars($actualite['contenu'] ?? '') ?></td>
                            <td><?= htmlspecialchars($actualite['photo_couverture'] ?? '') ?></td>
                            <td><?= htmlspecialchars($actualite['date_publication'] ?? '') ?></td>
                            <td><?= htmlspecialchars($actualite['auteur'] ?? '') ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="edit.php?id=<?= $actualite['id'] ?>" class="btn btn-sm p-1">Modifier</a>
                                <button class="btn btn-sm p-1 delete-btn" data-id="<?= $actualite['id']; ?>">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        // Confirmation avant suppression
        if (confirm("Voulez-vous vraiment supprimer cette actualité ?")) {
            fetch('delete.php', {
                method: 'POST',  
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(() => {
                const row = document.getElementById('row-' + id);
                if (row) row.remove(); 
            })
            .catch(error => console.error('Erreur:', error));
        }
    });
});
</script>
