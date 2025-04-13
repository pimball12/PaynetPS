@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Registro</h1>

            <form id="registerForm">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">Nome Completo</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="nameError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">E-mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2">Senha</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 mb-2">Confirme a Senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <div class="mb-4">
                    <label for="zip_code" class="block text-gray-700 mb-2">CEP</label>
                    <div class="flex">
                        <input type="text" id="zip_code" name="zip_code"
                            class="flex-1 px-3 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="button" id="searchCep"
                            class="bg-primary-500 text-white px-4 rounded-r-lg hover:bg-primary-600 transition duration-200">
                            Buscar
                        </button>
                    </div>
                    <p id="zipCodeError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-4">
                    <label for="street" class="block text-gray-700 mb-2">Rua</label>
                    <input type="text" id="street" name="street" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="neighborhood" class="block text-gray-700 mb-2">Bairro</label>
                    <input type="text" id="neighborhood" name="neighborhood" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="city" class="block text-gray-700 mb-2">Cidade</label>
                    <input type="text" id="city" name="city" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label for="state" class="block text-gray-700 mb-2">Estado</label>
                    <input type="text" id="state" name="state" readonly
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-6">
                    <label for="number" class="block text-gray-700 mb-2">Número</label>
                    <input type="text" id="number" name="number"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="numberError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <button type="submit"
                    class="w-full bg-primary-500 text-white py-2 px-4 rounded-lg hover:bg-primary-600 transition duration-200">
                    Registrar
                </button>
            </form>

            <div class="mt-4 text-center">
                <span class="text-gray-600">Já tem uma conta? </span>
                <a href="/" class="text-primary-500 hover:underline">Faça login</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchCep').addEventListener('click', function() {

            const zipCode = document.getElementById('zip_code').value.replace(/\D/g, '');

            if (zipCode.length !== 8) {

                showError('zipCodeError', 'CEP deve ter 8 dígitos');
                return;
            }

            axios.get(`/api/cep/${zipCode}`)

                .then(response => {

                    document.getElementById('street').value = response.data.logradouro || '';
                    document.getElementById('neighborhood').value = response.data.bairro || '';
                    document.getElementById('city').value = response.data.localidade || '';
                    document.getElementById('state').value = response.data.uf || '';
                    document.getElementById('zipCodeError').classList.add('hidden');
                })
                .catch(error => {

                    if (error.response && error.response.status === 400) {
                        showError('zipCodeError', 'CEP inválido');
                    } else if (error.response && error.response.status === 404) {
                        showError('zipCodeError', 'CEP não encontrado');
                    } else {
                        showError('zipCodeError', 'Erro ao buscar CEP');
                    }
                });
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {

            e.preventDefault();
            clearErrors();

            const formData = {

                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value,
                zip_code: document.getElementById('zip_code').value,
                number: document.getElementById('number').value,
                street: document.getElementById('street').value,
                neighborhood: document.getElementById('neighborhood').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
            };

            axios.post('/api/register', formData)
                .then(response => {

                    handleAuthResponse(response);
                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        const errors = error.response.data.errors;
                        for (const [field, messages] of Object.entries(errors)) {

                            showError(`${field}Error`, messages[0]);
                        }
                    } else if (error.response && error.response.data.error) {

                        alert(error.response.data.error);
                    } else {

                        alert('Ocorreu um erro ao registrar');
                    }
                });
        });
    </script>
@endsection
