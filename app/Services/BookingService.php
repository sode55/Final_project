<?php

namespace App\Services;

class BookingService
{
    public function seatList(array $unavailableSeats, $capacity)
    {
        foreach ($unavailableSeats as $seat => $gender) {
            $seatArray[] = explode(',', $seat);
            $singleSeatArray = array_reduce($seatArray, 'array_merge', array());
            $genderArray[] = explode(',', $gender);
            $singleGenderArray = array_reduce($genderArray, 'array_merge', array());
            $output[] = ['seat' => $singleSeatArray, 'gender' => $singleGenderArray];
            $singleOutputArray = array_reduce($output, 'array_merge', array());
            $seat = $singleOutputArray['seat'];
            $gender = $singleOutputArray['gender'];
            $reservedSeat = array_combine($seat, $gender);
        }
        $allSeatsArray = array_fill(1, $capacity, '0');
        $availableSeats = array_merge_recursive_distinct($allSeatsArray, $reservedSeat);

        return $availableSeats;
    }
    public function capacity($capacity)
    {
        $emptySeats = array_fill(1, $capacity, '0');

        return $emptySeats;
    }

}
