<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Resources\Admin\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use TraitApiController;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'notifications' => $this->resourceCollection(NotificationResource::class, \Auth::user()->notifications),
            'unread_notifications' => $this->resourceCollection(NotificationResource::class, \Auth::user()->unreadNotifications)
        ]);
    }

    /**
     * Mark as read/unread a notification
     *
     * @param string $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeNotificationStatus(string $notification)
    {
        $this->notificationStatus($notification);

        return $this->success();
    }

    /**
     * Mark many notifications as read/unread
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeNotificationsStatus(Request $request)
    {
        $ids = $this->validateNotificationIds($request);

        foreach ($ids['notifications'] as $id) {
            $this->notificationStatus($id);
        }

        return $this->success();
    }

    /**
     * Notification status
     *
     * @param string $id
     * @return void
     */
    private function notificationStatus(string $id)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Model $notification
         */
        $notification = \Auth::user()->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at) {
            $notification->read_at = null;
            $notification->save();
        } else {
            $notification->markAsRead();
        }
    }

    /**
     * Delete a notification
     *
     * @param string $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $notification)
    {
        $notf = \Auth::user()->notifications()->where('id', $notification)->firstOrFail();

        $notf->delete();

        return $this->success();
    }

    /**
     * Delete many notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMany(Request $request)
    {
        $ids = $this->validateNotificationIds($request);

        foreach ($ids['notifications'] as $id) {
            $ntf = \Auth::user()->notifications()->where('id', $id)->first();
            if ($ntf) {
                $ntf->delete();
            }
        }

        return $this->success();
    }

    /**
     * Validate notification ids
     *
     * @param Request $request
     * @return array
     */
    private function validateNotificationIds(Request $request)
    {
        return \Validator::make($request->all(), [
            'notifications' => ['nullable', 'array'],
            'notifications.*' => ['string']
        ])->validate();
    }
}
