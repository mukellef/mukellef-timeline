<?php

namespace Mukellef\Timeline;

use Mukellef\Timeline\Models\Event;
use Mukellef\Timeline\Models\History;
use Mukellef\Timeline\Services\EventService;
use Mukellef\Timeline\Services\HistoryService;
use Mukellef\Timeline\Traits\Eventable;

class Timeline
{
    /**
     * @var \Mukellef\Timeline\Services\EventService
     */
    private $eventService;

    /**
     * @var \Mukellef\Timeline\Services\HistoryService
     */
    private $historyService;

    public function __construct(EventService $eventService, HistoryService $historyService)
    {
        $this->eventService = $eventService;
        $this->historyService = $historyService;
    }

    /**
     * Create Timeline
     *
     * @param  Eventable[]  $participants
     * @param  string|null  $initialState
     * @return \Illuminate\Database\Eloquent\Model|History
     */
    public function create(array $participants = [], string $initialState = null)
    {
        $history = $this->historyService->start($participants, $initialState);

        $this->set($history);

        return $history;
    }

    /**
     * Set Timeline
     *
     * @param  History  $history
     * @return HistoryService
     */
    public function set(History $history): HistoryService
    {
        return $this->historyService->setHistory($history);
    }

    /**
     * Set event message
     *
     * @param  string|Event  $event
     *
     * @return EventService
     */
    public function event($event): EventService
    {
        return $this->eventService->setEvent($event);
    }

    /**
     * Get EventService
     *
     * @return EventService
     */
    public function events(): EventService
    {
        return $this->eventService;
    }

    /**
     * Get HistoryService
     *
     * @param  History|null  $history
     *
     * @return HistoryService
     */
    public function history(History $history = null): HistoryService
    {
        if ($history) {
            $this->set($history);
        }

        return $this->historyService;
    }

}
