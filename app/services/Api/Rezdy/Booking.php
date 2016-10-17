<?php

namespace services\Api\Rezdy;

use Carbon\Carbon;

class Booking extends \services\Api\Rezdy
{
    public function addBooking(array $data)
    {
        $response = $this->post('bookings', $data);
        if (!empty($response['errorMessage'])) {
            return [
                'error' => $response['errorMessage'],
            ];
        }

        foreach ($response['booking']['items'] as &$item) {
            $item['startTimeUtc'] = $item['startTime'];
            $item['endTimeUtc'] = $item['endTime'];
            $item['startTime'] = Carbon::createFromTimestampUTC(strtotime($item['startTimeUtc']))->timezone('Australia/Brisbane')->toDateTimeString();
            $item['endTime'] = Carbon::createFromTimestampUTC(strtotime($item['endTimeUtc']))->timezone('Australia/Brisbane')->toDateTimeString();
        }

        return $response['booking'];
    }

    public function deleteBooking($code)
    {
        return $this->delete('bookings/'.$code);
    }

    public function getBooking($code)
    {
        $response = $this->get('bookings/'.$code);
        pd('getBooking', $code, $response);

        return $response['product'];
    }

    public function getBookings(array $params = [])
    {
        $data = [];
        if (!empty($params['orderStatus'])) {
            $data['orderStatus'] = $params['orderStatus'];
        }
        if (!empty($params['search'])) {
            $data['search'] = $params['search'];
        }
        $response = $this->get('bookings', $data);

        return $response['bookings'];
    }
}
