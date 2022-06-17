<?php

class KvkCalculator {
    private $points;
    private $rss_type;
    private $rss_types;
    private $rss_amount = 0;

    /**
     * Kvk Calculator Constructor Takes Arguments To Perform Calculation
     *
     * @param integer $points Remain points in kvk event.
     * @param string $rss_type Chosen resource type.
     * @param array $rss_types Array of resources type and their points.
     * 
     * @return void
     */
    public function __construct(
        $points,
        $rss_type,
        $rss_types = array("food" => 120, "stone" => 180, "timber" => 180, "ore" => 240, "gold" => 330)
    ) {
        $this->points = $points;
        $this->rss_type = $rss_type;
        $this->rss_types = $rss_types;
    }

    /**
     * Calculate method performs kvk calculation to get the resource amount that player should gather.
     * 
     * @return integer The resource amount that user should gather.
     * 
     */

    public function calculate() {
        // Get Resource Points.
        $rss_pts = $this->rss_types[$this->rss_type];

        for ($i = 0; $i < $this->points; $i += $rss_pts) {
            $this->rss_amount += 1000;
        }
        return $this->rss_amount;
    }
}
