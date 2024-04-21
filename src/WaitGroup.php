<?php

namespace Visry;

class WaitGroup
{
    protected int $count = 0;

    /**
     * @param int $delta
     * @return void
     */
    public function add(int $delta = 1): void
    {
        $this->count += $delta;
    }

    /**
     * @param int $delta
     * @return void
     */
    public function done(int $delta = 1): void
    {
        $this->count -= $delta;
        if ($this->count < 0) {
            $this->count = 0;
        }
    }

    /**
     * @return void
     */
    public function wait(): void
    {
        while ($this->count > 0) {
            pcntl_wait($status);
            $this->count--;
        }
    }
}
