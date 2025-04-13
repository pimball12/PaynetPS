@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Login</h1>

            <form id="loginForm">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">E-mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 mb-2">Senha</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden error-message"></p>
                </div>

                <button type="submit"
                    class="w-full bg-primary-500 text-white py-2 px-4 rounded-lg hover:bg-primary-600 transition duration-200">
                    Entrar
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="/forgot-password" class="text-primary-500 hover:underline">Esqueci minha senha</a>
            </div>

            <div class="mt-4 text-center">
                <span class="text-gray-600">Não tem uma conta? </span>
                <a href="/register" class="text-primary-500 hover:underline">Registre-se</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {

            e.preventDefault();
            clearErrors();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            axios.post('/api/login', {

                    email: email,
                    password: password
                })
                .then(response => {

                    handleAuthResponse(response);
                })
                .catch(error => {

                    if (error.response && error.response.status === 401) {

                        showError('passwordError', 'Credenciais inválidas');
                    } else if (error.response && error.response.data.errors) {

                        const errors = error.response.data.errors;
                        if (errors.email) showError('emailError', errors.email[0]);
                        if (errors.password) showError('passwordError', errors.password[0]);
                    } else {

                        alert('Ocorreu um erro ao fazer login');
                    }
                });
        });
    </script>
@endsection
