<?php

namespace Djl997\LaravelActorIsActive\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait IsOnlineTrait
{

    protected function getCacheActorOnlineKey()
    {
        return sprintf('%s-%s', Str::of(get_class($this))->replace('\\', '-')->camel(), $this->id);
    }

    public function getOnlineAt()
    {
        if (empty($cache = Cache::get($this->getCacheActorOnlineKey()))) {
            return $this->created_at;
        }

        return $cache['online_at'];
    }

    public function isOnline()
    {
        return Cache::has($this->getCacheActorOnlineKey()) && $this->getOnlineAt()->diffInMinutes() <= 5; //TODO: configurable minutes
    }

    public function wasOnlineRecently()
    {
        $onlineAt = $this->getOnlineAt()->diffInMinutes();

        return $onlineAt > 5 && $onlineAt <= 30 ?? false; //TODO: configurable minutes
    }

    public function touchOnline(int $seconds = 1800) // TODO: configurable default minutes
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