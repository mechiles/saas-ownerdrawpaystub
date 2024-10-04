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
        $data = $request->session()->get('form_data', []);
        // Get previous owner draws for the authenticated user from manual entries
        // $prevOwnerDraws = PrevOwnerDraw::where('user_id', Auth::id())->get();
        // \DB::enableQueryLog();

        $prevOwnerDraws = PrevOwnerDraw::where('user_id', Auth::id())->get();

        // dd(\DB::getQueryLog());

        // If no manual entries exist, fetch from the Paystub table
        // if ($prevOwnerDraws->isEmpty()) {
            $prevPayStubs = Paystub::where('user_id', Auth::id())
                ->select('stubno','payday as prevpayday', 'companyname', \DB::raw('MAX(grossincome) as ownerdrawamount'), \DB::raw('MAX(id) as id'))
                ->groupBy('stubno', 'payday', 'companyname')
                ->orderBy('payday', 'asc')
                ->get();
        // }

        $data = $request->session()->get('form_data', []);

        return view('themes.tailwind.paystubs.create', compact('data', 'prevPayStubs', 'prevOwnerDraws'));
    }

 public function preview(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'selected_prev_paystubs' => 'nullable|array',
            'selected_prev_paystubs.*' => 'nullable|integer|exists:paystubs,id', 
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
            'ytdnetpayamount' => 'required|numeric',
        ]);

        // dd($validated);

        // Initialize variables
        $totalPrevOwnerDraws = 0;
        $selectedPrevPaystubs = collect(); // For storing selected paystubs
        $manualPrevDraws = collect(); // For manually entered previous draws

        // Process selected previous paystubs
        if (!empty($validated['selected_prev_paystubs'])) {
            $selectedPrevPaystubs = Paystub::whereIn('id', $validated['selected_prev_paystubs'])
                ->where('user_id', Auth::id())
                ->orderBy('payday', 'asc')
                ->get()
                ->map(function($paystub) {
                    return [
                        'payday' => $paystub->payday,
                        'amount' => $paystub->netpayamount,
                    ];
                });
        }

        // Process manual entries
        if (!empty($validated['prevpayday']) && !empty($validated['ownerdrawamount'])) {
            foreach ($validated['prevpayday'] as $index => $prevpayday) {
                if (!empty($prevpayday) && !empty($validated['ownerdrawamount'][$index])) {
                    $manualPrevDraws->push([
                        'payday' => $prevpayday,
                        'amount' => $validated['ownerdrawamount'][$index],
                    ]);
                }
            }
        }
    
        // Merge and sort all earnings by payday
        $allEarnings = $selectedPrevPaystubs->merge($manualPrevDraws)->sortBy('payday');

        // Calculate YTD Net Pay
        $ytdNetPay = $validated['netpayamount'] + $allEarnings->sum('amount');

        // Store validated data and totals in the session
        $validated['ytdNetPay'] = $ytdNetPay;
        $request->session()->put('form_data', $validated);

        // Pass data to the preview view
        return view('themes.tailwind.paystubs.preview', [
            'data' => $validated,
            'allEarnings' => $allEarnings, // Pass the sorted earnings
        ]);
    }

    public function store(Request $request)
    {
        // Retrieve validated data from the session
        $validated = $request->session()->get('form_data');

        // If no data is present, redirect back to the create page
        if (!$validated) {
            return redirect()->route('paystubs.create');
        }

        // Validate that the Pay Stub Number is unique for the user and company selected
        $existingPaystub = Paystub::where('user_id', Auth::id())
            ->where('stubno', $validated['stubno'])
            ->where('companyname', $validated['companyname'])
            ->first();

        // If a paystub with the same number exists, redirect back with an error
        if ($existingPaystub) {
            return redirect()->route('paystubs.create')->withErrors(['stubno' => 'The Pay Stub Number already exists for this company.']);
        }

        // Add the authenticated user's ID to the validated data
        $validated['user_id'] = Auth::id();

        // Create the Paystub
        $paystub = Paystub::create($validated);

        // Process and store previous paystubs (selected paystubs)
        if (!empty($validated['selected_prev_paystubs'])) {
            foreach ($validated['selected_prev_paystubs'] as $prevId) {
                // Ensure we're linking the correct previous paystubs and avoid duplicates
                $prevPaystub = Paystub::find($prevId);

                if ($prevPaystub) {
                    PrevOwnerDraw::create([
                        'stubno' => $paystub->stubno,
                        'prevpayday' => $prevPaystub->payday,
                        'ownerdrawamount' => $prevPaystub->netpayamount,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        }

        // Process and store manually entered previous owner draws, avoiding duplicates
        if (!empty($validated['prevpayday']) && !empty($validated['ownerdrawamount'])) {
            foreach ($validated['prevpayday'] as $index => $prevpayday) {
                $existingPrevDraw = PrevOwnerDraw::where('user_id', Auth::id())
                    ->where('stubno', $paystub->stubno)
                    ->where('prevpayday', $prevpayday)
                    ->where('ownerdrawamount', $validated['ownerdrawamount'][$index])
                    ->first();

                if (!empty($prevpayday) && !empty($validated['ownerdrawamount'][$index]) && !$existingPrevDraw) {
                    PrevOwnerDraw::create([
                        'stubno' => $paystub->stubno,
                        'prevpayday' => $prevpayday,
                        'ownerdrawamount' => $validated['ownerdrawamount'][$index],
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        }

        // Process and store allEarnings if they were passed through the preview
        if (!empty($validated['allEarnings'])) {
            foreach ($validated['allEarnings']['payday'] as $index => $payday) {
                $amount = $validated['allEarnings']['amount'][$index];

                PrevOwnerDraw::create([
                    'stubno' => $paystub->stubno,
                    'prevpayday' => $payday,
                    'ownerdrawamount' => $amount,
                    'user_id' => Auth::id(),
                ]);
            }
        }

        // Clear the session data after saving the paystub
        $request->session()->forget('form_data');

        // Redirect to the show page after saving
        return redirect()->route('paystubs.show', ['id' => $paystub->id]);
    }


    public function show($id)
    {
        // Find the Paystub by ID
        $paystub = Paystub::findOrFail($id);

        // Fetch any previous paystubs linked to this paystub's stub number
        $prevPayStubs = PrevOwnerDraw::where('stubno', $paystub->stubno)
            ->where('user_id', Auth::id())
            ->orderBy('prevpayday', 'asc')
            ->get();

        // Fetch any manually entered previous owner draws linked to this stub number
        $prevOwnerDraws = PrevOwnerDraw::where('stubno', $paystub->stubno)
            ->where('user_id', Auth::id())
            ->orderBy('prevpayday', 'asc')
            ->get();

        // Calculate YTD Net Pay by summing previous draws and the current net pay
        $totalPrevOwnerDraws = $prevPayStubs->sum('netpay') + $prevOwnerDraws->sum('ownerdrawamount');
        $ytdNetPay = $paystub->netpayamount + $totalPrevOwnerDraws;

        // Pass the data to the view
        return view('themes.tailwind.paystubs.show', compact('paystub', 'prevPayStubs', 'prevOwnerDraws', 'ytdNetPay'));
    }

    
    public function print($id)
    {
        $paystub = Paystub::with(['prevOwnerDraws' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->where('id', $id)->firstOrFail();

        $prevOwnerDraws = $paystub->prevOwnerDraws->map(function($draw) {
            return [
                'date' => new \DateTime($draw->prevpayday),
                'amount' => $draw->ownerdrawamount
            ];
        })->sortBy('date')->values()->all();

        $totalPrevOwnerDraws = collect($prevOwnerDraws)->sum('amount');
        // + $paystub->netpayamount;
        $ytdNetPay = $totalPrevOwnerDraws;

        $pdf = Pdf::loadView('themes.tailwind.paystubs.print', compact('paystub', 'prevOwnerDraws', 'totalPrevOwnerDraws', 'ytdNetPay'));
        return $pdf->download('paystub.pdf');
    }   
    
}
