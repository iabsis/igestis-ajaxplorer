<?php

/**
 * Hook listener for the roundcube module
 *
 * @author Gilles Hemmerlé
 */
namespace Igestis\Modules\Ajaxplorer;

/**
 * Hook listener for the Samba module
 */
class ConfigHookListener implements \Igestis\Interfaces\HookListenerInterface  {
    /**
     * 
     * @param string $HookName The name of the hook  that was fired
     * @param \Igestis\Types\HookParameters $params List of parameters sent by the hook to all the listeners
     * @return boolean True if the hook was intercepted by this listener, false else ...
     */
    public static function listen($HookName, \Igestis\Types\HookParameters $params = null) {
        switch($HookName) {
            case "loginSuccess" :
                AjaxplorerAuthentication::login($params);
                return true;
                break;         
            case "afterLogout" :
                AjaxplorerAuthentication::logout();
                return true;
                break;
            case "contactUpdated" :
                AjaxplorerAuthentication::updateContact($params);
                return true;
                break;
        }
        /*
        switch ($HookName) {
            // Fired when a contact was updated and stored in the ldap database
            
            case "afterContactLdapSave" :
                new SambaLdapUpdate($params->get("contact"));
                return true;
                break;
            // Default, do nothing
            case "command" :
                $application = $params->get("application");
                $application->add(new SambaCommand);
                return true;
                break;
            default:
                break;
        }
        */
        
        // If gone here, the hook has not been managed
        return false;
    }
}