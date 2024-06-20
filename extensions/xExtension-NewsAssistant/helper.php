<?php

const OPENAI_API_COMPLETIONS_URL = '/v1/chat/completions';
function endsWithPunctuation($str)
{
	$pattern = '/\p{P}$/u'; // regex pattern for ending with punctuation marks
	return preg_match($pattern, $str);
}

function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

function _dealResponse($openai_response)
{
	return $openai_response->choices[0]->delta->content ?? '';
}

function _errorHtmlSuffix($error_msg)
{
	return 'Ooooops!!!!<br><br>' . $error_msg;
}

function streamOpenAiApi(object $config, string $prompt, string $content, callable $task_callback, callable $finish_callback)
{
	$post_fields = json_encode(array(
		"model" => $config->model,
		"messages" => array(
			array(
				"role" => "system",
				"content" => $prompt,
			),
			array(
				"role" => "user",
				"content" => $content,
			),
		),
		"max_tokens" => $config->max_tokens,
		"temperature" => $config->temperature,
		"stream" => true,
	));

	Minz_Log::debug('Openai base url:' . $config->openai_base_url);

	$curl_info = [
		CURLOPT_URL            => $config->openai_base_url . OPENAI_API_COMPLETIONS_URL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING       => 'utf-8',
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_TIMEOUT        => 60,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST  => 'POST',
		CURLOPT_POSTFIELDS     => $post_fields,
		CURLOPT_HTTPHEADER     => [
			"Content-Type: application/json",
			"Authorization: Bearer $config->openai_api_key",
			"x-portkey-provider: $config->provider",
		],
	];

	$curl_info[CURLOPT_WRITEFUNCTION] = function ($curl_info, $data) use ($task_callback, $finish_callback) {
		Minz_Log::debug('Receive msg:' . $data);

		// if http status code != 200, then call the finish_callback to send the error message and stop the stream
		if (curl_getinfo($curl_info, CURLINFO_HTTP_CODE) != 200) {
			$task_callback(_errorHtmlSuffix(json_decode($data)->error->message));
			$finish_callback();
			return strlen($data);
		}

		$msg_list = explode(PHP_EOL, trim($data));
		foreach ($msg_list as $msg) {
			$msg = trim(substr(trim($msg), 5));

			if ($msg == '') {
				continue;
			} else if ($msg == "[DONE]") {
				$finish_callback();
			} else {
				$task_callback(_dealResponse(json_decode($msg)));
			}
		}

		return strlen($data);
	};

	$curl = curl_init();

	curl_setopt_array($curl, $curl_info);
	$response = curl_exec($curl);

	// handle the error request of curl
	if (curl_errno($curl)) {
		$task_callback(_errorHtmlSuffix(curl_error($curl)));
		$finish_callback();
	}

	curl_close($curl);
	return $response;
}
