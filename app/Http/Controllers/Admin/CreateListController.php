<?php

namespace App\Http\Controllers\Admin;

use App\Models\CreateList;
use App\models\CreateListItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CreateListController extends Controller
{
    const INSERT_COLUMNS = ['table_name', 'model_name', 'show_columns', 'search_columns', 'opreate_columns', 'is_need_create', 'is_need_delete'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.createList.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $model = CreateList::query();
        $res = $model->orderBy('id', 'desc')->paginate($request->get('limit', 30))->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    public function getTableColumns(Request $request)
    {
        $table = $request->only(['table']);
        $res = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($table['table']);
        $res = array_keys($res);
        //array_merge重置数组下标
        //array_filter和array_unique在对数组做处理后并不会重建数组下标，导致接下来的json_encode就变成了字典{}而不是数组[]
        $res = array_merge(array_filter(array_map(function ($v) {
            return in_array($v, ['id', 'created_at', 'updated_at']) ? '' : $v;
        }, $res)));
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'data' => $res
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allTables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        $allowConfigTable = DB::table('adverts')
            ->join('positions', 'adverts.position_id', '=', 'positions.id')
            ->where('positions.sort', 98)
            ->first();
        $allowConfigTable = json_decode(json_encode($allowConfigTable), true);
        $allowArr = explode("|", $allowConfigTable['description']);
        $tableInfo = array_intersect($allowArr, $allTables);
        return view('admin.createList.create', compact('tableInfo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $data = $request->only(self::INSERT_COLUMNS);
        try {
            //中间逻辑代码
            $mainData = [];
            $columnData = [];
            $allData = [];
            $i = 0;
            $type = ['show_columns' => 1, 'search_columns' => 2, 'opreate_columns' => 3];
            foreach ($data as $k => $v) {
                if (!is_array($v)) {
                    $mainData[$k] = $v;
                    $mainData['created_at'] = date("Y-m-d h:i:s", time());
                    $mainData['updated_at'] = date("Y-m-d h:i:s", time());
                } else {
                    foreach ($v as $index => $column) {
                        $columnData[$i]['type'] = $type[$k];
                        $columnData[$i]['column'] = $column;
                        $i++;
                    }
                }
            }
            $create_list_id = DB::table('create_list')->insertGetId($mainData);
            foreach ($columnData as $key => $val) {
                $everyData['type'] = $val['type'];
                $everyData['create_list_id'] = $create_list_id;
                $everyData['column'] = $val['column'];
                $everyData['created_at'] = date("Y-m-d h:i:s", time());
                $everyData['updated_at'] = date("Y-m-d h:i:s", time());
                $allData[] = $everyData;
            }
            DB::table('create_list_item')->insert($allData);
            DB::commit();
            return redirect(route('admin.createList'))->with(['status' => '添加成功']);
        } catch (\Exception $e) {
            //接收异常处理并回滚
            DB::rollBack();
            return redirect(route('admin.createList'))->with(['status' => '添加失败,错误原因为' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res = CreateList::findOrFail($id);
        if (!$res) {
            return redirect(route('admin.createList'))->withErrors(['status' => '配置不存在']);
        }
        $allTables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        $allowConfigTable = DB::table('adverts')
            ->join('positions', 'adverts.position_id', '=', 'positions.id')
            ->where('positions.sort', 98)
            ->first();
        $allowConfigTable = json_decode(json_encode($allowConfigTable), true);
        $allowArr = explode("|", $allowConfigTable['description']);
        $tableInfo = array_intersect($allowArr, $allTables);
        return view('admin.createList.edit', compact('tableInfo', 'res'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $data = $request->only(self::INSERT_COLUMNS);
        try {
            $mainData = [];
            $columnData = [];
            $allData = [];
            $i = 0;
            $type = ['show_columns' => 1, 'search_columns' => 2, 'opreate_columns' => 3];
            foreach ($data as $k => $v) {
                if (!is_array($v)) {
                    $mainData[$k] = $v;
                } else {
                    foreach ($v as $index => $column) {
                        $columnData[$i]['type'] = $type[$k];
                        $columnData[$i]['column'] = $column;
                        $i++;
                    }
                }
            }
            DB::table('create_list')->where('id', $id)->update($mainData);
            if (!empty($columnData)) {
                //先删除后添加
                DB::table('create_list_item')->where('create_list_id', $id)->delete();
                foreach ($columnData as $key => $val) {
                    $everyData['type'] = $val['type'];
                    $everyData['create_list_id'] = $id;
                    $everyData['column'] = $val['column'];
                    $everyData['created_at'] = date("Y-m-d h:i:s", time());
                    $everyData['updated_at'] = date("Y-m-d h:i:s", time());
                    $allData[] = $everyData;
                }
                DB::table('create_list_item')->insert($allData);
            }
            DB::commit();
            return redirect(route('admin.createList'))->with(['status' => '更新成功']);
        } catch (\Exception $e) {
            //接收异常处理并回滚
            DB::rollBack();
            return redirect(route('admin.createList'))->with(['status' => '更新失败,错误原因为' . $e->getMessage()]);
        }
    }

}

