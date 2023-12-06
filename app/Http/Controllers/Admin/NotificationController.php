<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Resources\Admin\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller {
    use TraitApiController;

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return $this->success([
            'notifications' => $this->resourceCollection(NotificationResource::class, \Auth::user()->notifications),
            'unread_notifications' => $this->resourceCollection(NotificationResource::class, \Auth::user()->unreadNotifications)
        ]);
    }

    /**
     * Mark as read a notification
     *
     * @param string $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(string $notification) {
        $notf = \Auth::user()->notifications()->where('id', $notification)->firstOrFail();

        $notf->markAsRead();

        return $this->success();
    }

    /**
     * Mark as unread a notification
     *
     * @param string $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsUnread(string $notification) {
        $notf = \Auth::user()->notifications()->where('id', $notification)->firstOrFail();

        $notf->read_at = null;
        $notf->save();

        return $this->success();
    }

    /**
     * Delete a notification
     *
     * @param string $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $notification) {
        $notf = \Auth::user()->notifications()->where('id', $notification)->firstOrFail();

        $notf->delete();

        return $this->success();
    }
}
