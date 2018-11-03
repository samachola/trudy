<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRequestNotificationMail;

class RequestController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Make a new request.
     * 
     * @return Object - created request
     */
    function createRequest(Request $request)
    {
        // dd($this->request->client);
        $this->validate($this->request, Requests::$rules);

        $newRequest = Requests::create(
            [
                'date' => $this->request->date,
                'category_id' => $this->request->category_id,
                'client_email' => $this->request->client_email,
                'partner_id' => $this->request->partner_id,
                'fee' => 0,
                'rating' => 0,
                'paid' => 0,
                'status' => 0
            ]
        );

        if ($newRequest) {
            $this->notifyPartner($newRequest->partner_id);
        }

        return response()->json($newRequest, 201);
    }

    /**
     * Accept, reject or complete request.
     * 
     * @param integer $id - Request ID
     */
    function updateRequestStatus($id)
    {
        $requestStatuses = [1, 2, 3];
        $currentRequest = Requests::findOrFail($id);
        if (in_array($this->request->status, $requestStatuses)) {
            $currentRequest->status = $this->request->status;
            $currentRequest->save();
        }
        $response = [
          'message' => 'Request status updated successfully'
        ];

        return response()->json($currentRequest, 201);

    }

    /**
     * Delete Request
     * 
     * @param integer $id - Request Id
     * 
     * @return void
     */
    function removeRequest($id)
    {
        $selectedRequest = Request::findOrFail($id);
        
        $selectedRequest->delete();
        $response = [
          'message' => 'Request successfully deleted'
        ];

        return response()->json($response, 200);
    }
    
    /**
     * Returns a list of all requests.
     * 
     * @return void
     */
    public function getAllRequests()
    {
        $requests = Requests::all();

        return response()->json($requests, 200);
    }

    /**
     * Get single request
     * 
     * @param integer $id - Request ID.
     */
    public function getRequest($id)
    {
        $request = Requests::findOrFail($id);

        return response()->json($request, 200);
    }

    /**
     * Update request fees
     * 
     * @param integer $id - Request ID.
     * 
     */
    public function updateRequestFees($id)
    {
        $request = Requests::findOrFail($id);
        
        $request->fee = $this->request->fee;
        $request->save();

        $response = [
            "message" => "Job Fee updated successfully",
        ];

        return response()->json($response, 201);
    }

    /**
     * Update Request Rating
     * 
     * @param integer $id - Request Id
     */
    public function updateRequestRating($id)
    {
        $request = Requests::findOrFail($id);
        $ratings = [1, 2, 3, 4, 5];
        $rating = $this->request->rating;

        if (in_array($rating, $ratings)) {
            $request->rating = $rating;
            $request->save();
        }

        return response()->json($request, 201);
    }


    /**
     * Notify partner of the new Request 
     * 
     * @param integer $id - partner_id
     * 
     * @return {void}
     */
    public function notifyPartner($id)
    {
        // Create a mail function.
        $user = User::find($id);
        $payload = [
          "user" => $user->email
        ];

        new NewRequestNotificationMail($payload);
    }
      
}
