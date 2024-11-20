<?php

namespace App\Http\Controllers;

use App\Models\TechStack;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TraineeController extends Controller
{

    public function index()
    {
        $trainees = Trainee::with('techStacks')->orderBy('id', 'desc')->paginate(10);
        $searchText = '';
        return view('index', compact('trainees', 'searchText'));
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt|max:2048'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $csv = array_map('str_getcsv', file($file));
                $headers = array_map('trim', $csv[0]);
                unset($csv[0]);

                DB::beginTransaction();

                foreach ($csv as $row) {
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $row = array_map('trim', $row);
                    $data = array_combine($headers, $row);

                    $traineeData = [
                        'firstName' => $data['firstName'] ?? null,
                        'lastName' => $data['lastName'] ?? null,
                        'email' => $data['email'] ?? null,
                        'phone' => $data['phone'] ?? null,
                    ];
                    // return $data;
                    $trainee = Trainee::create($traineeData);

                    if (isset($data['techStackName']) && isset($data['techStackStatus'])) {
                        $techStackData = [
                            'name' => $data['techStackName'],
                            'status' => $data['techStackStatus'],
                            'trainee_id' => $trainee->id,
                        ];
                        TechStack::create($techStackData);
                    }
                }

                DB::commit();

                return redirect()->route('trainees.index')->with('success', 'Trainees imported successfully.');
            }

            return back()->with('error', 'File not found or invalid.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            $fileName = 'trainees.csv';
            $trainees = Trainee::all();

            // Prepare CSV file headers
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            // Generate CSV data
            $callback = function () use ($trainees) {
                $file = fopen('php://output', 'w');

                // CSV headers
                fputcsv($file, array('id', 'firstName', 'lastName', 'email', 'phone', 'techStackName', 'techStackStatus'));

                // CSV data rows
                foreach ($trainees as $trainee) {
                    fputcsv($file, array(
                        $trainee->id,
                        $trainee->firstName,
                        $trainee->lastName,
                        $trainee->email,
                        $trainee->phone,
                        // Assuming you have a relationship or field for technology and status
                        $trainee->techStacks ? $trainee->techStacks->name : '',
                        $trainee->techStacks ? $trainee->techStacks->status : ''
                    ));
                }

                fclose($file);
            };

            // Return CSV file as response
            return response()->stream($callback, 200, $headers);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'name' => 'required',
                'status' => 'required|in:active,inactive,pending',
                'role' => 'required|in:guest,manager,admin'
            ]);
            DB::beginTransaction();

            $trainee = Trainee::create($request->only((new Trainee())->getFillable()));
            $stack = new TechStack();
            $stack->name = $request->input('name');
            $stack->status = $request->input('status');
            $stack->trainee_id = $trainee->id;
            $stack->save();

            if ($trainee) {
                // Debug line
                info('Trainee created successfully: ' . $trainee->id);
            }
            DB::commit();

            return redirect()->route('trainees.index')->with('success', 'Trainee has been created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id)
    {
        $trainee = Trainee::with('techStacks')->findOrFail($id);
        return view('edit', compact('trainee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
            'status' => 'required|in:active,inactive,pending',
            'role' => 'required|in:guest,manager,admin'
        ]);

        try {
            DB::beginTransaction();

            $trainee = Trainee::findOrFail($id);
            // return $trainee;
            $trainee->firstName = $request->input('firstName');
            $trainee->lastName = $request->input('lastName');
            $trainee->email = $request->input('email');
            $trainee->phone = $request->input('phone');
            $trainee->role = $request->input('role');
            $trainee->save();

            $techStack = TechStack::where('trainee_id', $id)->firstOrFail();
            $techStack->name = $request->input('name');
            $techStack->status = $request->input('status');
            $techStack->save();

            DB::commit();

            return redirect()->route('trainees.index')->with('success', 'Trainee Has Been updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('update Trainee controller' . $th);
            throw $th;
            return $th;
        }
    }

    public function destroy($id)
    {
        try {
            TechStack::where('trainee_id', $id)->delete();
            Trainee::where('id', $id)->delete();
            return redirect()->route('trainees.index')->with('success', 'Trainee has been deleted successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function search(Request $request)
    {
        $searchText = $request->input('query');
        $trainees = Trainee::where('email', 'LIKE', '%' . $searchText . '%')
            ->orWhere('firstName', 'LIKE', '%' . $searchText . '%')
            ->orWhere('lastName', 'LIKE', '%' . $searchText . '%')
            ->orWhere('phone', 'LIKE', '%' . $searchText . '%')
            ->orWhere('role', 'LIKE', '%' . $searchText . '%')
            ->orWhereHas('techStacks', function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchText . '%');
            })
            ->with('techStacks')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $searchText = $request->input('query', '');
        return view('index', compact('trainees', 'searchText'));
    }
}
