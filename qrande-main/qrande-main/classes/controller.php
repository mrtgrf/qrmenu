<?php

class Controller {
    protected $db;
    protected $currentLicense;
    protected $currentUser;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->loadCurrentLicense();
        $this->loadCurrentUser();
    }
    
    protected function loadCurrentLicense() {
        if (isset($_SESSION["license_key"])) {
            $this->currentLicense = checkLicense($_SESSION["license_key"]);
        }
    }
    
    protected function loadCurrentUser() {
        if (isset($_SESSION["user_id"]) && $this->currentLicense) {
            $this->currentUser = $this->db->fetchOne(
                "SELECT * FROM admin_users WHERE id = ? AND license_id = ?",
                [$_SESSION["user_id"], $this->currentLicense["id"]]
            );
        }
    }
    
    protected function requireAuth() {
        if (!$this->currentUser) {
            $this->redirect("admin/login");
        }
    }
    
    protected function requireLicense() {
        if (!$this->currentLicense) {
            $this->redirect("license-expired");
        }
    }
    
    protected function view($viewName, $data = []) {
        extract($data);
        require_once __DIR__ . "/../views/{$viewName}.php";
    }
    
    protected function json($data, $status = 200) {
        jsonResponse($data, $status);
    }

    protected function redirect($url) {
        header("Location: /" . ltrim($url, "/"));
        exit();
    }
}
?>
