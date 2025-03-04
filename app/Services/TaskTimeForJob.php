<?php
/**
 * Create: Volodymyr
 */

namespace App\Services;

use Illuminate\Support\Carbon;

class TaskTimeForJob
{
    protected array $times = [];
    protected array $ratios = [];
    protected ?Carbon $date_start = null;
    protected int $hour = 0;

    public function __construct(protected $min, protected $max)
    {
        $this->setDateStart(now());
    }

    public function setDateStart(?Carbon $date_start): static
    {
        $this->date_start = $date_start ?? now();
        return $this;
    }

    public function getDateStart(): Carbon
    {
        return $this->date_start;
    }

    public function getRatios(): array
    {
        return $this->ratios;
    }

    public function setRatios(array $ratios): static
    {
        $this->ratios = $ratios;
        return $this;
    }

    public function getRatio(int $hour): float|int
    {
        return $this->ratios[$hour % 24] ?? 1;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function setHour(int $hour): static
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * @return array
     */
    public function getTimes(): array
    {
        if (empty($this->times)) {
            $this->setHour($this->getHour() + 1);
            $ratio = $this->getRatio($this->getDateStart()->clone()->addHours($this->getHour())->hour);

            $counts = rand((int)round($this->min * $ratio), (int)round($this->max * $ratio));
            for ($index = 0; $index < $counts; $index++) {
                $this->times[] = rand(0, 59);
            }
            sort($this->times, SORT_NUMERIC);
        }
        return $this->times;
    }

    protected function getTimeAndReduce()
    {
        $this->getTimes();
        return array_shift($this->times);
    }

    public function getNextTime(): Carbon
    {
        $minute = $this->getTimeAndReduce();

        return $this->getDateStart()
            ->clone()
            ->setSecond(rand(0, 59))
            ->setMinutes($minute)
            ->addHours($this->getHour());
    }

}
