<?php
include '../Components/base_admin.php';

// Récupérer tous les partenaires
$stmt = $pdo->query("SELECT * FROM partenaires");
$partenaires = $stmt->fetchAll();
?>

<div class="container mt-4" style="max-width: 80%; display: flex; justify-content: center;">
    <div style="width: auto; min-width: 900px;">
        <h2 class="mb-3" style="text-align: center; font-size: 1.5rem;">Liste des Partenaires</h2>

        <div class="table-responsive">
            <a href="add.php" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter
            </a>

            <table class="table table-striped table-bordered align-middle text-center table-sm">
                <thead class="table-primary" style="font-size: 0.85rem;">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Logo</th>
                        <th>Site Web</th>
                        <th>Description</th>
                        <th>Ordre Affichage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    <?php foreach ($partenaires as $partenaire): ?>
                        <tr id="row-<?= $partenaire['id'] ?>">
                            <td><?= htmlspecialchars($partenaire['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($partenaire['nom'] ?? '') ?></td>
                            <td><?= htmlspecialchars($partenaire['logo'] ?? '') ?></td>
                            <td><?= htmlspecialchars($partenaire['site_web'] ?? '') ?></td>
                            <td><?= htmlspecialchars($partenaire['description'] ?? '') ?></td>
                            <td><?= htmlspecialchars($partenaire['ordre_affichage'] ?? '') ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="edit.php?id=<?= $partenaire['id'] ?>" class="btn btn-sm p-1">Modifier</a>
                                <button class="btn btn-sm p-1 delete-btn" data-id="<?= $partenaire['id']; ?>">Supprimer</button>
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

        
        if (confirm("Voulez-vous vraiment supprimer ce partenaire ?")) {
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
