"use strict";
import { registerTable } from "./helpers.js";

$(document).ready(function () {
    registerTable("dt");
    
    $("#s_iphone_select").change(function (e) {
        e.preventDefault();
        var elQte = $("#s_iphone_qte");
        var elPrix = $("#s_iphone_prix");
        var _selected = $(this).find(`option[value=${$(this).val()}]`);
        elQte.val(1);
        elPrix.val(_selected.data("modele")["m_prix"]);
    });

    // Verification de l'iphone du vente
    const ventes_datas = $("#datas_iphones_ventes").data(
        "datas_iphones_ventes"
    );
    if (Array.isArray(ventes_datas)) {
        var validInput = $("#vbarcode");
        var validBtn = $("#valid_vente_btn");

        validBtn.click(function (e) {
            e.preventDefault();
            const find = ventes_datas.find(
                (d) => d.barcode == validInput.val()
            );
            if (find) {
                validBtn.hide();
                $("#s_iphone_prix").val(find.prix);
                $("#info_vente").html(`
                    <p class="m-0">Nom du modele : ${find.modele}</p>
                    <p class="m-0">Type : ${find.type}</p>
                    <p class="m-0">Memoire : ${find.memoire}</p>
                `);
            } else {
                if (validInput.val().length > 2) {
                    alert("Iphone introuvable");
                    validInput.val("");
                }
            }
        });
    }

    // Verification de l'iphone lors du retour
    const retour_datas = $("#datas_iphones").data("datas_iphones");
    if (Array.isArray(retour_datas)) {
        var validInput = $("#barcode");
        var validBtn = $("#valid_retour_btn");
        var submitBtn = $("#retour_submit_btn");
        submitBtn.hide();

        validBtn.click(function (e) {
            e.preventDefault();
            const find = retour_datas.find(
                (d) => d.barcode == validInput.val()
            );
            if (find) {
                console.log(find);
                validBtn.hide();
                submitBtn.show();
                $("#info_retour").html(`
                    <p class="m-0">Nom du modele : ${find.modele}</p>
                    <p class="m-0">Type : ${find.type}</p>
                    <p class="m-0">Memoire : ${find.memoire}</p>
                    <p class="m-0">Client : ${find.client}</p>
                    <p class="m-0">Date : ${new Date(
                        find.date_vente
                    ).toLocaleString()}</p>
                `);
            }
        });
    }
});
