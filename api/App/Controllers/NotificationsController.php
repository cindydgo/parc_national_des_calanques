<?php
namespace App\Controllers;

use App\Models\NotificationModel;
use Core\ApiResponse;

final class NotificationsController
{
    private NotificationModel $model;

    public function __construct()
    {
        $this->model = new NotificationModel();
    }

    /**
     * GET /api/notifications
     * Get all notifications with optional filters
     * @param array $filters Filters to apply
     * @return void
     */
    public function index(array $filters = []): void
    {
        unset($filters['resource']);
        $notifications = $this->model->getNotifications($filters);
        ApiResponse::success('Liste des notifications récupérée', $notifications, 200);
    }

    /**
     * GET /api/notifications/{id}
     * Get a single notification by ID
     * @param int $id Notification ID
     * @return void
     */
    public function show(int $id): void
    {
        $notification = $this->model->getNotification($id);
        ApiResponse::success('Notification trouvée', $notification, 200);
    }

    /**
     * POST /api/notifications
     * Create a new notification
     * @param array $data Notification data
     * @return void
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
     * Update an existing notification
     * @param int $id Notification ID
     * @param array $data Notification data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $notification = $this->model->updateNotification($id, $data);

        if ($notification) {
            ApiResponse::success("Notification mise à jour avec succès", $data, 200);
        } else {
            ApiResponse::error("Erreur lors de la mise à jour de la notification", [], 500);
        }
    }

    /**
     * DELETE /api/notifications/{id}
     * Delete a notification by ID
     * @param int $id Notification ID
     * @return void
     */
    public function delete(int $id): void
    {
        $notification = $this->model->deleteNotification($id);

        if ($notification) {
            ApiResponse::success("Notification supprimée avec succès", [], 200);
        } else {
            ApiResponse::error("Erreur lors de la suppression de la notification", [], 500);
        }
    }
}
