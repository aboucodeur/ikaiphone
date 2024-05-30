"use strict";

function registerTable(id = null) {
    if (id) {
        $(`.${id}`).DataTable({
            lengthChange: true, // Afficher le nombre de colonnes
            pageLength: 10, // Fixer le nombre d'éléments par page
            ordering: true, // Activer le tri par défaut
            select: true,
            columnDefs: [
                {
                    targets: [0], // Ciblez la première colonne
                    searchable: false, // Rendre la colonne non recherchable
                    sortable: false, // Rendre la colonne non triable
                },
                {
                    targets: [1], // Ciblez la première colonne
                    searchable: false, // Rendre la colonne non recherchable
                    sortable: false, // Rendre la colonne non triable
                },
            ],
            responsive: true, // Activer la fonctionnalité de réactivité
            language: {
                processing: "Traitement en cours...",
                search: 'Rechercher <i class="bi bi-search"></i> &nbsp;:',
                lengthMenu: "Afficher _MENU_ éléments",
                info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                infoEmpty: "Affichage de l'élément 0 à 0 sur 0 éléments",
                infoFiltered: "(filtré de _MAX_ éléments au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun élément à afficher",
                emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "Premier",
                    previous: "Précédent",
                    next: "Suivant",
                    last: "Dernier",
                },
                aria: {
                    sortAscending:
                        ": activer pour trier la colonne par ordre croissant",
                    sortDescending:
                        ": activer pour trier la colonne par ordre décroissant",
                },
            },
        });
    }
}

export { registerTable };
