<?php
/**
 * This class will permitt to set all global variables of the module
 * @Author : Gilles Hemmerlé <gilles.h@iabsis.com>
 */

namespace Igestis\Modules\Ajaxplorer;

define("IGESTIS_AJAXPLORER_VERSION", "0.1-1");
define("IGESTIS_AJAXPLORER_MODULE_NAME", "Ajaxplorer");
define("IGESTIS_AJAXPLORER_TEXTDOMAIN", IGESTIS_AJAXPLORER_MODULE_NAME .  IGESTIS_AJAXPLORER_VERSION);
/**
 * Configuration of the module
 *
 * @author Gilles Hemmerlé
 */
class ConfigModuleVars {

    /**
     * @var String Numéro de version du module
     */
    const version = IGESTIS_AJAXPLORER_VERSION;
    /**
     *
     * @var String Name of the module (used only on the source code) 
     */
    const moduleName = IGESTIS_AJAXPLORER_MODULE_NAME;
    
    /**
     *
     * @var String Name of the menu showed to the user (blank if it is a simple service)
     */
    const moduleShowedName = "File manager";
    
    /**
     *
     * @var String textdomain used for this module
     */
    const textDomain = IGESTIS_AJAXPLORER_TEXTDOMAIN;    
 
    /**
     * @var String Security code for the ajaxplorer applicatioin authentication
     */
    const glueCodeSecret = '93H8D3HF93Y78Fiuhf9HD2';
    
    /**
     * @var sharedFolders Folders where to store the shated folders
     */
    const sharedFolders = "/home/data/shared";
    
    
}
