@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Redefinir Senha</h1>

            <form id="resetPasswordForm">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">E-mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2">Nova Senha</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 mb-2">Confirmar Nova Senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                <button type="submit"
                    class="w-full bg-primary-500 text-white py-2 px-4 rounded-lg hover:bg-primary-600 transition duration-200">
                    Redefinir Senha
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {

            e.preventDefault();
            clearErrors();

            const formData = {

                token: document.querySelector('input[name="token"]').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value
            };

            axios.post('/api/reset-password', formData)
                .then(response => {

                    alert('Senha resetada com sucesso');
                    window.location.href = '/';
                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        const errors = error.response.data.errors;
                        for (const [field, messages] of Object.entries(errors)) {

                            showError(`${field}Error`, messages[0]);
                        }
                    } else {

                        alert('Ocorreu um erro ao redefinir a senha');
                    }
                });
        });
    </script>
@endsection
