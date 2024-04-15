"use strict";
import { registerTable } from "./helpers.js";

$(document).ready(function () {
    // registrer le data table avec la class="data-table"
    registerTable("dt");

    // rendre dynamique l'ajout d'iphone en positionnant
    $("#s_iphone_select").change(function (e) {
        e.preventDefault();
        var elQte = $("#s_iphone_qte");
        var elPrix = $("#s_iphone_prix");
        var _selected = $(this).find(`option[value=${$(this).val()}]`);
        elQte.val(1);
        elPrix.val(_selected.data("modele")["m_prix"]);
    });

    // Scanne des retours d'iphones
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

    // Scanne des ventes d'iphones
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
                    <p class="m-0">Couleur : ${find.couleur}</p>
                `);
            } else {
                if (validInput.val().length > 5) {
                    alert("L'iphone est vendu ou echanger !");
                    validInput.val("");
                }
            }
        });
    }

    // MODALS
    // $(".editModeleBtn").click(function () {
    //     var modal = $("#editModele");
    //     var datas = $(this).data("data");

    //     var id = datas["m_id"];
    //     var _token = modal.find("input[name='_token']").val();
    //     console.log(_token);

    //     modal.find("#nom").val(datas["m_nom"]);
    //     modal.find("#couleur").val(datas["m_couleur"]);
    //     modal.find("#type").val(datas["m_type"]);
    //     modal.find("#memoire").val(datas["m_memoire"]);
    //     modal.find("#prix").val(datas["m_prix"]);
    //     modal.find("#annee").val(datas["m_annee"]);
    //     modal.find("#numero").val(datas["m_numero"]);

    //     console.log(datas);
    //     modal.find('button[type="button"]').click(function () {
    //         // requetes ajax ici
    //         $.ajax({
    //             type: "POST",
    //             url: "/modele/" + id,
    //             data: {
    //                 _token: _token,
    //                 _method: "PUT",
    //             },
    //             dataType: "json",
    //             success: function (response) {
    //                 console.log(response);
    //             },
    //             error: function (error) {
    //                 console.log(error);
    //             },
    //         });
    //     });
    // });
});
