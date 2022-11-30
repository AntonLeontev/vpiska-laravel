<?php

namespace App\Services\Cypix;

use App\Models\Order;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Support\Facades\Log;

class CypixService
{
	private string $salt;

	public function __construct()
	{
		$this->salt = str()->random(10);
	}

	public function transactionIsPaid(string $transactionId): bool
	{
		$body = [
			"transactionId" => $transactionId,
		];

		$response = $this->post("https://api.cypix.ru/gateway/status", $body);

		if ($response['status'] === 'DENIED') {
			throw new PaymentException($response['error']['message']);
		}

		if ($response['transaction']['status'] === 'PROCESSED') {
			return true;
		}

		return false;
	}

	public function transactionWithForm(Order $order, OrderCreateRequest $request): array
	{
		$body = [
			"amount" => $request->amount,
			"currency" => "RUB",
			"description" => "Оплата вписки",
			"returnUrl" => route('events.show', $request->event_id),
			'notificationUrl' => route('pay.notification'),
			"method" => "card",
			"orderId" => $order->id,
		];

		$response = $this->post("https://api.cypix.ru/gateway/form", $body);

		if ($response['status'] === 'DENIED') {
			throw new PaymentException($response['error']['message']);
		}
		Log::channel('payment')->debug('Заказ отправлен в оплату', [$order]);
		return $response;
	}

	private function post(string $url, array $body): array
	{
		$url = curl_init($url);
		curl_setopt($url, CURLOPT_HTTPHEADER, $this->headers($body));
		curl_setopt($url, CURLOPT_POST, 1);
		curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
		curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($url, CURLOPT_HEADER, false);
		$create_order = curl_exec($url);
		curl_close($url);

		return json_decode($create_order, true);
	}

	private function headers(array $body): array
	{
		return [
			"Content-Type: application/json",
			"X-Signature: " . $this->signature($body),
			"X-Service-Api-Key: " . env('CYPIX_SERVICE_API_KEY'),
			"X-Salt: " . $this->salt,
		];
	}

	private function signature(array $body): string
	{
		$signatureRaw = hash_hmac(
			'sha1',
			json_encode($body, JSON_UNESCAPED_UNICODE) . $this->salt,
			env('CYPIX_SECRET'),
			true
		);
		return base64_encode($signatureRaw);
	}
}
