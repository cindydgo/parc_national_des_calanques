<?php
namespace App\Models;

use Core\Model;
use Core\ApiResponse;

final class NotificationModel extends Model
{
    public function __construct()
    {
        parent::__construct('notifications');
    }

    /**
     * Récupérer toutes les notifications
     */
    public function getNotifications(array $filters = []): array
    {
        unset($filters['resource']);
        $notifications = $this->all($filters);

        if (empty($notifications)) {
            ApiResponse::success("Aucune notification trouvée", []);
        }

        return $notifications;
    }

    /**
     * Récupérer une notification par son ID
     */
    public function getNotification(int $id): ?array
    {
        $notification = $this->find($id);

        if (!$notification) {
            ApiResponse::error("Aucune notification trouvée avec l'ID $id", [], 404);
        }

        return $notification;
    }

    /**
     * Créer une nouvelle notification
     */
    public function createNotification(array $data): bool
    {
        if (empty($data['title']) || empty($data['message'])) {
            ApiResponse::error("Les champs 'titre' et 'message' sont requis");
        }

        return $this->create($data);
    }

    /**
     * Mettre à jour une notification existante
     */
    public function updateNotification(int $id, array $data): bool
    {
        $notification = $this->find($id);
        if (!$notification) {
            ApiResponse::error("Notification introuvable pour mise à jour", [], 404);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprimer une notification
     */
    public function deleteNotification(int $id): bool
    {
        $notification = $this->find($id);
        if (!$notification) {
            ApiResponse::error("Notification introuvable pour suppression", [], 404);
        }

        return $this->delete($id);
    }
}
