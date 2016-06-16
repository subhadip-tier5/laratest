<?php namespace Ecomtracker\Semrush\Console\Commands\Keyword;

use Ecomtracker\Semrush\Models\Domain;
use Ecomtracker\Semrush\Models\Keyword;
use Ecomtracker\Source\Models\Source;
use Illuminate\Console\Command;
class BuildRelated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'semrush:build-keyword-related
                            {--keyword_id= : The ID of the keyword model} {--value= : The value of the keyword to be built} {--limit= : Limit the number of results}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build related keywords for keyword';

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
        $limit = $this->option('limit');
        if(!$limit)
        {
            $limit = 10;
        }
        
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
            $this->info('Building Related Keywords: ' . $keyword->value);
            $keyword->save();
            $keyword->updateRelated($limit,true);
            
        }else{
            $this->info('Building Related Keywords: ' . $keyword->value);
            $keyword->updateRelated($limit, true);
        }
    }
}