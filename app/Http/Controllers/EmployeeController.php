<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\People\PeopleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    protected $employeeRepository;
    protected $peopleRepository;
    protected $userRepository;
    public function __construct(EmployeeRepository $employeeRepository, PeopleRepository $peopleRepository, UserRepository $userRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->peopleRepository = $peopleRepository;
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $filters = $request->query('filters');
        $relations = ['typeEmployee', 'people', 'people.user'];
        $paginate = $request->query('paginate', true);
        $perPage = $request->query('perPage', 10);
        $employees = $this->employeeRepository->all($filters, $relations, $paginate, $perPage);
        $columnsExport = Employee::columnsExport;
        $filters = Employee::filters;
        return response()->json([
            'type' => 'success',
            'message' => 'Datos consultados',
            'data' => $employees,
            'columnsExport' => $columnsExport,
            'filters' => $filters,
        ], 201);
    }
    public function show(int $id)
    {
        $employee = $this->employeeRepository->find($id, ['typeEmployee', 'people', 'people.user', 'people.addresses']);
        return response()->json(['type' => 'success', 'message' => 'Datos obtenidos', 'data' => $employee], 201);
    }
    public function update(Request $request, int $id){
        $data = $request->all();
        $employee = $this->employeeRepository->update($id, $data);
        $people = $this->peopleRepository->update($data['people_id'], $data['people']);
        $jsj = $data['people']['user_id'];
        $user = $this->userRepository->update($data['people']['user_id'], $data['people']['user']);
        return response()->json(['type' => 'success', 'message' => 'Registro actualizado', 'data' => []], 201);
    }
    public function delete($id)
    {
        $employee = $this->employeeRepository->delete($id);
        return response()->json(['type' => 'success', 'message' => 'Registro eliminado', 'data' => []], 201);
    }
    public function export(Request $request)
    {
       try {
           $format = $request->query('format');
           $filters = $request->query('filters');
           $dataExport = $request->query('data_export');
           $columnsSelected = $request->query('columns_selected');
           $columnsExport = array_intersect_key(Employee::columnsExport, array_flip($columnsSelected));

           $document = Excel::raw(new EmployeesExport($dataExport, $filters, $columnsExport), $format == 'pdf' ? \Maatwebsite\Excel\Excel::DOMPDF : \Maatwebsite\Excel\Excel::XLSX);

           return response()->json([
               'type' => 'success',
               'message' => 'Datos exportados',
               'data' => [
                   'file' => base64_encode($document),
                   'mime' => $format == 'pdf' ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               ]
           ], 201);
       } catch (\Exception $e) {
           return response()->json(['type' => 'error', 'message' => 'Ocurrio un error al exportar', 'data' => []], 201);
       }
    }
}
