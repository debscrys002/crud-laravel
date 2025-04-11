<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    private $produtos = [
        ['id' => 1, 'nome' => 'Notebook', 'preco' => 3500.00],
        ['id' => 2, 'nome' => 'Mouse', 'preco' => 120.50],
        ['id' => 3, 'nome' => 'Teclado', 'preco' => 250.00]
    ];

    public function index()
    {
        return response()->json($this->produtos);
    }

    public function create()
    {
        return response()->json(['message' => 'Página de criação de produto']);
    }

    public function store(Request $request)
    {
        $novoProduto = [
            'id' => count($this->produtos) + 1,
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco')
        ];
        
        array_push($this->produtos, $novoProduto);
        return response()->json($novoProduto, 201);
    }

    public function show($id)
    {
        $produto = collect($this->produtos)->firstWhere('id', $id);
        return $produto ? response()->json($produto) : response()->json(['message' => 'Produto não encontrado'], 404);
    }

    public function edit($id)
    {
        $produto = collect($this->produtos)->firstWhere('id', $id);
        return $produto ? response()->json($produto) : response()->json(['message' => 'Produto não encontrado'], 404);
    }

    public function update(Request $request, $id)
    {
        $produtoIndex = collect($this->produtos)->search(function ($produto) use ($id) {
            return $produto['id'] == $id;
        });

        if ($produtoIndex !== false) {
            $this->produtos[$produtoIndex] = [
                'id' => $id,
                'nome' => $request->input('nome'),
                'preco' => $request->input('preco')
            ];
            return response()->json($this->produtos[$produtoIndex]);
        }

        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    public function destroy($id)
    {
        $this->produtos = array_filter($this->produtos, function ($produto) use ($id) {
            return $produto['id'] != $id;
        });
        return response()->json(['message' => 'Produto removido com sucesso']);
    }
}
