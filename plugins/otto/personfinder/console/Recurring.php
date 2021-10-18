<?php

namespace Otto\Personfinder\Console;

use Carbon\Carbon;
use d2c\Payment\Models\Payment;
use Illuminate\Console\Command;
use Otto\Personfinder\Models\Subscription;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Recurring extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'simplepay:recurring';

    /**
     * @var string The console command description.
     */
    protected $description = 'Send a recurring';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $subscriptions = $this->getSubscription(Carbon::now());

        $subscriptions->each(function (Subscription $subscription) {
            (new \Otto\Personfinder\Classes\Recurring())->process($subscription);
        });
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    public function getSubscription(Carbon $date)
    {
        $subscriptions = Subscription::where('status_id', 2)
            ->whereDate('recurring_next_billing_date', $date->format('Y-m-d'))
            ->whereDate('recurring_final_payment_date', '>', $date->format('Y-m-d'))
            ->get();

        return $subscriptions;
    }
}
