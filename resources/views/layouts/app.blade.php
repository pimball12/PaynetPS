<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paynet Autenticação</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#6366f1',
                            600: '#4f46e5',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @yield('content')

    <script>

        function showError(elementId, message) {

            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = message;
                element.classList.remove('hidden');
            }
        }

        function clearErrors() {

            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.add('hidden');
            });
        }

        function handleAuthResponse(response) {

            if (response.data.access_token) {

                sessionStorage.setItem('auth_token', response.data.access_token);
                window.location.href = '/home';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            const token = sessionStorage.getItem('auth_token');

            if (token && !['/','/register','/forgot-password'].includes(window.location.pathname)) {

                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            } else if (!token && window.location.pathname === '/home') {

                window.location.href = '/';
            }
        });
    </script>
</body>
</html>
