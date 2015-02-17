<?php
// config/ConfigControllers.php

// Le fichier de config se trouve dans le namespace du module
namespace Igestis\Modules\Ajaxplorer;

class ConfigControllers extends \IgestisConfigController {
    /**
     * Retourne un tableau (attention à garder la même syntaxe de tableau)
     * contenant la liste des routes du module.
     * @return Array Liste des routes de ce module
     */
    public static function get() {
        return  array(
            /*********** Routes for the Samba module ***********/
            array(
                "id" => "ajaxplorer_index",
                "Parameters" => array(
                    "Module" => "ajaxplorer",
                    "Action" => "home"
                ),
                "Controller" => "\Igestis\Modules\Ajaxplorer\indexController",
                "Action" => "indexAction",
                "Access" => array("AJAXPLORER:ADMIN", "AJAXPLORER:EMP")
            ),
            
            array(
                "id" => "ajaxplorer_shared_folders_index",
                "Parameters" => array(
                    "Module" => "ajaxplorer_shared_folders",
                    "Action" => "home"
                ),
                "Controller" => "\Igestis\Modules\Ajaxplorer\sharedFoldersController",
                "Action" => "indexAction",
                "Access" => array("AJAXPLORER:ADMIN")
            )
            
         );
    }
}