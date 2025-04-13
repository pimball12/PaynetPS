<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CepRequest;
use App\Services\Cep\CepService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function __construct(

        private CepService $cepService
    ) {}

    public function buscarCep(Request $request, string $cep): JsonResponse
    {
        try {

            $data = $this->cepService->buscar($cep);
            return response()->json($data);
        } catch (\App\Exceptions\CepServiceException $e) {

            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Erro ao buscar CEP'], 500);
        }
    }
}
