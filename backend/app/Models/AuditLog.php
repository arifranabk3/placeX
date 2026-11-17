<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'ip_address',
        'user_agent',
        'payload',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function log(string $action, string $entityType, ?int $entityId = null, ?array $payload = null, ?int $userId = null): self
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'ip_address' => request() ? request()->ip() : '127.0.0.1',
            'user_agent' => request() ? request()->userAgent() : 'CLI',
            'payload' => $payload,
            'created_at' => now(),
        ]);
    }

    public static function record(string $action, string $entityType, ?int $entityId = null, ?array $payload = null, ?int $userId = null): self
    {
        return self::log($action, $entityType, $entityId, $payload, $userId);
    }
}
