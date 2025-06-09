<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notification extends BaseController {
    private $notificationModel;

    public function __construct(){
        $this -> notificationModel = new NotificationModel();
    }

    public function markRead(){
        if (!$this -> request -> isAJAX()) {
            return $this -> response-> setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $userId = session() -> get("userId");
        if (!$userId) {
            return $this -> response -> setStatusCode(401) -> setJSON(['error' => 'Unauthenticated']);
        }

        log_message('error', '[DEBUG] AJAX call to markRead. UserID is: ' . ($userId ?? 'NULL'));

        $success = $this -> notificationModel -> markAllAsRead($userId);

        if ($success) {
            return $this -> response -> setJSON(['success' => true]);
        } else {
            return $this -> response -> setStatusCode(500) -> setJSON(['error' => 'Update failed']);
        }
    }
}