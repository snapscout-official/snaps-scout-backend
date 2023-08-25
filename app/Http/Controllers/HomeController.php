<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Spec;
use App\Models\User;
use App\Models\Agency;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Merchant;
use App\Mail\MyTestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __invoke()
    {
        
    // $product = Product::find(1000);
    // $variant = $product->variants()->create([
    //     'variant_name' => 'Inkjet Printers',
    //     'is_available' => true
    // ]);
    // $values = [
    //     ['specs_name' => 'functions',
    //     'specs_value' => 'Print, Scan, Copy, Fax'
    //     ],
    //     ['specs_name' => 'printer type',
    //     'specs_value' => 'Inkjet Printer'],
    //     ['specs_name' => 'MAXIMUM PAPER CAPACITY',
    //     'specs_value' => 'Up to 250 sheets of 80 gsm plain paper'],
        
    // ];
    // foreach($values as $value)
    // {
    //     Spec::create($value);
    // }
    // dd(Spec::all());
    
    // $subCategory = $product->subCategory()->first();
    // dump($subCategory);
    // dump($subCategory->parentCategory()->first());
        // $variant = Variant::find(1);
        // dump($variant->variant_name);
        // foreach($variant->specs as $spec)
        // {
        //     dump($spec->specs_name);
        //     dump($spec->specs_value);
        // }
        Mail::to('gio.gonzales@carsu.edu.ph')->send(new MyTestEmail());
        

   
    

    }
}
