@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-gray-900">CEP Authentication</span>
                    </div>
                    <div class="flex items-center">
                        <button onclick="logout()"
                            class="text-primary-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">
                            Sair
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-semibold mb-6">Usuários Cadastrados</h2>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="usersTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            E-mail</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Endereço</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Dados serão preenchidos via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const token = sessionStorage.getItem('auth_token');

            if (!token) {

                window.location.href = '/';
                return;
            }

            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            axios.get('/api/home')
                .then(response => {
                    const users = response.data;
                    const tbody = document.querySelector('#usersTable tbody');

                    tbody.innerHTML = '';

                    users.forEach(user => {
                        const row = document.createElement('tr');

                        const nameCell = document.createElement('td');
                        nameCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
                        nameCell.textContent = user.name;

                        const emailCell = document.createElement('td');
                        emailCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                        emailCell.textContent = user.email;

                        const addressCell = document.createElement('td');
                        addressCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                        addressCell.textContent =
                            `${user.street}, ${user.number} - ${user.neighborhood}, ${user.city}/${user.state}`;

                        row.appendChild(nameCell);
                        row.appendChild(emailCell);
                        row.appendChild(addressCell);

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {

                    if (error.response && error.response.status === 401) {

                        sessionStorage.removeItem('auth_token');
                        window.location.href = '/';
                    } else {

                        console.error('Erro ao carregar usuários:', error);
                        alert('Erro ao carregar usuários');
                    }
                });
        });

        function logout() {

            const token = sessionStorage.getItem('auth_token');

            if (token) {

                axios.post('/api/logout', {}, {

                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).finally(() => {

                    sessionStorage.removeItem('auth_token');
                    window.location.href = '/';
                });
            } else {

                sessionStorage.removeItem('auth_token');
                window.location.href = '/';
            }
        }
    </script>
@endsection
