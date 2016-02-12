<?php
/*
 * Copyright 2007-2011 Charles du Jeu <contact (at) cdujeu.me>
 * This file is part of AjaXplorer.
 *
 * AjaXplorer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AjaXplorer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with AjaXplorer.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://www.ajaxplorer.info/>.
 *
 * This is the main configuration file for configuring the basic plugins the application
 * needs to run properly : an Authentication plugin, a Configuration plugin, and a Logger plugin.
 */

defined('AJXP_EXEC') or die( 'Access not allowed');

$PLUGINS = array(
	"CONF_DRIVER" => array(
		"NAME"		=> "serial",
		"OPTIONS"	=> array(
			"REPOSITORIES_FILEPATH"	=> "AJXP_DATA_PATH/plugins/conf.serial/repo.ser",
			"ROLES_FILEPATH"		=> "AJXP_DATA_PATH/plugins/auth.serial/roles.ser",
			"USERS_DIRPATH"			=> "AJXP_DATA_PATH/plugins/auth.serial",
            "FAST_CHECKS"		    => false,
			"CUSTOM_DATA"			=> array(
					"email"	=> "Email",
					"country" => "Country"
				)
			)
	),
        "AUTH_DRIVER" => array(
		"NAME"		=> "remote",
		"OPTIONS"       => array(
			"SLAVE_MODE"  => true,
			"USERS_FILEPATH" => "AJXP_DATA_PATH/users.ser",
			"LOGIN_URL" => \ConfigIgestisGlobalVars::serverAddress() . "/igestis/index.php?Action=login&Force=1",
			"LOGOUT_URL" => \ConfigIgestisGlobalVars::serverAddress() . "/igestis/index.php?Action=login&Force=1",
			"SECRET" => \Igestis\Modules\Ajaxplorer\ConfigModuleVars::glueCodeSecret,
			"TRANSMIT_CLEAR_PASS"   => false )
	),
    "LOG_DRIVER" => array(
         "NAME" => "text",
         "OPTIONS" => array(
             "LOG_PATH" => (defined("AJXP_FORCE_LOGPATH")?AJXP_FORCE_LOGPATH:"AJXP_INSTALL_PATH/data/logs/"),
             "LOG_FILE_NAME" => 'log_' . date('m-d-y') . '.txt',
             "LOG_CHMOD" => 0770
         )
    )
);
