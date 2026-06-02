<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubscriber extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'status',
        'ip_address',
        'user_agent',
        'confirmed_at',
        'unsubscribed_at',
        'unsubscribe_reason',
        'emails_sent',
        'emails_opened',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'confirmed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_UNSUBSCRIBED = 'unsubscribed';
    const STATUS_BOUNCED = 'bounced';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            // Auto-confirm if not in pending mode
            if (config('app.newsletter_auto_confirm', false)) {
                $subscriber->status = self::STATUS_ACTIVE;
                $subscriber->confirmed_at = now();
            }
        });
    }

    /**
     * Scope a query to only include active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include pending subscribers.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Subscribe an email address.
     */
    public static function subscribe(string $email, string $name = null, array $metadata = []): self
    {
        $subscriber = static::firstOrNew(['email' => $email]);
        
        // If previously unsubscribed, reactivate
        if ($subscriber->exists && $subscriber->status === self::STATUS_UNSUBSCRIBED) {
            $subscriber->status = self::STATUS_PENDING;
            $subscriber->unsubscribed_at = null;
            $subscriber->unsubscribe_reason = null;
        }

        $subscriber->fill(array_merge([
            'name' => $name,
            'ip_address' => $metadata['ip_address'] ?? null,
            'user_agent' => $metadata['user_agent'] ?? null,
        ], $metadata));

        $subscriber->save();

        return $subscriber;
    }

    /**
     * Confirm the subscription.
     */
    public function confirm(): void
    {
        if ($this->status === self::STATUS_PENDING) {
            $this->update([
                'status' => self::STATUS_ACTIVE,
                'confirmed_at' => now(),
            ]);
        }
    }

    /**
     * Unsubscribe the user.
     */
    public function unsubscribe(string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
            'unsubscribe_reason' => $reason,
        ]);
    }

    /**
     * Mark as bounced.
     */
    public function markAsBounced(): void
    {
        $this->update(['status' => self::STATUS_BOUNCED]);
    }

    /**
     * Increment email sent count.
     */
    public function incrementEmailsSent(int $amount = 1): void
    {
        $this->increment('emails_sent', $amount);
    }

    /**
     * Increment email opened count.
     */
    public function incrementEmailsOpened(int $amount = 1): void
    {
        $this->increment('emails_opened', $amount);
    }

    /**
     * Check if subscriber is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
