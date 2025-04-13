<?php

namespace App\Services\Cep;

use App\Exceptions\CepServiceException;
use Illuminate\Support\Facades\Http;

class CepService implements CepServiceInterface
{
    /**
     * URL base da API ViaCEP
     */
    protected const BASE_URL = 'https://viacep.com.br/ws/';

    /**
     * Formato de resposta
     */
    protected const RESPONSE_FORMAT = 'json';

    /**
     * {@inheritdoc}
     */
    public function buscar(string $cep): array
    {
        $cep = $this->sanitizeCep($cep);

        if (!$this->cepValido($cep)) {

            throw new CepServiceException('CEP inválido');
        }

        $response = Http::get($this->buildUrl($cep));

        if ($response->failed()) {

            throw new CepServiceException('Falha ao comunicar com o serviço de CEP');
        }

        $data = $response->json();

        if (isset($data['erro']) && $data['erro'] === true) {

            throw new CepServiceException('CEP não encontrado');
        }

        return $this->formatResponse($data);
    }

    /**
     * Remove caracteres não numéricos do CEP
     */
    protected function sanitizeCep(string $cep): string
    {
        return preg_replace('/[^0-9]/', '', $cep);
    }

    /**
     * Verifica se o CEP é válido
     */
    protected function cepValido(string $cep): bool
    {
        return strlen($cep) === 8 && ctype_digit($cep);
    }

    /**
     * Constrói a URL para a requisição
     */
    protected function buildUrl(string $cep): string
    {
        return self::BASE_URL . $cep . '/' . self::RESPONSE_FORMAT . '/';
    }

    /**
     * Formata a resposta para um padrão consistente
     */
    protected function formatResponse(array $data): array
    {
        return [
            'cep' => $data['cep'] ?? '',
            'logradouro' => $data['logradouro'] ?? '',
            'complemento' => $data['complemento'] ?? '',
            'bairro' => $data['bairro'] ?? '',
            'localidade' => $data['localidade'] ?? '',
            'uf' => $data['uf'] ?? '',
            'ibge' => $data['ibge'] ?? '',
            'gia' => $data['gia'] ?? '',
            'ddd' => $data['ddd'] ?? '',
            'siafi' => $data['siafi'] ?? '',
        ];
    }
}
