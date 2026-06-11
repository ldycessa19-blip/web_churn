<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prediction;

class ChurnController extends Controller
{
    public function index()
    {
        return view('churn.index');
    }

    public function history()
    {
        $histories = Prediction::latest()->paginate(15);
        return view('churn.history', compact('histories'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'gender'           => 'required',
            'age'              => 'required|numeric',
            'married'          => 'required',
            'dependents'       => 'required',
            'tenure'           => 'required|numeric',
            'phone_service'    => 'required',
            'internet_service' => 'required',
            'monthly_charge'   => 'required|numeric',
            'total_charges'    => 'required|numeric',
        ]);

        try {
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'gender'           => $request->gender,
                'age'              => $request->age,
                'married'          => $request->married,
                'dependents'       => $request->dependents,
                'tenure'           => $request->tenure,
                'phone_service'    => $request->phone_service,
                'internet_service' => $request->internet_service,
                'monthly_charge'   => $request->monthly_charge,
                'total_charges'    => $request->total_charges,
            ]);

            if ($response->successful()) {
                $result = $response->json();

                // Simpan ke database
                Prediction::create([
                    'type'             => 'single',
                    'gender'           => $request->gender,
                    'age'              => $request->age,
                    'married'          => $request->married,
                    'dependents'       => $request->dependents,
                    'tenure'           => $request->tenure,
                    'phone_service'    => $request->phone_service,
                    'internet_service' => $request->internet_service,
                    'monthly_charge'   => $request->monthly_charge,
                    'total_charges'    => $request->total_charges,
                    'prediction_result'=> $result['prediction'],
                    'probability'      => $result['probability'],
                ]);

                return redirect()->route('churn.index')->with([
                    'prediction'  => $result['prediction'],
                    'probability' => $result['probability']
                ]);
            }

            return redirect()->back()->with('error', 'Gagal mendapatkan respon dari server AI.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi ke Flask terputus: ' . $e->getMessage());
        }
    }

    public function predictBulk(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls']);

        try {
            $filename = $request->file('file')->getClientOriginalName();

            $response = Http::attach(
                'file',
                file_get_contents($request->file('file')->getRealPath()),
                $filename
            )->post('http://127.0.0.1:5000/predict-bulk');

            if ($response->successful()) {
                $result = $response->json();

                // Simpan ringkasan bulk ke database
                Prediction::create([
                    'type'          => 'bulk',
                    'filename'      => $filename,
                    'prediction_result' => 'Bulk',
                    'probability'   => $result['churn_rate'],
                    'total_data'    => $result['total'],
                    'churn_count'   => $result['churn_count'],
                    'nonchurn_count'=> $result['nonchurn_count'],
                    'churn_rate'    => $result['churn_rate'],
                ]);

                return redirect()->route('churn.index')
                    ->with('bulk_results', $result);
            }

            return redirect()->back()->with('error', 'Gagal memproses file.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi Flask error: ' . $e->getMessage());
        }
    }
}