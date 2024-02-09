<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Requests\ApiRequest;
use App\Models\Address;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiRequest $request)
    {
        $store_data = array(
            'name' => $request['name']
        );

        $address_data = [];
        $address_data['postal_code'] = $request['postal_code'];

        // BUSCA ENDEREÇO
        $cepLa = self::consultaCepLa($address_data['postal_code']);
        $viaCep = self::consultaViaCep($address_data['postal_code']);


        if ($cepLa || $viaCep) {
            if ($cepLa) {
                // Não encontrei a documentação da api
            } else if ($viaCep) {
                $address_data['state'] = $viaCep->uf;
                $address_data['city'] = $viaCep->localidade;
                $address_data['sublocality'] = $viaCep->bairro;
                $address_data['street'] = $viaCep->logradouro;
                $address_data['complement'] = $viaCep->complemento;
            }

            // CADASTRAR STORE
            $store = Store::create($store_data);
            $newStoreId = $store->id;

            // CADASTRAR ADDRESS
            $address_data['foreign_table'] = 'stores';
            $address_data['foreign_id'] = $newStoreId;
            $address_data['street_number'] = $request['street_number'];
            $address_data['complement'] = $request['complement'];

            $address = Address::create($address_data);

            if ($store && $address) {
                return response()->json(['sucsess' => 'Registro cadastrado com sucesso!']);
            }
        } else {
            return response()->json(['erro' => 'CEP não encontrado']);
        }
    }

    public function consultaCepLa(int|string $cep)
    {

        $url = 'https://cep.la/' . $cep;
        $response = file_get_contents($url);
        $data = json_decode($response);

        return $data;
    }

    public function consultaViaCep(int|string $cep)
    {
        $url = 'https://viacep.com.br/ws/' . $cep . '/json/';
        $response = file_get_contents($url);
        $data = json_decode($response);
        if (isset($data->cep)) {
            return $data;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $result = Address::getAll();
        return $result;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiRequest $request, int $id) // INCOMPLETA
    {
        $store = Store::findOrFail($id);

        if($store){
            $store_data = [];
            $store_data['name'] = $request['name'];

            $address_data = [];
            $address_data['postal_code'] = $request['postal_code'];
    
            // BUSCA ENDEREÇO
            $cepLa = self::consultaCepLa($address_data['postal_code']);
            $viaCep = self::consultaViaCep($address_data['postal_code']);

            if ($cepLa || $viaCep) {
                if ($cepLa) {
                    // Não encontrei a documentação da api
                } else if ($viaCep) {
                    $address_data['state'] = $viaCep->uf;
                    $address_data['city'] = $viaCep->localidade;
                    $address_data['sublocality'] = $viaCep->bairro;
                    $address_data['street'] = $viaCep->logradouro;
                    $address_data['complement'] = $viaCep->complemento;
                }
    
                // CADASTRAR STORE
                $store->update($store_data);

                $newStoreId = $store->id;
    
                // CADASTRAR ADDRESS
                $address_data['foreign_table'] = 'stores';
                $address_data['foreign_id'] = $newStoreId;
                $address_data['street_number'] = $request['street_number'];
                $address_data['complement'] = $request['complement'];
    
                $address->update($address_data);
    
                if ($store && $address) {
                    return response()->json(['sucsess' => 'Registro cadastrado com sucesso!']);
                }
            } else {
                return response()->json(['erro' => 'CEP não encontrado']);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
