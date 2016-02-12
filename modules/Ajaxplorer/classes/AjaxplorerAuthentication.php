<?php

namespace Igestis\Modules\Ajaxplorer;

/**
 * Description of AjaxplorerAuthentication
 *
 * @author Gilles Hemmerlé <giloux@gmail.com>
 */

class AjaxplorerAuthentication {
    /**
     * Start login process into the ajaxplorer database and synchronize all datas
     * @global type $AJXP_GLUE_GLOBALS
     * @param \Igestis\Types\HookParameters $params
     */
    public static function login(\Igestis\Types\HookParameters $params) {
        if($params->get('logedContact')->getUser()->getUserType() != \CoreUsers::USER_TYPE_EMPLOYEE) return;

        \ConfigControllers::get();

        $glueCode = dirname(__FILE__) . "/../../../public/modules/Ajaxplorer/ajaxplorer/plugins/auth.remote/glueCode.php";
    	$secret = ConfigModuleVars::glueCodeSecret;
    	if(!defined('AJXP_EXEC')) define('AJXP_EXEC', true);

        $securityObject = $params->get("securityObject");
        if($securityObject->hasAccess(\IgestisConfigController::getRoute("ajaxplorer_index"))) {
            self::updateUser($params);
        }
        else {
            self::deleteUser($params->get("postLogin"));
            return;
        }

    	global $AJXP_GLUE_GLOBALS;
    	$AJXP_GLUE_GLOBALS = array();
    	$AJXP_GLUE_GLOBALS["secret"] = $secret;
    	$AJXP_GLUE_GLOBALS["plugInAction"] = "login";
        $AJXP_GLUE_GLOBALS["autoCreate"] = true;

        $AJXP_GLUE_GLOBALS["login"] = array(
            "name" => $params->get("postLogin"),
            "password" => $params->get("postPassword")
        );
       	require($glueCode);

    }

    public static function updateContact(\Igestis\Types\HookParameters $params) {
        $glueCode = dirname(__FILE__) . "/../../../public/modules/Ajaxplorer/ajaxplorer/plugins/auth.remote/glueCode.php";
    	$secret = ConfigModuleVars::glueCodeSecret;
    	if(!defined('AJXP_EXEC')) define('AJXP_EXEC', true);

    	global $AJXP_GLUE_GLOBALS;
    	$AJXP_GLUE_GLOBALS = array();
    	$AJXP_GLUE_GLOBALS["secret"] = $secret;
    	$AJXP_GLUE_GLOBALS["plugInAction"] = "updateUser";
            $AJXP_GLUE_GLOBALS["autoCreate"] = true;


        $contact = $params->get("contact");
        $securityObject =  \IgestisSecurity::init();

        $route = \IgestisConfigController::getRoute("ajaxplorer_index");
        $accessName = $securityObject->module_access(ConfigModuleVars::moduleName, $contact->getId());
        $fullAccessName = strtoupper(ConfigModuleVars::moduleName . ":" . $accessName);

        if($contact->getUser()->getUserType() != \CoreUsers::USER_TYPE_EMPLOYEE || !in_array($fullAccessName, $route['Access']) || $contact->getUser()->getIsActive() == 0) {
            self::deleteUser($contact->getLogin());
            return;
        }

        $AJXP_GLUE_GLOBALS["user"] = array(
            "name" => $contact->getLogin(),
            "password" => $contact->getPassword(),
            "right" => ($accessName == "ADMIN" ? "admin" : "")
        );



        $AJXP_GLUE_GLOBALS["user"] ['email'] = $contact->getEmail();
        if ($contact->getCountryCode() == null) {
            $AJXP_GLUE_GLOBALS["user"] ['country'] = '';
        } else {
            $AJXP_GLUE_GLOBALS["user"] ['country'] = $contact->getCountryCode();
        }

       	require($glueCode);
    }

    /**
     * Logout the current user from the ajaxplorer application
     * @global \Igestis\Modules\Ajaxplorer\type $AJXP_GLUE_GLOBALS
     */
    public static function logout() {
        $glueCode = dirname(__FILE__) . "/../../../public/modules/Ajaxplorer/ajaxplorer/plugins/auth.remote/glueCode.php";
    	$secret = ConfigModuleVars::glueCodeSecret;
    	if(!defined('AJXP_EXEC')) define('AJXP_EXEC', true);

    	global $AJXP_GLUE_GLOBALS;
    	$AJXP_GLUE_GLOBALS = array();
    	$AJXP_GLUE_GLOBALS["secret"] = $secret;
    	$AJXP_GLUE_GLOBALS["plugInAction"] = "logout";
       	require($glueCode);
    }

    /**
     * Update datas of the authenticated user in the ajaxplorer database
     * @global \Igestis\Modules\Ajaxplorer\type $AJXP_GLUE_GLOBALS
     * @param \Igestis\Types\HookParameters $params
     */
    private static function updateUser(\Igestis\Types\HookParameters $params) {
        $glueCode = dirname(__FILE__) . "/../../../public/modules/Ajaxplorer/ajaxplorer/plugins/auth.remote/glueCode.php";
    	$secret = ConfigModuleVars::glueCodeSecret;
    	if(!defined('AJXP_EXEC')) define('AJXP_EXEC', true);


    	global $AJXP_GLUE_GLOBALS;
    	$AJXP_GLUE_GLOBALS = array();
    	$AJXP_GLUE_GLOBALS["secret"] = $secret;
    	$AJXP_GLUE_GLOBALS["plugInAction"] = "updateUser";
        $AJXP_GLUE_GLOBALS["autoCreate"] = true;

        $_em =\Application::getEntityMaanger();
        /* @var $CoreContacts \CoreContacts */
        $CoreContacts = $_em->getRepository("CoreContacts")->findOneBy(array("login" => $params->get("postLogin")));


        $securityObject = $params->get("securityObject");
        $AJXP_GLUE_GLOBALS["user"] = array(
            "name" => $params->get("postLogin"),
            "password" => $params->get("postPassword"),
            "right" => ($securityObject->module_access(ConfigModuleVars::moduleName) == "ADMIN" ? "admin" : "")
        );


        $AJXP_GLUE_GLOBALS["user"] ['email'] = $CoreContacts->getEmail();
        if($CoreContacts->getCountryCode() == null) {
            $AJXP_GLUE_GLOBALS["user"] ['country'] = '';
        }
        else {
            $AJXP_GLUE_GLOBALS["user"] ['country'] = $CoreContacts->getCountryCode();
        }


   	require($glueCode);
    }

    /**
     * Delete the authenticated user from the ajaxplorer database
     * @global \Igestis\Modules\Ajaxplorer\type $AJXP_GLUE_GLOBALS
     * @param \Igestis\Types\HookParameters $params
     */
    private static function deleteUser($login) {
        $glueCode = dirname(__FILE__) . "/../../../public/modules/Ajaxplorer/ajaxplorer/plugins/auth.remote/glueCode.php";
    	$secret = ConfigModuleVars::glueCodeSecret;
    	if(!defined('AJXP_EXEC')) define('AJXP_EXEC', true);

    	global $AJXP_GLUE_GLOBALS;
    	$AJXP_GLUE_GLOBALS = array();
    	$AJXP_GLUE_GLOBALS["secret"] = $secret;
    	$AJXP_GLUE_GLOBALS["plugInAction"] = "delUser";
        $AJXP_GLUE_GLOBALS["userName"] = $login;

       	require($glueCode);
    }
}
