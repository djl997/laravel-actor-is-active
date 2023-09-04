<?php

namespace Djl997\LaravelActorIsActive\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait IsOnlineTrait
{
    /**
     * Generate the actor online cache key, composed of className and ID.
     */
    protected function getCacheActorOnlineKey()
    {
        return sprintf('%s-%s', Str::of(get_class($this))->replace('\\', '-')->camel(), $this->id);
    }

    /**
     * Gets the latest online_at timestamp of actor, returns Carbon object.
     * If no cache for model is found, return created_at.
     * If created_at is somehow null or not set, fallback to 1970 (never online)
     * 
     */
    public function lastOnlineAt(): Carbon
    {
        if (empty($cache = Cache::get($this->getCacheActorOnlineKey()))) {
            return $this->created_at ?? Carbon::create(1970);
        }

        return $cache['online_at'];
    }
    
    /**
     * Get all actors of model which are online (Warning! This can be expensive!)
     */
    // public function allOnline()
    // {
    //     return $this->all()->filter->isOnline();
    // }

    /**
     * Check if actor is currenty online (true if last updated time is less or equal then x minutes)
     */
    public function isOnline(): bool
    {
        return Cache::has($this->getCacheActorOnlineKey()) && $this->lastOnlineAt()->diffInMinutes() <= 5; //TODO: configurable minutes
    }

    /**
     * Check if actor was online recently (true if last updated time was between x minutes ago)
     */
    public function wasOnlineRecently(): bool
    {
        $onlineAt = $this->lastOnlineAt()->diffInMinutes();

        return $onlineAt > 5 && $onlineAt <= 30 ?? false; //TODO: configurable minutes
    }

    /**
     * Touch online value.
     * 
     * @params  int  $seconds
     */
    public function touchOnline(int $seconds = 1800): bool  // TODO: configurable default minutes
    {
        return Cache::put(
            $this->getCacheActorOnlineKey(),
            [
                'online_at' => now()
            ],
            $seconds
        );
    }
}