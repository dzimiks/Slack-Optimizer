<?php

namespace App\Http\Requests;

use Auth;
use GuzzleHttp;
use GuzzleHttp\Client;

class SlackRequest extends Request
{
    /**
     * @var ApiClient
     */
    protected $client;

    /**
     * SlackRequest constructor, for GuzzleHttp
     * client initialization.
     *
     * @param array $query
     */
    public function __construct($query)
    {
        // Set token
        $query['token'] = Auth::user()->slack_token;

        $this->client = new Client([
            'base_uri' => 'https://slack.com/api/',
            'timeout'  => 0,
            'query'    => $query
        ]);
    }

    /**
     * Send API request to Slack and parse
     * json data from response.
     *
     * @param string $method
     * @return json
     */
    public function getJSON($method)
    {
        try
        {
            $response = $this->client->get($method)->getBody();
        }
        catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();

            return $response->getBody()->getContents();
        }

        // Return json
        return json_decode($response, true);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
