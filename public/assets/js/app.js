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
});
