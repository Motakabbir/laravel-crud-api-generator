<?php

namespace Dolar\LaravelApiGenerator;

use Illuminate\Support\Str;

class LaravelApiGenerator
{
    const STUB_DIR = __DIR__.'/resources/stubs/';
    protected $model;
    protected $result = false;

    public function __construct(string $model)
    {
        $this->model = $model;
        self::generate();
    }

    public function generate()
    {
        self::directoryCreate();
        self::generateBasicFiles();
    }

    public function directoryCreate()
    {
        if (! file_exists(base_path('app/Http/Controllers/Api'))) {
            mkdir(base_path('app/Http/Controllers/Api'));
        }
        if (! file_exists(base_path('app/Http/Resources'))) {
            mkdir(base_path('app/Http/Resources'));
        }
        if (! file_exists(base_path('app/Http/Traits'))) {
            mkdir(base_path('app/Http/Traits'));
        }
        if (! file_exists(base_path('app/Http/Requests'))) {
            mkdir(base_path('app/Http/Requests'));
        }
        if (! file_exists(base_path('app/Http/Constants'))) {
            mkdir(base_path('app/Http/Constants'));
        }
    }

    public function generateBasicFiles()
    {
        $this->result = false;
        //Constants generate
        if (! file_exists(base_path('app/Constants/AuthConstants.php'))) {
            $template = self::getStubContents('AuthConstants.stub');
            $template = '';
            file_put_contents(base_path('app/Constants/AuthConstants.php'), $template);
            $this->result = true;
        }
        if (! file_exists(base_path('app/Constants/Constants.php'))) {
            $template = self::getStubContents('Constants.stub');
            $template = '';
            file_put_contents(base_path('app/Constants/Constants.php'), $template);
            $this->result = true;
        }
        if (! file_exists(base_path('app/Constants/ValidationConstants.php'))) {
            $template = self::getStubContents('ValidationConstants.stub');
            $template = '';
            file_put_contents(base_path('app/Constants/ValidationConstants.php'), $template);
            $this->result = true;
        }
        //Traits generate
        if (! file_exists(base_path('app/Http/Traits/Access.php'))) {
            $template = self::getStubContents('Access.stub');
            $template = '';
            file_put_contents(base_path('app/Http/Traits/Access.php'), $template);
            $this->result = true;
        }
        if (! file_exists(base_path('app/Http/Traits/Helper.php'))) {
            $template = self::getStubContents('Helper.stub');
            $template = '';
            file_put_contents(base_path('app/Http/Traits/Helper.php'), $template);
            $this->result = true;
        }
        if (! file_exists(base_path('app/Http/Traits/HttpResponses.php'))) {
            $template = self::getStubContents('HttpResponses.stub');
            $template = '';
            file_put_contents(base_path('app/Http/Traits/HttpResponses.php'), $template);
            $this->result = true;
        }
        //Resources generate
        if (! file_exists(base_path('app/Http/Resources/resource.php'))) {
            $template = self::getStubContents('resource.stub');
            $template = '';
            file_put_contents(base_path('app/Http/Resources/resource.php'), $template);
            $this->result = true;
        }
        return $this->result;
    }

    public function generateController()
    {
        $this->result = false;
        if (! file_exists(base_path('app/Http/Controllers/Api/'.$this->model.'Controller.php'))) {
            $template = self::getStubContents('controller.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->model), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->model), $template);
            $template = str_replace('{{modelNameSpace}}', is_dir(base_path('app/Models')) ? 'Models\\'.$this->model : $this->model, $template);
            file_put_contents(base_path('app/Http/Controllers/Api/'.$this->model.'Controller.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }    

    public function generateStoreRequest()
    {
        $this->result = false;
        if (! file_exists(base_path('app/Http/Requests/'.$this->model.'/Store'.$this->model.'Request.php'))) {
            $model = is_dir(base_path('app/Models')) ? app('App\\Models\\'.$this->model) : app('App\\'.$this->model);
            $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $print_columns = null;
            foreach ($columns as $key => $column) {
                $print_columns .= "'".$column."'".' =>  [\'required\'], '."\n \t\t\t";
            }
            $template = self::getStubContents('StoreRequest.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{columns}}', $print_columns, $template);
            
            if (! file_exists(base_path('app/Http/Requests/'.$this->model))) {
                mkdir(base_path('app/Http/Requests/'.$this->model));
            }
            file_put_contents(base_path('app/Http/Requests/'.$this->model.'/Store'.$this->model.'Request.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateUpdateRequest()
    {
        $this->result = false;
        if (! file_exists(base_path('app/Http/Requests/'.$this->model.'/Update'.$this->model.'Request.php'))) {
            $model = is_dir(base_path('app/Models')) ? app('App\\Models\\'.$this->model) : app('App\\'.$this->model);
            $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $print_columns = null;
            foreach ($columns as $key => $column) {
                $print_columns .= "'".$column."'".' =>  [\'required\'], '."\n \t\t\t";
            }
            $template = self::getStubContents('UpdateRequest.stub');
            $template = str_replace('{{modelName}}', $this->model, $template);
            $template = str_replace('{{columns}}', $print_columns, $template);
            
            if (! file_exists(base_path('app/Http/Requests/'.$this->model))) {
                mkdir(base_path('app/Http/Requests/'.$this->model));
            }
            file_put_contents(base_path('app/Http/Requests/'.$this->model.'/Update'.$this->model.'Request.php'), $template);
            $this->result = true;
        }

        return $this->result;
    } 

    public function generateRoute()
    {
        $this->result = false;
        if ((int)app()->version() >= 8) {
            $nameSpace = "\nuse App\Http\Controllers\Api\{{modelName}}Controller;";
            $template = "Route::apiResource('{{modelNameLower}}', {{modelName}}Controller::class);\n";
            $nameSpace = str_replace('{{modelName}}', $this->model, $nameSpace);
        } else {
            $template = "Route::apiResource('{{modelNameLower}}', 'Api\{{modelName}}Controller');\n";
        }
        $route = str_replace('{{modelNameLower}}', Str::camel(Str::plural($this->model)), $template);
        $route = str_replace('{{modelName}}', $this->model, $route);
        if (! strpos(file_get_contents(base_path('routes/api.php')), $route)) {
            file_put_contents(base_path('routes/api.php'), $route, FILE_APPEND);
            if (app()->version() >= 8) {
                if (! strpos(file_get_contents(base_path('routes/api.php')), $nameSpace)) {
                    $lines = file(base_path('routes/api.php'));
                    $lines[0] = $lines[0]."\n".$nameSpace;
                    file_put_contents(base_path('routes/api.php'), $lines);
                }
            }
            $this->result = true;
        }

        return $this->result;
    }

    private function getStubContents($stubName)
    {
        return file_get_contents(self::STUB_DIR.$stubName);
    }
}
