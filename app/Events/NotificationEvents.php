<?php

namespace App\Events;

use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\SysNotifications;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvents implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public $company;

    /**
     * Create a new event instance.
     *
     * @param SysNotifications $notifications
     * @param SysEmpresasModel $company
     */
    public function __construct( SysNotifications $notifications, SysEmpresasModel $company )
    {
        $this->notification = $notifications;
        $this->company = $company;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notifications');
    }
}
