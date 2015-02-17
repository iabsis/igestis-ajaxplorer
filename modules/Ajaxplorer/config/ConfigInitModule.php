<?php
// config/ConfigInitModule.php

// Le fichier de config se trouve dans le namespace du module
namespace Igestis\Modules\Ajaxplorer;

/* 
 * La classe ConfigInitModule sera lancée par le coeur de l'application à différents moments,
 * afin de  rapatrier la liste des droits ou les entrées du menu.
 * Il est conseillé d'implémenter les interfaces ConfigMenuInterface et
 * ConfigRightsListInterface afin que votre logiciel puisse aisément vous aider à compléter
 * les méthodes abstraites.
 */
class ConfigInitModule implements \Igestis\Interfaces\ConfigMenuInterface, \Igestis\Interfaces\ConfigRightsListInterface {

    /* Ajoute au menu les différentes url, inutile de faire des vérifications des droits, 
     * le core ne les affichera automatiquement que pour les personnes aillant le droit 
     * d'accéder à la page.
     */
    public static function menuSet(\Application $context, \IgestisMenu &$menu) {
        /**
         * $menu->additem prend 3 paramètres
         * - Le nom du menu de la racine dans lequel placer l'entrée (ici dans le menu Modules)
         * - Le nom de l'entrée dans le menu (ici on crée l'entrée tickets dans le menu Modules)
         * - La route à lancer
         */
        $menu->addItem(
                dgettext(ConfigModuleVars::textDomain, "Documents"), 
                dgettext(ConfigModuleVars::textDomain, "File manager"), 
                "ajaxplorer_index"
        );
        
        $menu->addItem(
                dgettext(ConfigModuleVars::textDomain, "Administration"), 
                dgettext(ConfigModuleVars::textDomain, "Shared folders"), 
                "ajaxplorer_shared_folders_index"
        );
    }

    public static function getRightsList() {
        $module =   array(
            /* MODULE_NAME 
             * contient la référence de l'application que le core a besoin de connaitre */
            "MODULE_NAME" => ConfigModuleVars::moduleName,
            /* MODULE_FULL_NAME 
             * contient le nom de l'application tel qu'affiché dans la gestion des droits */
            "MODULE_FULL_NAME" => _(ConfigModuleVars::moduleShowedName),
            /* RIGHTS_LIST 
             * contient la liste des droits qu'on va définir plus bas */
            "RIGHTS_LIST" => NULL);
        
        /* On définit maintenant la liste des droits */
        $module['RIGHTS_LIST'] =  array(
            /* Premier droit "None"*/
            array(
                "CODE" => "NONE",
                "NAME" => "None",
                "DESCRIPTION" => "The user has no access to this module"
            ),
            array(
                "CODE" => "ADMIN",
                "NAME" => "Administrator",
                "DESCRIPTION" => "The user can create sharing folders and browse networking files"
            ),
            array(
                "CODE" => "EMP",
                "NAME" => "Employee",
                "DESCRIPTION" => "User can only browse and create files and folder on its shared network folders"
            )
        );
        
        return $module;
    }
    
}

