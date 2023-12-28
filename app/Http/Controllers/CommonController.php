<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Society;
use App\Models\Member;
use App\Models\SocietyMembers;
use App\Models\ContributionPayment;

use Illuminate\Support\Facades\DB;     

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // $authorCount = Author::count();
        // $categoryCount = Category::count();
        // $languageCount = Language::count();
        // $bookCount = Book::count();

        // $bookStocksCount = Book_stocks::sum('received_quantity');
        // $bookIssueCount = Book_issue::sum('issued_quantity');
        // $bookReturnCount = Book_return::sum('returned_quantity');
        // $bookSellCount = Book_sell::sum('soled_quantity');       
        // $volunteerPaymentCount = Volunteer_payment::sum('amount');

        $userCount = User::count();
        $societiesCount = Society::count();
        $memberCount = Member::count();
        $societiesMemberCount = SocietyMembers::count();
        $contribution_payment = ContributionPayment::sum('amount');
        //bookStocksCount = Book_stocks::sum('received_quantity');
        //eventInfoCount contactInfoCount

        // return view('dashboard', compact(
        //     'authorCount','categoryCount','languageCount','bookCount',
        //     'bookStocksCount','bookIssueCount','bookReturnCount','bookSellCount',
        //     'volunteerPaymentCount', 'userCount','eventInfoCount','contactInfoCount'
        // ));

        return view('dashboard', compact('userCount','societiesCount','memberCount','societiesMemberCount','contribution_payment'));
        
    }
}
