<?php
include '../Components/base_admin.php'; 

$stmt = $pdo->query("SELECT * FROM Postes");
$postes = $stmt->fetchAll();
?>

<div class="container mt-4" style="max-width: 95%; display: flex; justify-content: flex-end;">
    <div style="width: auto; min-width: 1070px;">
        <h2 class="mb-4" style="text-align: center;">Liste des Postes</h2>

        <div class="table-responsive">
            <a href="add.php" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter
            </a>

            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 40px;">ID</th>
                        <th style="width: 150px;">Nom du Poste</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($postes as $poste): ?>
                        <tr id="row-<?php echo $poste['id']; ?>">
                            <td><?php echo htmlspecialchars($poste['id']); ?></td>
                            <td><?php echo htmlspecialchars($poste['name']); ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="edit.php?id=<?php echo $poste['id']; ?>" class="btn btn-sm p-1">Modifier</a>
                                <button class="btn btn-sm p-1 delete-btn" data-id="<?php echo $poste['id']; ?>">Supprimer</button>
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

        if (confirm("Voulez-vous vraiment supprimer ce poste ?")) {
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
