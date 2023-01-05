<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Auction\AuctionCollection;


class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AuctionCollection(Auction::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auction = new Auction();
        $auction->id = $request->id;
        $auction->title = $request->title;
        $auction->description = $request->description;
        $auction->image = $request->image;
        $auction->reserve_price = $request->reserve_price;
        $auction->starting_price = $request->starting_price;
        $auction->buy_now_price = $request->buy_now_price;
        $auction->end_date = $request->end_date;
        $auction->end_time = $request->end_time;
        $auction->status = $request->status;
        $auction->user_id = $request->user_id;
        $auction->save();

        return response()->json([
            'message' => 'Auction created successfully',
            'auction' => $auction
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        
        if ($auction->status == 'active') {
            return new AuctionResource($auction);
        } else {
            return response()->json([
                'message' => 'Auction not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        
        if ($auction->id == $request->id) {
            return response()->json([
                'message' => 'Auction updated successfully',
                'auction' => $auction
            ], 200);
        } else {
            return response()->json([
                'message' => 'Auction not found'
            ], 404);
        }
        return response([
            'massage' => 'Auction updated successfully',
            'data' => new AuctionResource($auction)
        ], 200);
        
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        $auction->delete();
        
        return response([
            'message' => 'Auction deleted successfully'
        ], 204);
        
    }
}