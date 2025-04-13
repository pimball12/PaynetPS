<?php

namespace App\Services\Cep;

interface CepServiceInterface
{
    /**
     * Busca informações de um CEP
     *
     * @param string $cep CEP a ser consultado (formato 00000000 ou 00000-000)
     * @return array Dados do endereço correspondente ao CEP
     * @throws \App\Exceptions\CepInvalidException Se o CEP for inválido
     * @throws \App\Exceptions\CepNotFoundException Se o CEP não for encontrado
     * @throws \App\Exceptions\CepServiceException Em caso de erro na comunicação com o serviço
     */
    public function buscar(string $cep): array;
}
