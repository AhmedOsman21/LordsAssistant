<?php

class KvkCalculator {
    private $points;
    private $rss_type;
    private $rss_types;
    private $rss_amount = 0;

    public function __construct(
        $points,  
        $rss_type, 
        $rss_types = array("food" => 120,"stone" => 180,"timber" => 180,"ore" => 240,"gold" => 330)
    ) {
        $this->points = $points;
        $this->rss_type = $rss_type;
        $this->rss_types = $rss_types;
    }

    public function calculate() {
        // Get Resource Points.
        $rss_pts = $this->rss_types[$this->rss_type];

        for ($i = 0; $i < $this->points; $i += $rss_pts) {
            $this->rss_amount += 1000;
        }
        return $this->rss_amount;
    }
}