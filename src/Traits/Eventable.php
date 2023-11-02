<?php

namespace Mukellef\Timeline\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mukellef\Timeline\Models\History;
use Mukellef\Timeline\Models\Participation;

/**
 * Trait Eventable
 *
 * @package Mukellef\Timeline\Traits
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Eventable
{
    public function participation(): MorphMany
    {
        return $this->morphMany(Participation::class, 'eventable');
    }

    public function joinHistory(History $history): void
    {
        $participation = new Participation([
            'history_id'     => $history->getKey(),
            'eventable_id'   => $this->getKey(),
            'eventable_type' => $this->getMorphClass(),
        ]);

        $this->participation()->save($participation);
    }

    public function leaveHistory($historyID): void
    {
        $this->participation()->where([
            'history_id'     => $historyID,
            'eventable_id'   => $this->getKey(),
            'eventable_type' => $this->getMorphClass(),
        ])->delete();
    }

    public function isTimelineInitiator(): bool
    {
        return in_array(TimelineInitiator::class, class_uses_recursive($this));
    }

}
