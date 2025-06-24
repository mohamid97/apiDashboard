<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ModelRequestFactory;
use App\Services\ModelServiceFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrudController extends Controller
{
    use \App\Traits\ResponseTrait;
    
    protected $data;

    protected function getResourceClass(string $modelName)
    {

        $studlyName = Str::studly($modelName);
        $resourceClass =  "App\\Http\\Resources\\Api\\Admin\\{$studlyName}Resource";
        if (class_exists($resourceClass)) {
              return $this->success( new $resourceClass($this->data),__('main.stored_successfully', ['model' => $modelName]));
        }
        return $this->success( $this->data, __('main.stored_successfully', ['model' => $modelName]) );

        
    }

  
    public function store(Request $request)
    {
        
        ModelRequestFactory::validate($request->model, 'store', $request);
        try{
            $service = ModelServiceFactory::make($request->model);
            DB::beginTransaction();
            $this->data = $service->store($request->except('model'));
            DB::commit();
            return  $this->getResourceClass($request->model);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->error($e->getMessage() , 500);
        }

        

    }





        public function update(Request $request)
    {
        ModelRequestFactory::validate($request->model, 'update', $request);
        $service = ModelServiceFactory::make($request->model);
        $data = $service->update($request->id, $request->except(['model', 'id']));
        return response()->json(['data' => $data]);
    }

    public function delete(Request $request)
    {
        $service = ModelServiceFactory::make($request->model);
        $service->delete($request->id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function handleAction(Request $request)
    {
        $service = ModelServiceFactory::make($request->model);
        $action = $request->action;
        $id = $request->id ?? null;
        $data = $request->except(['model', 'action', 'id']);

        if (!method_exists($service, $action)) {
            return response()->json(['error' => "Action '{$action}' not defined for model '{$request->model}'"], 400);
        }

        $result = $id ? $service->$action($id, $data) : $service->$action($data);
        return response()->json(['data' => $result]);
    }


    


    
}