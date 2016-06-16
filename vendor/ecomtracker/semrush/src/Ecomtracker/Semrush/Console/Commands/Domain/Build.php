<?php namespace Ecomtracker\Semrush\Console\Commands\Domain;

use Ecomtracker\Semrush\Models\Domain;
use Ecomtracker\Source\Models\Source;
use Illuminate\Console\Command;
class Build extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'semrush:build-domain
                            {--domain_id= : The ID of the product model} {--domain_name= : The ID of the product model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the build method domain';

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
        $domain_id = $this->option('domain_id');
        $domain_name = $this->option('domain_name');
        if($domain_id)
        {
            $domain = \Ecomtracker\Semrush\Models\Domain::where('id','=',$domain_id)->firstOrFail();
            $domain->build();
            $this->info('Building Domain' . $domain->value);
        }elseif($domain_name){
            //Build a new domain
            $domain = Domain::getModel();
            $domain->value = $domain_name;
            $domain->source_id = Source::where('source','=','Ecomtracker\Semrush\Models\Domain')->first()->id;
            $domain->save();
        }
    }
}