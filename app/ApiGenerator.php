<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ApiGenerator
{
    protected $model;
    protected $modelName;
    protected $subFolder;
    protected $result = false;

    public function __construct(string $model)
    {
        $this->model = $model;
        $this->modelName = $model;
        // $this->subFolder = '\\';
        $models = explode('/', $model);
        if (count($models) == 2) {
            $this->subFolder = '\\' . $models[0];
            $this->modelName = $models[count($models) - 1];
        }
        self::generate();
    }

    public function generate()
    {
        self::directoryCreate();
    }

    public function directoryCreate()
    {

        if (!file_exists(base_path('app/Http/Controllers' . $this->subFolder ?? ''))) {
            mkdir(base_path('app/Http/Controllers' . $this->subFolder ?? ''));
        }
        if (!file_exists(base_path('app/Http/Requests'))) {
            mkdir(base_path('app/Http/Requests'));
        }
        if (!file_exists(base_path('app/Http/Resources'))) {
            mkdir(base_path('app/Http/Resources'));
        }
        if (!file_exists(base_path('app/Http/Requests' . $this->subFolder ?? ''))) {
            mkdir(base_path('app/Http/Requests' . $this->subFolder ?? ''));
        }
        if (!file_exists(base_path('app/Http/Resources' . $this->subFolder ?? ''))) {
            mkdir(base_path('app/Http/Resources' . $this->subFolder ?? ''));
        }
    }
    public function generateRequest()
    {
        $this->result = false;

        if (!file_exists(base_path('app/Http/Requests/' . $this->model . 'Request.php'))) {
            $model = is_dir(base_path('app/Models')) ? app('App\\Models' . $this->subFolder . '\\' . $this->modelName) : app('App\\' . $this->model);
            // $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($model->getTable());
            $print_columns = null;
            foreach ($columns as $key => $column) {
                $name = $column->getName();

                if ($name !== 'id' && $name !== 'created_at' && $name !== 'updated_at' && $name !== 'deleted_at') {
                    $required = $column->getNotnull();
                    $type = $column->getType()->getName();

                    switch ($type) {
                        case 'integer':
                            $typeVal = 'numeric';
                            break;
                        case 'bigint':
                            $typeVal = 'numeric';
                            break;
                        case 'smallint':
                            $typeVal = 'numeric';
                            break;
                        case 'datetime':
                            $typeVal = 'datetime';
                            break;

                        default:
                            $typeVal = 'string';
                            break;
                    }
                    $max = $column->getLength();
                    $print_columns .= "'" . $name . "'" . ' =>"' . ($required ? 'required' : 'nullable') . ($typeVal ? '|' . $typeVal : '') . ($max ? '|max:' . $max . '",' : '",') . "\n \t\t\t\t";
                }
            }

            $template = self::getStubContents('request.stub');
            $template = str_replace('{{modelName}}', $this->modelName, $template);
            $template = str_replace('{{subFolder}}', $this->subFolder ?? '', $template);
            $template = str_replace('{{columns}}', $print_columns, $template);
            file_put_contents(base_path('app/Http/Requests/' . $this->model . 'Request.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }
    public function generateController()
    {
        $this->result = false;

        if (!file_exists(base_path('app/Http/Controllers/' . $this->model . 'Controller.php'))) {
            $template = self::getStubContents('controller.stub');
            $template = str_replace('{{modelName}}', $this->modelName, $template);
            $template = str_replace('{{modelNameLower}}', strtolower($this->modelName), $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->modelName), $template);
            $template = str_replace('{{subFolder}}', $this->subFolder ?? '', $template);
            // $template = str_replace('{{modelNameSpace}}', $this->subFolder . $this->modelName, $template);
            file_put_contents(base_path('app/Http/Controllers/' . $this->model . 'Controller.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }


    public function generateResource()
    {

        $this->result = false;

        if (!file_exists(base_path('app/Http/Resources/' . $this->model . 'Resource.php'))) {
            $model = is_dir(base_path('app/Models')) ? app('App\\Models' . $this->subFolder . '\\' . $this->modelName) : app('App\\' . $this->model);
            $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $print_columns = null;
            foreach ($columns as $key => $column) {
                $print_columns .= "'" . $column . "'" . ' => $this->' . $column . ', ' . "\n \t\t\t";
            }
            $template = self::getStubContents('resource.stub');
            $template = str_replace('{{modelName}}', $this->modelName, $template);
            $template = str_replace('{{subFolder}}', $this->subFolder ?? '', $template);
            $template = str_replace('{{columns}}', $print_columns, $template);
            $template = str_replace('{{modelNameCamel}}', Str::camel($this->modelName), $template);
            file_put_contents(base_path('app/Http/Resources/' . $this->model . 'Resource.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateCollection()
    {
        $this->result = false;

        if (!file_exists(base_path('app/Http/Resources/' . $this->model . 'Collection.php'))) {
            $template = self::getStubContents('collection.stub');
            $template = str_replace('{{modelName}}', $this->modelName, $template);
            $template = str_replace('{{subFolder}}', $this->subFolder ?? '', $template);
            file_put_contents(base_path('app/Http/Resources/' . $this->model . 'Collection.php'), $template);
            $this->result = true;
        }

        return $this->result;
    }

    public function generateRoute()
    {
        $this->result = false;
        if (app()->version() >= 8) {
            $nameSpace = "use App\Http\Controllers{{subFolder}}\{{modelName}}Controller;";
            $template = "\n
        //Route::patch('{{modelNameLower}}/{{{modelNameLower}}}/restore', [{{modelName}}Controller::class, 'restore'])->withTrashed()->name('{{modelNameLower}}.restore');
        //Route::delete('{{modelNameLower}}/{{{modelNameLower}}}/forceDelete', [{{modelName}}Controller::class, 'forceDelete'])->withTrashed()->name('{{modelNameLower}}.forceDelete');
        Route::apiResource('{{modelNameLower}}', {{modelName}}Controller::class);";
            $nameSpace = str_replace('{{modelName}}', $this->modelName, $nameSpace);
            $nameSpace = str_replace('{{subFolder}}', $this->subFolder ?? '', $nameSpace);
        } else {
            $template = "Route::apiResource('{{modelNameLower}}', 'Api\{{modelName}}Controller');\n";
        }
        $route = str_replace('{{modelNameLower}}', Str::camel(Str::plural($this->modelName)), $template);
        $route = str_replace('{{modelName}}', $this->modelName, $route);
        $template = str_replace('{{subFolder}}', $this->subFolder, $template);
        if (!strpos(file_get_contents(base_path('routes/api.php')), $route)) {
            file_put_contents(base_path('routes/api.php'), $route, FILE_APPEND);
            if (app()->version() >= 8) {
                if (!strpos(file_get_contents(base_path('routes/api.php')), $nameSpace)) {
                    $lines = file(base_path('routes/api.php'));
                    $lines[0] = $lines[0] . "\n" . $nameSpace;
                    file_put_contents(base_path('routes/api.php'), $lines);
                }
            }
            $this->result = true;
        }

        return $this->result;
    }

    private function getStubContents($stubName)
    {
        return file_get_contents(
            resource_path('stubs/' . $stubName)
        );
    }
}
