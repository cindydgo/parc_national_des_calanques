<?php
namespace App\Models;

use Core\Model;

final class NotificationModel extends Model
{
    public function __construct()
    {
        parent::__construct('notifications');
    }

    /**
     * Get all notifications with optional filters
     * @param array $filters Filters to apply
     * @return array
     */
    public function getNotifications(array $filters = []): array
    {
        $notifications = $this->all($filters);

        return $notifications;
    }

    /**
    * Get a single notification by ID
     * @param int $id Notification ID
     * @return array|null
     */
    public function getNotification(int $id): ?array
    {
        $notification = $this->find($id);

        return $notification;
    }

    /**
    * Create a new notification
     * @param array $data Notification data
     * @return bool
     */
    public function createNotification(array $data): bool
    {
        return $this->create($data);
    }

    /**
     * Update an existing notification
     * @param int $id Notification ID
     * @param array $data Notification data
     * @return bool
     */
    public function updateNotification(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a notification
     * @param int $id Notification ID
     * @return bool
     */
    public function deleteNotification(int $id): bool
    {
        return $this->delete($id);
    }
}
