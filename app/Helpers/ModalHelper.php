<?php

namespace App\Helpers;

class ModalHelper
{
    // boutton pour afficher le modal
    public static function trigger(string $id, string $label, string $tclass): void
    {
        echo '
            <button type="button" id="' . $id . 'Btn" class="btn ' . ($tclass ? $tclass : 'btn btn-sm btn-primary ') . ' " data-bs-toggle="modal"
                data-bs-target="#' . $id . '">
                ' . $label . '
            </button>
        ';
    }

    // boutton d'action du formulaire
    public static function action(string $id, string $label, mixed $datas, string $aclass)
    {

        $attrs = "";
        if (!empty($datas)) {
            foreach ($datas as $dtkey => $dtvalue) {
                $attrs .= 'data-' . $dtkey . '="' . htmlentities($dtvalue) . '"';
            }
        }

        echo '
        <a role="button" class="' . $id . 'Btn ' . (!empty($aclass) ? $aclass : 'btn btn-sm btn-primary rounded-circle ') . '"
            data-bs-toggle="modal"
            data-bs-target="#' . $id . ' " ' . $attrs . ' >
            ' . $label . '
        </a>
        ';
    }
}
