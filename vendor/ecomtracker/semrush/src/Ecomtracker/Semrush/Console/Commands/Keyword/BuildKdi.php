<?php namespace Ecomtracker\Semrush\Console\Commands\Keyword;

use Ecomtracker\Semrush\Models\Domain;
use Ecomtracker\Semrush\Models\Keyword;
use Ecomtracker\Source\Models\Source;
use Illuminate\Console\Command;
class BuildKdi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'semrush:build-keyword-kdi
                            {--keyword_id= : The ID of the keyword model} {--value= : The value of the keyword to be built}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the keyword difficulty index for keyword';

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
        $keyword_id = $this->option('keyword_id');
        $value = $this->option('value');
        
        if($value)
        {
            $keyword = Keyword::where('value','=',$value)->first();
        }

        if(!$keyword && $keyword_id)
        {
            $keyword = Keyword::where('id','=',$keyword_id)->first();
        }
        
        if(!$keyword)
        {
            $keyword = Keyword::getModel();
            $keyword->value = $value;
            $keyword->source_id = Source::where('source','=','Ecomtracker\Semrush\Models\Keyword')->first()->id;
            $this->info('Building Keyword Difficulty: ' . $keyword->value);
            $keyword->save();
            $keyword->buildKdi($keyword->getClient());
            $keyword->save();
            
        }else{
            $this->info('Building Keyword Difficulty: ' . $keyword->value);
            $keyword->buildKdi($keyword->getClient());
            $keyword->save();
        }
    }
}