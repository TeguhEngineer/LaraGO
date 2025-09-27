<?php

namespace App\Broadcasting;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhatsAppStatusChannel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $deviceInfo;
    public $userId;

    public function __construct($status, $deviceInfo = null, $userId = null)
    {
        $this->status = $status;
        $this->deviceInfo = $deviceInfo;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('whatsapp-status.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'status.updated';
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
            'device_info' => $this->deviceInfo,
            'timestamp' => now()->toISOString()
        ];
    }
}
