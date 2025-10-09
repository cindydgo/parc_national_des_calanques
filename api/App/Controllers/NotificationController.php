<?php
namespace App\Controllers;

use App\Models\NotificationModel;
use Core\ApiResponse;

final class NotificationController
{
    private NotificationModel $model;

    public function __construct()
    {
        $this->model = new NotificationModel();
    }

    /**
     * GET /api/notifications
     */
    public function index(array $filters = []): void
    {
        $notifications = $this->model->getNotifications($filters);
        ApiResponse::success('Liste des notifications récupérée', $notifications);
    }

    /**
     * GET /api/notifications/{id}
     */
    public function show(int $id): void
    {
        $notification = $this->model->getNotification($id);
        ApiResponse::success('Notification trouvée', $notification);
    }

    /**
     * POST /api/notifications
     */
    public function store(array $data): void
    {
        $notification = $this->model->createNotification($data);

        if ($notification) {
            ApiResponse::success('Notification créée avec succès', $data, 201);
        } else {
            ApiResponse::error("Erreur lors de la création de la notification", [], 500);
        }
    }

    /**
     * PUT /api/notifications/{id}
     */
    public function update(int $id, array $data): void
    {
        $notification = $this->model->updateNotification($id, $data);

        if ($notification) {
            ApiResponse::success("Notification mise à jour avec succès");
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de la notification", [], 500);
        }
    }

    /**
     * DELETE /api/notifications/{id}
     */
    public function delete(int $id): void
    {
        $notification = $this->model->deleteNotification($id);

        if ($notification) {
            ApiResponse::success("Notification supprimée avec succès");
        } else {
            ApiResponse::error("Erreur lors de la suppression de la notification", [], 500);
        }
    }
}
