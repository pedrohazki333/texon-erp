@extends('layout')

@section('title', 'Pedidos')

@section('content')
    <h1>Pedidos</h1>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Ações
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Ver lista</a></li>
            <li><a class="dropdown-item" href="{{ route('orders.create') }}">Cadastrar</a></li>
        </ul>
    </div>
    <br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="customer_id" class="form-select" required>
                <option value="">Selecione um cliente</option>
                @foreach ($customers as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->first_name }} {{ $cliente->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status do Pedido</label>
            <select name="status" class="form-select" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <h4 class="mt-4">Produtos</h4>
        <table class="table" id="tabela-produtos">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="d-grid gap-2 mb-3">
            <button type="button" class="btn btn-sm btn-primary" onclick="adicionarProduto()">Adicionar Produto</button>
        </div>

        <div class="alert alert-secondary text-center mb-3">
            <h3>Total: R$ <span id="total">0,00</span></h3>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Salvar Pedido</button>
        </div>
    </form>

    <script>
        const produtos = @json($products);
        let produtoIndex = 0;

        function atualizarTotal() {
            let total = 0;
            document.querySelectorAll('#tabela-produtos tbody tr').forEach(linha => {
                const qtd = parseFloat(linha.querySelector('input[name$="[quantity]"]').value) || 0;
                const val = parseFloat(linha.querySelector('input[name$="[unit_price]"]').value) || 0;
                const subtotal = qtd * val;
                linha.querySelector('.subtotal').innerText = subtotal.toFixed(2).replace('.', ',');
                total += subtotal;
            });
            document.getElementById('total').innerText = total.toFixed(2).replace('.', ',');
        }

        function adicionarProduto() {
            const index = produtoIndex++;
            const linha = document.createElement('tr');

            const options = produtos.map(p => `<option value="${p.id}" data-price="${p.price}">${p.product_name}</option>`)
                .join('');

            linha.innerHTML = `
                <td>
                    <select name="products[${index}][product_id]" class="form-select select-produto" required>
                        <option value="">Selecione</option>
                        ${options}
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${index}][quantity]" class="form-control input-qtd" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" name="products[${index}][unit_price]" class="form-control input-preco" value="0" step="0.01" min="0" required>
                </td>
                <td class="subtotal">0,00</td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="this.closest('tr').remove(); atualizarTotal()">Remover</button>
                </td>
            `;

            const select = linha.querySelector('.select-produto');
            const inputPreco = linha.querySelector('.input-preco');
            const inputQtd = linha.querySelector('.input-qtd');

            select.addEventListener('change', () => {
                const selected = select.options[select.selectedIndex];
                const preco = selected.getAttribute('data-price');
                if (preco) {
                    inputPreco.value = preco;
                    atualizarTotal();
                }
            });

            inputPreco.addEventListener('input', atualizarTotal);
            inputQtd.addEventListener('input', atualizarTotal);

            document.querySelector('#tabela-produtos tbody').appendChild(linha);
            atualizarTotal();
        }

        // Adiciona um produto por padrão
        window.addEventListener('DOMContentLoaded', () => {
            adicionarProduto();
        });
    </script>
@endsection
