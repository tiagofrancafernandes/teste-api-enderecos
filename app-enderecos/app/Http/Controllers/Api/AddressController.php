<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Str;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['hello' => 'World'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['cep'] = preg_replace("/\D+/", "", $request->input('cep'));

        $request->validate([
            'cidade'      => 'required|max:100',
            'uf'          => 'required|min:2|max:2',
            'cep'         => 'required|string|min:8|max:8',
            'bairro'      => 'nullable|max:100',
            'localizacao' => 'nullable|max:100',
        ]);

        $address_data = $request->only([
            'cidade',
            'cep',
            'bairro',
            'localizacao',
        ]);

        $address_data['uf'] = strtoupper($address_data['uf']);
        $new_cep            = Address::create($address_data);

        if($new_cep)
            return response()->json([
                'created' => true,
                'cep'     => $new_cep->cep,
            ], 201);

        return response()->json([
            'created' => false,
            'message' => 'Falha ao cadastrar endereço',
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addressByCep(string $cep)
    {
        $validator = \Validator::make([
            'cep' => $cep
        ], [
            'cep' => 'required|string|min:8|max:9',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $cep          = preg_replace("/\D+/", "", $cep);
        $cep          = implode('%', str_split($cep));
        $key_to_cache = "cache_cep_". $cep;

        $address_data = Cache::remember($key_to_cache, 3060, function ()  use ($cep) {
            return Address::orderBy('localizacao', 'DESC')->where('cep', 'like', "%${cep}%")->first();
        });

        if($address_data)
            return response()->json($address_data, 200);

        return response()->json(['error' => true, 'message' => 'Endereço não encontrado'], 404);
    }

    public function search(Request $request, string $term = null)
    {
        $search = $term ?? $request->input('search')
                        ?? $request->input('term')
                        ?? $request->input('q')
                        ?? null;

        $search         = str_replace(str_split('ÃÂÁÉÍÓÚÀÇãâáéíóúàçã'), '-', $search);
        $clean_search   = Str::slug($search);

        $validator      = \Validator::make([
            'search' => $search
        ], [
            'search' => 'required|string|min:3|max:100',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $only_number = preg_replace("/\D+/", "", $search);

        if(strlen($only_number) >= 4 && strlen($only_number) <= 8)
        {
            $only_number = strlen($only_number) == 8 ? $only_number : null;
            $cep_like    = "UPPER(cep) like '". $only_number ."%' OR";

            if($only_number && is_string($only_number))
                return $this->addressByCep($only_number);
        }

        $search_like    = str_replace(['-'], '%', $clean_search);
        $address_query  = Address::orderBy('cidade')->select([ 'cidade', 'uf', 'cep', 'bairro', 'localizacao', ]);

        $key_to_cache   = "cache_clean_search_". $clean_search;

        Cache::forget($key_to_cache);

        $address_data = Cache::remember($key_to_cache, 3060, function ()  use ($address_query, $cep_like, $search_like) {

            $address_query = $address_query->whereRaw("(
                UPPER(cidade)       like '%". strtoupper($search_like) ."%' OR
                UPPER(bairro)       like '%". strtoupper($search_like) ."%' OR
                ". ($cep_like ?? '') ."
                UPPER(localizacao)  like '%". strtoupper($search_like) ."%'
            )");

            return $address_query->paginate(40);
        });

        return response()->json($address_data, 200);
    }
}
