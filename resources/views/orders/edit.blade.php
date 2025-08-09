@extends('layout')

@section('title', 'Pedidos')

@section('content')
    <h2>Editar Pedido #{{ $order->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Vendedor</label>
            <select name="employee_id" class="form-select" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $order->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="customer_id" class="form-select" required>
                @foreach ($customers as $cliente)
                    <option value="{{ $cliente->id }}" {{ $order->customer_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->first_name }} {{ $cliente->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status do Pedido</label>
            <select name="status" class="form-select" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="notes" class="form-control" rows="3">{{ $order->notes }}</textarea>
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
            <tbody>
                @foreach ($order->items as $index => $item)
                    <tr>
                        <td>
                            <select name="products[{{ $index }}][product_id]" class="form-select select-produto"
                                required>
                                <option value="">Selecione</option>
                                @foreach ($products as $produto)
                                    <option value="{{ $produto->id }}"
                                        {{ $produto->id == $item->product_id ? 'selected' : '' }}
                                        data-price="{{ $produto->price }}">
                                        {{ $produto->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="products[{{ $index }}][quantity]"
                                class="form-control input-qtd" value="{{ $item->quantity }}" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="products[{{ $index }}][unit_price]"
                                class="form-control input-preco" value="{{ $item->unit_price }}" step="0.01"
                                min="0" required>
                        </td>
                        <td class="subtotal">{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                        <td>
                            <button type="button" class="btn btn-danger"
                                onclick="this.closest('tr').remove(); atualizarTotal()">Remover</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-3" onclick="adicionarProduto()">Adicionar Produto</button>

        <div class="mb-3">
            <label>Total: R$ <span id="total">{{ number_format($order->total, 2, ',', '.') }}</span></label>
        </div>

        <button type="submit" class="btn btn-success">Atualizar Pedido</button>
    </form>

    <script>
        const produtos = @json($products);
        let produtoIndex = {{ $order->items->count() }};

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
                <td><input type="number" name="products[${index}][quantity]" class="form-control input-qtd" value="1" min="1" required></td>
                <td><input type="number" name="products[${index}][unit_price]" class="form-control input-preco" value="0" step="0.01" min="0" required></td>
                <td class="subtotal">0,00</td>
                <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove(); atualizarTotal()">Remover</button></td>
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

        document.addEventListener('DOMContentLoaded', atualizarTotal);
    </script>
@endsection
