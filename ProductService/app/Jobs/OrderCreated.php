<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class OrderCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $message = "order created")
    {
        //
    }

    public function handle(): void
    {
        echo "Product Service :Start: {$this->message} \n";
        sleep(4);
        echo "Product Service :End: {$this->message} \n";

        RabbitMQJob::class;
    }
}
