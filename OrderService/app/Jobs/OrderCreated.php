<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $message = "order created")
    {
        $this->onConnection('rabbitmq');

        $this->onQueue('.order.product.');
    }

    public function handle(): void
    {
        echo "Order Service :Start: {$this->message} \n";
        sleep(10);
        echo "Order Service :End: {$this->message} \n";
    }
}
