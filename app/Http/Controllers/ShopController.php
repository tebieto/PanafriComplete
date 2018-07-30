<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use App\User;
use App\category;
use App\product;
use App\Transaction;
use App\Chat;
use App\referral;
use App\Store;
use App\Location;
use App\Price;
use App\Tracker;
use Auth;
use DB;

class ShopController extends Controller
{
    
	public function __construct()
    {
        
    }
	
	
	public function createTracker($store, $owner) 
	
	{
		
	 $tracker = Tracker::create([
			
			'buyer_id' => auth::id(),
			'seller_id' => $owner,
			'shop_id' => $store,
			'status' => 0,
			'seller_status' => 0,
			'buyer_status' => 0,
		]);	
		
		return $tracker;
		
	}
	
	public function requestTransaction($tracker, $location, $seller) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'status' => 2,
			'location' => $location,
			
		]);	
		
	User::find($seller)->notify(new \App\Notifications\NewRequest(Auth::user()));		
		
	}
	
	
	
	
	
	
	public function acceptTransaction($tracker, $delivery, $buyer) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'seller_status' => 1,
			'delivery' => $delivery,
			
			
		]);	
		
		User::find($buyer)->notify(new \App\Notifications\NewAvailable(Auth::user()));	
		
	}
	
	public function buyerAcceptTransaction($tracker, $seller) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'buyer_status' => 1
			
			
		]);	
		
	User::find($seller)->notify(new \App\Notifications\NewAccept(Auth::user()));	
		
	}
	
	
	public function cancelTransaction($tracker) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'status' => 3,
			
		]);	
		
		
		
	}
	
	
	public function finishTransaction($tracker) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'status' => 6,
			
		]);	
		
		
		
	}
	
	public function deliverTransaction($tracker) 
	
	{
		
	 $tracker = Tracker::where('id', $tracker)->first()
	  ->update([
			
			'status' => 7,
			
		]);	
		
		
		
	}
	
	public function deleteTransaction($id) 
	
	{
		
	 $transaction = Transaction::where('id', $id)->first()
	  ->delete();
	}
		
	
	
	
	public function addToCart($product, $price, $quantity) {
		
	 $product = Product::where('id', $product)->first();
	
	 $tracker = Tracker::where('shop_id', $product->store_id)->where('status', 0)->orderBy('created_at', 'DESC')->first();	
	 
	 if (empty($tracker)) {
		 
		return 0; 
		 
	 }
	 
	 $transaction = Transaction::create([
			
			'price_id' => $price,
			'quantity' => $quantity,
			'shop_id' => $product->store_id,
			'tracker_id' => $tracker->id,
		]);	
			
		return 1;
		
	}
	
	
	
	
	
	public function allShops($start)
    {
		
	$shops = Store::where('online', 1)->orderBy('created_at', 'DESC')->skip($start)->take(5)->get();
	$all = array();
	
	 foreach ($shops as $shop):
		 
		 $owner = User::where('id', $shop->seller)->first();
		 if ($owner->online == 1) {
		 array_push($all, $shop); 
		 }
		
	 endforeach;
	
	return $all;
	
		
	}

public function shopDetails($shop)
    {
		
	$shop = Store::where('id', $shop)->orderBy('created_at', 'DESC')->first();
	
	return $shop;
		
	}
	
public function trackedTransactions($tracker)
    {
		
	$transactions = Transaction::where('tracker_id', $tracker)->orderBy('created_at', 'DESC')->get();
	
	$all = array();
	
	 foreach ($transactions as $transaction):
		
		 array_push($all, $transaction); 
		
		
	 endforeach;
	
	return $all;
		
	}
	

	

public function pendingTrackers()
    {
	
	$all = array();
	
	$trackers = Tracker::where('status', 0)->where('buyer_id', auth::id())->orderBy('created_at', 'DESC')->get();
	
	
	 foreach ($trackers as $tracker):
	 $transactions = Transaction::where('tracker_id', $tracker->id)->first(); 
		 if(!empty($transactions)){
			
		 array_push($all, $tracker);
		 
		 }
		
	 endforeach;
	
	return $all;
	
		
	}
	
	
public function buyerActiveTrackers()
    {
	
	$all = array();
	
	$trackers = Tracker::where('status', 2)->where('buyer_id', auth::id())->where('seller_status', 1)->where('buyer_status', 0)->orderBy('created_at', 'DESC')->get();
	
	
	 foreach ($trackers as $tracker):
	 $transactions = Transaction::where('tracker_id', $tracker->id)->first(); 
		 if(!empty($transactions)){
			
		 array_push($all, $tracker);
		 
		 }
		 
		 

		
	 endforeach;
	
	return $all;
	
		
	}
	
	
public function buyerChatTrackers()
    {
	
	$all = array();
	
	$trackers = Tracker::where('status', 2)->where('buyer_id', auth::id())->where('seller_status', 1)->where('buyer_status', 1)->orWhere('status', 7)->orderBy('created_at', 'DESC')->get();
	
	
	 foreach ($trackers as $tracker):
	 $transactions = Transaction::where('tracker_id', $tracker->id)->first(); 
		 if(!empty($transactions)){
			
		 array_push($all, $tracker);
		 
		 }
		 
		 

		
	 endforeach;
	
	return $all;
	
		
}

public function recentBuyerChat($buyer, $tracker)
    {
	
	$chat = Chat::where('tracker_id', $tracker)->where('sender_id', auth::id())->orderBy('created_at', 'DESC')->first();
	
	return $chat;	
		
}

public function recentSellerChat($seller, $tracker)
    {
	
	$chat = Chat::where('tracker_id', $tracker)->where('sender_id', auth::id())->orderBy('created_at', 'DESC')->first();
	
	return $chat;	
		
}


public function sellerChatTrackers()
    {
	
	$all = array();
	
	$trackers = Tracker::where('status', 2)->where('seller_id', auth::id())->where('seller_status', 1)->where('buyer_status', 1)->orWhere('status', 6)->orderBy('created_at', 'DESC')->get();
	
	
	 foreach ($trackers as $tracker):
	 $transactions = Transaction::where('tracker_id', $tracker->id)->first(); 
		 if(!empty($transactions)){
			
		 array_push($all, $tracker);
		 
		 }
		 
		 

		
	 endforeach;
	
	return $all;
	
		
}
	
	
public function requestTrackers()
    {
	
	$all = array();
	
	$trackers = Tracker::where('status', 2)->where('seller_id', auth::id())->where('seller_status', 0)->where('buyer_status', 0)->orderBy('created_at', 'DESC')->get();
	
	
	 foreach ($trackers as $tracker):
	 $transactions = Transaction::where('tracker_id', $tracker->id)->first(); 
		 if(!empty($transactions)){
			
		 array_push($all, $tracker);
		 
		 }
		
	 endforeach;
	
	return $all;
	
		
	}
	
	
public function pendingTransactions()
    {
	
	$all = array();
	$trackers = Tracker::where('status', 0)->where('buyer_id', auth::id())->get();
	
	
	 foreach ($trackers as $tracker):
		 
		 $transactions = Transaction::where('tracker_id', $tracker->id)->get();
		
		foreach ($transactions as $transaction):
		 
		 array_push($all, $transaction); 
		 
		endforeach;
		
	 endforeach;
	
	return $all;
	
		
	}
	
public function buyerActiveTransactions()
    {
	
	$all = array();
	$trackers = Tracker::where('status', 2)->where('seller_status', 1)->where('buyer_status', 0)->where('buyer_id', auth::id())->get();
	
	
	 foreach ($trackers as $tracker):
		 
		 $transactions = Transaction::where('tracker_id', $tracker->id)->get();
		
		foreach ($transactions as $transaction):
		 
		 array_push($all, $transaction); 
		 
		endforeach;
		
	 endforeach;
	
	return $all;
	
		
	}
	
	public function sellerActiveTransactions()
    {
	
	$all = array();
	$trackers = Tracker::where('status', 2)->where('seller_status', 0)->where('buyer_status', 0)->where('seller_id', auth::id())->get();
	
	
	 foreach ($trackers as $tracker):
		 
		 $transactions = Transaction::where('tracker_id', $tracker->id)->get();
		
		foreach ($transactions as $transaction):
		 
		 array_push($all, $transaction); 
		 
		endforeach;
		
	 endforeach;
	
	return $all;
	
		
	}
	
	
public function buyerChats()
    {
	
	$all = array();
	$trackers = Tracker::where('status', 2)->where('seller_status', 1)->where('buyer_status', 1)->where('buyer_id', auth::id())->get();
	
	
	 foreach ($trackers as $tracker):
		
		 
		 array_push($all, $tracker); 
		
	 endforeach;
	
	return $all;
	
		
	}
	
	public function sellerChats()
    {
	
	$all = array();
	$trackers = Tracker::where('status', 2)->where('seller_status', 1)->where('buyer_status', 1)->where('seller_id', auth::id())->get();
	
	
	 foreach ($trackers as $tracker):
		
		 
		 array_push($all, $tracker); 
		
	 endforeach;
	
	return $all;
	
		
	}
	
	
	
public function shopOwner($id)
    {
		
	$owner = User::where('id', $id)->first();
	
	
	return $owner;
	
		
	}
	
	
	public function itemOwner($store)
    {
		
	$store = Store::where('id', $store)->first();
	
	$owner = User::where('id', $store->seller)->first();
	
	return $owner;
	
		
	}
	
	public function productOwner($product)
    {
		
	$product = Product::where('id', $product)->first();
	
	$store = Store::where('id', $product->store_id)->first();
	
	$owner = User::where('id', $store->seller)->first();
	
	return $owner;
	
		
	}
	
	
	public function shopLocation($id)
    {
		
	$location = Location::where('id', $id)->first();
	
	
	return $location;
	
		
	}
	
	
	public function itemPrices($id)
    {
		
	$prices = Price::where('product_id', $id)->get();
	
	$all = array();
	
	 foreach ($prices as $price):
		 
		 
		 array_push($all, $price);
		
	 endforeach;
	
	return $all;
	
		
	}
	
	
	public function shopItems($id)
    {
		
	$items = Product::where('store_id', $id)->get();
	
	$all = array();
	
	 foreach ($items as $item):
		 
		 
		 array_push($all, $item);
		
	 endforeach;
	
	return $all;
	
		
	}
	

public function sendSellerChat(Request $request) {
	
	$tracker = Tracker::where('id', $request->tracker)->first();
	
	if (($tracker->seller_id == auth::id())) {
		
		 $chat = Chat::create([
			
			'sender_id' => auth::id(),
			'receiver_id' => $request->receiver,
			'tracker_id' => $request->tracker,
			'body' => $request->body,
			'status' => 1,
		]);
		
		User::find($request->receiver)->notify(new \App\Notifications\NewSellerMessage(Auth::user()));
		
		return 1;
		
	} else {
		
		return 0;
		
		
		
	}
	
	
}
	
public function sendBuyerChat(Request $request) {
	
	$tracker = Tracker::where('id', $request->tracker)->first();
	
	if (($tracker->buyer_id == auth::id())) {
		
		 $chat = Chat::create([
			
			'sender_id' => auth::id(),
			'receiver_id' => $request->receiver,
			'tracker_id' => $request->tracker,
			'body' => $request->body,
			'status' => 0,
		]);
		
		User::find($request->receiver)->notify(new \App\Notifications\NewMessage(Auth::user()));
		
		return 1;
		
	} else {
		
		return 0;
		
		
		
	}
	
	
}
		
	
	
	
}
