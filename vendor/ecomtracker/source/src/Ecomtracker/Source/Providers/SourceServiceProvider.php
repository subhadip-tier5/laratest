<?php namespace Ecomtracker\Source\Providers;

use Ecomtracker\Source\Models\Source;
use \Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class SourceServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $events)
    {
        $events->listen('eloquent.saved:*', function ($model) {

                    //Our model is a sourced model and therefore we might create a source
                    if(is_subclass_of($model,'Ecomtracker\Source\Models\SourcedModel'))
                    {

                        if(!$model->source && !$model->source_id)
                        {
                            $sourceConfig = Source::where('id','=',$model->source_id)->first();
                            //Create a new Source class instance based on the configuration from the source
                            $newSource = new $sourceConfig->source;
                            $newSource->setEntity($model);
                            $newSource->syncToEntity();
                            $newSource->findOrCreate(['value',$model->value],$newSource->toArray());
                        }else{
                            //Do nothing
                        }

                    }elseif(is_subclass_of($model,'Ecomtracker\Source\Models\SourceModel'))
                    {
                        //If there is no entity for this

                        if(!$model->entity && !$model->entity_id)
                        {

                            $sourceConfig = Source::where('id','=',$model->source_id)->first();
                            $newEntity = new $sourceConfig->entity;

                            $newEntity->syncToSource($model);

                             $newEntity->findOrCreate([['value', $model->value],['source_id',$model->source_id]],$newEntity->toArray());

                        }

                    }
                    else{
                        //Do nothing
//                        dd('we are dealing with something other than a SourcedModel being changed');
                    }
//                    dd('is dirty');







        });

    }





    public function bootz(Dispatcher $events)
    {
        echo "<pre>";
        $events->listen('eloquent.saved:*', function ($model) {
//            var_dump($model->toArray());

            //Class is a sourced model , an entity
            if(is_subclass_of($model,'Ecomtracker\Source\Models\SourcedModel'))
            {
//                var_dump($model->source);
                //if we can retrieve a source 
                if ($model->source != null) {
                    dd("PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAASSSSSSSSSSSSSSSSSSSSSSSSSS");
                    $model->source->setEntity($model)->syncEntity();
                    
                }else{
                   //We dont have an associated source model
                    echo "no source";

                    //Foreach of the configs returned back related to the entity
                    foreach($model->sourceConfig->get() as $sourceConfig)
                    {

                        //Create a new instance of the class value related to the config
                        $newSource = new $sourceConfig->class;
                        //Set the entity to that new instance


                        $newSource->setEntity($model)->syncEntity();
                        $newSource->save();
                        dd('here');


                        //Set the source to the new and sync
                        $model->setSource($newSource)->syncSource();
                        dd('test');
                        dd();
                        dd($model);

                    }


               }

//                var_dump($model->getOriginal());
                echo "1";
                dd($model->toArray());


            }

//            dd(get_class($model));
            //Source is saved
            if(is_subclass_of($model,'Ecomtracker\Source\Models\SourceModel'))
            {
                if($model->source)
                {
                    dd('yep has a source');
                }


                //if we can retrieve an entity
                if ($model->getEntity()) {

                    $model->getEntity()->setSource($model)->syncSource();

                    if($model->isDirty())
                    {
                        $model->save();
                    }
                    echo "dirty";
                    dd($model->getDirty());
                    echo "no dirty";

                    $entity = $model->getEntity();

                    var_dump($model->toArray());
                    var_dump($model->getOriginal());



                    var_dump($model->getEntity()->toArray());
                    var_dump($model->getEntity()->getOriginal());
                    dd();

                    $model->save();

                }

            }



        });

        $packageDir = realpath(__DIR__.'/..');
    }

    public function register()
    {
    }

}