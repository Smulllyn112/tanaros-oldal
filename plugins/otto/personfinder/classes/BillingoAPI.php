<?php namespace Otto\Personfinder\Classes;

/**

 * Author: Gabor Takacs

 * Website: futurit.hu

 * E-mail: gabor.takacs@futurit.hu

 */



class BillingoAPI
{

    private const API_KEY = '0b60c5fe-16da-11ec-a6ff-0254eb6072a0';
    private const BILLINGO_BACKACCOUNT_ID = '77302';
    private const BILLINGO_DOCUMENTBLOCK_ID = '79426';

    private function runPostRequest($endpoint, $fields = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.billingo.hu/v3/'.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $headers = [
            'Accept: application/json',
            'X-Api-Key: '.self::API_KEY,
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            \Log::debug(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result, true);
    }



    private function runGetRequest($endpoint, $params = [])
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.billingo.hu/v3/'.$endpoint.'?page=1&per_page=100');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = [
            'Accept: application/json',
            'X-Api-Key: '.self::API_KEY,
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            \Log::debug(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result, true);
    }



    public function createPartner($partner = [])
    {
        return $this->runPostRequest('partners', $partner);
    }



    public function getPartners()
    {
        return $this->runGetRequest('partners');
    }



    public function getPartner($id)
    {
        return $this->runGetRequest('partners/'.$id);
    }



    public function getBankAccounts()
    {
        return $this->runGetRequest('bank-accounts');
    }



    public function createDocument($invoice)
    {
        $invoice['bank_account_id'] = self::BILLINGO_BACKACCOUNT_ID;
        $invoice['block_id'] = self::BILLINGO_DOCUMENTBLOCK_ID;

        return $this->runPostRequest('documents', $invoice);
    }
}
