<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notification extends BaseController {
    private $notificationModel;

    public function __construct(){
        $this -> notificationModel = new NotificationModel();
    }

    public function markRead(){
        if (!$this -> request -> isAJAX() || !session() -> get("userId")) {
            $data = [
                'error' => 'Forbidden',
                'csrf_token' => csrf_hash() // Get the newest token
            ];
            return $this -> response -> setStatusCode(403)->setJSON($data);
        }

        $userId = session() -> get("userId");
        if (!$userId) {
            return $this -> response -> setStatusCode(401) -> setJSON(['error' => 'Unauthenticated']);
        }

        $success = $this -> notificationModel -> markAllAsRead($userId);

        if ($success) {
            $data = [
                'success' => true,
                'message' => 'Notifications marked as read.',
                'csrf_token' => csrf_hash() // Add the NEW token to the response
            ];
            return $this->response->setJSON($data);
        } else {
            $data = [
                'error' => 'Update failed',
                'csrf_token' => csrf_hash() // Also send a new token on failure
            ];
            return $this->response->setStatusCode(500)->setJSON($data);
        }
    }
}