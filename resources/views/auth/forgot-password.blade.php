@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Recuperação de Senha</h1>

            <form id="forgotPasswordForm">
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 mb-2">E-mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <button type="submit"
                    class="w-full bg-primary-500 text-white py-2 px-4 rounded-lg hover:bg-primary-600 transition duration-200">
                    Enviar Link de Recuperação
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="/" class="text-primary-500 hover:underline">Voltar para login</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {

            e.preventDefault();
            clearErrors();

            const email = document.getElementById('email').value;

            axios.post('/api/forgot-password', {

                    email: email
                })
                .then(response => {

                    alert(response.data.message || 'Link de recuperação enviado para seu e-mail');
                    window.location.href = '/';
                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        showError('emailError', error.response.data.errors.email[0]);
                    } else {

                        showError('emailError', 'Ocorreu um erro ao enviar o link de recuperação');
                    }
                });
        });
    </script>
@endsection
