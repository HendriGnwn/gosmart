<?php

namespace App\Http\Controllers\Api;

use App\Payment;

class PaymentController extends Controller 
{
	public function listPayments()
	{
		$payments = Payment::actived()
				->ordered()
				->get();
		
		return response()->json([
			'status' => 200,
			'message' => 'success',
			'data' => $payments,
		], 200);
	}
}