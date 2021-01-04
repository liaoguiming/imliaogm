<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use App\models\CreateList;
use Illuminate\Support\Facades\DB;


class AutoCreateAdminFunction extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoCreateAdmin {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new admin function';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = $this->getModelName();
        //检查是否能生成
        $check = $this->checkCreateList($model);
        //否 则退出
        if (!$check) {
            $this->info('model info not exsit, please config in the admin');
            exit;
        }
        //生成路由信息
        //$this->updateRoute($model);
        //生成控制器CURD信息
        $this->createController($model);
        //生成模型 信息
        //$this->createModel($model);
        //生成模板信息
        //$this->createView($model);
        $this->info('created successfully');
    }

    protected function getModelName()
    {
        return trim($this->argument('model'));
    }

    protected function getStub($type = "controller")
    {
        if (!in_array($type, ['model', 'controller', 'view'])) {
            return false;
        }
        $stub = $type == "model" ? '\\stubs\\default.model.stub' : '\\stubs\\default.controller.stub';

        return __DIR__ . $stub;
    }

    /**
     * @param $model string 模型名称 根据模型名称生成路有信息
     */
    protected function updateRoute($model)
    {
        $lowerModel = lcfirst($model);
        $note = $this->getNoteInfo($lowerModel);
        if (!$note) {
            return false;
        }
        $br = PHP_EOL;
        $content = $br . '//' . $note . '管理';
        $content .= $br . "Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:" . $lowerModel . ".manage']], function () {";
        $content .= $br . '    //' . $note . '列表';
        $content .= $br . "    Route::group(['middleware' => 'permission:" . $lowerModel . ".index'], function () {";
        $content .= $br . "        Route::get('" . $lowerModel . "/index', '" . $model . "Controller@index')->name('admin." . $lowerModel . "');";
        $content .= $br . "        Route::get('" . $lowerModel . "/data', '" . $model . "Controller@data')->name('admin." . $lowerModel . ".data')->middleware('permission:" . $lowerModel . ".index.create');";
        $content .= $br . '        //添加';
        $content .= $br . "        Route::get('" . $lowerModel . "/create', '" . $model . "Controller@create')->name('admin." . $lowerModel . ".create')->middleware('permission:" . $lowerModel . ".index.create');";
        $content .= $br . "        Route::get('" . $lowerModel . "/store', '" . $model . "Controller@store')->name('admin." . $lowerModel . ".store')->middleware('permission:" . $lowerModel . ".index.store');";
        $content .= $br . '        //编辑';
        $content .= $br . "        Route::get('" . $lowerModel . "/{id}/edit', '" . $model . "Controller@edit')->name('admin." . $lowerModel . ".edit')->middleware('permission:" . $lowerModel . ".index.edit');";
        $content .= $br . "        Route::get('" . $lowerModel . "/{id}/update', '" . $model . "Controller@update')->name('admin." . $lowerModel . ".update')->middleware('permission:" . $lowerModel . ".index.update');";
        $content .= $br . '        //删除';
        $content .= $br . "        Route::get('" . $lowerModel . "/destroy', '" . $model . "Controller@destroy')->name('admin." . $lowerModel . ".destroy')->middleware('permission:" . $lowerModel . ".index.destroy');";
        $content .= $br . "    });";
        $content .= $br . "});";
        $dir = explode("\\", __FILE__, 3);
        $dirName = $dir[0] . $dir[1];
        file_put_contents($dirName . '\\routes\\admin.php', $content, FILE_APPEND);
    }

    /**
     * 生成包含CURD的控制器
     *
     * @param $model string
     */

    private function createController($model)
    {
        $getShowColumns = $this->getShowColumns($model);
        $controllerDir = $this->getStub();
        $info = file_get_contents($controllerDir);
        $replaceInfo = str_replace('default', $model, $info);
        $replaceInfo = str_replace('routeIndex', strtolower($model), $replaceInfo);
        $replaceInfo = str_replace('DefaultController', $model . "Controller", $replaceInfo);
        $replaceInfo = str_replace('insertColumns', $getShowColumns, $replaceInfo);
        $dir = explode("\\", __FILE__, 3);
        $dirName = $dir[0] . $dir[1];
        $path = $dirName . '\\app\\Http\\Controllers\\Admin\\' . $model . "Controller.php";
        print_r($path);
        print_r($replaceInfo);
        exit;
    }

    /**
     * 生成模型
     *
     * @param $model string
     */

    private function createModel($model)
    {
        exec("php artisan make:model models/" . $model);
    }

    /**
     * 检查是否更新路由
     *
     * @param $model string
     */
    private function checkUpdateRoute($model)
    {

    }

    /**
     * 检查是否新增控制器
     *
     * @param $model string
     */
    private function checkAddController($model)
    {

    }

    /**
     * 检查是否新增模型
     *
     * @param $model string
     */
    private function checkAddModel($model)
    {

    }

    /**
     * 获取配置信息
     *
     * @param $model string
     * @return array
     */

    private function getCreateListInfo($model)
    {
        $mainInfo = CreateList::with('items')->where('model_name', trim($model))->get()->toArray();
        return $mainInfo;
    }

    private function getShowColumns($model)
    {
        $res = [];
        $info = $this->getCreateListInfo($model);
        foreach ($info[0]['items'] as $k => $v) {
            $res[] = $v['column'];
        }
        return $res ? implode(",", $res) : [];
    }

    /**
     * 检查是否配置了生成列表 需要后台配置后才能生成
     *
     * @param $model string 模型名
     * @return mixed
     */
    private function checkCreateList($model)
    {
        return DB::table('create_list')->select('id')->where('model_name', trim($model))->value('id');
    }

    /**
     * @param $model string 根据路由查询
     * @return string 返回权限列表的display_name作为注释
     */
    private function getNoteInfo($model)
    {
        $route = "admin." . $model;
        return DB::table('permissions')->select('display_name')->where('route', $route)->value('display_name');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildParentReplacements()
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if (!class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $parentModelClass]);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     *
     * @param  array $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (!class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string $model
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (!Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],

            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
        ];
    }
}
