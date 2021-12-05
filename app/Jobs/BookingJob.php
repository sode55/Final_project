<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Models\Booking;
use App\Models\User;



class BookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $booking;

//    public $uniqueFor = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking)
    {

        $this->booking = $booking;
    }

//    public function uniqueId()
//    {
//        $this->booking->id;
//    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Booking $bookings, $userId)
    {
        $bookings =  Booking::where('status', 'in_process')->where('user_id', $userId);

                foreach ($bookings as $booking) {

                    $booking->update(['status' => 'confirmed']);
                }

    }
}
