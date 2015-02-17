<?php
// controllers/indexController.php

// Les controleurs dans le namespace du module
namespace Igestis\Modules\Ajaxplorer;

/**
 * Show the admin page for Samba
 */
class indexController extends \IgestisController {
    /**
     * We show the computer list.
     */
    public function indexAction() {
        // Get list of all computers

        $this->context->render("Ajaxplorer/pages/AjaxplorerHome.twig", array());
    }
}