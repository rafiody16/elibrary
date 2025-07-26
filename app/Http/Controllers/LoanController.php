<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'book'])->get();
        return view('loan.index', compact('loans'));
    }
    
    public function create()
    {
        $members = Member::all();
        $books = Book::all();
        return view('loan.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $rules = [
            'id_member' => 'required|integer|exists:members,id_member',
            'id_book' => 'required|integer|exists:books,id_book',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|string|in:borrowed,returned',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        Loan::create([
            'id_member' => $request->id_member,
            'id_book' => $request->id_book,
            'loan_date' => Carbon::parse($request->loan_date),
            'return_date' => Carbon::parse($request->loan_date)->addDays(7), 
            'status' => 'borrowed',
        ]);
    }
}
