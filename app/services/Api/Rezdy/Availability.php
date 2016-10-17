<?php

namespace services\Api\Rezdy;

class Availability extends \services\Api\Rezdy
{
    public function availability($productCode, $startTime, $endTime = false, $minAvailability = false)
    {
        $params = [
            'productCode' => $productCode,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'limit' => 100,
        ];
        if ($minAvailability) {
            $params['minAvailability'] = $minAvailability;
        }
        $response = $this->get('availability', $params);

        return !empty($response['sessions']) ? $response['sessions'] : [];
    }
}
