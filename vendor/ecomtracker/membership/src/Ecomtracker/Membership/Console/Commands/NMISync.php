<?php

namespace Ecomtracker\Membership\Console\Commands;
use Ecomtracker\Product\Models\Product as ParentProduct;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;
use Ecomtracker\User\Models\User as User;
use Illuminate\Console\Command;

class NMISync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nmi:sync-transactions
                            {--user_id= : The ID of the user model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync NMI transactions history with local DB table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('SYNC Command launched');

        $user_id = $this->option('user_id');
        $this->info('user_id:'.$user_id);

        if ($user_id)
        {
            $User=User::find($user_id);
            $res=\Ecomtracker\Membership\BillingManager::NMISyncUser($User);
        }
        else
        {
            $res=\Ecomtracker\Membership\BillingManager::NMISyncUsers();
        }


    }
}
