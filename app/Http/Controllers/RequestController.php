<?php

use App\Models\Requests;
use Illuminate\Http\Request;
namespace App\Http\Controllers;

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
    function createRequest()
    {
        $this->validate($this->request, Requests::$rules);

        $newRequest = Requests::create(
            [
                'date' => $this->request->date,
                'category_id' => $this->request->category,
                'client_email' => $this->request->client,
                'partner_id' => $this->request->partner,
                'status' => $this->request->status
            ]
        );

        return response()->json($newRequest, 201);
    }

    /**
     * Accept, reject or complete request.
     * 
     * @param integer $id - Request ID
     * 
     * @return void.
     */
    function updateRequestStatus($id)
    {
        $currentRequest = Request::findOrFail($id);
        $currentRequest->status = $this->request->status;

        $currentRequest->save();
        $response = [
          'message' => 'Request status updated successfully'
        ];

        return response()->json($response, 201);

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
    public function getRequests()
    {
        $requests = Request::all();

        return response()->json($requests, 200);
    }
      
}
