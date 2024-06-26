<?php

namespace App\Http\Controllers;

use App\Models\Paystub;
use App\Models\PrevOwnerDraw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaystubController extends Controller
{
    public function create(Request $request)
    {
        $formData = $request->session()->get('form_data', []);
        return view('themes.tailwind.paystubs.create', compact('formData'));
    }

    public function preview(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'companyname' => 'required|string|max:255',
            'einno' => 'required|string|max:255',
            'companyphone' => 'required|string|max:255',
            'companystreet' => 'required|string|max:255',
            'companycity' => 'required|string|max:255',
            'companystate' => 'required|string|max:255',
            'companyzip' => 'required|string|max:255',
            'companycountry' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'ssn' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'employeeid' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'paystartday' => 'required|date',
            'payendday' => 'required|date',
            'payday' => 'required|date',
            'grossincome' => 'required|numeric',
            'stubno' => 'required|string|max:255',
            'prevpayday' => 'nullable|array',
            'ownerdrawamount' => 'nullable|array',
            'prevpayday.*' => 'nullable|date',
            'ownerdrawamount.*' => 'nullable|numeric',
            'netpayamount' => 'required|numeric',
        ]);
    
        // Calculate the total previous owner draws
        $totalPrevOwnerDraws = 0;
        if (!empty($validated['prevpayday']) && !empty($validated['ownerdrawamount'])) {
            foreach ($validated['ownerdrawamount'] as $amount) {
                $totalPrevOwnerDraws += floatval($amount);
            }
        }
    
        // Add hidden inputs to the preview form
        $request->session()->flash('form_data', $validated);
    
        return view('themes.tailwind.paystubs.preview', [
            'data' => $validated,
            'totalPrevOwnerDraws' => $totalPrevOwnerDraws,
        ]);
    }
    

    public function store(Request $request)
    {
        $validated = $request->session()->get('form_data');

        if (!$validated) {
            return redirect()->route('paystubs.create');
        }

        // Add the user_id to the validated data
        $validated['user_id'] = Auth::id();

        // Create a new Paystub
        $paystub = Paystub::create($validated);

        // Create previous owner draws if provided
        if (!empty($validated['prevpayday']) && !empty($validated['ownerdrawamount'])) {
            foreach ($validated['prevpayday'] as $index => $prevpayday) {
                if (!empty($prevpayday) && !empty($validated['ownerdrawamount'][$index])) {
                    PrevOwnerDraw::create([
                        'stubno' => $paystub->stubno,
                        'prevpayday' => $prevpayday,
                        'ownerdrawamount' => $validated['ownerdrawamount'][$index],
                    ]);
                }
            }
        }

        return redirect()->route('paystubs.show', ['id' => $paystub->id]);
    }

    public function show($id)
    {
        $paystub = Paystub::with('prevOwnerDraws')->where('id', $id)->firstOrFail();
        $prevOwnerDraws = $paystub->prevOwnerDraws->map(function($draw) {
            return [
                'date' => new \DateTime($draw->prevpayday),
                'amount' => $draw->ownerdrawamount
            ];
        })->sortBy('date')->values()->all();

        $totalPrevOwnerDraws = collect($prevOwnerDraws)->sum('amount');

        return view('themes.tailwind.paystubs.show', compact('paystub', 'prevOwnerDraws', 'totalPrevOwnerDraws'));
    }

    public function print($id)
    {
        $paystub = Paystub::with('prevOwnerDraws')->where('id', $id)->firstOrFail();
        $prevOwnerDraws = $paystub->prevOwnerDraws->map(function($draw) {
            return [
                'date' => new \DateTime($draw->prevpayday),
                'amount' => $draw->ownerdrawamount
            ];
        })->sortBy('date')->values()->all();

        $totalPrevOwnerDraws = collect($prevOwnerDraws)->sum('amount');

        $pdf = Pdf::loadView('themes.tailwind.paystubs.print', compact('paystub', 'prevOwnerDraws', 'totalPrevOwnerDraws'));
        return $pdf->download('paystub.pdf');
    }
}
