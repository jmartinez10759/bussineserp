<?php

namespace App\Events;

use App\SysNotifications;
use App\SysOrders;
use Illuminate\Broadcasting\Channel;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvents extends Notification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $title;

    /**
     * Create a new event instance.
     *
     * @param SysNotifications $notify
     */
    public function __construct(SysNotifications $notify)
    {
        $this->title = $notify->title;
        $this->message = $notify->message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications'];
    }

    public function broadcastAs()
    {
        return 'notification-event';
    }

}
