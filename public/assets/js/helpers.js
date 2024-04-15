"use strict";

/**
 * Transformer un tableaux en data table via son identifiant
 * @param {string} id
 */
function registerTable(id = null) {
    if (id) {
        $(`.${id}`).DataTable({
            lengthChange: false, // Ne pas afficher le nombre de colonnes
            pageLength: 10, // Fixez le nombres d'element
            // finit le trie
            bSort: false, // desactiver le trie
            bOrder: false, // desactiver l'ordre
            ordering: false, // desactiver l'ordre par defaut
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    sortable: false,
                },
            ],
            responsive: !0,
            language: {
                processing: "Traitement en cours...",
                search: 'Rechercher <i class="bi bi-search"></i> &nbsp;:',
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:
                    "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:
                    "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "Premier",
                    previous: "Pr&eacute;c&eacute;dent",
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