<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Repository\WorkLog;

use TijmenWierenga\Project\Common\Domain\Event\EventStore;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Exception\ModelNotFoundException;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLog;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogRepository;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventSourcedWorkLogRepository implements WorkLogRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * EventSourcedWorkLogRepository constructor.
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * Finds a WorkLog by WorkLogId
     *
     * @param WorkLogId $workLogId
     * @throws ModelNotFoundException
     * @return WorkLog
     */
    public function find(WorkLogId $workLogId): WorkLog
    {
        $eventStream = $this->eventStore->getEventsFor($workLogId);

        if (! count($eventStream->getEvents())) {
            throw ModelNotFoundException::byId(WorkLog::class, $workLogId);
        }

        return WorkLog::reconstitute($eventStream);
    }

    /**
     * Stores a WorkLog.
     *
     * @param WorkLog $workLog
     */
    public function save(WorkLog $workLog): void
    {
        $events = $workLog->recordedEvents();

        $this->eventStore->append(new EventStream($workLog->getWorkLogId(), $events));

        $workLog->clearEvents();
    }
}
