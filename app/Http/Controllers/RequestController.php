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
        $requests = Requests::all();

        return response()->json($requests, 200);
		}
		

		/**
		 * Notify partner of the new Request 
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
