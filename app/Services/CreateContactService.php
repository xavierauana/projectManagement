<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-09
 * Time: 23:07
 */

namespace App\Services;


use App\Client;
use App\Contact;
use Illuminate\Support\Facades\DB;

class CreateContactService
{

    public function create(array $data, Client $client = null): ?Contact {

        DB::beginTransaction();

        try {

            $contact = $client ?
                $client->contacts()->create($data) :
                Contact::create($data);

            if (isset($data['addresses'])) {
                foreach ($data['addresses'] as $address) {
                    $contact->addresses()->create($address);
                }
            }
            if (isset($data['phones'])) {
                foreach ($data['phones'] as $phone) {
                    $contact->phones()->create($phone);
                }
            }
            if (isset($data['emails'])) {
                foreach ($data['emails'] as $email) {
                    $contact->emails()->create($email);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $contact;

    }


}