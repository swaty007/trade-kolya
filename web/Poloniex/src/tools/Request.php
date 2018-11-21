<?php

namespace poloniex\api\tools;

/**
 * HTTP requests support class.
 *
 * @category Poloniex API
 * @author Dmytro Zarezenko <dmytro.zarezenko@gmail.com>
 * @copyright (c) 2017, Dmytro Zarezenko
 *
 * @git https://github.com/dzarezenko/poloniex-api
 * @license http://opensource.org/licenses/MIT
 */
class Request {

    /**
     * Poloniex API Key value.
     *
     * @var type
     */
    private $apiKey = "";

    /**
     * Poloniex API Secret value.
     *
     * @var type
     */
    private $apiSecret = "";

    /**
     * cURL handle.
     *
     * @var resource
     */
    private static $ch = null;

    public function __construct($apiKey, $apiSecret) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Executes curl request to the Poloniex API.
     *
     * @param array $req Request parameters list.
     *
     * @return array JSON data.
     * @throws \Exception If Curl error or Poloniex API error occurred.
     */
    public function exec(array $req = []) {
        usleep(200000);

        // API settings
        $key = $this->apiKey;
        $secret = $this->apiSecret;
        $mt = explode(' ', microtime());
        $req['nonce'] = $mt[1] . substr($mt[0], 2, 6);

        // generate the POST data string
        $postData = http_build_query($req, '', '&');
        $sign = hash_hmac('sha512', $postData, $secret);

        // generate the extra headers
        $headers = [
            'Key: ' . $key,
            'Sign: ' . $sign,
        ];

        // curl handle (initialize if required)
        if (!is_resource(self::$ch)) {
            self::$ch = curl_init();
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                self::$ch,
                CURLOPT_USERAGENT,
                'Mozilla/4.0 (compatible; Poloniex PHP API; ' . php_uname('a') . '; PHP/' . phpversion() . ')'
            );
        }
        curl_setopt(self::$ch, CURLOPT_URL, \poloniex\api\PoloniexAPIConf::URL_TRADING);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, false);

        // run the query
        $res = curl_exec(self::$ch);
        if ($res === false) {
            $e = curl_error(self::$ch);
            curl_close(self::$ch);

            throw new \Exception("Curl error: " . $e);
        }
        curl_close(self::$ch);

        $json = json_decode($res, true);

        // Check for the Poloniex API error
        if (isset($json['error'])) {
            throw new \Exception("Poloniex API error: {$json['error']}");
        }

        return $json;
    }

    /**
     * Executes simple GET request to the Poloniex public API.
     *
     * @param string $url API method URL.
     *
     * @return array JSON data.
     */
    public static function json($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $output = curl_exec($ch);
        if ($output === false) {
            $e = curl_error($ch);
            curl_close($ch);

            throw new \Exception("Curl error: " . $e);
        }

        curl_close($ch);

        $json = json_decode($output, true);

        return $json;
    }

}
